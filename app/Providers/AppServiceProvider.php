<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    Inertia::share('storagePath', env('VITE_STORAGE_PATH'));
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    //
  }
}
