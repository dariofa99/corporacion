<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\SuccessfulLogin',
        ],
        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\UserLogout',
        ],
        'user.created' => [
            'App\Events\UserEvent@itemCreated',
        ],
        'user.updated' => [
            'App\Events\UserEvent@itemUpdated',
        ],
        'user.deleted' => [
            'App\Events\UserEvent@itemDeleted',
        ],
        'case.created' => [
            'App\Events\CaseMEvent@itemCreated',
        ],
        'case.updated' => [
            'App\Events\CaseMEvent@itemUpdated',
        ],
        'case.deleted' => [
            'App\Events\CaseMEvent@itemDeleted',
        ],
        'userMailNoti.created' => [
            'App\Events\UserMailNotificationEvent@itemCreated',
        ],
        'userMailNoti.updated' => [
            'App\Events\UserMailNotificationEvent@itemUpdated',
        ],
        'userMailNoti.deleted' => [
            'App\Events\UserMailNotificationEvent@itemDeleted',
        ],
        'caselog.created' => [
            'App\Events\CaseLogEvent@itemCreated',
        ],
        'caselog.updated' => [
            'App\Events\CaseLogEvent@itemUpdated',
        ],
        'caselog.deleted' => [
            'App\Events\CaseLogEvent@itemDeleted',
        ],
        'userAdi.created' => [
            'App\Events\UserAditEvent@itemCreated',
        ],
        'userAdi.updated' => [
            'App\Events\UserAditEvent@itemUpdated',
        ],
        'userAdi.deleted' => [
            'App\Events\UserAditEvent@itemDeleted',
        ],
        'refdata.created' => [
            'App\Events\ReferenceDataEvent@itemCreated',
        ],
        'refdata.updated' => [
            'App\Events\ReferenceDataEvent@itemUpdated',
        ],
        'refdata.deleted' => [
            'App\Events\ReferenceDataEvent@itemDeleted',
        ],
        'refdataop.created' => [
            'App\Events\ReferenceDataOptionEvent@itemCreated',
        ],
        'refdataop.updated' => [
            'App\Events\ReferenceDataOptionEvent@itemUpdated',
        ],
        'refdataop.deleted' => [
            'App\Events\ReferenceDataOptionEvent@itemDeleted',
        ],
        'reception.created' => [
            'App\Events\ReceptionEvent@itemCreated',
        ],
        'reception.updated' => [
            'App\Events\ReceptionEvent@itemUpdated',
        ],
        'reception.deleted' => [
            'App\Events\ReceptionEvent@itemDeleted',
        ],
        'diary.created' => [
            'App\Events\DiaryEvent@itemCreated',
        ],
        'diary.updated' => [
            'App\Events\DiaryEvent@itemUpdated',
        ],
        'diary.deleted' => [
            'App\Events\DiaryEvent@itemDeleted',
        ],
        'directory.created' => [
            'App\Events\DirectoryEvent@itemCreated',
        ],
        'directory.updated' => [
            'App\Events\DirectoryEvent@itemUpdated',
        ],
        'directory.deleted' => [
            'App\Events\DirectoryEvent@itemDeleted',
        ],
        'adtd.created' => [
            'App\Events\AditionalDataEvent@itemCreated',
        ],
        'adtd.updated' => [
            'App\Events\AditionalDataEvent@itemUpdated',
        ],
        'adtd.deleted' => [
            'App\Events\AditionalDataEvent@itemDeleted',
        ],
        'libra.created' => [
            'App\Events\LibraryEvent@itemCreated',
        ],
        'libra.updated' => [
            'App\Events\LibraryEvent@itemUpdated',
        ],
        'libra.deleted' => [
            'App\Events\LibraryEvent@itemDeleted',
        ]
        ,
        'panicalert.created' => [
            'App\Events\PanicAlertEvent@itemCreated',
        ],
        'panicalert.updated' => [
            'App\Events\PanicAlertEvent@itemUpdated',
        ],
        'panicalert.deleted' => [
            'App\Events\PanicAlertEvent@itemDeleted',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
