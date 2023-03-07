<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = "equipments";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'description',
        'life',
        'bizboxID',
        'status',
        'isforpreventive',
        'created_by',
        'created_dt',
        'updated_by',
        'updated_dt',
    ];
}
