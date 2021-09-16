<?php

namespace  M74asoud\TempTag\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use M74asoud\TempTag\Services\TempTagService;

class TempTag extends Model
{
    use HasFactory;
    protected $collection = 'temptags';
    protected $connection = 'mongodb';
    public $timestamps = true;
    protected $dates = ['expire_at'];


    protected $fillable = [
        'temptagable_id',
        'temptagable_type',
        'title',
        'payload',
        'expire_at',
    ];

    public function temptagable()
    {
        return $this->morphTo();
    }

    public function isPermanent()
    {
        return $this->expire_at->equalTo(
            Carbon::parse(TempTagService::LIFETIME)
        );
    }

    public function isExpire()
    {
        return now()->greaterThan(
            $this->expire_at
        );
    }

    public function isActive()
    {
        return !$this->isExpire();
    }

    public function scopeExpire($q)
    {
        return $q->where('expire_at', '<', now());
    }

    public function scopeActive($q)
    {
        return $q->where('expire_at', '>=', now());
    }
}
