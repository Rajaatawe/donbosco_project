<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) =>
                $query->whereDoesntHave('roles', fn ($q) => $q->where('name', 'super_admin'))
                      ->where('role', '!=', 1)
            )
            ->columns([
                TextColumn::make('name')
                    ->label(__('users.fields.name'))
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label(__('users.fields.email'))
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('email_verified_at')
                    ->label(__('users.fields.email_verified_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('role')
                    ->label(__('users.fields.role'))
                    ->badge()
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(fn ($state, $record) =>
                        (int)$state === 4 ? 'user' : ($record->roles->first()?->name ?? $state)
                    ),

                TextColumn::make('status')
                    ->label(__('users.fields.status'))
                    ->formatStateUsing(fn ($state) => match ((int)$state) {
                        1 => __('users.statuses.active'),
                        2 => __('users.statuses.banned') ?? 'Banned',
                        default => __('users.statuses.inactive'),
                    })
                    ->badge()
                    ->color(fn ($state) => match ((int)$state) {
                        1 => 'success',
                        2 => 'danger',
                        default => 'warning',
                    })
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('users.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('users.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // تم إزالة TrashedFilter
            ])
            ->recordUrl(fn ($record) => $record?->role == 4 ? null : "/admin/users/{$record->id}/edit")
            ->recordAction(fn ($record) => $record?->role == 4 ? null : 'edit')
            ->actions([
                Action::make('toggleBan')
                    ->label(fn ($record) => $record?->status == 2 ? __('users.actions.unban') ?? 'إلغاء الحظر' : __('users.actions.ban') ?? 'حظر')
                    ->icon(fn ($record) => $record?->status == 2 ? 'heroicon-o-lock-open' : 'heroicon-o-lock-closed')
                    ->color(fn ($record) => $record?->status == 2 ? 'success' : 'danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record?->role == 4)
                    ->action(function ($record) {
                        if ($record) {
                            $record->update(['status' => $record->status == 2 ? 1 : 2]);
                        }
                    }),

                Action::make('edit')
                    ->label(__('users.actions.edit'))
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->url(fn ($record) => $record && $record->role != 4 ? "/admin/users/{$record->id}/edit" : null)
                    ->visible(fn ($record) => $record?->role != 4),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('users.actions.delete')),
                ]),
            ]);
    }
}
