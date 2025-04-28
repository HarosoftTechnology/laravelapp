<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $session;
    public $noMenu = false;
    public $noBanner = false;
    public string $title = "";
    public string $pageTitle = "";
    public $keywords = "";
    public $description = "";
    /**
     * Default meta tags. Controllers can override any of these.
     */
    
    // protected $metaTags = [
    //     'title'       => '', // If empty, it will default to config('site-title')
    //     'description' => 'This is the default description for the website.',
    //     'keywords'    => 'default, laravel, meta tags'
    // ];

    public function __construct(Store $session)
    {
        $this->session = $session;

        // Use a closure to conditionally apply the session.timeout middleware only if the user is authenticated
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                // Dynamically resolve and execute the SessionTimeout middleware
                $middleware = resolve(\App\Http\Middleware\SessionTimeout::class);
                return $middleware->handle($request, $next);
            }
            return $next($request);
        });
    }

    /**
     * Get the view type based on the first URI segment.
     * Added by Dele
     *
     * @return string
     */
    public static function viewType()
    {
        $segment = request()->segment(1);
        return ($segment === 'admincp') ? 'backend' : 'frontend';
    }

    public function removeMenu($value = false) {
        $this->noMenu = $value;
        return $this;
    }

    public function removeBanner($value = false) {
        $this->noBanner = $value;
        return $this;
    }
}
