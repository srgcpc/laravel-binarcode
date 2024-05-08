<?php

namespace Tests\Feature;

use App\Jobs\SendNotifications;
use App\Models\Scheduler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SendNotificationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_database_notifications_are_sent(): void
    {
       $dbScheduler = Scheduler::create([
           'channel' => 'database',
           'message' => 'dummy message',
           'time' => '2024-05-01 15:00:00',
           'email' => 'email@example.com',
       ]);

        (new SendNotifications())->__invoke();

        $notification = DB::table('notifications')->first();

        $notificationData = json_decode($notification->data, true);

        $this->assertEquals('App\Notifications\PaymentReceivedDb', $notification->type);
        $this->assertEquals('App\Models\Scheduler', $notification->notifiable_type);
        $this->assertEquals($dbScheduler->email, $notificationData['email']);
        $this->assertEquals($dbScheduler->channel, $notificationData['channel']);
    }
}
