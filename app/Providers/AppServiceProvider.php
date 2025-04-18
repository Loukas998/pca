<?php

namespace App\Providers;

use App\Interfaces\IFileUploaderService;
use App\Services\FileUploaderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->app->bind(FileUploaderService::class, function () {
        //     return new FileUploaderService();
        // });
        $this->app->bind(IFileUploaderService::class, FileUploaderService::class);
    }
}
