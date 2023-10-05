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
 *     @OA\Property(property="fullname", type="string", description="User fullname", example="John Doe", required={"fullname"}),
 *     @OA\Property(property="adresse", type="string", description="User adresse", example="123 Main St"),
 *     @OA\Property(property="ville", type="string", description="User ville", example="New York"),
 *     @OA\Property(property="phone", type="string", description="User phone number", example="123-456-7890", required={"phone"}),
 *     @OA\Property(property="email", type="string", format="email", description="User email", example="johndoe@example.com"),
 *     @OA\Property(property="password", type="string", format="password", description="User password", example="mysecretpassword", required={"password"}),
 *     @OA\Property(property="image", type="file", description="Photo de l'utilisateur (pas obligatoire)"),
 *     @OA\Property(property="id_type_assurance", type="integer", description="ID du type d'assurance de l'utilisateur (Nullable)", example="1" ),
 *     @OA\Property(property="n_cmu", type="string", description="Numéro de la carte CMU de l'utilisateur", example="12345-67890"),
 *     @OA\Property(property="n_assurance", type="string", description="Numéro de la carte d'assurance de l'utilisateur", example="A123456"),
 *     @OA\Property(property="sexe", type="string", description="Sexe de l'utilisateur", enum={"M", "F", "Autre"}, example="M", required={"sexe"}),
 *     @OA\Property(property="maladie_chronique", type="string", description="Maladie chronique de l'utilisateur", example="Diabète", required={"maladie_chronique"}),
 *     @OA\Property(property="poids", type="string", description="Poids de l'utilisateur", example="75 kg"),
 *     @OA\Property(property="taille", type="string", description="Taille de l'utilisateur", example="180 cm"),
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
        'id_type_assurance',
        'n_cmu',
        'n_assurance',
        'sexe',
        'maladie_chronique',
        'poids',
        'taille'

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

    public function type_assurance()
    {
        return $this->belongsTo(TypeAssurance::class);
    }


    public function isMobileClient(): bool
    {
        return $this->role_id === 1;
    }

    public function isPharmacie(): bool
    {
        return $this->role_id === 2;
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 3;
    }
}
