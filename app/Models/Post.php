<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'category_id',
        'slug',
        'user_id',
        'excerpt',
        'body',
        'published',
        'image_path'
    ];

    protected function casts():array
    {
        return [
            'published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected function title() : Attribute{
        return new Attribute(
            set: fn ( $value ) => strtolower( $value ),
            get: fn ( $value ) => ucfirst($value)
        );
    }

    protected function image() : Attribute{
        return new Attribute(
            // get: fn () => $this->image_path ?? 'https://media.wired.com/photos/5f87340d114b38fa1f8339f9/master/w_1600,c_limit/Ideas_Surprised_Pikachu_HD.jpg',
            get: function (){
                if($this->image_path){
                    // verificar si la url comienza con https://
                    if(substr($this->image_path, 0, 8) == 'https://' || substr($this->image_path, 0, 8) == 'http://'){
                        return $this->image_path;
                    }

                    return Storage::url($this->image_path);
                } else {
                    return 'https://media.wired.com/photos/5f87340d114b38fa1f8339f9/master/w_1600,c_limit/Ideas_Surprised_Pikachu_HD.jpg';
                }
            }
        );
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relaciones
    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    } 

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    } 

    // Relacion de uno a muchos polimorfica
    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Relacion muchos a muchos polimorfica
    public function tags(){
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
