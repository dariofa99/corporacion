<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Models\CaseLog;
use App\Notifications\LogDatabaseNotification;


class SendLogNotificationDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $caseL; 
    public $users;
    public $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CaseLog $caseL,$users)
    {
        $this->caseL = $caseL;       
        $this->users = $users;
        //$this->date = $date;
    }

    /**
     * Execute the job. 
     *
     * @return void
     */
    public function handle()
    {
        Notification::send($this->users, new LogDatabaseNotification($this->caseL,date("Y-m-d")));
    }
}
