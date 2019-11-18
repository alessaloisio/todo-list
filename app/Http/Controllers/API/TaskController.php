<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $project_id
     * @param  string  $list_id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $project_id, $list_id)
    {
        $project = DB::table('projects')
            ->where('user_id', $request->get('user')->id)
            ->where('id', $project_id)
            ->get()->first();

        if($project) {

            $lists = DB::table('lists')
                ->where('project_id', $project_id)
                ->where('id', $list_id)
                ->get()->first();

            if ($lists) {
                $tasks = DB::table('tasks')
                    ->where('list_id', $list_id)
                    ->get()->all();
                return response()->json([
                    'status' => 200,
                    'list' => $lists
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'List not found.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Project not found'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $project_id
     * @param  string  $list_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id, $list_id)
    {

        $validator = Validator::make($request->all(), [
            'content_task'     => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        }
        else {

            $project = DB::table('projects')
                ->where('user_id', $request->get('user')->id)
                ->where('id', $project_id)
                ->get()->first();

            if ($project) {

                $lists = DB::table('lists')
                    ->where('project_id', $project_id)
                    ->where('id', $list_id)
                    ->get()->first();

                if ($lists) {

                    $postArray = [];

                    $postArray['list_id'] = $list_id;
                    $postArray['created_at'] = now();
                    if (!empty($request->content_task)) {
                        $postArray['content'] = $request->content_task;
                    }

                    $list = DB::table('tasks')->insert($postArray);

                    if ($list) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Task created'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'Task not created',
                        ]);
                    }

                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'List not found'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Project not found'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
