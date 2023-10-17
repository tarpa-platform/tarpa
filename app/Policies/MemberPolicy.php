<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MemberPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Member $member): bool
    {
        if($user->can('member.view-all')){
            return true;
        }

        if($user->can('view') && $user->linkable_id === $member->id){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->can('member.create')
            ? Response::allow() :
              Response::deny('You cannot create team members.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Member $member): bool
    {
        if($user->can('member.update')){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->can('member.delete')
            ? Response::allow() :
              Response::deny('You cannot delete team members.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): Response
    {
        return $user->can('member.restore')
            ? Response::allow() :
              Response::deny('You cannot restore team members.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Member $member): Response
    {
        return $user->can('member.force-delete')
            ? Response::allow() :
              Response::deny('You cannot delete team members.');
    }
}
