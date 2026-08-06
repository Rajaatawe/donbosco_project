<?php

namespace App\Filament\Resources\Programs;

use App\Filament\Resources\Programs\Pages\CreateProgram;
use App\Filament\Resources\Programs\Pages\EditProgram;
use App\Filament\Resources\Programs\Pages\ListPrograms;
use App\Filament\Resources\Programs\Schemas\ProgramForm;
use App\Filament\Resources\Programs\Tables\ProgramsTable;
use App\Models\Program;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'title';

    /*
    |--------------------------------------------------------------------------
    | Form & Table
    |--------------------------------------------------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return ProgramForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgramsTable::configure($table);
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    public static function getPages(): array
    {
        return [
            'index' => ListPrograms::route('/'),
            'create' => CreateProgram::route('/create'),
            'edit' => EditProgram::route('/{record}/edit'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Query
    |--------------------------------------------------------------------------
    */

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Navigation Labels
    |--------------------------------------------------------------------------
    */

    public static function getNavigationLabel(): string
    {
        return __('programs.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('programs.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('programs.plural');
    }

    /*
    |--------------------------------------------------------------------------
    | Permissions Helpers
    |--------------------------------------------------------------------------
    */

    protected static function user()
    {
        return auth()->user();
    }

    protected static function isAdmin(): bool
    {
        return auth()->check()
            && optional(static::user())->hasRole('admin');
    }

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    public static function canViewAny(): bool
    {
        return static::isAdmin()
            || optional(static::user())->can('view programs');
    }

    public static function canView($record): bool
    {
        return static::isAdmin()
            || optional(static::user())->can('view programs');
    }

    public static function canCreate(): bool
    {
        return static::isAdmin()
            || optional(static::user())->can('create programs');
    }

    public static function canEdit($record): bool
    {
        return static::isAdmin()
            || optional(static::user())->can('edit programs');
    }

    public static function canDelete($record): bool
    {
        return static::isAdmin()
            || optional(static::user())->can('delete programs');
    }

    public static function canDeleteAny(): bool
    {
        return static::isAdmin()
            || optional(static::user())->can('delete programs');
    }

    public static function canRestore($record): bool
    {
        return static::isAdmin()
            || optional(static::user())->can('delete programs');
    }

    public static function canForceDelete($record): bool
    {
        return static::isAdmin()
            || optional(static::user())->can('delete programs');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::isAdmin()
            || optional(static::user())->can('view programs');
    }
}
