<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'org_departments';

    protected $fillable = [
        'internal_id',
        'name',
        'remarks',
        'created_by',
        'updated_by'
    ];
}
