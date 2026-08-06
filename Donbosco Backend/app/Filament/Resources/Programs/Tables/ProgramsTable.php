<?php

namespace App\Filament\Resources\Programs\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;

class ProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                    ->label(__('programs.fields.title'))
                    ->formatStateUsing(function ($record) {
                        if (is_array($record->title)) {
                            return $record->title[app()->getLocale()] ?? $record->title['en'] ?? '-';
                        }

                        $titleData = json_decode($record->title, true);

                        if (is_array($titleData)) {
                            return $titleData[app()->getLocale()] ?? $titleData['en'] ?? '-';
                        }

                        return $record->title ?? '-';
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                ImageColumn::make('cover_image')
                    ->label(__('programs.fields.cover_image'))
                    ->toggleable(),

                TextColumn::make('start_date')
                    ->label(__('programs.fields.start_date'))
                    ->date()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('registration_status')
                    ->label(__('programs.fields.registration_status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'upcoming' => __('programs.registration_status_values.upcoming'),
                        'opened' => __('programs.registration_status_values.opened'),
                        'closed' => __('programs.registration_status_values.closed'),
                        'finished' => __('programs.registration_status_values.finished'),
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'opened' => 'success',
                        'upcoming' => 'warning',
                        'closed' => 'danger',
                        'finished' => 'gray',
                        default => 'slate',
                    })
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('programs.fields.status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => __('programs.status_values.active'),
                        'hidden' => __('programs.status_values.hidden'),
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'hidden' => 'gray',
                        default => 'slate',
                    })
                    ->toggleable(),

                TextColumn::make('deleted_at')
                    ->label(__('programs.fields.record_status'))
                    ->badge()
                    ->state(function ($record) {
                        return $record->trashed()
                            ? __('programs.record_status_values.deleted')
                            : __('programs.record_status_values.active');
                    })
                    ->color(function ($record) {
                        return $record->trashed() ? 'danger' : 'success';
                    })
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('programs.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('programs.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ]);
    }
}
