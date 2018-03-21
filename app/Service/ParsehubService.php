<?php

namespace App\Service;

use Parsehub\Parsehub;

/**
 * Class ParsehubService
 *
 * @package App\Service
 */
class ParsehubService
{
    /**
     * @var array
     */
    private $parsehubConfig;

    /**
     * AppServiceProvider constructor.
     *
     * @param array $parsehubConfig
     */
    public function __construct(array $parsehubConfig)
    {
        $this->parsehubConfig = $parsehubConfig;
    }

    /**
     * @return array
     */
    public function getProjectTokens()
    {
        $parsehub = new Parsehub($this->parsehubConfig['api-key']);
        $projects = $parsehub->getProjectList();

        $tokens = [];
        foreach ($projects->projects as $project) {
            $tokens[] = $project->token;
        }

        return $tokens;
    }

    /**
     * @param string $projectToken
     * @param int    $offset
     *
     * @return array
     */
    public function getRunTokensByProject(string $projectToken, int $offset = 0)
    {
        $parsehub = new Parsehub($this->parsehubConfig['api-key']);
        $project  = $parsehub->getProject($projectToken, $offset);

        $tokens = [];
        foreach ($project->run_list as $run) {
            $tokens[] = $run->run_token;
        }

        return $tokens;
    }

    /**
     * @param string $runToken
     *
     * @return array
     */
    public function getRunData(string $runToken)
    {
        try {
            $parsehub = new Parsehub($this->parsehubConfig['api-key']);

            return json_decode($parsehub->getRunData($runToken), true);
        } catch (\Exception $ex) {
            return null;
        }
    }
}
