<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessCounter extends Model
{
    use HasFactory;
    protected $fillable = ['ip_address', 'date', 'counter'];
    public $timestamps = false;

}
