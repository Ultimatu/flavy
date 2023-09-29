<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Roles",
 *     title="Roles",
 *     description="Roles model",
 *     @OA\Property(property="id", type="integer", description="Roles ID auto incremented"),
 *    @OA\Property(property="nom", type="string", description="Roles nom"),
 *    @OA\Property(property="description", type="string", description="Roles description"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Roles creation date and time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Roles last update date and time"),
 *
 *
 * )
 */
class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';


    protected $fillable = [
        'nom',
        'description',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }
}
