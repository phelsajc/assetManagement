<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = "vendors";

    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'bizboxID',
        'contactno',
        'address',
        'email',
        'status',
        'created_by',
        'created_dt',
        'updated_by',
        'updated_dt',
    ];
}
