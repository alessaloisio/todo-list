<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\ListTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ListTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $project = DB::table('projects')
            ->where('user_id', $request->get('user')->id)
            ->where('id', $id)
            ->get()->first();

        if($project) {

            $lists = DB::table('lists')
                ->where('project_id', $id)
                ->get();

            if ($lists) {
                return response()->json([
                    'status' => 200,
                    'lists' => $lists
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Saving failed, please try again.'
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
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
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
        else
            {
                $project = DB::table('projects')
                    ->where('user_id', $request->get('user')->id)
                    ->where('id', $id)
                    ->get()->first();

                if($project) {

                    $postArray = [];

                    $postArray['created_at'] = now();
                    $postArray['project_id'] = $id;
                    $postArray['name'] = $request->name;

                    $list = DB::table('lists')->insert($postArray);

                    if ($list) {
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
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $project_id
     * @param  string  $list_id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $project_id, $list_id)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $project_id
     * @param  string  $list_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id, $list_id)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'max:255'
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

                    if (!empty($request->name)) {
                        $postArray['name'] = $request->name;
                    }

                    $list = DB::table('lists')
                        ->where('id', $list_id)
                        ->update($postArray);

                    if ($list) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'List updated'
                        ]);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'List not updated',
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
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $project_id
     * @param  string  $list_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $project_id, $list_id)
    {
        $project = DB::table('projects')
            ->where('user_id', $request->get('user')->id)
            ->where('id', $project_id)
            ->get()->first();

        if($project) {

            $list = DB::table('lists')
                ->where('project_id', $project_id)
                ->where('id', $list_id)
                ->delete();

            if ($list) {
                return response()->json([
                    'status' => 200,
                    'message' => 'List deleted'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'List not deleted',
                ]);
            }

        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Project not deleted',
            ]);
        }
    }
}
