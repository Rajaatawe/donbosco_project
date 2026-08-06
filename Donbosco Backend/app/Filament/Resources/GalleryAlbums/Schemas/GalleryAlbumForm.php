<?php

namespace App\Filament\Resources\GalleryAlbums\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Schemas\Schema;

use Illuminate\Support\Str;

class GalleryAlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Textarea::make('title.en')
                    ->label(__('gallery-albums.fields.title_en'))
                    ->required()
                    ->rows(2)
                    ->columnSpanFull()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),

                Textarea::make('title.ar')
                    ->label(__('gallery-albums.fields.title_ar'))
                    ->required()
                    ->rows(2)
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->label(__('gallery-albums.fields.slug'))
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),

                Textarea::make('description.en')
                    ->label(__('gallery-albums.fields.description_en'))
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),

                Textarea::make('description.ar')
                    ->label(__('gallery-albums.fields.description_ar'))
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),

                FileUpload::make('cover_image')
                    ->label(__('gallery-albums.fields.cover_image'))
                    ->image()
                    ->disk('public')
                    ->directory('gallery-albums')
                    ->required()
                    ->columnSpanFull(),

                Select::make('status')
                    ->label(__('gallery-albums.fields.status'))
                    ->options([
                        'active' => __('gallery-albums.statuses.active'),
                        'hidden' => __('gallery-albums.statuses.hidden'),
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
