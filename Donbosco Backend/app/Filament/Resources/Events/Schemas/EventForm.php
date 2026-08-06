<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;

use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Textarea::make('title.en')
                ->label(__('events.fields.title_en'))
                ->required()
                ->rows(2)
                ->columnSpanFull()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('slug', Str::slug($state));
                }),

            Textarea::make('title.ar')
                ->label(__('events.fields.title_ar'))
                ->required()
                ->rows(2)
                ->columnSpanFull(),

            TextInput::make('slug')
                ->label(__('events.fields.slug'))
                ->required()
                ->disabled()
                ->dehydrated()
                ->unique(ignoreRecord: true)
                ->columnSpanFull(),

            Textarea::make('description.en')
                ->label(__('events.fields.description_en'))
                ->required()
                ->rows(4)
                ->columnSpanFull(),

            Textarea::make('description.ar')
                ->label(__('events.fields.description_ar'))
                ->required()
                ->rows(4)
                ->columnSpanFull(),

            DateTimePicker::make('start_time')
                ->label(__('events.fields.start_time'))
                ->required(),

            DateTimePicker::make('end_time')
                ->label(__('events.fields.end_time'))
                ->required(),

            Textarea::make('location.en')
                ->label(__('events.fields.location_en'))
                ->required()
                ->rows(2)
                ->columnSpanFull(),

            FileUpload::make('cover_image')
                ->label(__('events.fields.cover_image'))
                ->image()
                ->disk('public')
                ->directory('events')
                ->columnSpanFull(),

            Select::make('status')
                ->label(__('events.fields.status'))
                ->options([
                    'draft' => __('events.statuses.draft'),
                    'published' => __('events.statuses.published'),
                    'hidden' => __('events.statuses.hidden'),
                    'archived' => __('events.statuses.archived'),
                ])
                ->default('draft')
                ->required(),

            Checkbox::make('is_featured')
                ->label(__('events.fields.featured'))
                ->helperText(__('events.fields.featured_helper'))
                ->default(false)
                ->columnSpanFull()
                ->extraAttributes([
                    'class' => 'p-4 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 hover:bg-indigo-50/30 hover:border-indigo-300 transition-all dark:border-gray-700 dark:bg-gray-800/50'
                ]),
        ]);
    }
}
