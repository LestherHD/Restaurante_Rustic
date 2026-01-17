<?php

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    
    /**
     * Verificar si el usuario tiene alguno de los roles permitidos
     */
    protected function hasAdminRole(AuthUser $authUser): bool
    {
        return $authUser->hasAnyRole(['super_admin', 'administrador']);
    }
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $this->hasAdminRole($authUser);
    }

    public function view(AuthUser $authUser): bool
    {
        return $this->hasAdminRole($authUser);
    }

    public function create(AuthUser $authUser): bool
    {
        return $this->hasAdminRole($authUser);
    }

    public function update(AuthUser $authUser): bool
    {
        return $this->hasAdminRole($authUser);
    }

    public function delete(AuthUser $authUser): bool
    {
        return $this->hasAdminRole($authUser);
    }

    public function restore(AuthUser $authUser): bool
    {
        return $this->hasAdminRole($authUser);
    }

    public function forceDelete(AuthUser $authUser): bool
    {
        return $this->hasAdminRole($authUser);
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $this->hasAdminRole($authUser);
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:User');
    }

    public function replicate(AuthUser $authUser): bool
    {
        return $authUser->can('Replicate:User');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:User');
    }

}