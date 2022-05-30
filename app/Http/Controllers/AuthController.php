<?php

declare(strict_type=1);
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * トップページを表示する
     * 
     * @return\Illuminate\View\View
     * */
     public function index()
     {
         return view('welcome');
     }
     
     /*2ndページを表示する
     @return \Illuminate\Vie\View
     */
     public function second()
     {
         return view('Welcome_second');
     }
}