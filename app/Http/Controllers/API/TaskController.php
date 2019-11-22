<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskPostRequest;
use App\Http\Requests\TaskPutRequest;
use App\ListTask;
use App\Project;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param  string  $project_id
     * @param  string  $list_id
     * @return Response
     */
    public function index(Request $request, $project_id, $list_id)
    {
        $project = Project::where('user_id', $request->get('user')->id)
            ->where('projects.id', $project_id)->get()->first();

        if($project) {
            $list = ListTask::where('project_id', $project_id)->where('id', $list_id)->get()->first();

            if($list) {
                $tasks = Task::where('list_id', $list_id)->get();

                return response()->json($tasks);
            }
        }

        return response()->json(['message' => 'Tasks not found'], 422);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskPostRequest $request
     * @param string $project_id
     * @param string $list_id
     * @param Task $task
     * @return Response
     */
    public function store(TaskPostRequest $request, $project_id, $list_id, Task $task)
    {
        $project = Project::where('user_id', $request->get('user')->id)
            ->where('projects.id', $project_id)->get();

        if($project) {

            $list = ListTask::where('project_id', $project_id)
                ->where('id', $list_id)
                ->get()->first();

            if($list) {
                $data = $request->validated();

                $task->content = $data['content'];
                $task->list_id = $list_id;

                $result = $task->save();

                if($result) return response()->json($task->getOriginal());
            }
        }

        return response()->json(['message' => 'Task not added'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $project_id
     * @param $list_id
     * @param $task_id
     * @return Response
     */
    public function show(Request $request, $project_id, $list_id, $task_id)
    {
        $project = Project::where('user_id', $request->get('user')->id)
            ->where('id', $project_id)->get()->first();

        if($project) {
            $list = ListTask::where('project_id', $project_id)->where('id', $list_id)->get()->first();

            if($list) {
                $task = Task::where('list_id', $list_id)->where('id', $task_id)->get()->first();

                return response()->json($task);
            }
        }

        return response()->json(['message' => 'Tasks not found'], 422);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskPutRequest $request
     * @param $project_id
     * @param $list_id
     * @param $task_id
     * @return Response
     */
    public function update(TaskPutRequest $request, $project_id, $list_id, $task_id)
    {
        $project = Project::where('user_id', $request->get('user')->id)
            ->where('projects.id', $project_id)->get();

        if($project) {

            $list = ListTask::where('project_id', $project_id)
                ->where('id', $list_id)
                ->get()->first();

            if($list) {

                $task = Task::where('id', $task_id)->get()->first();

                if($task) {
                    if (!empty($request->content)) $task->content = $request->content;
                    if (!empty($request->confirmed)) $task->confirmed = $request->confirmed;

                    $result = $task->save();

                    if ($result)
                        return response()->json($task->getOriginal());
                }

                return response()->json($task);
            }
        }

        return response()->json(['message' => 'Task not updated'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $project_id
     * @param $list_id
     * @param $task_id
     * @return Response
     */
    public function destroy(Request $request, $project_id, $list_id, $task_id)
    {
        $project = Project::where('user_id', $request->get('user')->id)
            ->where('id', $project_id)->get()->first();

        if($project) {
            $list = ListTask::where('project_id', $project_id)->where('id', $list_id)->get()->first();

            if($list) {
                $task = Task::where('list_id', $list_id)->where('id', $task_id)->delete();

                if($task) return response()->json(['message' => 'Tasks deleted']);
            }
        }

        return response()->json(['message' => 'Tasks not deleted'], 422);
    }
}
