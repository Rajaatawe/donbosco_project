<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Schemas\Schema;

use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Textarea::make('title.en')
                ->label(__('news.fields.title_en'))
                ->required()
                ->rows(2)
                ->columnSpanFull()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('slug', Str::slug($state));
                }),

            Textarea::make('title.ar')
                ->label(__('news.fields.title_ar'))
                ->required()
                ->rows(2)
                ->columnSpanFull(),

            TextInput::make('slug')
                ->label(__('news.fields.slug'))
                ->required()
                ->disabled()
                ->dehydrated()
                ->unique(ignoreRecord: true)
                ->columnSpanFull(),

            FileUpload::make('cover_image')
                ->label(__('news.fields.cover_image'))
                ->image()
                ->disk('public')
                ->directory('news')
                ->columnSpanFull(),

            Textarea::make('summary.en')
                ->label(__('news.fields.summary_en'))
                ->required()
                ->rows(3)
                ->columnSpanFull(),

            Textarea::make('summary.ar')
                ->label(__('news.fields.summary_ar'))
                ->required()
                ->rows(3)
                ->columnSpanFull(),

            Textarea::make('content.en')
                ->label(__('news.fields.content_en'))
                ->required()
                ->rows(6)
                ->columnSpanFull(),

            Textarea::make('content.ar')
                ->label(__('news.fields.content_ar'))
                ->required()
                ->rows(6)
                ->columnSpanFull(),

            DateTimePicker::make('published_at')
                ->label(__('news.fields.published_at')),

            Select::make('status')
                ->label(__('news.fields.status'))
                ->options([
                    'draft' => __('news.statuses.draft'),
                    'published' => __('news.statuses.published'),
                    'hidden' => __('news.statuses.hidden'),
                    'archived' => __('news.statuses.archived'),
                ])
                ->default('draft')
                ->required(),

            Checkbox::make('is_featured')
                ->label(__('news.fields.featured'))
                ->helperText(__('news.fields.featured_helper'))
                ->default(false)
                ->columnSpanFull()
                ->extraAttributes([
                    'class' => 'p-4 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 hover:bg-indigo-50/30 hover:border-indigo-300 transition-all dark:border-gray-700 dark:bg-gray-800/50'
                ]),
        ]);
    }
}
