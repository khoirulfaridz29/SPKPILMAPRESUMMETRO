<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('admin', fn($user) => $user->role === 'admin');
        Gate::define('mahasiswa', fn($user) => $user->role === 'mahasiswa');
        Gate::define('juri', fn($user) => $user->role === 'juri');
        Gate::define('wr3', fn($user) => $user->role === 'wr3');

        View::composer('layouts.dashboard', \App\View\Composers\SidebarComposer::class);
    }
}
