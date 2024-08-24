<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use Illuminate\Support\Facades\Gate;
// use App\Models\Post;
// use App\Policies\PostPolicy;
// use App\Models\Discussion;
// use App\Policies\DiscussionPolicy;


class AppServiceProvider extends ServiceProvider
{
    
    // protected $policies = [
    //     // Post::class => PostPolicy::class,
    //     // Discussion::class => DiscussionPolicy::class,
    //     // \App\Models\Post::class => \App\Policies\PostPolicy::class,
    // ];

    public function register(){

    }
    

    public function boot()
    {
        // $this->registerPolicies();

        // Additional boot logic, if needed
    }
}
