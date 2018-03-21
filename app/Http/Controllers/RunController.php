<?php

namespace App\Http\Controllers;

use App\Eloquent\Repository\RunRepository;
use App\Service\DataService;
use App\Service\ParsehubService;

/**
 * Class HomeController
 *
 * @package App\Http\Controllers
 */
class RunController extends Controller
{
    /**
     * @var RunRepository
     */
    private $runRepository;

    /**
     * @var DataService
     */
    private $dataService;

    /**
     * @var ParsehubService
     */
    private $parsehubService;

    /**
     * RunController constructor.
     *
     * @param RunRepository   $runRepository
     * @param DataService     $dataService
     * @param ParsehubService $parsehubService
     */
    public function __construct(
        RunRepository $runRepository,
        DataService $dataService,
        ParsehubService $parsehubService
    ) {
        $this->runRepository   = $runRepository;
        $this->dataService     = $dataService;
        $this->parsehubService = $parsehubService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function runList()
    {
        $runs = $this->runRepository->fetchAll()->orderByCreated('DESC')->paginate(20);

        return view('app/run/run-list', ['runs' => $runs]);
    }

    /**
     * @param $runId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function syncData($runId)
    {
        $run = $this->runRepository->find($runId)->first();
        if (empty($run)) {
            abort(404, 'Run is not found');
        }

        $data = $this->parsehubService->getRunData($run->run_id);
        if (empty($data)) {
            abort(404, 'Data is not found');
        }

        $data = array_shift($data);
        $data = $this->dataService->create($run, $data);

        if (empty($data)) {
            abort(500, 'Run status is not pending');
        }

        return redirect()->route('run.show.data', ['runId' => $run->id]);
    }
}
