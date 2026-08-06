<?php

namespace App\Filament\Resources\News\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('slug')
                    ->label(__('news.fields.slug'))
                    ->searchable()
                    ->toggleable(),

                ImageColumn::make('cover_image')
                    ->label(__('news.fields.cover_image'))
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->label(__('news.fields.published_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('news.fields.status'))
                    ->badge()
                    ->formatStateUsing(fn ($state) =>
                        __('news.statuses.' . $state)
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'hidden' => 'danger',
                        'archived' => 'gray',
                        default => 'slate',
                    })
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label(__('news.fields.featured'))
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('deleted_at')
                    ->label(__('news.fields.record_status'))
                    ->badge()
                    ->state(function ($record) {
                        return $record->trashed()
                            ? __('news.record_status.deleted')
                            : __('news.record_status.active');
                    })
                    ->color(function ($record) {
                        return $record->trashed()
                            ? 'danger'
                            : 'success';
                    })
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('news.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('news.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->actions([
                EditAction::make()
                    ->label(__('news.actions.edit')),

                Action::make('preview')
                    ->label(__('news.actions.preview'))
                    ->icon('heroicon-m-eye')
                    ->color('success')
                    ->url(fn ($record): string =>
                        url("/news/{$record->slug}")
                    )
                    ->openUrlInNewTab(),
            ])

            ->filters([
                TrashedFilter::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
