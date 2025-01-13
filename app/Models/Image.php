<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'path',
        'imageable_type',
        'imageable_id',
    ];

    // relacion polimorfica
    public function imageable(){
        return $this->morphTo();
    }
}
