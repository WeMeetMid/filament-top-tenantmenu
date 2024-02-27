@if (filament()->hasTenancy() && $isVisible)
    <div>
        <x-filament-top-tenantmenu::tenant-menu
            :isSidebarCollapsibleOnDesktop="$isSidebarCollapsibleOnDesktop"
            :isAvatarVisible="$isAvatarVisible"
        />
    </div>
@endif