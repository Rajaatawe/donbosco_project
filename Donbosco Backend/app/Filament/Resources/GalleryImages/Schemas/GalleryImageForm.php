<?php

namespace App\Filament\Resources\GalleryImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

use Filament\Schemas\Schema;

class GalleryImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('gallery_album_id')
                    ->label(__('gallery-images.fields.album'))
                    ->relationship('galleryAlbum', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('status')
                    ->label(__('gallery-images.fields.status'))
                    ->options([
                        'active' => __('gallery-images.statuses.active'),
                        'hidden' => __('gallery-images.statuses.hidden'),
                    ])
                    ->default('active')
                    ->required(),

                FileUpload::make('image')
                    ->label(__('gallery-images.fields.image'))
                    ->image()
                    ->disk('public')
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('caption')
                    ->label(__('gallery-images.fields.caption'))
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
