<?php

namespace App\Jobs;

use App\Mail\orderListToAdmin as MailorderListToAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail
// use Illuminate\Support\Facades\Mail;


class SendOrderListToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details,$tempFilePath;
    /**
     * Create a new job instance.
     */
    public function __construct($details,$tempFilePath)
    {
        //
        $this->details = $details;
        $this->tempFilePath = $tempFilePath['tempFilePath'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $email = new orderListToAdmin(['tempFilePath'=>$this->tempFilePath]);
        Mail::to($this->details)->send($email);
    }
}
