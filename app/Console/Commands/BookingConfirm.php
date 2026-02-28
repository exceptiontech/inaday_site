<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Booking;
use Mail;
use Carbon\Carbon;

class BookingConfirm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        //$data = Carbon::now()->subDay(2);

        // Mail::send('mail.test', ['osama'=>$osama], function($message) use ($osama)
        //     {
        //         $message->to('a.alhadi@ad.net.sa', 'info@d24.sa')->subject('test');
        //     }); 


        $bookings = Booking::where('status_id',2)->where('created_at', '<', Carbon::now()->addDays(1))->get();

        foreach ($bookings as $item) {

            $booking = Booking::find($item->id);
            $booking->status_id = 3;
            $booking->save();
        }
    }
}
