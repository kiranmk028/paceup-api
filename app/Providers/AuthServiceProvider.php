<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Folder;
use App\Models\PList;
use App\Models\Space;
use App\Models\Workspace;
use App\Policies\FolderPolicy;
use App\Policies\PListPolicy;
use App\Policies\SpacePolicy;
use App\Policies\WorkspacePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Workspace::class => WorkspacePolicy::class,
        Space::class => SpacePolicy::class,
        Folder::class => FolderPolicy::class,
        PList::class => PListPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
