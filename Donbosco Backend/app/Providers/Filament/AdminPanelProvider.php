<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\MenuItem;
use Illuminate\Support\Facades\Blade;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\View;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('')

            ->colors([
                'primary' => Color::Blue,
                'info'    => Color::Sky,
                'gray'    => Color::Slate,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger'  => Color::Rose,
            ])


->renderHook(
    PanelsRenderHook::TOPBAR_START,
    fn (): string => Blade::render('
        <div style="
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-inline-start: 10px;
        ">
            <img src="' . asset('images/logo.png') . '" style="height: 3rem; width: auto;">
            <span style="font-size: 1.2rem; font-weight: bold; color: #d23d45;">
                DonBosco
            </span>
        </div>
    ')
)
            ->userMenuItems([
                MenuItem::make()->label('Arabic')->url('/lang/ar')->icon('heroicon-m-language'),
                MenuItem::make()->label('English')->url('/lang/en')->icon('heroicon-m-language'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([Dashboard::class])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([AccountWidget::class, FilamentInfoWidget::class])

            ->middleware([
                EncryptCookies::class, AddQueuedCookiesToResponse::class, StartSession::class,
                AuthenticateSession::class, ShareErrorsFromSession::class,
                PreventRequestsDuringMaintenance::class, SubstituteBindings::class,
                DisableBladeIconComponents::class, DispatchServingFilamentEvent::class,
                \App\Http\Middleware\SetLocale::class,
            ])

            ->authMiddleware([Authenticate::class])

            ->plugin(
                SpatieTranslatablePlugin::make()
                    ->defaultLocales(['ar', 'en'])
                    ->persist()
            );
    }
}
