<?php

namespace Modules\AuthModule\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\AuthModule\Facades\OTPFacade;

class SendOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $phone;
    private $phoneCode;
    private $verificationCode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone, $phoneCode, $verificationCode)
    {
        $this->phone = $phone;
        $this->phoneCode = $phoneCode;
        $this->verificationCode = $verificationCode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        OTPFacade::send($this->phone, $this->phoneCode, $this->verificationCode);
    }
}
