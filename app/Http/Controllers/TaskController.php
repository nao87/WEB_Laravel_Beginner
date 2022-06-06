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
     return $this->singleTaskRender($task_id,'task.detail');
     }
     
     //タスクの編集画面表示
     public function edit($task_id)
     {
      //task_idのレコードを取得すr
      //テンプレートに「取得したレコード」の情報を渡す
      return $this->singleTaskRender($task_id,'task.edit');
     }
     
     
     protected function getTaskModel($task_id)
     {
         //task_idのレコード取得
     $task=TaskModel::find($task_id);
     if($task===null){
        return null;
     }
     //本人以外のタスクならNGにする
     if($task->user_id !==Auth::id()){
        return null;
     }
     return $task;
     }
     
     //「単一タスク」の表示
     protected function singleTaskRender($task_id,$template_name)
     {
      //task_idのレコード取得
        $task=$this->getTaskModel($task_id);
        if($task===null){
        return redirect('/task/list');
        }
      //テンプレートに「取得したコードの情報を渡す
      return view($template_name,['task'=>$task]);
     }
     
     //タスクの編集処理
     public function editSave(TaskRegisterPostRequest $request,$task_id)
     {
      //formからの情報取得
      $datum=$request->validated();
      
      //task_idのレコード取得
      $task=TaskModel::find($task_id);
      if($task===null){
       return redirect('/task/list');
      }
      
      //コード内容をUPDATEする
      $task->name=$datum['name'];
      $task->period=$datum['period'];
      $task->detail=$datum['detail'];
      $task->priority=$datum['priority'];
      
      /*可変変数を使った書き方
      foreach($datum as $k => $v) {
            $task->$k = $v;
        }
      */
      
      //レコード更新
      $task->save();
      //タスク編集成功
      $request->session()->flash('front.task_edit_success',true);
      //詳細閲覧画面にリダイレクトする
      return redirect(route('detail',['task_id'=> $task->id]));
     }
}
