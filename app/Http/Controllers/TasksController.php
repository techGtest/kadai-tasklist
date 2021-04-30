<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task; 

//Model名：Task(Modelのclass名も同)
//$URI：/tasks(ルーティング設定済)

class TasksController extends Controller
{
    public function index() //一覧を表示
    {
        $tasks = Task::all();
        
        return view('tasks.index', ['tasks'=>$tasks,]);
    }

    public function create() //入力フォームを表示
    {
        $task = new Task;
        
        return view('tasks.create', ['task'=>$task,]);
    }

    public function store(Request $request) //投稿機能
    {
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',
        ]);
        
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    
    public function show($id) //詳細ページ表示
    {
        $task = Task::findOrFail($id);
        
        return view('tasks.show', ['task'=>$task,]);
    }

    
    public function edit($id) //編集ページ表示
    {
        $task = Task::findOrFail($id);
        
        return view('tasks.edit', ['task'=>$task,]);
        
    }

   
    public function update(Request $request, $id) //編集機能
    {
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',
        ]);
        
        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    
    public function destroy($id) //削除機能
    {
        $task = Task::findOrFail($id);
        $task->delete();
        
         return redirect('/');
    }
}
