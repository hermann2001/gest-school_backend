<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'photo',
        'nom',
        'prenoms',
        'birthday',
        'adresse',
        'masculin',
        'nom_prenoms_pere',
        'nom_prenoms_mere',
        'parent_email',
        'parent_telephone'
    ];
}
