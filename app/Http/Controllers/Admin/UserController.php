<?php

declare(strict_type=1);
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\User as UserModel;

class UserController extends Controller
{
    /**
     * ユーザー一覧 を表示する
     * 
     * @return \Illuminate\View\View
     */
     public function list()
     {
         $group_by_column=['users.id','users.name'];
         $list=UserModel::select($group_by_column)
             ->selectRaw('count(tasks.id) AS task_num')
             ->leftJoin('tasks','users.id','=','tasks.user_id')
             ->groupBY($group_by_column)
             ->orderBY('users.id')
             ->get();
//echo"<pre>\n";
//var_dump($list->toArray());exit;
         return view('admin.user.list',['users'=>$list]);
     }
}