<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPostRequest;
use App\Http\Requests\ProjectPutRequest;
use App\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $projects = Project::where('user_id', $request->get('user')->id)->get();

        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectPostRequest $request
     * @param Project $project
     * @return Response
     */
    public function store(ProjectPostRequest $request, Project $project)
    {

        $data = $request->validated();

        $project->name = $data['name'];
        $project->description = $data['description'];
        $project->user_id = $request->get('user')->id;

        $result = $project->save();

        if($result) return response()->json(['message' => 'Project added']);

        return response()->json(['message' => 'Project not added'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $project = Project::where('user_id', $request->get('user')->id)
            ->where('id', $id)
            ->get();

        if($project) return response()->json($project);

        return response()->json(['message' => 'Project not found'], 422);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  string  $id
     * @return Response
     */
    public function update(ProjectPutRequest $request, $id)
    {
        $project = Project::where('user_id', $request->get('user')->id)->where('id', $id)->first();

        if($project) {
            if(!empty($request->name)) $project->name = $request->name;
            if(!empty($request->description)) $project->description = $request->description;

            $result = $project->save();

            if($result)
                return response()->json(['message' => 'Project updated']);
        }

        return response()->json(['message' => 'Project not updated'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  string  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $project = Project::where('user_id', $request->get('user')->id)->where('id', $id)->delete();

        if($project)
            return response()->json(['message' => 'Project deleted']);

        return response()->json(['message' => 'Project not deleted'], 422);

    }
}
