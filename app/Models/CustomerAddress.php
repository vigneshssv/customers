<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddress extends Model
{
    
    // use SoftDeletes;

    protected $table = 'customer_address';

     protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer','address_type','address','city','state','pincode','is_primary'
    ];

    
}