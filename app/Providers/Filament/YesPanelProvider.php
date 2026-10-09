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
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

class YesPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('yes')
            ->path('admin')
            ->login()
            ->brandName('MentalCare')
            ->colors([
                'primary' =>' #E0004D',
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => new HtmlString('
                    <style>
                        /* Warna latar navbar */
                        .fi-topbar,
                        .fi-topbar > nav {
                            background-color: #E0004D !important;
                        }

                        /* Teks dan ikon jadi putih */
                        .fi-topbar .fi-logo,
                        .fi-topbar .fi-icon-btn,
                        .fi-topbar .fi-topbar-open-sidebar-btn,
                        .fi-topbar .fi-topbar-close-sidebar-btn,
                        .fi-topbar .fi-user-menu-trigger {
                            color: #ffffff !important;
                        }

                        /* Kolom search dibuat transparan agar serasi */
                        .fi-topbar .fi-global-search-field .fi-input-wrp {
                            background-color: rgba(255, 255, 255, 0.15) !important;
                            --tw-ring-color: rgba(255, 255, 255, 0.4) !important;
                        }
                        .fi-topbar .fi-global-search-field input {
                            color: #ffffff !important;
                        }
                        .fi-topbar .fi-global-search-field input::placeholder,
                        .fi-topbar .fi-global-search-field .fi-input-wrp svg {
                            color: rgba(255, 255, 255, 0.8) !important;
                        }
                    </style>
                '),
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
