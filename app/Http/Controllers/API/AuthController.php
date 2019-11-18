<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @param UserRegisterRequest $request
     * @param User $user
     * @return Response
     */
    public function register(UserRegisterRequest $request, User $user)
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
     * @param UserLoginRequest $request
     * @return Response
     */
    public function login(UserLoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (password_verify($request->password, $user->password)) {

                // Update Token
                $login = User::where('email', $request->email)
                    ->update(['api_token' => $this->apiToken]);

                if($login) {
                    return response()->json([
                        'name' => $user->name,
                        'email' => $user->email,
                        'access_token' => $this->apiToken,
                    ]);
                }

            } else {
                return response()->json(['message' => 'Invalid Password'], 422);
            }
        } else {
            return response()->json(['message' => 'User not found'], 422);
        }
    }

    /**
     * Logout User
     *
     * @param Request $request * @return void
     * @return Response
     */
    public function logout(Request $request)
    {

        $user = $request->get('user');

        $logout = User::where('id',$user->id)->update(['api_token' => null]);

        if($logout) {
            return response()->json([
                'message' => 'User Logged Out'
            ]);
        }
    }

}
