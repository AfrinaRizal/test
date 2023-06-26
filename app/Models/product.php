<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;


class product extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $primarykey = 'product_id';
     protected $table = 'product';
   
     protected $fillable = [
         'product_id', 
         'product_name',
         'category', 
         'price',
         'stock',
 
     ];
}
