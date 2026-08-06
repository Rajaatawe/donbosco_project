<?php

namespace App\Filament\Resources\GalleryImages;

use App\Filament\Resources\GalleryImages\Pages\CreateGalleryImage;
use App\Filament\Resources\GalleryImages\Pages\EditGalleryImage;
use App\Filament\Resources\GalleryImages\Pages\ListGalleryImages;
use App\Filament\Resources\GalleryImages\Schemas\GalleryImageForm;
use App\Filament\Resources\GalleryImages\Tables\GalleryImagesTable;
use App\Models\GalleryImage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;


    protected static string|null|BackedEnum $navigationIcon =
        Heroicon::OutlinedRectangleStack;

    public static function getNavigationGroup(): string
    {
        return __('navigation.groups.content_management');
    }

    protected static ?string $navigationLabel =
        'Gallery Images';

    /*
    |--------------------------------------------------------------------------
    | Forms & Tables
    |--------------------------------------------------------------------------
    */

    public static function form(Schema $schema): Schema
    {
        return GalleryImageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GalleryImagesTable::configure($table);
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
            'index' => ListGalleryImages::route('/'),
            'create' => CreateGalleryImage::route('/create'),
            'edit' => EditGalleryImage::route('/{record}/edit'),
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
    |--------------------------------------------------------------------------
    | TRANSLATION
    |--------------------------------------------------------------------------
    */
    public static function getNavigationLabel(): string
    {
        return __('gallery-images.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('gallery-images.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('gallery-images.plural');
    }

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    public static function canViewAny(): bool
    {
        return static::isAdmin()
            || static::user()?->can('upload images');
    }

    public static function canView($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('upload images');
    }

    public static function canCreate(): bool
    {
        return static::isAdmin()
            || static::user()?->can('upload images');
    }

    public static function canEdit($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('upload images');
    }

    public static function canDelete($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('upload images');
    }

    public static function canDeleteAny(): bool
    {
        return static::isAdmin()
            || static::user()?->can('upload images');
    }

    public static function canRestore($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('upload images');
    }

    public static function canForceDelete($record): bool
    {
        return static::isAdmin()
            || static::user()?->can('upload images');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::isAdmin()
            || static::user()?->can('upload images');
    }
}
