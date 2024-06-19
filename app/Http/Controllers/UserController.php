<?php
/**
 * Test file directory:
 * tests/Feature/Users
 */

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
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
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @param UserService $service
     * @return RedirectResponse
     */
    public function store(CreateUserRequest $request, UserService $service): RedirectResponse
    {
        /*
         * validate the request
         * */
        $validated = $request->validated();

        /*
         * create the user
         * */
        $create = $service->create($validated);

        /*
         * redirect to show this user
         * */
        return Redirect::route('users.show', [$create['user']->id])
            ->with('message', 'User created.');
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
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        /*
         * Email should be unique
         * If a user PUTs name through request with the existing name
         * So we tell the validation to ignore the unique rule when this happens
         * */
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'string',
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user),
            ],
        ]);

        // Create array of values to update
        $updateArray = $validated;
        $updateArray['updated_at'] = date('Y-m-d H:i:s');

        // Persist
        $user->update($updateArray);

        // Build return array to show new resource and the fields that were changed in the update
        $returnArray = [
            'user' => UserResource::make($user),
            'updated' => $user->getChanges(),
        ];

        return response($returnArray, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response([
            'message' => 'User deleted successfully',
        ], 200);
    }
}
