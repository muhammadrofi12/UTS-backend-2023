<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //bikin fungsi register
    public function register(Request $request)
    {
        #tangkap input
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        # insert ke tabel user
        $user = User::create($input);

        $data = [
            'message' => 'User is created succesfully',
        ];

        return response()->json($data, 200);
    }

    # bikin login
    public function login(Request $request)
    {
        #tangkap input
        $input = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        # ambil data user
        $user = User::where('email', $input['email'])->first();

        # bandingkan input user dengan data di DB
        $isLoginSuccessfully = ($input['email'] === $user->email &&
            Hash::check($input['password'], $user->password)
        );

        if ($isLoginSuccessfully) {

            # buat token
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login successfully',
                'token' => $token->plainTextToken,
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Login failed',
            ];

            return response()->json($data, 401);
        }
    }
}
