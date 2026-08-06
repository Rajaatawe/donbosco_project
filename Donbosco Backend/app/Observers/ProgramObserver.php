<?php

namespace App\Observers;

use App\Models\Program;
use Illuminate\Support\Facades\Cache;

class ProgramObserver
{
    public function created(Program $program): void
    {
        $this->clearCache();
    }

    public function updated(Program $program): void
    {
        $this->clearCache();
    }

    public function deleted(Program $program): void
    {
        $this->clearCache();
    }

    protected function clearCache(): void
    {
        Cache::tags(['program_list'])->flush();
    }
}
