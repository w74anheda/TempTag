<?php

namespace M74asoud\TempTag\Services;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Relations\MorphMany;
use M74asoud\TempTag\Models\TempTag;
use M74asoud\TempTag\ObjectValues\TempTagCollection;

class TempTagService
{
    const LIFETIME = '2048-01-01';
    private $model;

    public function tagIt(string $title, $payload = null, Carbon $expire_at = null): TempTag
    {
        return $this->query()->create(
            [
                'title' => $title,
                'payload' => $payload,
                'expire_at' => $this->expire_at($expire_at),
            ]
        );
    }

    public function tagItMany(TempTagCollection $tags): EloquentCollection
    {
        $data = [];
        foreach ($tags->allArrayStyle() as $tag) {
            $tag['expire_at'] = $this->expire_at($tag['expire_at']);
            $data[] = $tag;
        }

        return $this->query()->createMany($data);
    }

    public function unTag(string $title)
    {
        return $this->whereFiled('title', $title)->delete();
    }

    public function unTagID($ID): bool
    {
        return !!$this->whereFiled('_id', $ID)->delete();
    }

    public function unTagAll()
    {
        return $this->query()->delete();
    }

    public function unTagExpire(string $title)
    {
        return $this->queryExpire(
            $this->whereFiled('title', $title)
        )->delete();
    }

    public function unTagAllExpire()
    {
        return $this->queryExpire(
            $this->query()
        )->delete();
    }

    public function unTagMany(string ...$titles)
    {
        $this->whereInFiled('title', $titles)->delete();
    }

    public function get(string  $title): EloquentCollection
    {
        return  $this->queryLast(
            $this->whereFiled('title', $title)
        )->get();
    }

    public function getActive(string  $title): EloquentCollection
    {
        return  $this->queryActive(
            $this->whereFiled('title', $title)
        )->get();
    }

    public function getExpire(string  $title): EloquentCollection
    {
        return  $this->queryExpire(
            $this->whereFiled('title', $title)
        )->get();
    }

    public function getOne(string  $title): ?TempTag
    {
        return  $this->queryLast(
            $this->whereFiled('title', $title)
        )->first();
    }

    public function getOneID($ID): ?TempTag
    {
        return $this->whereFiled('_id', $ID)
            ->first();
    }

    public function all(): EloquentCollection
    {
        return $this->query()->get();
    }

    public function allExpire(): EloquentCollection
    {
        return $this->queryExpire(
            $this->query()
        )->get();
    }

    public function allActive(): EloquentCollection
    {
        return $this->queryActive(
            $this->query()
        )->get();
    }


    public function count(string $title): int
    {
        return $this->whereFiled('title', $title)->count();
    }

    public function countExpire(string $title): int
    {
        return  $this->queryExpire(
            $this->whereFiled('title', $title)
        )->count();
    }

    public function countActive(string $title): int
    {
        return  $this->queryActive(
            $this->whereFiled('title', $title)
        )->count();
    }

    public function countAll(): int
    {
        return $this->query()->count();
    }

    public function CountAllExpire(): int
    {
        return $this->queryExpire(
            $this->query()
        )->count();
    }

    public function countAllActive(): int
    {
        return $this->queryActive(
            $this->query()
        )->count();
    }




    public function query(): MorphMany
    {
        return $this->model->temptags();
    }

    private function queryLast(MorphMany $query): MorphMany
    {
        return $query->orderByDesc('created_at');
    }


    private function queryActive(MorphMany $query): MorphMany
    {
        return $query->where('expire_at', '>=', now());
    }

    private function queryExpire(MorphMany $query): MorphMany
    {
        return $query->where('expire_at', '<', now());
    }

    private function whereFiled(string $key,  $value): MorphMany
    {
        return $this->query()->where($key, $value);
    }

    private function whereInFiled(string $key,  array $values): MorphMany
    {
        return $this->query()->whereIn($key, $values);
    }

    public function setModel(Model $model): Model
    {
        $this->model = $model;
        return $this->model;
    }

    private function expire_at(Carbon $expire_at = null): DateTime
    {
        return $expire_at
            ? $expire_at->toDateTime()
            : Carbon::parse(self::LIFETIME)->toDateTime();
    }
}
