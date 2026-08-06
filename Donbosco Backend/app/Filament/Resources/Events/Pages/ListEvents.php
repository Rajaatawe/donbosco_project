<?php

namespace App\Filament\Resources\Events\Pages;

use App\Filament\Resources\Events\EventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Pages\Dashboard;
class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

 protected function getHeaderActions(): array
    {
       return [
  Action::make('back_to_dashboard')
    ->label(__('dashboard.main_page'))
    ->icon('heroicon-m-home')
    ->color('danger')
              ->url(fn (): string => Dashboard::getUrl()),

              CreateAction::make(),

        ];
    }
}
