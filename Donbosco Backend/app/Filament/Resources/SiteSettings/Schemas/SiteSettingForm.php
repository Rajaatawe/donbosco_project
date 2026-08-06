<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /*
            |--------------------------------------------------------------------------
            | KEY
            |--------------------------------------------------------------------------
            */

            TextInput::make('key')
                ->label(__('site-settings.fields.setting_key'))
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            /*
            |--------------------------------------------------------------------------
            | GROUP
            |--------------------------------------------------------------------------
            */

            Select::make('group')
                ->label(__('site-settings.fields.group'))
                ->options([
                    'general' => __('site-settings.groups.general'),
                    'social_media' => __('site-settings.groups.social_media'),
                    'contact_info' => __('site-settings.groups.contact_info'),
                ])
                ->default('general')
                ->required(),

            /*
            |--------------------------------------------------------------------------
            | TYPE
            |--------------------------------------------------------------------------
            */

            Select::make('type')
                ->label(__('site-settings.fields.setting_type'))
                ->options([
                    'text' => __('site-settings.types.text'),
                    'url' => __('site-settings.types.url'),
                    'image' => __('site-settings.types.image'),
                ])
                ->default('text')
                ->required()
                ->live()
                ->disabled(fn (string $operation) =>
                    $operation === 'edit'
                )
                ->dehydrated(),

            /*
            |--------------------------------------------------------------------------
            | IMAGE VALUE
            |--------------------------------------------------------------------------
            */

            FileUpload::make('value.image')
                ->label(__('site-settings.types.image'))
                ->image()
                ->disk('public')
                ->directory('settings')
                ->visible(fn (callable $get) =>
                    $get('type') === 'image'
                ),

            /*
            |--------------------------------------------------------------------------
            | URL VALUE
            |--------------------------------------------------------------------------
            */

            TextInput::make('value.url')
                ->label(__('site-settings.types.url'))
                ->url()
                ->visible(fn (callable $get) =>
                    $get('type') === 'url'
                ),

            /*
            |--------------------------------------------------------------------------
            | TEXT VALUES
            |--------------------------------------------------------------------------
            */

            Tabs::make('translations')
                ->tabs([

                    Tab::make(__('site-settings.fields.value_ar'))
                        ->schema([
                            TextInput::make('value.ar')
                                ->label(__('site-settings.fields.value_ar')),
                        ]),

                    Tab::make(__('site-settings.fields.value_en'))
                        ->schema([
                            TextInput::make('value.en')
                                ->label(__('site-settings.fields.value_en')),
                        ]),
                ])
                ->visible(fn (callable $get) =>
                    $get('type') === 'text'
                )
                ->columnSpanFull(),
        ]);
    }
}
