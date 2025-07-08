<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Blade directive for role
        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && in_array(auth()->user()->role, array_map('trim', explode(',', $role)))): ?>";
        });
        Blade::directive('endrole', function () {
            return '<?php endif; ?>';
        });

        Gate::define('manage-users', function ($user) {
            return strtolower($user->role) === 'admin';
        });
    }
}
