<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapTag extends Model
{
    use HasFactory; 

    protected $table='map_tags';
    protected $guarded=[];
    protected $fillable=['id_user','name','longitude','latitude'];
}
