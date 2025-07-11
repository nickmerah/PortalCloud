<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Users;
use App\Policies\MenuPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Users::class => MenuPolicy::class,
    ];


    public function boot(): void
    {
        $this->registerPolicies();
    }
}
