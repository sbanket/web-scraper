<?php

namespace App\Eloquent\DataRequest;

use App\Eloquent\AbstractDataRequest;

/**
 * Class DataRequest
 *
 * @package App\Eloquent\DataRequest
 */
class DataRequest extends AbstractDataRequest
{
    /**
     * @param int $runId
     *
     * @return DataRequest
     */
    public function byRunId(int $runId): DataRequest
    {
        $this->qb->where('run_id', $runId);

        return $this;
    }
}
