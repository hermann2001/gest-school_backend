<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EleveClasse extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year',
        'level',
        'serie',
        'eleve_id',
    ];
}