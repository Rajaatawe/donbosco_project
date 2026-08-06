<?php

namespace App\Services;

use App\Repositories\ProgramRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class ProgramService
{
    protected $programRepository;
    protected $locale;
    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
        $this->locale = App::getLocale();
    }

    public function get_available_programs()
    {
        $page = request('page', 1);
        $cacheKey = $this->locale == "ar" ? "ar:programs_page_" . $page : "en:programs_page_" . $page;

        return Cache::tags(["program_list"])->remember(
            $cacheKey,
            604800,
            function () {
                return $this->programRepository->get_available_programs();
            }
        );
    }

    public function apply_to_program($programId, $userId)
    {
        return $this->programRepository->apply_to_program($programId, $userId);
    }
}
