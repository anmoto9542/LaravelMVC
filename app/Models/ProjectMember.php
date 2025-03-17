<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    protected $fillable = [
        'memberId',
        'projectId',
        'roleId',
        'status',
        'createdBy',
        'createdTime',
        'updatedBy',
        'updatedTime',
    ];
}
