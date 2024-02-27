<?php

namespace WeMeetMid\FilamentTopTenantmenu;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;

class TopTenantmenuPlugin implements Plugin
{
    use EvaluatesClosures;

    public bool | Closure | null $visible = null;

    public bool | Closure | null $sidebarCollapsibleOnDesktop = null;

    public bool | Closure | null $showBadge = null;

    public bool | Closure | null $showBorder = null;

    public bool | Closure | null $avatar = null;

    public array|Closure|null $color = null;

    public static function make(): static
    {
        $plugin = app(static::class);

        // Defaults
        $plugin->visible(true);
        $plugin->avatar(false);
        $plugin->sidebarCollapsibleOnDesktop(false);

        return $plugin;
    }

    public function getId(): string
    {
        return 'top-tenantmenu';
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function register(Panel $panel): void
    {
        $panel->renderHook('panels::global-search.after', function () {
            if (!$this->evaluate($this->visible)) {
                return '';
            }

            $visibility = $this->visibility();
            $isAvatarVisible = $this->isAvatarVisible();

            $isSidebarCollapsibleOnDesktop = $this->isSidebarCollapsibleOnDesktop();

            return View::make('filament-top-tenantmenu::top-tenantmenu', [
                'isVisible' => $visibility,
                'isSidebarCollapsibleOnDesktop' => $isSidebarCollapsibleOnDesktop,
                'isAvatarVisible' => $isAvatarVisible,
            ]);
        });

        $panel->renderHook('panels::styles.after', function () {
            if (!$this->evaluate($this->visible)) {
                return '';
            }

            if (!$this->evaluate($this->showBorder)) {
                return '';
            }

            return new HtmlString("
                <style>
                    .fi-topbar,
                    .fi-sidebar {
                        border-top: 5px solid rgb({$this->getColor()['500']}) !important;
                    }

                    .fi-topbar {
                        height: calc(4rem + 5px) !important;
                    }
                </style>
            ");
        });
    }

    public function visible(bool|Closure $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function visibility()
    {
        return $this->evaluate($this->visible);
    }

    public function avatar(bool|Closure $avatar = true): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function isAvatarVisible()
    {
        return $this->evaluate($this->avatar);
    }

    public function sidebarCollapsibleOnDesktop(bool|Closure $condition): static
    {
        $this->sidebarCollapsibleOnDesktop = $condition;

        return $this;
    }

    public function isSidebarCollapsibleOnDesktop()
    {
        return $this->evaluate($this->sidebarCollapsibleOnDesktop);
    }
}
