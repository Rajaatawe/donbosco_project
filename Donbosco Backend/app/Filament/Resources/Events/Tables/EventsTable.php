<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label(__('events.fields.slug'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('start_time')
                    ->label(__('events.fields.start_time'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_time')
                    ->label(__('events.fields.end_time'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                ImageColumn::make('cover_image')
                    ->label(__('events.fields.cover_image'))
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('events.fields.status'))
                    ->badge()
                    // Fixed: Added missing opening quote inside __() helper
                    ->formatStateUsing(fn ($state) =>
                        __('events.statuses.' . $state)
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'hidden' => 'danger',
                        'archived' => 'gray',
                        default => 'slate',
                    })
                    ->toggleable(),

                // Check soft deletion status using trashed state
                TextColumn::make('deleted_at')
                    ->label(__('events.fields.record_status'))
                    ->badge()
                    ->state(function ($record) {
                        return $record->trashed()
                            ? __('events.record_status.deleted')
                            : __('events.record_status.active');
                    })
                    ->color(function ($record) {
                        return $record->trashed()
                            ? 'danger'
                            : 'success';
                    })
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label(__('events.fields.featured'))
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('events.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
