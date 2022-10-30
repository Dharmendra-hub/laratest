<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /*
     * Calling Our Custom Created Trait
     */
    use HttpResponses;

    /**     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaskResource::collection(
            Task::where('user_id',Auth::user()->id)->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     * THIS IS A AUTO GENERATED FUNCTION WHICH IS USED FOR CREATING ENTRIES USING HTML FORM - BUT WE ARE USING API'S SO WILLN NOT USE THIS
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());

        $task = Task::create([
            'user_id'=>Auth::user()->id,
            'name'=> $request->name,
            'description'=> $request->description,
            'priority'=> $request->priority
        ]);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * THIS IS ELOQUENT WAY TO GET FROM THE DB ANOTHER WAY USING THE ENTIRE RESOURCE IS COPIED BELOW
     */
//    public function show($id)
//    {
//        //get user by specific loggedin user only
//        $task = Task::where('id',$id)->get();
//        return $task;
//    }

    public function show($id)
    {
        //Way one using condtion everytime
        //if(Auth::user()->id !== $task->user_id){
        //    return $this->error(NULL,'You are not authorized for this request',403);
        //}
        //return new TaskResource($task);

        $task = Task::find($id);
        if($task){
            return $this->isNotAuthorized($task) ? $this->isNotAuthorized($task) : new TaskResource($task);
        }
        return $this->error(NULL,"Task with id: {$id} not found or deleted",404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if(Auth::user()->id !== $task->user_id){
            return $this->error(NULL,'You are not authorized for this request',403);
        }
        $task->update($request->all());

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if($task){
            $task->delete();
            return $this->success('action_success',"Task with id: {$id} is deleted",200);
            //return new TaskResource($task);
        }
        return $this->error(NULL,"Task with id: {$id} not found or deleted",404);
        //abort(404, "Task with id: {$task->id} does not exists");
    }

    private function isNotAuthorized($task){
        if(Auth::user()->id !== $task->user_id){
            return $this->error(NULL,'You are not authorized for this request',403);
        }
    }

}
