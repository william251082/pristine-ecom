<?php

namespace App\Http\Controllers\User;

use App\Mail\UserCreated;
use App\Transformers\UserTransformer;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserController extends ApiController
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store', 'resend']);
        $this->middleware('auth:api')->except(['store', 'verify', 'resend']);
        $this->middleware('transform.input:'.UserTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-account')->only(['show', 'update']);
        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:delete,user')->only('destroy');
    }

    /**
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        $this->allowedAdminAction();
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

    /**
     * @throws AuthorizationException
     * @throws ValidationException
     */
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
            $this->allowedAdminAction();
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

    /**
     * @throws Exception
     */
    public function resend(User $user)
    {
        if ($user->isVerified()) {
            return $this->errorResponse('This user is already verified.', 409);
        }

        retry(5, function () use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);

        return $this->showMessage('The verification email has been resend.');
    }
}
