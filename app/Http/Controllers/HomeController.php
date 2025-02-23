<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     $user = Auth::user();
    //     if ($user->is_admin == 1) {
    //         // return view('backend.dashboard');
    //         return redirect()->route('admin.dashboard'); // Redirect ke admin dashboard
    //     } else {
    //         $categories = Category::all();
    //         $product = Product::all();
    //         return view('home', compact('categories', 'product'));
    //     }
    // }
    public function index()
    {
        $categories = Category::all();
        $product = Product::all();
        return view('home', compact('categories', 'product'));
    }

}
