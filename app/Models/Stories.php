<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
    {
        use HasFactory;

        protected $fillable = ['title', 'link', 'thumbnail', 'summary','product_id','user_id','publishdate','ttl','clicks'];
        public function product()
            {
                return $this->belongsTo(Product::class);
            }
        public function user()
            {
                return $this->belongsTo(User::class);
            }
    }
