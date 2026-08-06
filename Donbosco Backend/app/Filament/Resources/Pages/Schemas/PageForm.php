<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;

use Filament\Schemas\Schema;

use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make('PageTabs')
                    ->persistTabInQueryString()
                    ->contained(false)

                    ->tabs([

                        Tab::make(__('pages.tabs.general_information'))
                            ->icon('heroicon-m-document-text')
                            ->schema([

                                Section::make(__('pages.sections.page_details'))
                                    ->description(__('pages.descriptions.page_details'))
                                    ->schema([

                                        Grid::make(2)
                                            ->schema([

                                                TextInput::make('title')
                                                    ->label(__('pages.fields.title'))
                                                    ->placeholder(__('pages.placeholders.title'))
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(
                                                        function (Set $set, $state, $operation) {
                                                            if ($operation === 'create') {
                                                                $set('slug', Str::slug($state));
                                                            }
                                                        }
                                                    ),

                                                TextInput::make('slug')
                                                    ->label(__('pages.fields.slug'))
                                                    ->placeholder('page-slug')
                                                    ->disabled()
                                                    ->dehydrated()
                                                    ->required()
                                                    ->prefix('https://example.com/pages/')
                                                    ->helperText(__('pages.helpers.slug')),
                                            ]),
                                    ]),
                            ]),

                        Tab::make(__('pages.tabs.page_content'))
                            ->icon('heroicon-m-pencil-square')
                            ->schema([

                                Section::make(__('pages.sections.content_sections'))
                                    ->description(__('pages.descriptions.content_sections'))
                                    ->schema([

                                        Tabs::make('ContentTabs')
                                            ->contained(true)

                                            ->tabs([

                                                Tab::make(__('pages.content_tabs.about_us'))
                                                    ->icon('heroicon-m-user-group')
                                                    ->schema([

                                                        RichEditor::make('content.about_us')
                                                            ->label(__('pages.fields.about_us_content'))
                                                            ->placeholder(__('pages.placeholders.about_us'))
                                                            ->toolbarButtons([
                                                                'bold',
                                                                'italic',
                                                                'underline',
                                                                'bulletList',
                                                                'orderedList',
                                                                'h2',
                                                                'h3',
                                                                'blockquote',
                                                                'redo',
                                                                'undo',
                                                            ])
                                                            ->required(),
                                                    ]),

                                                Tab::make(__('pages.content_tabs.our_mission'))
                                                    ->icon('heroicon-m-rocket-launch')
                                                    ->schema([

                                                        RichEditor::make('content.mission')
                                                            ->label(__('pages.fields.mission_content'))
                                                            ->placeholder(__('pages.placeholders.mission'))
                                                            ->toolbarButtons([
                                                                'bold',
                                                                'italic',
                                                                'bulletList',
                                                                'orderedList',
                                                                'h2',
                                                                'h3',
                                                            ])
                                                            ->required(),
                                                    ]),

                                                Tab::make(__('pages.content_tabs.our_vision'))
                                                    ->icon('heroicon-m-eye')
                                                    ->schema([

                                                        RichEditor::make('content.vision')
                                                            ->label(__('pages.fields.vision_content'))
                                                            ->placeholder(__('pages.placeholders.vision'))
                                                            ->toolbarButtons([
                                                                'bold',
                                                                'italic',
                                                                'bulletList',
                                                                'orderedList',
                                                                'h2',
                                                                'h3',
                                                            ])
                                                            ->required(),
                                                    ]),
                                            ]),
                                    ]),
                            ]),

                        Tab::make(__('pages.tabs.media_status'))
                            ->icon('heroicon-m-photo')
                            ->schema([

                                Section::make(__('pages.sections.media_settings'))
                                    ->description(__('pages.descriptions.media_settings'))
                                    ->schema([

                                        Grid::make(2)
                                            ->schema([

                                                FileUpload::make('image')
                                                    ->label(__('pages.fields.featured_image'))
                                                    ->image()
                                                    ->imageEditor()
                                                    ->imagePreviewHeight('250')
                                                    ->directory('pages-hero')
                                                    ->disk('public')
                                                    ->visibility('public')
                                                    ->helperText(__('pages.helpers.featured_image')),

                                                Select::make('status')
                                                    ->label(__('pages.fields.status'))
                                                    ->options([
                                                        'draft' => __('pages.statuses.draft'),
                                                        'published' => __('pages.statuses.published'),
                                                    ])
                                                    ->default('draft')
                                                    ->native(false)
                                                    ->required(),
                                            ]),
                                    ]),
                            ]),
                    ])

                    ->activeTab(1),
            ]);
    }
}
