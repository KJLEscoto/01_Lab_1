<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AuthenticatedUserResource;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\AuthenticatedCreateUserResource;
use App\Http\Resources\CreateUserResource;

class AuthController extends Controller
{
    public function authenticate(AuthenticateUserRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid Login Credentials']
            ]);
        }

        $request = (object)[
            'user' => new UserResource($user),
            'token' =>$user->createToken('auth-token')->plainTextToken
        ];
        return new AuthenticatedUserResource($request);
    }

    public function create(CreateUserRequest $request) 
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $request = (object)[
            'user' => new UserResource($user),
            'token' =>$user->createToken('auth-token')->plainTextToken
        ];
        return new AuthenticatedUserResource($request);            
    }

    public function getUsers() 
    {
        $users = User::all();

        if ($users->count() > 0) {
            return response()->json(['users' => $users]);
        } else {
            return response()->json([
                'users' => 'No users Found'
            ]);
        }
    }
}