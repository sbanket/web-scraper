<?php

namespace App\Eloquent\DataRequest;

use App\Eloquent\AbstractDataRequest;

/**
 * Class RunDataRequest
 *
 * @package App\Eloquent\DataRequest
 */
class RunDataRequest extends AbstractDataRequest
{
    /**
     * @param int $id
     *
     * @return RunDataRequest
     */
    public function byId(int $id): RunDataRequest
    {
        $this->qb->where('id', $id);

        return $this;
    }

    /**
     * @param string $token
     *
     * @return RunDataRequest
     */
    public function byToken(string $token): RunDataRequest
    {
        $this->qb->where('run_id', $token);

        return $this;
    }

    /**
     * @param string $order
     *
     * @return RunDataRequest
     */
    public function orderByCreated($order = 'ASC'): RunDataRequest
    {
        $this->qb->orderBy('created_at', $this->normalizeOrderDirection($order));

        return $this;
    }

    /**
     * @param string $status
     *
     * @return RunDataRequest
     */
    public function byStatus(string $status): RunDataRequest
    {
        $this->qb->where('status', $status);

        return $this;
    }
}
