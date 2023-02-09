<?php

namespace App\Policies;

use App\Models\Adherant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdherantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if($user->hasRole('Admin') || $user->hasPermissionTo('view_prospects')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Adherant  $adherant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Adherant $adherant)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if($user->hasRole('Admin') || $user->hasPermissionTo('create_prospects')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Adherant  $adherant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Adherant $adherant)
    {
        if($user->hasRole('Admin') || $user->hasPermissionTo('update_prospects')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Adherant  $adherant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Adherant $adherant)
    {
        if($user->hasRole('Admin') || $user->hasPermissionTo('delete_prospects')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Adherant  $adherant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Adherant $adherant)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Adherant  $adherant
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Adherant $adherant)
    {
        //
    }
}
