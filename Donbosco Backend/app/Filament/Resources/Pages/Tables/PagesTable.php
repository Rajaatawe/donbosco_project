<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('image')
                    ->circular()
                    ->label(__('pages.fields.image'))
                    ->toggleable(),

                TextColumn::make('title')
                    ->label(__('pages.fields.title'))
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('pages.fields.status'))
                    ->badge()
                    ->formatStateUsing(fn ($state) =>
                        __('pages.statuses.' . $state)
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        default => 'gray',
                    })
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label(__('pages.fields.updated_at'))
                    ->dateTime()
                    ->toggleable(),

            ])
            ->filters([
                // لا يوجد TrashedFilter هنا لأن الموديل لا يدعم الحذف المؤقت
            ])
            ->actions([
                \Filament\Actions\EditAction::make()
                    ->label(__('pages.actions.edit')),
            ]);
    }
}
