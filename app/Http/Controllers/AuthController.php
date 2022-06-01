<?php

declare(strict_type=1);
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;

class AuthController extends Controller
{
    /**
     * トップページを表示する
     * 
     * @return\Illuminate\View\View
     * */
     public function index()
     {
         return view('index');
     }
     public function login(LoginPostRequest $request)
     {
         //validate済
         
         //データの取得
         $datum=$request ->validated();
         var_dump($datum);exit;
     }
     
}
