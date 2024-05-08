<?php

namespace App\Jobs;

use App\Models\Scheduler;
use App\Notifications\PaymentReceived;
use App\Notifications\PaymentReceivedDb;
use Illuminate\Support\Facades\Notification;

class SendNotifications
{
    public function __invoke()
    {
        Notification::send(Scheduler::ready()->where('channel', 'mail')->get(), (new PaymentReceived())->onQueue('emails'));

        Scheduler::ready()->where('channel', 'mail')->update(['sent_at' => now()]);

        Notification::send(Scheduler::ready()->where('channel', 'database')->get(), (new PaymentReceivedDb()));

        Scheduler::ready()->where('channel', 'database')->update(['sent_at' => now()]);
    }

}
