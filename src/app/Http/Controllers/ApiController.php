<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @throws AuthorizationException
     */
    protected function allowedAdminAction()
    {
        if (Gate::denies('admin-action')) {
            throw new AuthorizationException('This action is unauthorized.');
        }
    }
}
