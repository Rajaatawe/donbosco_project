<?php

namespace App\Http\Controllers;

use App\Services\ProgramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    protected $programService;

    public function __construct(ProgramService $programService)
    {
        $this->programService = $programService;
    }

    public function index()
    {
        $programs = $this->programService->get_available_programs();
        return response()->json($programs);
    }

    public function apply($programId)
    {
        $userId = Auth::id();
        $result = $this->programService->apply_to_program($programId, $userId);

        if ($result['success']) {
            return response()->json(['message' => $result['message']], 200);
        } else if ($result['message'] === __('messages.program_not_found')) {
            return response()->json(['message' => $result['message']], 404);
        }else{
            return response()->json(['message' => $result['message']], 400);
        }
    }
}


