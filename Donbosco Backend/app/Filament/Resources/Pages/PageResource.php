<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Filament\Resources\Pages\Schemas\PageForm;
use App\Filament\Resources\Pages\Tables\PagesTable;
use App\Models\Page;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|null|BackedEnum $navigationIcon =
        'heroicon-o-document-duplicate';

     public static function getNavigationGroup(): string
{
    return __('navigation.groups.content');
}

    protected static ?string $navigationLabel =
        'Pages';

    /*
    |--------------------------------------------------------------------------
    | Forms & Tables
    |--------------------------------------------------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return PageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
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
    TRANSLATION :: : :
    */
    public static function getNavigationLabel(): string
{
    return __('pages.navigation');
}

public static function getModelLabel(): string
{
    return __('pages.single');
}

public static function getPluralModelLabel(): string
{
    return __('pages.plural');
}
    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    public static function canViewAny(): bool
    {
        return static::isAdmin()
            || static::user()?->can('view pages');
    }

    public static function canView($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('view pages');
    }

    public static function canCreate(): bool
    {
        return static::isAdmin()
            || static::user()?->can('create pages');
    }

    public static function canEdit($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('edit pages');
    }

    public static function canDelete($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('delete pages');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::isAdmin()
            || static::user()?->can('view pages');
    }
}
