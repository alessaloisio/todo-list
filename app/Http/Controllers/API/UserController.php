<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Show User
     *
     * @param Request $request * @return void
     * @return Response
     */
    public function show(Request $request)
    {

        $user = $request->get('user');

        $user = User::where('id',$user->id)->get()->first();

        if($user) {
            return response()->json($user);
        }

        return response()->json(['message'=>'User not found.'], 422);
    }

    /**
     * Show User
     *
     * @param UserPostRequest $request * @return void
     * @return Response
     */
    public function update(UserPostRequest $request)
    {

        $user = $request->get('user');

        $user = User::where('id',$user->id)->get()->first();

        if($user) {
            if(!empty($request->name)) $user->name = $request->name;
            if(!empty($request->email) && $request->email !== $user->email) {

                $result = User::where('email', $request->email)->get()->first();

                if($result) {
                    return response()->json(['message'=>'Email already used'], 422);
                } else {
                    $user->email = $request->email;
                }
            }
            if(!empty($request->password)) $user->password = bcrypt($request->input('password'));

            $result = $user->save();

            if($result)
                return response()->json(['message' => 'User updated']);
        }

        return response()->json(['message'=>'User not found.'], 422);
    }
}
