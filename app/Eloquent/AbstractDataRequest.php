<?php

namespace App\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator as PaginatorInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class AbstractDataRequest
 *
 * @package App\Eloquent
 */
abstract class AbstractDataRequest
{
    /**
     * @var Builder
     */
    protected $qb;

    /**
     * @var callable
     */
    protected $transformer;

    /**
     * @var callable
     */
    protected $filter;

    /**
     * AbstractFetch constructor.
     *
     * @param Builder $qb
     */
    public function __construct(Builder $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @param Builder $qb
     *
     * @return static
     */
    public static function create(Builder $qb)
    {
        return new static($qb);
    }

    /**
     * @param callable $transformer
     *
     * @return $this
     */
    public function withTransformer(callable $transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * @param callable $filter
     *
     * @return $this
     */
    public function withFilter(callable $filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return EloquentCollection
     */
    public function get(?int $limit = null)
    {
        if (isset($limit)) {
            $this->qb->limit($limit);
        }
        $collection = $this->qb->get();

        $this->transformCollection($collection);
        $collection = $this->filterCollection($collection);

        return $collection;
    }

    /**
     * @param int $id
     *
     * @return Model|mixed
     */
    public function findOrFail(int $id)
    {
        $entity = $this->qb->findOrFail($id);
        if (!isset($this->transformer)) {
            return $entity;
        }

        return call_user_func($this->transformer, $entity);
    }

    /**
     * @return Model|mixed
     */
    public function firstOrFail()
    {
        $entity = $this->qb->firstOrFail();
        if (!isset($this->transformer)) {
            return $entity;
        }

        return call_user_func($this->transformer, $entity);
    }

    /**
     * @return Model|mixed|null
     */
    public function first()
    {
        $entity = $this->qb->first();
        if (!$entity instanceof Model) {
            return null;
        }

        if (!isset($this->transformer)) {
            return $entity;
        }

        return call_user_func($this->transformer, $entity);
    }

    /**
     * @param int $perPage
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15)
    {
        $paginator = $this->qb->paginate($perPage);

        $this->transformCollection($paginator);

        return $paginator;
    }

    /**
     * @param int $perPage
     *
     * @return PaginatorInterface
     */
    public function simplePaginate(int $perPage = 15)
    {
        $paginator = $this->qb->simplePaginate($perPage);
        $this->transformCollection($paginator);

        return $paginator;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->qb->count();
    }

    /**
     * @param string      $column
     * @param string|null $key
     *
     * @return Collection
     */
    public function pluck(string $column, string $key = null)
    {
        return $this->qb->pluck($column, $key);
    }

    /**
     * @param Collection|PaginatorInterface $collection
     */
    protected function transformCollection($collection)
    {
        if (!isset($this->transformer)) {
            return;
        }

        if ($collection instanceof Paginator) {
            $collection = $collection->getCollection();
        }

        $collection->transform($this->transformer);
    }

    /**
     * @param Collection|PaginatorInterface $collection
     *
     * @return Collection|PaginatorInterface
     */
    protected function filterCollection($collection)
    {
        if (!isset($this->filter)) {
            return $collection;
        }

        if ($collection instanceof Paginator) {
            $collection = $collection->getCollection();
        }

        return $collection->filter($this->filter);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Scope|string $scope
     *
     * @return $this
     */
    public function withoutGlobalScope($scope)
    {
        $this->qb->withoutGlobalScope($scope);

        return $this;
    }

    /**
     * @param string $order (ASC|DESC)
     *
     * @return string
     */
    protected function normalizeOrderDirection($order): string
    {
        $order = Str::lower($order);

        return $order === 'desc' ? 'DESC' : 'ASC';
    }
}
