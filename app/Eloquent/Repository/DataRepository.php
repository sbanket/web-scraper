<?php

namespace App\Eloquent\Repository;

use App\Eloquent\DataRequest\DataRequest;
use App\Entity\Data;

/**
 * Class DataRepository
 *
 * @package App\Eloquent\Repository
 */
class DataRepository
{
    /**
     * @return DataRequest
     */
    public function fetchAll(): DataRequest
    {
        $dataRequest = DataRequest::create(Data::with([]));

        return $dataRequest;
    }

    /**
     * @param int $runId
     *
     * @return DataRequest
     */
    public function fetchByRun(int $runId): DataRequest
    {
        $dataRequest = $this->fetchAll();
        $dataRequest->byRunId($runId);

        return $dataRequest;
    }
}
