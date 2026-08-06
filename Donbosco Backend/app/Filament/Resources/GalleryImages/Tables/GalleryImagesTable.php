<?php

namespace App\Filament\Resources\GalleryImages\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class GalleryImagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('galleryAlbum.title')
                    ->label(__('gallery-images.fields.gallery_album'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                ImageColumn::make('image')
                    ->label(__('gallery-images.fields.image'))
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('gallery-images.fields.status'))
                    ->badge()
                    ->formatStateUsing(fn ($state) =>
                        __('gallery-images.statuses.' . $state)
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'hidden' => 'danger',
                        default => 'gray',
                    })
                    ->toggleable(),

                TextColumn::make('sort_order')
                    ->label(__('gallery-images.fields.sort_order'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('deleted_at')
                    ->label(__('gallery-images.fields.record_status'))
                    ->badge()
                    ->state(function ($record) {
                        return $record->trashed()
                            ? __('gallery-images.record_status.deleted')
                            : __('gallery-images.record_status.active');
                    })
                    ->color(function ($record) {
                        return $record->trashed()
                            ? 'danger'
                            : 'success';
                    })
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('gallery-images.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('gallery-images.fields.updated_at'))
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
