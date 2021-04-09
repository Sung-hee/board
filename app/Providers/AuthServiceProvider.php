<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Article;
use Facade\FlareClient\Http\Response;
// use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::define('update-post', function (User $user, Article $article) {
            return $user->id === $article->user_id;
        });
        //
        // Gate::define('article-auth-check', function(User $user, Article $article) {
        //     echo $user->id;
        //     echo $article->user_id;
        //     return $user->id === $article->user_id
        //         ? Response::allow() : Response::deny('작성자가 아닙니다');
        // });
    }
}
