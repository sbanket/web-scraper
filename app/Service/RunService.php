<?php

namespace App\Service;

use App\Eloquent\Repository\RunRepository;
use App\Entity\Run;

/**
 * Class RunService
 *
 * @package App\Service
 */
class RunService
{
    /**
     * @var RunRepository
     */
    private $repository;

    /**
     * RunService constructor.
     *
     * @param RunRepository $repository
     */
    public function __construct(RunRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $runId
     *
     * @return Run
     */
    public function create($runId)
    {
        /** @var Run $run */
        $run = (new Run())->fill(['run_id' => $runId]);
        $run->save();

        return $run;
    }

    /**
     * @param Run $run
     * @param int $countRow
     *
     * @return bool
     */
    public function reserveRun(Run $run, int $countRow)
    {
        $actualRun = $this->repository->find($run->id)->first();
        if (empty($actualRun) || $actualRun->status != Run::PENDING_STATUS) {
            return false;
        }

        $run->fill(['status' => Run::IN_PROCESS_STATUS, 'count_row' => $countRow]);
        $run->save();

        return true;
    }

    /**
     * @param Run $run
     *
     * @return Run
     */
    public function cancelReservationRun(Run $run)
    {
        $run->fill(['status' => Run::PENDING_STATUS, 'count_row' => 0]);
        $run->save();

        return $run;
    }

    /**
     * @param Run $run
     *
     * @return Run
     */
    public function completeRun(Run $run)
    {
        $run->fill(['status' => Run::COMPLETE_STATUS]);
        $run->save();

        return $run;
    }
}
