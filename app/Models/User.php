<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Property(property="id", type="integer", description="User ID auto incremented"),
 *    @OA\Property(property="fullname", type="string", description="User fullname"),
 *    @OA\Property(property="adresse", type="string", description="User adresse"),
 *   @OA\Property(property="ville", type="string", description="User ville"),
 *     @OA\Property(property="role_id", type="integer", description="User role ID"),
 *     @OA\Property(property="phone", type="string", description="User phone number"),
 *     @OA\Property(property="email", type="string", format="email", description="User email"),
 *     @OA\Property(property="password", type="string", format="password", description="User password"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="User creation date and time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="User last update date and time"),
 *    @OA\Property(property="image", type="file", description="photo de l'utilisateur pas obligatoire"),
 *
 *
 * )
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'adresse',
        'phone',
        'photo',
        'ville',
        'email',
        'password',
        'role_id',
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


    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
}
