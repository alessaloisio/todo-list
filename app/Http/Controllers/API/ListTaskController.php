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

    }
}
