<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;

use App\Review;
use App\Booking;
use App\User;
use App\Transaction;
use Illuminate\Http\Request;

use App\Log;
use Auth;
use Redirect;
use Session;

use App\Notifications\ReviewCreated;
use App\Notifications\ReviewUpdated;
use App\Notifications\ReviewDeleted;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (count(Auth::user()->roles) == 0  || !Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            return view('front.errors.denied');
        }

        return view('front.profile.reviews.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            //'title'     =>'required|max:500',
            'review'     =>'required|min:3|max:500',
        ]);

        $review= new Review();
        $review->user_id=Auth::id();
        $review->title=$request->title;
        $review->review=$request->review;
        $review->service_id=$request->service_id;
        $review->booking_id=$request->booking_id;
        $review->author_id=Auth::user()->id;        
        $review->is_active=1;
        $review->save();

        if ($review) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'review';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();

        }

        if ($request->is_confirmed) {
            $booking = Booking::find($request->booking_id);
            $booking->status_id = 3;
            $booking->save();

            $transaction = Transaction::where('booking_id',$booking->id)->first();
            $transaction->is_confirmed = 1;
            $transaction->save();

        }else {
            $booking = Booking::find($request->booking_id);
            $booking->status_id = 4;
            $booking->save();
        }

        Auth::user()->notify(new \App\Notifications\Database\ReviewCreated($review));

        if (Auth::user()->usersettings && Auth::user()->usersettings->review_notifications)
        {
            Auth::user()->notify(new ReviewCreated($review));
        } 

        if ($request->is_confirmed == 0) {
            $admin = User::find(1);
            $admin->notify(new ReviewCreated($review));
        }


        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
