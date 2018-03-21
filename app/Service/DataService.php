<?php

namespace App\Service;

use App\Entity\Data;
use App\Entity\Run;

/**
 * Class DataService
 *
 * @package App\Service
 */
class DataService
{
    /**
     * @var RunService
     */
    private $runService;

    /**
     * DataService constructor.
     *
     * @param RunService $runService
     */
    public function __construct(RunService $runService)
    {
        $this->runService = $runService;
    }

    /**
     * @param Run   $run
     * @param array $data
     *
     * @return Data|null
     */
    public function create(Run $run, array $data)
    {
        if (!$this->runService->reserveRun($run, count($data))) {
            return null;
        }

        foreach ($data as $values) {
            $values['run_id'] = $run->id;
            /** @var Data $data */
            $data = (new Data())->fill($values);
            $data->save();
        }
        $this->runService->completeRun($run);

        return $data;
    }
}
