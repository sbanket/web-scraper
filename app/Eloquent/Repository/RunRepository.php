<?php

namespace App\Eloquent\Repository;

use App\Eloquent\DataRequest\RunDataRequest;
use App\Entity\Run;

/**
 * Class RunRepository
 *
 * @package App\Eloquent\Repository
 */
class RunRepository
{
    /**
     * @return RunDataRequest
     */
    public function fetchAll(): RunDataRequest
    {
        $dataRequest = RunDataRequest::create(Run::with([]));

        return $dataRequest;
    }

    /**
     * @param string $token
     *
     * @return RunDataRequest
     */
    public function fetchByToken(string $token): RunDataRequest
    {
        $dataRequest = $this->fetchAll();
        $dataRequest->byToken($token);

        return $dataRequest;
    }

    /**
     * @return RunDataRequest
     */
    public function fetchRunsWithoutData(): RunDataRequest
    {
        $dataRequest = $this->fetchAll();
        $dataRequest->byStatus(Run::PENDING_STATUS);

        return $dataRequest;
    }

    /**
     * @param int $id
     *
     * @return RunDataRequest
     */
    public function find(int $id)
    {
        $dataRequest = $this->fetchAll();
        $dataRequest->byId($id);

        return $dataRequest;
    }
}
