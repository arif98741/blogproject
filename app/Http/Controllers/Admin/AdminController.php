<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function dashboard()
    {
        $data = [
            'post_count' => Post::select('status', DB::raw('count(id) as total'))
                ->orderBy('status','desc')
                ->groupBy('status')
                ->get(),
            'author' => User::count(),
        ];


        return view('back.dashboard')->with($data);
    }
}
