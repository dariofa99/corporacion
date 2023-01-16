<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Diary;
use App\Notifications\DiaryNotification;

class SendEventDiaryEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $users;
    public $diary;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users,Diary $diary)
    {
        $this->users = $users;
        $this->diary = $diary;
    }

    /**
     * Execute the job. 
     *
     * @return void
     */
    public function handle()
    {
        Notification::send($this->users, new DiaryNotification($this->diary)); 
    }
}
