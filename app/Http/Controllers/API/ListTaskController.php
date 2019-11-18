<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListTaskPostRequest;
use App\Http\Requests\ListTaskPutRequest;
use App\ListTask;
use App\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $project_id
     * @return Response
     */
    public function index(Request $request, $project_id)
    {
        $projects = Project::where('user_id', $request->get('user')->id)
            ->where('id', $project_id)->get()->first();

        if($projects) {
            $lists = ListTask::where('project_id', $project_id)->get();

            if(!empty($lists)) return response()->json($lists);
        }

        return response()->json(['message' => 'Lists not found'], 422);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ListTaskPostRequest $request
     * @param $project_id
     * @param ListTask $listTask
     * @return Response
     */
    public function store(ListTaskPostRequest $request, $project_id, ListTask $listTask)
    {

        $data = $request->validated();

        $listTask->name = $data['name'];
        $listTask->project_id = $project_id;

        $result = $listTask->save();

        if($result) return response()->json(['message' => 'List added']);

        return response()->json(['message' => 'List not added'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  string  $project_id
     * @param  string  $list_id
     * @return Response
     */
    public function show(Request $request, $project_id, $list_id)
    {
        $projects = Project::where('user_id', $request->get('user')->id)
            ->where('id', $project_id)->get()->first();

        if($projects) {
            $list = ListTask::where('project_id', $project_id)->where('id', $list_id)->get()->first();

            if($list) return response()->json($list);
        }

        return response()->json(['message' => 'List not found'], 422);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ListTaskPutRequest $request
     * @param string $project_id
     * @param string $list_id
     * @param ListTask $listTask
     * @return Response
     */
    public function update(ListTaskPutRequest $request, $project_id, $list_id)
    {

        $projects = Project::where('user_id', $request->get('user')->id)
            ->where('id', $project_id)->get()->first();

        if($projects) {

            $listTask = ListTask::where('project_id', $project_id)->where('id', $list_id)->get()->first();

            if ($listTask) {
                if (!empty($request->name)) $listTask->name = $request->name;

                $result = $listTask->save();

                if ($result)
                    return response()->json(['message' => 'List updated']);
            }

        }

        return response()->json(['message' => 'List not updated'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  string  $project_id
     * @param  string  $list_id
     * @return Response
     */
    public function destroy(Request $request, $project_id, $list_id)
    {
        $projects = Project::where('user_id', $request->get('user')->id)
            ->where('id', $project_id)->get()->first();

        if($projects) {
            $list = ListTask::where('project_id', $project_id)->where('id', $list_id)->delete();

            if($list) return response()->json(['message' => 'List deleted']);
        }

        return response()->json(['message' => 'List not deleted'], 422);
    }
}
