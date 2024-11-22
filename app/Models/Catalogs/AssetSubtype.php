<?php

namespace App\Models\Catalogs;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetSubtype extends Model
{
    use HasFactory;

    protected $table = 'cat_asset_subtypes';

    public function assets(): HasMany{
        return $this->hasMany(Asset::class);
    }
}
