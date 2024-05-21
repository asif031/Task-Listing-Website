@extends('layouts.app')

@section('title',$task->title)

@section('content')

    {{-- go back to task list  --}}
    <div class="mb-4">
        <a href="{{ route('tasks.index') }}" 
            class="link">
            ← Go back to the task list!</a>
    </div>


    <p class="mb-4 text-slate-700 hrline ">{{ $task->description }}</p>

    @if ($task->long_description)
        <p class="mb-4 text-slate-700 hrline">{{ $task->long_description }}</p>
    @endif

    <p class="mb-4 text-sm text-slate-500">Created: {{ $task->created_at->diffForHumans() }} • Updated: {{ $task->updated_at->diffForHumans() }}</p>


    <p class="mb-4">
        @if ($task->completed)
            <span class="font-medium text-green-500">Task Completed</span>
            
        @else
            <span class="font-medium text-red-500">Task Not Completed</span>
            
        @endif

    </p>

    

  

    <div class="flex gap-2">
        <form action="{{ route('tasks.toggleComplete',['task'=>$task]) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn">
                Mark as {{ $task->completed? "Not Completed": "Completed" }}
            </button>
        </form>
 
        <a href="{{ route('tasks.edit',['task'=>$task]) }}"
            class="btn">EDIT</a>
 
        <form action="{{ route('tasks.destroy',['task'=>$task]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">DELETE</button>        
        </form>
    </div>

@endsection