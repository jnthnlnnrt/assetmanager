<?php

namespace App\Models\Catalogs;

use App\Models\AssetEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetEventType extends Model
{
    use HasFactory;

    protected $table = 'cat_asset_event_types';  

    public function events(): HasMany{
        return $this->hasMany(AssetEvent::class);
    }
}
