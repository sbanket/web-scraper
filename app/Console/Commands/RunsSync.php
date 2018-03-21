<?php

namespace App\Console\Commands;

use App\Eloquent\Repository\RunRepository;
use App\Service\ParsehubService;
use App\Service\RunService;
use Illuminate\Console\Command;

/**
 * Class RunsSync
 *
 * @package App\Console\Commands
 */
class RunsSync extends Command
{
    /**
     * @var string
     */
    protected $signature = 'run:sync';

    /**
     * @var string
     */
    protected $description = 'Sync runs';

    /**
     * @var ParsehubService
     */
    private $parsehubService;

    /**
     * @var RunService
     */
    private $runService;

    /**
     * @var RunRepository
     */
    private $runRepository;

    /**
     * RunsSync constructor.
     *
     * @param ParsehubService $parsehubService
     * @param RunService      $runService
     * @param RunRepository   $runRepository
     */
    public function __construct(
        ParsehubService $parsehubService,
        RunService $runService,
        RunRepository $runRepository
    ) {
        parent::__construct();
        $this->parsehubService = $parsehubService;
        $this->runService      = $runService;
        $this->runRepository   = $runRepository;
    }

    /**
     * return void
     */
    public function handle()
    {
        $tokens = $this->parsehubService->getProjectTokens();
        foreach ($tokens as $token) {
            $this->getRunsWithOffset($token);
        }
    }

    /**
     * @param $token
     */
    protected function getRunsWithOffset($token)
    {
        $offset = 0;
        do {
            $runTokens = $this->parsehubService->getRunTokensByProject($token, $offset);
            $addedRuns = $this->saveRuns($runTokens);
            if (empty($addedRuns)) {
                return;
            }
            $offset = $offset + 20;
        } while (!empty($runTokens));
    }

    /**
     * @param array $runTokens
     *
     * @return array
     */
    private function saveRuns(array $runTokens)
    {
        $addedRuns = [];
        foreach ($runTokens as $runToken) {
            $run = $this->runRepository->fetchByToken($runToken)->first();
            if (empty($run)) {
                $addedRuns[] = $this->runService->create($runToken);
            }
        }

        return $addedRuns;
    }
}
