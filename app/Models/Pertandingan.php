<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertandingan extends Model
{
    use HasFactory;

    protected $fillable = ['klub_id_1', 'klub_id_2', 'skor_1', 'skor_2'];

    public function klub1()
    {
        return $this->belongsTo(Klub::class, 'klub_id_1');
    }

    public function klub2()
    {
        return $this->belongsTo(Klub::class, 'klub_id_2');
    }
}
