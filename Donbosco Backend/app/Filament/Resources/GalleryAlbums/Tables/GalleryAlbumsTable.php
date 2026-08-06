<?php

namespace App\Filament\Resources\GalleryAlbums\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class GalleryAlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                    ->label(__('gallery-albums.fields.title'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                ImageColumn::make('cover_image')
                    ->label(__('gallery-albums.fields.cover_image'))
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('gallery-albums.fields.status'))
                    ->badge()
                    ->formatStateUsing(fn ($state) =>
                        __('gallery-albums.statuses.' . $state)
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'hidden' => 'danger',
                        default => 'gray',
                    })
                    ->toggleable(),

                TextColumn::make('sort_order')
                    ->label(__('gallery-albums.fields.sort_order'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('deleted_at')
                    ->label(__('gallery-albums.fields.record_status'))
                    ->badge()
                    ->state(function ($record) {
                        return $record->trashed()
                            ? __('gallery-albums.record_status.deleted')
                            : __('gallery-albums.record_status.active');
                    })
                    ->color(function ($record) {
                        return $record->trashed()
                            ? 'danger'
                            : 'success';
                    })
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('gallery-albums.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('gallery-albums.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->reorderable('sort_order')

            ->defaultSort('sort_order', 'asc')

            ->filters([
                TrashedFilter::make(),
            ]);
    }
}
