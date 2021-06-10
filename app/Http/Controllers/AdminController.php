<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use Redirect;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Auth;
use Config;
use App;
use Hash;
use App\User;

use App\Log;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AdminController extends Controller
{
    public function index()
    {
		return view('admin.index');
    }


    public function summary() {

        $payments = Payment::all();
        $treasuries = Treasury::all();
        $ecategories = Ecategory::all();
        $icategories = Icategory::all();

        $totalexpenses = Expense::sum('amount');
        $totalincomes = Income::sum('amount');
        $totalinvoices = Invoice::sum('netcost');
        $invoices = (Medicalsession::where('status_id',2)->has('invoice')->sum('price') ) + (Appointment::where('status_id',2)->sum('price'));

        $oldinvoices = Medicalsession::where('status_id',1)->doesntHave('invoice')->sum('price');



        return view('admin.finance.index')->withTotalexpenses($totalexpenses)->withTotalincomes($totalincomes)->withTotalinvoices($totalinvoices)->withInvoices($invoices)->withOldinvoices($oldinvoices)->withPayments($payments)->withTreasuries($treasuries)->withEcategories($ecategories)->withIcategories($icategories);
    }


    public function userReport(Request $request , User $users) {

        $users = $users->newQuery();


        if ($request->role_id) {

            $role_id = $request->role_id;

            $users->whereHas('roles',function($q) use ($role_id){
                $q->where('name', $role_id);
            });
        }


        if ($request->mobile) {

            $mobile = $request->mobile;

            $users->where('mobile', $mobile);
        }


        if ($request->start_date) {

            //return Carbon($start_date)->toDateTimeString();

            $start_date = $request->start_date;

            $users->whereDate('created_at', '>=', $start_date);

        }

        if ($request->end_date) {

            $end_date = $request->end_date;

            $users->whereDate('created_at', '<=', $end_date);
        }

        if ($users) {

            $roles = Role::pluck('name','name')->all();

            return view('admin.reports.users')->withUsers($users->latest()->get())->withRoles($roles);
        }



    }

    public function MedicalsessionsReport(Request $request , Medicalsession $medicalsessions) {

        $medicalsessions = $medicalsessions->newQuery();

        if ($request->fullname) {

            $fid = $request->fullname;

            $medicalsessions->whereHas('appointment', function ($query) use ($fid) {
                $query->whereHas('patient', function ($query) use ($fid) {
                    $query->where('fullname', 'like', '%' . $fid . '%');
                });
            });
        }


        if ($request->fromdate && $request->todate ) {

            $fromdate = $request->fromdate;
            $todate = $request->todate;

            $medicalsessions->whereBetween('date', [$fromdate, $todate] );

        }elseif ($request->todate) {
            $date = $request->todate;
            $medicalsessions->where('date', 'like', '%' . $date . '%');

        }elseif ($request->fromdate) {
            $date = $request->fromdate;
            $medicalsessions->where('date', 'like', '%' . $date . '%');
        }


        if ($medicalsessions) {

            $total = $medicalsessions->sum('price');
            return view('admin.reports.medicalsessions')->withMedicalsessions($medicalsessions->latest()->paginate(15))->withTotal($total);
        }

    }

    public function IncomesReport(Request $request , Income $incomes) {
        $incomes = $incomes->newQuery();

        if ($request->name) {

            $name = $request->name;
            $incomes->where('name', $name);
        }

        if ($request->icategory_id) {

            $icategory_id = $request->icategory_id;
            $incomes->where('icategory_id', $icategory_id);
        }

        if ($request->fromdate && $request->todate ) {

            $fromdate = $request->fromdate;
            $todate = $request->todate;

            $incomes->whereBetween('entry_date', [$fromdate, $todate] );

        }elseif ($request->todate) {
            $date = $request->todate;
            $incomes->where('entry_date', 'like', '%' . $date . '%');

        }elseif ($request->fromdate) {
            $date = $request->fromdate;
            $incomes->where('entry_date', 'like', '%' . $date . '%');
        }


        if ($incomes) {

            $total = $incomes->sum('amount');
            $icategories = Icategory::get()->pluck('name', 'id')->prepend(trans('admin.please_select'), '');

            return view('admin.reports.incomes')->withIncomes($incomes->latest()->paginate(15))->withIcategories($icategories)->withTotal($total);
        }

    }

    public function ExpensesReport(Request $request , Expense $expenses) {
        $expenses = $expenses->newQuery();

        if ($request->name) {

            $name = $request->name;
            $expenses->where('name', $name);
        }

        if ($request->ecategory_id) {

            $ecategory_id = $request->ecategory_id;
            $expenses->where('ecategory_id', $ecategory_id);
        }

        if ($request->fromdate && $request->todate ) {

            $fromdate = $request->fromdate;
            $todate = $request->todate;

            $expenses->whereBetween('entry_date', [$fromdate, $todate] );

        }elseif ($request->todate) {
            $date = $request->todate;
            $expenses->where('entry_date', 'like', '%' . $date . '%');

        }elseif ($request->fromdate) {
            $date = $request->fromdate;
            $expenses->where('entry_date', 'like', '%' . $date . '%');
        }


        if ($expenses) {
            $total = $expenses->sum('amount');

            $ecategories = Ecategory::get()->pluck('name', 'id')->prepend(trans('admin.please_select'), '');

            return view('admin.reports.expenses')->withExpenses($expenses->latest()->paginate(15))->withEcategories($ecategories)->withTotal($total);
        }
    }


    public function internaltransfer() {

        $ecategories = Ecategory::get()->pluck('name', 'id')->prepend(trans('admin.please_select'), '');
        $icategories = Icategory::get()->pluck('name', 'id')->prepend(trans('admin.please_select'), '');
        $payments = Payment::get()->pluck('name', 'id')->prepend(trans('admin.please_select'), '');
        $treasuries = Treasury::get()->pluck('name', 'id')->prepend(trans('admin.please_select'), '');
        $users = User::has('roles')->pluck('fullname', 'id')->prepend(trans('admin.please_select'), '');

        return view('admin.finance.internaltransfer', compact('ecategories','icategories','users','payments','treasuries'));

    }
    public function internalTransferStore(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'amount' => 'required|integer',
            'entry_date' => 'date',
            'ecategory_id' => 'required',
            'icategory_id' => 'required',
            'source_id' => 'required',
            'destination_id' => 'required',
        ]);


        function convert($string) {
            $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١','٠'];
            $num = range(9, 0);
            $englishNumbersOnly = str_replace($arabic, $num, $string);
            return $englishNumbersOnly;
        }

        $expense = New Expense;
        $expense->name = $request->name;
        $expense->ecategory_id = $request->ecategory_id;
        $expense->source_id = $request->source_id;
        $expense->destination_id = $request->destination_id;
        $expense->treasury_id = $request->source_id;
        $expense->entry_date = $request->entry_date;
        $expense->amount = convert($request->amount);
        $expense->reference = $request->reference;
        $expense->user_id = Auth::user()->id;
        $expense->save();


        $image = Input::file('image');

        if (isset($image)) {
            $destinationPath = 'uploads/expenses';
            $extension =  $image->getClientOriginalExtension();
            $fileName = rand(11111,99999).'.'.$extension; 
            $upload_success = $image->move($destinationPath, $fileName);
            $expense->image =  $destinationPath.'/'.$fileName;
        }

        $expense->save();

        $income = New Income;
        $income->name = $request->name;
        $income->icategory_id = $request->icategory_id;
        $income->source_id = $request->source_id;
        $income->destination_id = $request->destination_id;
        $income->treasury_id = $request->destination_id;
        $income->entry_date = $request->entry_date;
        $income->amount = convert($request->amount);
        $income->reference = $request->reference;
        $income->user_id = Auth::user()->id;
        $income->save();


        $image = Input::file('image');

        if (isset($image)) {
            $destinationPath = 'uploads/incomes';
            $extension =  $image->getClientOriginalExtension();
            $fileName = rand(11111,99999).'.'.$extension; 
            $upload_success = $image->move($destinationPath, $fileName);
            $income->image =  $destinationPath.'/'.$fileName;
        }

        $income->save();

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect('admin/summary');


    }

}
