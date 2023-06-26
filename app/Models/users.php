<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class users extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primarykey = 'id';
    protected $table = 'users';
   
     protected $fillable = [
         'id', 
         'name',
         'email', 
         'icnum',
         'address', 
         'contact', 
         'password', 
         'created_by', 
         'updated_by', 


     ];

     protected $hidden = [
        'password', 'token'
    ];
}
