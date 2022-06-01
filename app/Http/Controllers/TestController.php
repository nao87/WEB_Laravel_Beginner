<?php

declare(strict_type=1);
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TestPostRequest;

class TestController extends Controller
{
    /**
     * トップページを表示する
     * 
     * @return\Illuminate\View\View
     * */
     public function index()
     {
         return view('test.index');
     }
     
     public function input(TestPostRequest $request)
     {
         //validate済
         
         //データ取得
         $validateData=$request ->validated();
             
             //var_dump($validateData); exit;
         /*validation入力前
         $email=$request ->input('email');
         $pass=$request ->input('pass');
         var_dump($email,$pass);
         exit;
         */
         return view('test.input',['datum'=>$validateData]);
     }
  
}
