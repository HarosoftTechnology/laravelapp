<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        // Optionally include 'role' if you need it explicitly
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Defines the relationship with the UserRole model.
     * The 'role' column in the users table stores the id from the user_roles table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'role');
    }

    /**
     * Check if the user has a given role alias.
     *
     * If the user is a super-admin, they automatically have every role.
     *
     * @param string $roleAlias
     * @return bool
     */
    public function hasRole($roleAlias)
    {
        if (!$this->userRole) {
            return false;
        }

        // Grant super-admin all roles.
        if ($this->userRole->alias === 'super-admin') {
            return true;
        }

        return $this->userRole->alias === $roleAlias;
    }

    /**
     * Check if the user has a given permission alias.
     *
     * If the user is a super-admin, they automatically have every permission.
     * The method splits the comma-separated 'permission' string from the user role into an array,
     * retrieves the corresponding RolePermission by alias, and checks if its id exists in that array.
     *
     * @param string $permissionAlias
     * @return bool
     */
    public function hasPermission($permissionAlias)
    {
        if (!$this->userRole) {
            return false;
        }

        // Grant super-admin all permissions.
        if ($this->userRole->alias === 'super-admin') {
            return true;
        }

        // Convert the permission string (e.g., "1,2,3,4,5,6,7,8") into an array
        $permissionIds = array_map('trim', explode(',', $this->userRole->permission));

        if (empty($permissionIds) || $permissionIds[0] === '') {
            return false;
        }

        // Retrieve the RolePermission by alias.
        $rolePermission = \App\Models\RolePermission::where('alias', $permissionAlias)->first();
        if (!$rolePermission) {
            return false;
        }

        // Check if the role's permission list contains the RolePermission id.
        return in_array((string)$rolePermission->id, $permissionIds);
    }
}
