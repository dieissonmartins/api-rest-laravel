<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    protected $table = 'real_state';

    protected $fillable = ['user_id', 'title', 'description', 'content', 'price', 'slug',
     'badrooms', 'bathrooms', 'property_area', 'total_property_area']; 

    public function user()
    {
        return $this->belongsTo(User::class); //referencia user_id
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'real_state_categories'); 
    }
}
