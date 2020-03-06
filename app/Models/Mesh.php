<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Mesh extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'uuid', 'srcpts', 'dstpts', 'colors', 'shorturl'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
    protected $table = 'mesh';

}
