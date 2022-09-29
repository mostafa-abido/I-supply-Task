<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Translatable,
        SoftDeletes;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

  
    protected $table = 'products';


    protected $fillable = ['usr_id','pro_id'];

    public function users()
    {
       return $this->belongsToMany(User::class, 'products', 'id', 'usr_id');
    }

    public function products()
    {
       return $this->belongsToMany(Product::class, 'products', 'id', 'pro_id');
    }

   
}