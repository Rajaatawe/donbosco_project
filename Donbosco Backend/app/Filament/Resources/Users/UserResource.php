<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|null|BackedEnum $navigationIcon =
        Heroicon::OutlinedRectangleStack;

   public static function getNavigationGroup(): string
{
    return __('navigation.groups.administration');
}
    protected static ?string $navigationLabel =
        'Users';

    /*
    |--------------------------------------------------------------------------
    | Forms & Tables
    |--------------------------------------------------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public static function getRelations(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

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
    TRANSLATION : : :
    */

    public static function getNavigationLabel(): string
{
    return __('users.navigation');
}

public static function getModelLabel(): string
{
    return __('users.single');
}

public static function getPluralModelLabel(): string
{
    return __('users.plural');
}

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    public static function canViewAny(): bool
    {
        return static::isAdmin()
            || static::user()?->can('manage users');
    }

    public static function canView($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('manage users');
    }

    public static function canCreate(): bool
    {
        return static::isAdmin()
            || static::user()?->can('manage users');
    }

    public static function canEdit($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('manage users');
    }

    public static function canDelete($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('manage users');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::isAdmin()
            || static::user()?->can('manage users');
    }
}
