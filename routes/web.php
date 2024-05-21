<?php

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\task;
use App\Http\Requests\TaskRequest;

// Redirecting to main page
Route:: get('/',function(){
    return redirect()->route('tasks.index');
});


//Routing to main page
Route::get('/tasks', function (){
    return view('index',[
        'tasks'=>task::latest()->paginate(10)
    ]);
})->name('tasks.index');


//Routing to task CREATE page
Route::view('/tasks/create','create')
    ->name('task.create');

//Routing to Task EDIT page
Route:: get('/tasks/{task}/edit',function(task $task){

  return view('edit',['task'=>$task]);
})->name('tasks.edit');



//Routing to Individual Task page
Route:: get('/tasks/{task}',function(task $task){

    return view('show',['task'=>$task]);
})->name('tasks.show');


//inserting to database or 
//creating a task after form submission
Route::post('/tasks',function(TaskRequest $request){
  // $data = $request->validated();
  // $task = new task;
  // $task->title = $data['title'];
  // $task->description = $data['description'];
  // $task->long_description = $data['long_description'];
  // $task->save();
  $task=task::create($request->validated());

  return redirect()->route('tasks.show',['task'=>$task->id])
                      ->with('success','Task Created Successfully!');
})->name('tasks.store');



//Updatinh to database or 
//editinh a task after form submission
Route::put('/tasks/{task}',function(task $task,TaskRequest $request){
  // $data = $request->validated();
  // $task->title = $data['title'];
  // $task->description = $data['description'];
  // $task->long_description = $data['long_description'];
  // $task->save();
  $task->update($request->validated());

  return redirect()->route('tasks.show',['task'=>$task->id])->with('success','Task Updated Successfully!');
})->name('tasks.update');

//deleting task
Route::delete('/tasks/{task}',function(task $task){
  $task->delete();
  return redirect()->route('tasks.index')
          ->with('success','Task Successfully Deleated!');
})->name('tasks.destroy');


//adding toggle route
Route::put('/tasks/{task}/toggle-complete',function(task $task){
  $task->toggleComplete();
  return redirect()->back()->with('success','Task Updated Successfully');
})->name('tasks.toggleComplete');
// Route:: get('/greet/{name}',function($name){
//     return "Hello ". $name;
// });


// Route:: get('/hello',function(){
//     return "Hello";
// })->name('helloRoute');

// Route:: get('/hallo', function(){

//     return redirect()->route('helloRoute');
// });

//fallback
Route:: fallback(function(){
    return "WRONG URL MATE";
});
