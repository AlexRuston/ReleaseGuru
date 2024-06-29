<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    private Role $accessRole;

    public function __construct()
    {
        /*
         * get the lowest role allowed to access the model
         * */
        $this->accessRole = Role::where('name', 'Admin')
            ->first();
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        /*
         * check if:
         * the user has a role assigned
         * or
         * the users highest role gives them greater or equal access rights
         * */
        return ($user->highestRole()) && ($user->highestRole()->hierarchy <= $this->accessRole->hierarchy)
            ? Response::allow()
            : Response::deny('You do not have access rights to view this model.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        /*
         * check if:
         * the user has a role assigned
         * or
         * the users highest role gives them greater or equal access rights
         * */
        return ($user->highestRole()) && ($user->highestRole()->hierarchy <= $this->accessRole->hierarchy)
            ? Response::allow()
            : Response::deny('You do not have access rights to update this model.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): Response
    {
        /*
         * check if:
         * the user has a role assigned
         * or
         * the users highest role gives them greater or equal access rights
         * */
        return ($user->highestRole()) && ($user->highestRole()->hierarchy <= $this->accessRole->hierarchy)
            ? Response::allow()
            : Response::deny('You do not have access rights to delete this model.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
