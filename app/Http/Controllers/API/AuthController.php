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
