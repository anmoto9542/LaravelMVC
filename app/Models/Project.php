<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'customerId',
        'name',
        'code',
        'remark',
        'status',
        'isDeleted',
        'createdBy',
        'createdTime',
        'updatedBy',
        'updatedTime',
    ];
}
