<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages\CreateSiteSetting;
use App\Filament\Resources\SiteSettings\Pages\EditSiteSetting;
use App\Filament\Resources\SiteSettings\Pages\ListSiteSettings;
use App\Filament\Resources\SiteSettings\Schemas\SiteSettingForm;
use App\Filament\Resources\SiteSettings\Tables\SiteSettingsTable;
use App\Models\SiteSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'key';

    /*
    |--------------------------------------------------------------------------
    | Forms & Tables
    |--------------------------------------------------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return SiteSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiteSettingsTable::configure($table);
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    public static function getPages(): array
    {
        return [
            'index' => ListSiteSettings::route('/'),
            'create' => CreateSiteSetting::route('/create'),
            'edit' => EditSiteSetting::route('/{record}/edit'),
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
    TRANSLATION : : : :
    */
    public static function getNavigationLabel(): string
{
    return __('site-settings.navigation');
}

public static function getModelLabel(): string
{
    return __('site-settings.single');
}

public static function getPluralModelLabel(): string
{
    return __('site-settings.plural');
}

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    public static function canViewAny(): bool
    {
        return static::isAdmin()
            || static::user()?->can('view site settings');
    }

    public static function canView($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('view site settings');
    }

    public static function canCreate(): bool
    {
        return static::isAdmin()
            || static::user()?->can('create site settings');
    }

    public static function canEdit($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('edit site settings');
    }

    public static function canDelete($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete site settings');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::isAdmin()
            || static::user()?->can('view site settings');
    }
}
