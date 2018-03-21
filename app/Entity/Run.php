<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Run
 *
 * @package App\Entity
 */
class Run extends Model
{
    const PENDING_STATUS    = 'pending';
    const IN_PROCESS_STATUS = 'inProcess';
    const COMPLETE_STATUS   = 'complete';

    protected $table = 'runs';

    protected $fillable = [
        'run_id',
        'processed',
        'status',
        'count_row',
    ];
}
