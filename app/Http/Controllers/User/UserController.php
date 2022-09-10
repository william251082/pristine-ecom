<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Traits\ApiResponser;

class UserController extends ApiController
{
    use ApiResponser;

    public function index(): JsonResponse
    {
        $users = User::all();

        return $this->showAll($users);
    }

    public function store(Request $request): JsonResponse
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:6|confirmed',
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return $this->showOne($user, 201);
    }

    public function show($id): JsonResponse
    {
        $user = User::findOrFail($id);

        return $this->showOne($user);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $rules = [
            'email' => 'required|email|unique:user,email,'.$user->id,
            'password' => 'required|min:6|confirmed',
            'admin' => 'in:'.User::ADMIN_USER.','.User::REGULAR_USER
        ];
        $this->validate($request, $rules);

        if ($request->has('name')) {
             $user->name = $request->name;
        }
        if ($request->has('email') && $user->email !== $request->email) {
            $user->verified = User::VERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return $this->errorResponse('Only verified users can modify.', 409);
            }
            $user->admin = $request->admin;
        }
        if (!$user->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update.', 422);
        }
        $user->save();

        return $this->showOne($user);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->showOne($user);
    }
}
