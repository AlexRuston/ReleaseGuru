<?php
/**
 * Test file directory:
 * tests/Feature/Users
 */

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        /*
         * if a user can't viewAny, they definitely can't perform any other actions
         * so we'll apply the Policy check here
         * and give them a 403 if they're not allowed to proceed
         * */
        if ((Auth::check()) && (Auth::user()->cannot('viewAny', Auth::user()))) {
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => UserResource::collection(User::all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @param UserService $service
     * @return RedirectResponse
     */
    public function store(CreateUserRequest $request, UserService $service)
    {
        /*
         * create the user
         * */
        $create = $service->create($request->validated());

        /*
         * redirect to show this user
         * */
        return Redirect::route('users.edit', $create['user']->id)
            ->with([
                'message' => 'User created successfully',
                'messageType' => 'success'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        return response(UserResource::make($user), 200);
    }

    /**
     *
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Edit',[
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @param UserService $service
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user, UserService $service)
    {
        /*
         * check a user can delete another user
         * */
        if ((Auth::check()) && (Auth::user()->cannot('update', Auth::user()))) {
            abort(403);
        }

        /*
         * update the user
         * */
        $update = $service->update($user, $request->validated());

        /*
         * redirect to show this user
         * */
        return Redirect::route('users.edit', $update['user']->id)
            ->with([
                'message' => 'User updated successfully',
                'messageType' => 'success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param UserService $service
     * @return RedirectResponse
     */
    public function destroy(User $user, UserService $service)
    {
        /*
         * check a user can delete another user
         * */
        if ((Auth::check()) && (Auth::user()->cannot('delete', Auth::user()))) {
            abort(403);
        }

        /*
         * delete the user
         * */
        $delete = $service->delete($user);

        /*
         * redirect to show this user
         * */
        return Redirect::route('users.index')
            ->with([
                'message' => 'User deleted successfully',
                'messageType' => 'success'
            ]);
    }
}
