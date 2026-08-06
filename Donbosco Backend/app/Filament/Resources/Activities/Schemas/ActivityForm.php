<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Checkbox;

use App\Models\ActivityCategory;
use Illuminate\Support\Str;

use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // Category
            Select::make('activity_category_id')
                ->label(__('activities.fields.category'))
                ->relationship('activityCategory', 'name')
                ->getOptionLabelFromRecordUsing(
                    fn ($record) =>
                        $record->getTranslation('name', app()->getLocale())
                )
                ->searchable()
                ->preload()
                ->required()
                ->createOptionForm([
                    TextInput::make('name.en')
                        ->label('Name (English)')
                        ->required(),

                    TextInput::make('name.ar')
                        ->label('Name (Arabic)'),

                    Textarea::make('description.en')
                        ->label('Description (English)'),

                    Textarea::make('description.ar')
                        ->label('Description (Arabic)'),
                ])
                ->createOptionUsing(function (array $data) {
                    $data['slug'] = Str::slug($data['name']['en']);
                    return ActivityCategory::create($data)->id;
                }),

            // Title EN
            TextInput::make('title.en')
                ->label(__('activities.fields.title_en'))
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('slug', Str::slug($state));
                }),

            // Title AR
            TextInput::make('title.ar')
                ->label(__('activities.fields.title_ar'))
                ->required(),

            // Slug
            TextInput::make('slug')
                ->label(__('activities.fields.slug'))
                ->disabled()
                ->dehydrated()
                ->unique(ignoreRecord: true)
                ->helperText(__('activities.fields.slug_helper'))
                ->required(),

            // Summary EN
            Textarea::make('summary.en')
                ->label(__('activities.fields.summary_en'))
                ->rows(2)
                ->required(),

            // Summary AR
            Textarea::make('summary.ar')
                ->label(__('activities.fields.summary_ar'))
                ->rows(2)
                ->required(),

            // Content EN
            Textarea::make('content.en')
                ->label(__('activities.fields.content_en'))
                ->rows(5)
                ->columnSpanFull()
                ->required(),

            // Content AR
            Textarea::make('content.ar')
                ->label(__('activities.fields.content_ar'))
                ->rows(5)
                ->columnSpanFull()
                ->required(),

            // Cover Image
            FileUpload::make('cover_image')
                ->label(__('activities.fields.cover_image'))
                ->image()
                ->disk('public')
                ->directory('activities'),

            // Status (تم إصلاح الترجمة هنا)
            Select::make('status')
                ->label(__('activities.fields.status'))
                ->options([
                    'draft' => __('activities.status_values.draft'),
                    'published' => __('activities.status_values.published'),
                    'hidden' => __('activities.status_values.hidden'),
                    'archived' => __('activities.status_values.archived'),
                ])
                ->default('draft')
                ->required(),

            // Featured
            Checkbox::make('is_featured')
                ->label(__('activities.fields.featured'))
                ->default(false)
                ->columnSpanFull()
                ->extraAttributes([
                    'class' => 'p-4 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 hover:bg-indigo-50/30 hover:border-indigo-300 transition-all dark:border-gray-700 dark:bg-gray-800/50'
                ]),
        ]);
    }
}
