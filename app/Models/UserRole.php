<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';

    // If you’re not using timestamps or want to disable them:
    public $timestamps = false;

    protected $fillable = ['role_title', 'alias', 'permission'];

    /**
     * (Optional)
     * Retrieve the RolePermission models linked to this role.
     */
    public function permissions()
    {
        // Convert the permission string to an array of ids.
        $permissionIds = array_map('trim', explode(',', $this->permission));

        return RolePermission::whereIn('id', $permissionIds)->get();
    }
}
