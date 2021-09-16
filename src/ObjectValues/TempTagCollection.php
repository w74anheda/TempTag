<?php

namespace M74asoud\TempTag\ObjectValues;

class TempTagCollection
{

    private $tags = [];

    public function push(TempTagValue $tag): array
    {
        $this->tags[] = $tag;
        return $this->tags;
    }

    public function pop(TempTagValue $tag): array
    {
        $list = collect($this->tags);
        $list->where('id', $tag->id)->delete();
        $this->tags = $list->toArray();
        return $this->tags;
    }

    public function all(): array
    {
        return  $this->tags;
    }

    public function allArrayStyle(): array
    {
        $list = [];
        foreach ($this->tags as $tag) {
            $list[] = $tag->toArray();
        }
        return  $list;
    }

    public function reset(): array
    {
        $this->tags = [];
        return $this->tags;
    }


}
