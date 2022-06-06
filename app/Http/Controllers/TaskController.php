<?php

declare(strict_type=1);
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;

class TaskController extends Controller
{
    /**
     * トップページを表示する
     * 
     * @return\Illuminate\View\View
     * */
     public function list()
     {
         //1ページあたりのアイテム数の設定
         $per_page=2;
         
         //一覧の取得
         $list=TaskModel::where('user_id',Auth::id())
         ->orderBy('priority','DESC')
         ->orderBy('period')
         ->orderBy('created_at')
         ->paginate($per_page);
        // ->get();
         
         /*
         $sql=TaskModel::where('user_id',Auth::id())
         ->orderBy('priority','DESC')
         ->orderBy('period')
         ->orderBy('created_at')
         ->toSql();
         
         //echo"<pre>\n";var_dump($sql,$list);exit;
         var_dump($sql);
         */
         return view('task.list',['list'=>$list]);
     }
     
     public function register(TaskRegisterPostRequest $request)
     {
         //validate済みのデータ取得
         $datum=$request->validated();
         
         // $user=Auth::user();
         //$id=Auth::id();
         //var_dump($datum,$user,$id);exit;
         
         //user_idの取得
         $datum['user_id']=Auth::id();
         //テーブルへのINSERT
         try{
             $r=TaskModel::create($datum);
         //var_dump($r);exit;
     }catch(\Throwable $e){
         echo $e->getMessage();
         exit;
     }
     //タスク登録成功
     $request->session()->flash('front.task_register_success',true);
     
     return redirect('/task/list');
     }
     
     // タスクの詳細閲覧
     public function detail($task_id)
     {
      //task_idのレコード取得
     $task=TaskModel::find($task_id);
     if($task===null){
      return redirect('/task/list');
     }
     //本人以外のタスクならNGにする
     if($task->user_id !==Auth::id()){
      return redirect('/task/list');
     }
      
      //テンプレートに「取得したコードの情報を渡す
      return view('task.detail',['task'=>$task]);
      
     }
}
