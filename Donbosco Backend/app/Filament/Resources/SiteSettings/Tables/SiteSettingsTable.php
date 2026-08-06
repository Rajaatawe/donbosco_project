<?php

namespace App\Filament\Resources\SiteSettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('key')
                    ->label(__('site-settings.fields.key'))
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('value.image')
                    ->label(__('site-settings.types.image'))
                    ->disk('public')
                    ->square()
                    ->visible(fn ($record = null) =>
                        $record?->type === 'image'
                    ),

                TextColumn::make('value')
                    ->label(__('site-settings.fields.value'))
                    ->formatStateUsing(function ($state, $record) {

                        if (! $record) {
                            return '-';
                        }

                        if (is_string($state)) {
                            return $state;
                        }

                        if (is_array($state)) {

                            return match ($record->type) {

                                'text' => $state['en']
                                    ?? $state['ar']
                                    ?? json_encode($state, JSON_UNESCAPED_UNICODE),

                                'url' => $state['url']
                                    ?? '-',

                                'image' => $state['image']
                                    ?? '-',

                                default => json_encode($state, JSON_UNESCAPED_UNICODE),
                            };
                        }

                        return '-';
                    })
                    ->limit(50)
                    ->visible(fn ($record = null) =>
                        $record?->type !== 'image'
                    ),

                TextColumn::make('type')
                    ->label(__('site-settings.fields.type'))
                    ->badge()
                    ->searchable()
                    ->formatStateUsing(fn ($state) =>
                        __('site-settings.types.' . $state)
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'text' => 'gray',
                        'image' => 'danger',
                        'url' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('group')
                    ->label(__('site-settings.fields.group'))
                    ->badge()
                    ->searchable()
                    ->formatStateUsing(fn ($state) =>
                        __('site-settings.groups.' . $state)
                    ),

                TextColumn::make('created_at')
                    ->label(__('activities.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                // لا يوجد TrashedFilter هنا لأن الموديل لا يدعم الحذف المؤقت
            ])
            ->recordActions([
                EditAction::make()
                    ->label(__('site-settings.actions.edit')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
