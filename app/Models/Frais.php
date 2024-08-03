<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frais extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'frais_inscription',
        'frais_reinscription',
        'frais_scolarite',
        'frais_scolarite_tranche1',
        'frais_scolarite_tranche2',
        'frais_scolarite_tranche3',
        'school_id',
    ];
}
