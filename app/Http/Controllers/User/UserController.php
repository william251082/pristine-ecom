<?php

namespace App\Http\Controllers\User;

use App\Mail\UserCreated;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Mail;

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

    public function show(User $user): JsonResponse
    {
        return $this->showOne($user);
    }

    public function update(Request $request, User $user): JsonResponse
    {
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

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->showOne($user);
    }

    public function verify(string $token): JsonResponse
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage('The account has been successfully verified.');
    }

    public function resend(User $user)
    {
        if ($user->isVerified()) {
            return $this->errorResponse('This user is already verified.', 409);
        }

        Mail::to($user)->send(new UserCreated($user));

        return $this->showMessage('The verification email has been resend.');
    }
}
