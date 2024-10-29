<?php

namespace App\Providers;

use App\Events\InvoiceCreated;
use App\Listeners\CreateInvoiceAttachments;
use App\Listeners\CreateInvoiceDetails;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            InvoiceCreated::class,
            CreateInvoiceDetails::class,
            CreateInvoiceAttachments::class
        );

        
    }
}
