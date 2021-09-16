<?php

namespace M74asoud\TempTag\Traits;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use M74asoud\TempTag\Models\TempTag;
use M74asoud\TempTag\Services\TempTagService;

trait TempTagAble
{
    use HybridRelations;

    private $tempTagService;

    private function prepareTempTagService(): TempTagService
    {
        if (!$this->tempTagService instanceof TempTagService) {
            $this->tempTagService  = app(TempTagService::class);
            $this->tempTagService->setModel($this);
        }
        return $this->tempTagService;
    }

    public function temptags()
    {
        return $this->morphMany(TempTag::class, 'temptagable');
    }

    public function tempTagService()
    {
        return  $this->prepareTempTagService();
    }

}
