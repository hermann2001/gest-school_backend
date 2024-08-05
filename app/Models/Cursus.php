<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursus extends Model
{
    use HasFactory;

    protected $fillable = [
        'annee_id',
        'level',
        'serie',
        'eleve_id',
        'school_id'
    ];
}
