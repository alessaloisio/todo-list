<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {

        // Validations : https://laravel.com/docs/5.7/validation#manually-creating-validators
        $validator = Validator::make($request->all(), [
            'name'     => 'required|min:3',
            'email'    => 'required|unique:users,email',
            'password' => 'required|min:8'
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
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'api_token' => $this->apiToken
            ];

            $user = User::create($postArray);

            if ($user) {
                return response()->json([
                    'status' => 200,
                    'name' => $request->name,
                    'email' => $request->email
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Registration failed, please try again.',
                ]);
            }

        }
    }

    /**
     * Login User
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        }
        else
        {
            // Fetch User
            $user = User::where('email', $request->email)->first();

            if ($user) {
                // Verify the password
                if (password_verify($request->password, $user->password)) {

                    // Update Token
                    $postArray = ['api_token' => $this->apiToken];
                    $login = User::where('email', $request->email)->update($postArray);

                    if($login) {
                        return response()->json([
                            'status' => 200,
                            'name' => $user->name,
                            'email' => $user->email,
                            'access_token' => $this->apiToken,
                        ]);
                    }

                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Invalid Password'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'User not found'
                ]);
            }
        }
    }

    /**
     * Logout User
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {

        $user = $request->get('user');

        $postArray = ['api_token' => null];
        $logout = User::where('id',$user->id)->update($postArray);

        if($logout) {
            return response()->json([
                'status' => 200,
                'message' => 'User Logged Out'
            ]);
        }

    }

}
