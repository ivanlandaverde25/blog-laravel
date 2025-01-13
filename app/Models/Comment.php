<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'body',
        'user_id',
        'commentable_type',
        'commentable_id',
    ];

    // Relaciones
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relacion uno a muchod polimorfica
    public function images(){
        return $this->morphToMany(Image::class, 'imageable');
    }

    // Relacion ppolimorfica
    public function commentable(){
        return $this->morphTo();
    }
}
