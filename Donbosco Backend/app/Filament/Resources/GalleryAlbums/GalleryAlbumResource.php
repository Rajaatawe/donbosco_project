<?php

namespace App\Filament\Resources\GalleryAlbums;

use App\Filament\Resources\GalleryAlbums\Pages\CreateGalleryAlbum;
use App\Filament\Resources\GalleryAlbums\Pages\EditGalleryAlbum;
use App\Filament\Resources\GalleryAlbums\Pages\ListGalleryAlbums;
use App\Filament\Resources\GalleryAlbums\Schemas\GalleryAlbumForm;
use App\Filament\Resources\GalleryAlbums\Tables\GalleryAlbumsTable;
use App\Models\GalleryAlbum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryAlbumResource extends Resource
{
    protected static ?string $model = GalleryAlbum::class;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';
  public static function getNavigationGroup(): string
{
    return __('navigation.groups.content_management');
}
    protected static ?string $navigationLabel =
        'Gallery Albums';

    /*
    |--------------------------------------------------------------------------
    | Forms & Tables
    |--------------------------------------------------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return GalleryAlbumForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GalleryAlbumsTable::configure($table);
    }

    /*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    */

    public static function getPages(): array
    {
        return [
            'index' => ListGalleryAlbums::route('/'),
            'create' => CreateGalleryAlbum::route('/create'),
            'edit' => EditGalleryAlbum::route('/{record}/edit'),
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
    return __('gallery-albums.navigation');
}

public static function getModelLabel(): string
{
    return __('gallery-albums.single');
}

public static function getPluralModelLabel(): string
{
    return __('gallery-albums.plural');
}
    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    public static function canViewAny(): bool
    {
        return auth()->check()
            && (static::isAdmin() || static::user()->can('view albums'));
    }

    public static function canView($record): bool
    {
        return auth()->check()
            && (static::isAdmin() || static::user()->can('view albums'));
    }

    public static function canCreate(): bool
    {
        return auth()->check()
            && (static::isAdmin() || static::user()->can('create albums'));
    }

    public static function canEdit($record): bool
    {
        return auth()->check()
            && (static::isAdmin() || static::user()->can('edit albums'));
    }

    public static function canDelete($record): bool
    {
        return auth()->check()
            && (static::isAdmin() || static::user()->can('delete albums'));
    }

    public static function canDeleteAny(): bool
    {
        return auth()->check()
            && (static::isAdmin() || static::user()->can('delete albums'));
    }

    public static function canRestore($record): bool
    {
        return auth()->check()
            && (static::isAdmin() || static::user()->can('delete albums'));
    }

    public static function canForceDelete($record): bool
    {
        return auth()->check()
            && (static::isAdmin() || static::user()->can('delete albums'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canViewAny();
    }
}
