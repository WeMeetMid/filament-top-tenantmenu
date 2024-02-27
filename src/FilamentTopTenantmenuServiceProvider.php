<?php

namespace WeMeetMid\FilamentTopTenantmenu;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentTopTenantmenuServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-top-tenantmenu';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews();
    }
}