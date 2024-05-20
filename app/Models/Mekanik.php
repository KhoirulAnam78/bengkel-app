<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    use HasFactory;
    
    protected $table = 'mekanik';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}