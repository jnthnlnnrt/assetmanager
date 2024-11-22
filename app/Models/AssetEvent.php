<?php

namespace App\Models;

use App\Models\Catalogs\AssetEventType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetEvent extends Model
{
    use HasFactory;

    protected $table = 'asset_events';

    protected $fillable = [
        'event_tag',
        'event_type_id',
        'start_date',
        'end_date',
        'asset_id',
        'employee_id',
        'status',
        'remarks',
        'created_by',
        'updated_by'
    ];

    public function type(): BelongsTo{
        return $this->belongsTo(AssetEventType::class, 'event_type_id', 'id');
    }

}
