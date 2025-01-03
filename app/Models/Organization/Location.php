<?php

namespace App\Models\Organization;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $table = 'org_locations';

    public function employees(): HasMany{
        return $this->hasMany(Employee::class);
    }

    public function assets(): HasMany{
        return $this->hasMany(Asset::class);
    }
}
