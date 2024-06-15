<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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
        'name',
        'email',
        'password',
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

    /*
     * gives us the roles the users is assinged to
     * */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /*
     * accepts a role name
     * returns bool check on if the user exists in that role
     * */
    public function is($roleName): bool
    {
        /*
         * get the role based off name passed
         * */
        $role = Role::where('name', $roleName)->first();

        /*
         * early return if we don't find the role
         * */
        if(!$role) return false;

        /*
         * check if the user exists in the role or not
         * */
        if($role){
            return DB::table('user_role')
                ->where('user_id', $this->id)
                ->where('role_id', $role->id)
                ->exists();
        }
    }

    public function highestRole()
    {
        return $this->roles()->orderBy('hierarchy')->first();
    }
}
