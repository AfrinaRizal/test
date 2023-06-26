<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $primarykey = 'admin_id';
     protected $table = 'admin';
 
     protected $fillable = [
         'admin_id', 
         'name',
         'pfile',

     ];
}
