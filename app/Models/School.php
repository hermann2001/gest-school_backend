<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'email',
        'adresse',
        'password',
        'phone_number',
        'verify_link_send',
    ];

    // Si vous souhaitez masquer le mot de passe lors de la sérialisation
    protected $hidden = [
        'password',
    ];

    // Si vous souhaitez hacher automatiquement le mot de passe lors de sa définition
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
