<?php

namespace M74asoud\TempTag\ObjectValues;

use Carbon\Carbon;
use Illuminate\Support\Str;

class TempTagValue
{
    private $id;
    private $title;
    private $payload;
    private $expire_at;

    public function __construct(string $title, $payload = null, Carbon $expire_at = null)
    {
        $this->id = Str::uuid();
        $this->title = $title;
        $this->payload = $payload;
        $this->expire_at = $expire_at;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'payload' => $this->payload,
            'expire_at' => $this->expire_at,
        ];
    }
}
