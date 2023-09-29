<?php

namespace App\Models\Free;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="TypeConseil",
 *     title="TypeConseil",
 *     description="TypeConseil model",
 *     @OA\Property(property="id", type="integer", description="TypeConseil ID auto incremented"),
 *    @OA\Property(property="nom", type="string", description="TypeConseil nom"),
 *    @OA\Property(property="description", type="string", description="TypeConseil description"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="TypeConseil creation date and time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="TypeConseil last update date and time"),
 *
 *
 * )
 */
class TypeConseil extends Model
{
    use HasFactory;


    protected $table = 'type_conseils';


    protected $fillable = [
        'nom',
        'description',
    ];



    public function conseils()
    {
        return $this->hasMany(Conseils::class);
    }
}
