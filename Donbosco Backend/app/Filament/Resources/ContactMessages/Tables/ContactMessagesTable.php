<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;

use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label(__('contact-messages.fields.id'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('name')
                    ->label(__('contact-messages.fields.name'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label(__('contact-messages.fields.email'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('phone')
                    ->label(__('contact-messages.fields.phone'))
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('subject')
                    ->label(__('contact-messages.fields.subject'))
                    ->searchable()
                    ->limit(30)
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('contact-messages.fields.status'))
                    ->badge()
                    ->formatStateUsing(
                        fn ($state) => __('contact-messages.statuses.' . $state)
                    )
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'in_progress' => 'warning',
                        'replied' => 'success',
                        'archived' => 'gray',
                        default => 'slate',
                    })
                    ->toggleable(),

                TextColumn::make('deleted_at')
                    ->label(__('contact-messages.fields.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('contact-messages.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('contact-messages.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                TrashedFilter::make(),
            ])

            ->bulkActions([
                ExportBulkAction::make()
                    ->label('Export Excel')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withColumns([
                                Column::make('user_id'),
                                Column::make('name'),
                                Column::make('email'),
                                Column::make('phone'),
                                Column::make('subject'),
                                Column::make('status'),
                                Column::make('deleted_at'),
                                Column::make('created_at'),
                                Column::make('updated_at'),
                            ]),
                    ]),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
