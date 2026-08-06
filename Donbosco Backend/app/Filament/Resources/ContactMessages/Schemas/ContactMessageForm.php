<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('ContactMessageTabs')
                ->contained(false)
                ->tabs([

                    Tab::make(__('contact-messages.tabs.overview'))
                        ->icon('heroicon-m-envelope')
                        ->schema([

                            Section::make(__('contact-messages.sections.sender_snapshot'))
                                ->schema([
                                    Grid::make(3)->schema([

                                        Placeholder::make('name')
                                            ->label(__('contact-messages.fields.full_name'))
                                            ->content(fn ($record) => $record?->name ?? '—'),

                                        Placeholder::make('email')
                                            ->label(__('contact-messages.fields.email'))
                                            ->content(fn ($record) => $record?->email ?? '—'),

                                        Placeholder::make('phone')
                                            ->label(__('contact-messages.fields.phone'))
                                            ->content(fn ($record) => $record?->phone ?? __('contact-messages.placeholders.not_provided')),
                                    ]),
                                ]),

                            Section::make(__('contact-messages.sections.message'))
                                ->schema([

                                    TextInput::make('subject')
                                        ->label(__('contact-messages.fields.subject'))
                                        ->disabled()
                                        ->columnSpanFull(),

                                    Textarea::make('message')
                                        ->label(__('contact-messages.fields.message_content'))
                                        ->disabled()
                                        ->rows(10)
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    Tab::make(__('contact-messages.tabs.management'))
                        ->icon('heroicon-m-cog-6-tooth')
                        ->schema([

                            Section::make(__('contact-messages.sections.status_control'))
                                ->schema([
                                    Grid::make(1)->schema([

                                        Select::make('status')
                                            ->label(__('contact-messages.fields.message_status'))
                                            ->options([
                                                'new' => '🆕 ' . __('contact-messages.statuses.new'),
                                                'in_progress' => '⏳ ' . __('contact-messages.statuses.in_progress'),
                                                'replied' => '✅ ' . __('contact-messages.statuses.replied'),
                                                'archived' => '📁 ' . __('contact-messages.statuses.archived'),
                                            ])
                                            ->required()
                                            ->native(false)
                                            ->live()
                                            ->rules([
                                                fn ($get): \Closure => function (
                                                    string $attribute,
                                                    $value,
                                                    \Closure $fail
                                                ) use ($get) {
                                                    if ($value === 'archived') {
                                                        if (blank($get('admin_notes'))) {
                                                            $fail(__('contact-messages.validation.archive_notes'));
                                                        }
                                                    }
                                                },
                                            ])
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                if ($state === 'replied') {
                                                    $set('replied_at', now());
                                                }
                                            }),

                                        DateTimePicker::make('replied_at')
                                            ->label(__('contact-messages.fields.replied_at'))
                                            ->disabled()
                                            ->dehydrated()
                                            ->visible(fn ($get) => in_array(
                                                $get('status'),
                                                ['replied']
                                            ))
                                            ->columnSpanFull(),
                                    ]),
                                ]),

                            Section::make(__('contact-messages.sections.internal_notes'))
                                ->schema([

                                    RichEditor::make('admin_notes')
                                        ->label(__('contact-messages.fields.internal_notes'))
                                        ->columnSpanFull()
                                        ->live()
                                        ->disabled(fn ($get) => $get('status') === 'archived')
                                        ->helperText(fn ($get) => $get('status') === 'archived'
                                            ? __('contact-messages.helpers.archived_notes')
                                            : null)
                                        ->required(fn ($get) => in_array(
                                            $get('status'),
                                            ['replied', 'archived']
                                        )),

                                    Placeholder::make('admin_notes_view')
                                        ->label(__('contact-messages.fields.final_notes'))
                                        ->visible(fn ($get) => $get('status') === 'archived')
                                        ->content(fn ($get) => new HtmlString(
                                            '<div class="p-4 border rounded-lg bg-yellow-50 prose max-w-none text-gray-700 italic dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">'
                                            . ($get('admin_notes') ?: '—') .
                                            '</div>'
                                        ))
                                        ->columnSpanFull(),
                                ]),
                        ]),
                ]),
        ]);
    }
}
