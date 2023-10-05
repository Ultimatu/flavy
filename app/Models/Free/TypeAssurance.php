<?php

namespace App\Models\Free;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAssurance extends Model
{
    use HasFactory;

    protected $table = 'type_assurance';

    protected $fillable = [
        'libelle',
        'description',
        'photo',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }
}
