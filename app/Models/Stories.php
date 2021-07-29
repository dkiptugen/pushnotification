<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
    {
        use HasFactory;

        protected $fillable = ['title', 'link', 'thumbnail', 'summary'];
        public function product()
            {
                return $this->belongsTo(Product::class);
            }
    }
