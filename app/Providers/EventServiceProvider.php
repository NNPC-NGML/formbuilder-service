<?php

namespace App\Providers;

use App\Jobs\Form\FormDataCreated;
use App\Jobs\Automator\AutomatorTaskBroadcasterJob;
use App\Jobs\Customer\CustomerTaskBroadcasterJob;
use App\Jobs\ProcessFlow\ProcessFlowTaskBroadcasterJob;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        \App::bindMethod(FormDataCreated::class . '@handle', fn($job) => $job->handle());
        \App::bindMethod(AutomatorTaskBroadcasterJob::class . '@handle', fn ($job) => $job->handle());
        \App::bindMethod(ProcessFlowTaskBroadcasterJob::class . '@handle', fn ($job) => $job->handle());
        \App::bindMethod(CustomerTaskBroadcasterJob::class . '@handle', fn ($job) => $job->handle());


    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
