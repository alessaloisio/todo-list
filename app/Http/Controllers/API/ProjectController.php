<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Project;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = DB::table('projects')
            ->where('user_id', $request->get('user')->id)
            ->get();

        return response()->json([
            'status' => 200,
            'projects' => $projects
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        }
        else {

            $postArray = [
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => $request->get('user')->id
            ];

            $project = Project::create($postArray);

            if ($project) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Project saved'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Saving failed, please try again.'
                ]);
            }
        }
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
        $project = DB::table('projects')
            ->where('user_id', $request->get('user')->id)
            ->where('id', $id)
            ->get();

        return response()->json([
            'status' => 200,
            'projects' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

    }
}
