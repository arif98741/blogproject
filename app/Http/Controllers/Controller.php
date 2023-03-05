<?php

namespace App\Http\Controllers;

use App\AppTrait\AuthTrait;
use App\AppTrait\FileTrait;
use App\Core\Models\Navigation\Navigation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, AuthTrait, FileTrait;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            return $next($request);
        });

    }
}
