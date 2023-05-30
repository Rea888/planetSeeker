<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractProcessingReportsModel extends Model
{
    public function startProcessing()
    {
        $this->processing_began_at = Carbon::now();
        $this->save();
    }

    public function finishProcessing()
    {
        $this->processing_finished_at = Carbon::now();
        $this->save();
    }
}
