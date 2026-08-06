<?php

namespace App\Repositories;

use App\Models\Program;
use App\Traits\HasTranslation;

class ProgramRepository
{
    use HasTranslation;

    protected $programModel;

    public function __construct(Program $programModel)
    {
        $this->programModel = $programModel;
    }

    public function get_available_programs()
    {
        $programs = $this->programModel
            ->where('status', 'active')
            ->whereIn('registration_status', ['opened', 'upcoming'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $programs->getCollection()->transform(function ($program) {
            return [
                'id' => $program->id,
                'title' => $this->translateField($program, 'title'),
                'slug' => $program->slug,
                'description' => $this->translateField($program, 'description'),
                'cover_image' => $program->cover_image ? asset('storage/' . $program->cover_image) : null,
                'start_date' => $program->start_date,
                'registration_status' => $program->registration_status,
                'status' => $program->status,
            ];
        });

        return $programs->toArray();
    }



    public function apply_to_program($programId, $userId)
    {
        $program = $this->programModel->find($programId);
        if (!$program) {
            return ['success' => false, 'message' => __('messages.program_not_found')];
        }
        if ($program->user()->where('user_id', $userId)->exists()) {
            return ['success' => false, 'message' => __('messages.already_applied')];
        }

        $program->user()->attach($userId);

        return ['success' => true, 'message' => __('messages.program_application_success')];
    }
}
