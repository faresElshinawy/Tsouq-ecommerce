<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as AuthMustVerifyEmail;
// implements AuthMustVerifyEmail // implements this to make sure that user cannot access any content before verify the email

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;


    public static $path = 'uploads/users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
        'roles_name',
        'social_id',
        'social_type'
    ];

    public function getAllPermissions(): Collection
    {

       $permissions = $this->permissions; // replaced by below line
        $permissions = collect();
        if (method_exists($this, 'roles')) {
            $permissions = $permissions->merge($this->getPermissionsViaRoles());
        }

        return $permissions->sort()->values();
    }

    public function hasDirectPermission($permission): bool
    {
        return false;
    }


    public function hasRole($roles, string $guard = null): bool
    {
        // Convert the $roles array to a string
        $rolesAsString = is_array($roles) ? implode('_', $roles) : $roles;

        return Cache::remember('hasRole_' . $this->id . '_' . $guard . '_' . $rolesAsString, now()->addHours(1), function () use ($roles, $guard) {
            $this->loadMissing('roles');

            if (is_string($roles) && false !== strpos($roles, '|')) {
                $roles = $this->convertPipeToArray($roles);
            }

            if (is_string($roles)) {
                return $guard
                    ? $this->roles->where('guard_name', $guard)->contains('name', $roles)
                    : $this->roles->contains('name', $roles);
            }

            if (is_int($roles)) {
                $roleClass = $this->getRoleClass();
                $key = (new $roleClass())->getKeyName();

                return $guard
                    ? $this->roles->where('guard_name', $guard)->contains($key, $roles)
                    : $this->roles->contains($key, $roles);
            }

            if ($roles instanceof Role) {
                return $this->roles->contains($roles->getKeyName(), $roles->getKey());
            }

            if (is_array($roles)) {
                foreach ($roles as $role) {
                    if ($this->hasRole($role, $guard)) {
                        return true;
                    }
                }

                return false;
            }

            return $roles->intersect($guard ? $this->roles->where('guard_name', $guard) : $this->roles)->isNotEmpty();
        });
    }





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
        'roles_name'=>'array'
    ];

    public function addresses(){
        return $this->belongsToMany(Address::class);
    }

    public static function wishListsItems(){
        $wishlists = WishList::with('wishListItems')->where('user_id',auth()->user()->id)->get();
        $count = 0;
        foreach ($wishlists as $wishlist){
            $count += $wishlist->wishListItems->count();
        }
        return $count;
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class);
    }

}
