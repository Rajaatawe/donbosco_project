<?php

namespace App\Filament\Resources\Activities\Pages;

use App\Filament\Resources\Activities\ActivityResource;
use Filament\Resources\Pages\EditRecord;

class EditActivity extends EditRecord
{
    protected static string $resource = ActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // استدعاء الأكشنز المخصصة للصفحات بمسارها المطلق لتجنب تعارض الـ Tables
            \Filament\Actions\DeleteAction::make(),
            \Filament\Actions\RestoreAction::make(),
            \Filament\Actions\ForceDeleteAction::make(),
        ];
    }

    //translation::
}
