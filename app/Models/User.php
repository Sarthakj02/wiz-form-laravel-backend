<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    ];

    /**
     * Add filtration to the Model.
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilter($query, $filters)
    {

        if (!empty(request()->input('search'))) {
            $query->orWhere('id', request()->input('search'));
            $query->orWhere('name', 'LIKE', "%" . request()->input('search') . "%");
            $query->orWhere('email', 'LIKE', "%" . request()->input('search') . "%");
            $query->orWhere('dob', 'LIKE', "%" . request()->input('search') . "%");
            $query->orWhere('phone', 'LIKE', "%" . request()->input('search') . "%");
            $query->orWhere('college', 'LIKE', "%" . request()->input('search') . "%");
            $query->orWhere('cgpa', 'LIKE', "%" . request()->input('search') . "%");
            $query->orWhere('qualification', 'LIKE', "%" . request()->input('search') . "%");
            $query->orWhere('hobby', 'LIKE', "%" . request()->input('search') . "%");
        }
    }

    /**
     * Add sorting to the Model.
     *
     */
    public function scopeSort($query)
    {
        if (request()->sortOrder === 'desc') {
            $query->orderBy(request()->sortField, 'desc');
        } elseif (request()->sortOrder === 'asc') {
            $query->orderBy(request()->sortField, 'asc');
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }
}
