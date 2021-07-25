<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epaper extends Model
{
    use HasFactory;
    protected $table = "epaper";
    protected $fillable = [
        'title', 'link', 'thumbnail', 'summary'
    ];
}
