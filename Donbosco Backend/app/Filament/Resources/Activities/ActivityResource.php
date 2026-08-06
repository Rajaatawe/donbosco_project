<?php

namespace App\Filament\Resources\Activities;

use App\Filament\Resources\Activities\Pages\CreateActivity;
use App\Filament\Resources\Activities\Pages\EditActivity;
use App\Filament\Resources\Activities\Pages\ListActivities;
use App\Filament\Resources\Activities\Schemas\ActivityForm;
use App\Filament\Resources\Activities\Tables\ActivitiesTable;
use App\Models\Activity;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|null|\BackedEnum $navigationIcon =
        'heroicon-o-rectangle-stack';

    /*
    |--------------------------------------------------------------------------
    | Forms & Tables
    |--------------------------------------------------------------------------
    |*/

    public static function form(Schema $schema): Schema
    {
        return ActivityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivitiesTable::configure($table);
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    |*/

    public static function getPages(): array
    {
        return [
            'index' => ListActivities::route('/'),
            'create' => CreateActivity::route('/create'),
            'edit' => EditActivity::route('/{record}/edit'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Query
    |--------------------------------------------------------------------------
    |*/

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
    | Helpers
    |--------------------------------------------------------------------------
    |*/

    protected static function user()
    {
        return auth()->user();
    }

    protected static function isAdmin(): bool
    {
        return auth()->check()
            && static::user()->hasRole('admin');
    }
    /*
    Translation section::::

    */
public static function getNavigationLabel(): string
{
    return __('activities.navigation');
}

public static function getModelLabel(): string
{
    return __('activities.single');
}

public static function getPluralModelLabel(): string
{
    return __('activities.plural');
}
    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |*/

    public static function canViewAny(): bool
    {
        return static::isAdmin()
            || static::user()?->can('view activities');
    }

    public static function canView($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('view activities');
    }

    public static function canCreate(): bool
    {
        return static::isAdmin()
            || static::user()?->can('create activities');
    }

    public static function canEdit($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('edit activities');
    }

    public static function canDelete($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete activities');
    }

    public static function canDeleteAny(): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete activities');
    }

    public static function canRestore($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete activities');
    }

    public static function canForceDelete($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete activities');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::isAdmin()
            || static::user()?->can('view activities');
    }
}
