<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task; 

//Model名：Task(Modelのclass名も同)
//$URI：/tasks(ルーティング設定済)

class TasksController extends Controller
{
    public function index()//一覧を表示
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->paginate(10);
        }
        return view('tasks.index', ['tasks'=>$tasks,]);
    }

    public function create() //入力フォームを表示
    {
        if (\Auth::check()) {
        return view('tasks.create');
        }
    }

    public function store(Request $request) //投稿機能
    {
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',
        ]);
        
        $tasks=$request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        return redirect('/tasks');
    }

    
    public function show($id) //詳細ページ表示
    {
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', ['task'=>$task,]);
        }
        return redirect('/tasks');
    }

    
    public function edit($id) //編集ページ表示
    {
        $task = Task::findOrFail($id);
        
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', ['task'=>$task,]);
        }
        return redirect('/tasks');
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
        
        return redirect('/tasks');
    }

    
    public function destroy($id) //削除機能
    {
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        return redirect('/tasks');
    }
}
