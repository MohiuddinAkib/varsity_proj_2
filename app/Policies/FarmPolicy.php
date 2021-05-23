<?php

namespace App\Policies;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FarmPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Farm $farm
     * @return mixed
     */
    public function view(User $user, Farm $farm)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole(["superadmin"]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Farm $farm
     * @return mixed
     */
    public function update(User $user, Farm $farm)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Farm $farm
     * @return mixed
     */
    public function delete(User $user, Farm $farm)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Farm $farm
     * @return mixed
     */
    public function restore(User $user, Farm $farm)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Farm $farm
     * @return mixed
     */
    public function forceDelete(User $user, Farm $farm)
    {
        //
    }

    /**
     * Determine whether the user can assign a local admin to the farm.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function updateLocalAdmin(User $user)
    {
        return $user->hasRole("superadmin");
    }

    /**
     * Determine whether the user can assign a local admin to the farm.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Farm $farm
     * @return mixed
     */
    public function createPost(User $user, Farm $farm)
    {
        return $user->hasRole("superadmin") || ($user->hasRole("localadmin") && $farm->id === $user->farm_id);
    }
}
