<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * This is the instance of the current logged in user.
     * @var App\User
     */
    protected $user;

    /**
     * [__construct description]
     */
    public function __construct()
    {
        /**
         * Inject currently logged in user or staff Doing $this->user = Auth::guard('user')->user();
         * will not work as the service providers are still being loaded hence the need to
         * enclose it in a middleware
         */
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();

            return $next($request);
        });
    }
}
