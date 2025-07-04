<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
       
        'name',
        'type',
    ];
    
    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
