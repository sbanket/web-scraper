<?php

namespace App\Console\Commands;

use App\Eloquent\Repository\RunRepository;
use App\Entity\Run;
use App\Service\DataService;
use App\Service\ParsehubService;
use App\Service\RunService;
use Illuminate\Console\Command;

/**
 * Class DataSync
 *
 * @package App\Console\Commands
 */
class DataSync extends Command
{
    /**
     * @var string
     */
    protected $signature = 'data:sync';

    /**
     * @var string
     */
    protected $description = 'Sync data for run';

    /**
     * @var ParsehubService
     */
    private $parsehubService;

    /**
     * @var RunRepository
     */
    private $runRepository;

    /**
     * @var RunService
     */
    private $runService;

    /**
     * @var DataService
     */
    private $dataService;

    /**
     * RunsSync constructor.
     *
     * @param ParsehubService $parsehubService
     * @param RunService      $runService
     * @param RunRepository   $runRepository
     * @param DataService     $dataService
     */
    public function __construct(
        ParsehubService $parsehubService,
        RunService $runService,
        RunRepository $runRepository,
        DataService $dataService
    ) {
        parent::__construct();
        $this->parsehubService = $parsehubService;
        $this->runService      = $runService;
        $this->runRepository   = $runRepository;
        $this->dataService     = $dataService;
    }

    /**
     * return void
     */
    public function handle()
    {
        $runs = $this->runRepository->fetchRunsWithoutData()->get();
        try {
            /** @var Run $run */
            foreach ($runs as $run) {
                $data = $this->parsehubService->getRunData($run->run_id);
                if (empty($data)) {
                    continue;
                }
                $data = array_shift($data);
                $this->dataService->create($run, $data);
            }
        } catch (\Exception $ex) {
            $this->runService->cancelReservationRun($run);
        }
    }
}
