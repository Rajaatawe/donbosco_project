<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Pages\Dashboard;
class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

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
