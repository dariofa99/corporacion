<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Models\CaseLog;
use App\Notifications\LogNotification;


class SendLogNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $caseL;
    public $notification_message;
    public $users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CaseLog $caseL,$notification_message,$users)
    {
        $this->caseL = $caseL;
        $this->notification_message = $notification_message;
        $this->users = $users;
    }

    /**
     * Execute the job. 
     *
     * @return void
     */
    public function handle()
    {
        Notification::send($this->users, new LogNotification($this->caseL,$this->notification_message));
    }
}
