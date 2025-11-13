<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use App\Policies\ProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        \App\Models\Section::class => \App\Policies\SectionPolicy::class,
        \App\Models\ClassModel::class => \App\Policies\ClassPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register the ProfilePolicy as a gate for more flexibility
        // Since ProfilePolicy is not bound to a single model, we register it as a gate
        Gate::define('view-profile', function (User $user, User $profile) {
            return (new ProfilePolicy())->view($user, $profile);
        });

        Gate::define('update-profile', function (User $user, User $profile) {
            return (new ProfilePolicy())->update($user, $profile);
        });

        Gate::define('delete-profile', function (User $user, User $profile) {
            return (new ProfilePolicy())->delete($user, $profile);
        });
    }
}
