<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klub extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'kota'];

    public function pertandingans()
    {
        return $this->hasMany(Pertandingan::class);
    }
}
