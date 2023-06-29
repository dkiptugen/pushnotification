<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
    {
        use HasFactory;
        protected $fillable =   ['guest_id','story_id','status'];
        public function guest()
            {
                return $this->belongsTo(Guest::class) ;
            }
        public function story()
            {
                return $this->belongsTo(Stories::class);
            }
    }
