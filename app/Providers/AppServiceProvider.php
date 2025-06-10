<?php

namespace App\Providers;

use App\Models\Semester;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        session()->remember('semester_id', function (){
            return Semester::whereName('8th')->value('id');
        });
        Gate::define('viewPulse', function (User $user) {
            return true;
        });
    }
}
