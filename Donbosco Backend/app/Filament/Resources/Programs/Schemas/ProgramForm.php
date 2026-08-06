<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

use Illuminate\Support\Str;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // Title EN
            TextInput::make('title.en')
                ->label(__('programs.fields.title_en'))
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('slug', Str::slug($state));
                }),

            // Title AR
            TextInput::make('title.ar')
                ->label(__('programs.fields.title_ar')),

            // Slug
            TextInput::make('slug')
                ->label(__('programs.fields.slug'))
                ->disabled()
                ->dehydrated()
                ->unique(ignoreRecord: true)
                ->helperText(__('programs.fields.slug_helper'))
                ->required(),

            // Description EN
            Textarea::make('description.en')
                ->label(__('programs.fields.description_en'))
                ->required()
                ->columnSpanFull(),

            // Description AR
            Textarea::make('description.ar')
                ->label(__('programs.fields.description_ar'))
                ->columnSpanFull(),

            // Cover Image
            FileUpload::make('cover_image')
                ->label(__('programs.fields.cover_image'))
                ->image()
                ->disk('public')
                ->directory('programs')
                ->columnSpanFull(),

            // Start Date
            DatePicker::make('start_date')
                ->label(__('programs.fields.start_date'))
                ->required(),

            // Registration Status
            // Registration Status
Select::make('registration_status')
    ->label(__('programs.fields.registration_status'))
    ->options([
        'upcoming' => __('programs.registration_status_values.upcoming'),
        'opened' => __('programs.registration_status_values.opened'),
        'closed' => __('programs.registration_status_values.closed'),
        'finished' => __('programs.registration_status_values.finished'),
    ])
    ->default('upcoming')
    ->required(),

// Status
Select::make('status')
    ->label(__('programs.fields.status'))
    ->options([
        'active' => __('programs.status_values.active'),
        'hidden' => __('programs.status_values.hidden'),
    ])
    ->default('active')
    ->required(),
        ]);
    }
}
