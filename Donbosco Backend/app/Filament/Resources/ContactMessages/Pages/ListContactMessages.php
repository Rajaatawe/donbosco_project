<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Pages\Dashboard;
class ListContactMessages extends ListRecords
{
    protected static string $resource = ContactMessageResource::class;

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
