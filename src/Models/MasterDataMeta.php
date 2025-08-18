<?php

namespace Iquesters\Masterdata\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class MasterDataMeta extends Model
{
    use HasFactory;
    protected $fillable = [
        'ref_parent',
        'meta_key',
        'meta_value',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $table = 'master_data_metas';

    public function refCreatedBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function refUpdatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}