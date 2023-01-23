<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ShortLink extends Model
{
    use HasFactory;


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable  = [
        'destination', 'slug', 'user_id'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

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
    public function shortLink(): Attribute {
        return Attribute::make(
            get: fn () => url(''). '/' . $this->attributes['slug']
        );
    }

    /**
     * Generate the slug on model creation.
     *
     */
     protected static function boot() {
        parent::boot();

        static::creating(function ($shortLink) {
            $shortLink->slug = Str::random(5);
        });
    }
}
