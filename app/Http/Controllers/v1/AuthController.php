<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * API of User registration
     *
     *  @param  \Illuminate\Http\Request  $request
     * @return $token
     */
    public function register(Request $request)
    {
        //validation
        $request->validate([
            'name'      => 'required|string|max:51',
            'email'     => 'required|email|unique:users,email|max:255',
            'password'  => 'required|max:255',
        ]);

        $user = User::create($request->only('name', 'email') + [
            'password' => Hash::make($request->password)
        ]);
        // $token = $user->createToken($request->email)->plainTextToken;
        $data = [
            'user'  => $user
        ];

        return ok("User registered successfully!", $data);
    }

    /**
     * API of User login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return error("User with this email is not found!");
        }
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($request->email)->plainTextToken;

            $data = [
                'token' => $token,
                'user'  => $user
            ];
            return ok('User Logged in Succesfully', $data);
        } else {
            return error("Password is incorrect");
        }
    }

    /**
     * API of User Logout
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return ok("Logged out successfully!");
    }
}
