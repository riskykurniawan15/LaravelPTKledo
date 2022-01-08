<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gajis';

    protected $primaryKey = 'id_gajis';

    protected $fillable = [
        'id_pegawais',
        'total_gaji',
        'periods_gaji',
    ];
}
