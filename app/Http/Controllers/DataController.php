<?php

namespace App\Http\Controllers;

use App\Eloquent\Repository\DataRepository;

/**
 * Class DataController
 *
 * @package App\Http\Controllers
 */
class DataController extends Controller
{
    /**
     * @var DataRepository
     */
    private $dataRepository;

    /**
     * DataController constructor.
     *
     * @param DataRepository $dataRepository
     */
    public function __construct(DataRepository $dataRepository)
    {
        $this->dataRepository = $dataRepository;
    }

    /**
     * @param $runId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showData($runId)
    {
        $data = $this->dataRepository->fetchByRun((int)$runId)->paginate(10);

        return view('app/data/show', ['data' => $data]);
    }
}
