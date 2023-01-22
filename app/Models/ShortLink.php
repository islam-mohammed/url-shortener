<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    use HasFactory;


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable  = [
        'destination', 'slug'
    ];

     /**
     * Get the user that owns the url.
     */
    protected function user() {
        return $this->belongsTo(User::class);
    }


    /**
     * Get the shortened URL.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function shortLink(): Attribute {
        return Attribute::make(
            get: fn () => url(''). '/' . $this->attributes['slug']
        );
    }
}
