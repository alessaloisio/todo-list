<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $apiToken;

    public function __construct()
    {
        $this->apiToken = uniqid(base64_encode(Str::random(60)));
    }

    /**
     * Register User
     *
     * @param UserRequest $request
     * @param User $user
     * @return Response
     */
    public function register(UserRequest $request, User $user)
    {

        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->password = bcrypt($request->input('password'));
        $user->api_token = $this->apiToken;

        $user->save();

        return response()->json(['message' => 'User registered']);
    }

    /**
     * Login User
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {

    }

    /**
     * Logout User
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {

    }

}
