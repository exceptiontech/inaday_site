<?php

namespace App\Http\Controllers\API\Account;
use App\Http\Controllers\Controller;

use App\User;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Validator;
use Socialite;
use URL;
use Auth;
use Redirect;
use Session;

use Pusher\Pusher;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $users)
    {

        $users = $users->newQuery();


        $users->orwhereHas('roles',function($q) {
            $q->where('name', 'services_provider')->oRwhere('name', 'entrepreneur');
        })->get();


        // $users->orwhereHas('service_bookings', function ($query)  {
        //         $query->where('provider_id','!=', Auth::id())->where('user_id', Auth::id());
        //     });

        // $users->orwhereHas('bookings', function ($query)  {
        //         $query->where('user_id','!=', Auth::id())->where('provider_id', Auth::id());
        //     });


        // if (Auth::user()->isServicesProvider()) {
        //     $users->orwhereHas('roles',function($q) {
        //                 $q->where('name', 'services_provider');
        //             })->get();

        // }elseif (Auth::user()->isEntrepreneur()) {
        //     $users->orwhereHas('roles',function($q) {
        //                 $q->where('name', 'entrepreneur');
        //             })->get();
        // }

        $users->where('id', '!=', Auth::id());
        $users->where('id', '!=', 1);

        $data['status'] = true;

        $arr = array("status" => 200,"data" => $users->with('userdetail','messages')->latest()->get());

        return \Response::json(['data'=> $arr]);

        //return response()->json(['data' => ], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        //return view('front.profile.messages.index', ['users' => $users->latest()->get()]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::user() ) {
            $arr = array("status" => 401, "errorMsg" =>  __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $my_id = Auth::id();

        $other_user = User::find($id);

        // Make read all unread message
        Message::where(['from' => $id, 'to' => $my_id])->update(['is_read' => 1]);

        // Get all message from selected user
        $messages = Message::where(function ($query) use ($id, $my_id) {
            $query->where('from', $id)->where('to', $my_id);
        })->oRwhere(function ($query) use ($id, $my_id) {
            $query->where('from', $my_id)->where('to', $id);
        })->get();

        $data['messages'] = $messages;
        $data['other_user'] = $other_user;
        $data['other_user']['userdetail'] = $other_user->userdetail;


        return response()->json(['data' => $data], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }


    public function getMessage($user_id)
    {

        if (!Auth::user() ) {
            $arr = array("status" => 401, "errorMsg" =>  __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $my_id = Auth::id();

        // Make read all unread message
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // Get all message from selected user
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->get();

        return view('front.profile.messages.show', ['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        if (!Auth::user() ) {
            $arr = array("status" => 401, "errorMsg" =>  __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;
        

        $data = new Message();
        $data->from = $from;
        $data->to = $to;

        $file = $request->file;
        $audio = $request->audio;

        if ($file) {

            $validator = Validator::make($request->all(), [
                'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:25500',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>'حدث خطأ غير متوقع من فضلك تحقق من اتصالك او امتداد الملف غير صالح']);
            }

            $destinationPath = 'uploads/messages';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $file = $destinationPath.'/'.$fileName;
            
            $data->file = $file;
            $data->message = $file;

        }elseif ($audio) {
            $destinationPath = 'uploads/messages/audio';
            $extension='mp3';
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $audio->move($destinationPath, $fileName);
            $audio = $destinationPath.'/'.$fileName;
            $data->file = $audio;
            $data->message = $audio;

        }else {

            $validator = Validator::make($request->all(), [
                'message' => 'required',
            ]);

            if ($validator->fails()) {

                $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

                return \Response::json(['error'=> $arr]);
            }


            $data->message = $message;
        }

        


        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter

        $pusher->trigger('my-channel', 'my-event', $data);

        $arr = array("status" => 200,"data" => $data);

        return \Response::json(['data'=> $arr]);


    }


    function listenAudio($fileName)
    {

        $file = $request->file;
        //$file = Storage::disk('local')->get($fileName);
        return (new Response($file, 200))
                  ->header('Content-Type', 'audio/mpeg');
    }
}
