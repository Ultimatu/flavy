<?php

namespace App\Models\Free;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Conseils",
 *     title="Conseils",
 *     description="Conseils model",
 *     @OA\Property(property="id", type="integer", description="Conseils ID auto incremented"),
 *    @OA\Property(property="titre", type="string", description="Conseils titre"),
 *    @OA\Property(property="description", type="string", description="Conseils description"),
 *    @OA\Property(property="image", type="file", description="Conseils image"),
 *   @OA\Property(property="id_type", type="integer", description="Conseils, id_type de conseil, relation avec type_conseils"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Conseils creation date and time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Conseils last update date and time"),
 *
 *
 * )
 */
class Conseils extends Model
{
    use HasFactory;

    protected $table = 'conseils';

    protected $fillable = [
        'titre',
        'description',
        'image',
        'id_type'
    ];


    public function typeConseil()
    {
        return $this->belongsTo(TypeConseil::class);
    }
}
