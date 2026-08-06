<?php

namespace App\Filament\Resources\Activities\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                    ->label(__('activities.fields.title'))
                    ->state(function ($record) {
                        return $record->getTranslation('title', app()->getLocale())
                            ?? $record->getTranslation('title', 'en')
                            ?? '-';
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('slug')
                    ->label(__('activities.fields.slug'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('activityCategory.name')
                    ->label(__('activities.fields.category'))
                    ->formatStateUsing(function ($record) {
                        return $record->activityCategory?->getTranslation('name', app()->getLocale())
                            ?? $record->activityCategory?->getTranslation('name', 'en')
                            ?? '-';
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('activities.fields.status'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => __('activities.status_values.' . $state))
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'hidden' => 'danger',
                        'archived' => 'gray',
                        default => 'slate',
                    })
                    ->toggleable(),

                // تعديل عمود حالة النشاط (deleted_at) هنا لحل مشكلة العمود الفاضي
                TextColumn::make('deleted_at')
                    ->label(__('activities.fields.record_status'))
                    ->badge()
                    ->state(function ($record): string {
                        return $record->trashed() ? 'محذوف' : 'نشط';
                    })
                    ->color(fn ($record): string =>
                        $record->trashed() ? 'danger' : 'success'
                    )
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label(__('activities.fields.featured'))
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('activities.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([

                SelectFilter::make('status')
                    ->label(__('activities.fields.status'))
                    ->options([
                        'published' => __('activities.status_values.published'),
                        'draft' => __('activities.status_values.draft'),
                        'hidden' => __('activities.status_values.hidden'),
                        'archived' => __('activities.status_values.archived'),
                    ]),

                TrashedFilter::make()
                    ->label(__('activities.fields.record_status')),
            ]);
    }
}
