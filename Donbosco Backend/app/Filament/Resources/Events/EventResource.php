<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\Schemas\EventForm;
use App\Filament\Resources\Events\Tables\EventsTable;
use App\Models\Event;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|null|BackedEnum $navigationIcon =
        Heroicon::OutlinedRectangleStack;

  public static function getNavigationGroup(): string
{
    return __('navigation.groups.content');
}
    protected static ?string $navigationLabel =
        'Events';

    /*
    |--------------------------------------------------------------------------
    | Forms & Tables
    |--------------------------------------------------------------------------
    |*/

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    |*/

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
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
    TRANSLATION : : : :
    */
    public static function getNavigationLabel(): string
{
    return __('events.navigation');
}

public static function getModelLabel(): string
{
    return __('events.single');
}

public static function getPluralModelLabel(): string
{
    return __('events.plural');
}
    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |*/

    public static function canViewAny(): bool
    {
        return static::isAdmin()
            || static::user()?->can('view events');
    }

    public static function canView($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('view events');
    }

    public static function canCreate(): bool
    {
        return static::isAdmin()
            || static::user()?->can('create events');
    }

    public static function canEdit($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('edit events');
    }

    public static function canDelete($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete events');
    }

    public static function canDeleteAny(): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete events');
    }

    public static function canRestore($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete events');
    }

    public static function canForceDelete($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete events');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::isAdmin()
            || static::user()?->can('view events');
    }
}
