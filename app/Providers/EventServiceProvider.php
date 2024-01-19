<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Order\Payment\Pending' => [
            'App\Listeners\Order\Payment\PendingNotification',
        ],
        'App\Events\Coupon' => [
            'App\Listeners\CuoponNotification',
        ],
        'App\Events\Reward' => [
            'App\Listeners\RewardNotification',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
