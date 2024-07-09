<?php

namespace TomatoPHP\FilamentEcommerce;

use TomatoPHP\FilamentEcommerce\Filament\Pages\OrderReceiptSettingsPage;
use TomatoPHP\FilamentEcommerce\Filament\Pages\OrderSettingsPage;
use TomatoPHP\FilamentEcommerce\Filament\Pages\OrderStatusSettingsPage;
use TomatoPHP\FilamentEcommerce\Filament\Resources\BranchResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\CompanyResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\CouponResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\DeliveryResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\OrderResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\ProductResource;
use TomatoPHP\FilamentEcommerce\Filament\Resources\ReferralCodeResource;
use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentEcommerce\Filament\Resources\ShippingVendorResource;
use TomatoPHP\FilamentEcommerce\Filament\Widgets\OrderPaymentMethodChart;
use TomatoPHP\FilamentEcommerce\Filament\Widgets\OrderSourceChart;
use TomatoPHP\FilamentEcommerce\Filament\Widgets\OrdersStateWidget;
use TomatoPHP\FilamentEcommerce\Filament\Widgets\OrderStateChart;
use TomatoPHP\FilamentEcommerce\Models\GiftCard;
use TomatoPHP\FilamentEcommerce\Models\ShippingVendor;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;


class FilamentEcommercePlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-ecommerce';
    }

    public ?bool $useWidgets = false;

    public function useWidgets(bool $condation = true): static
    {
        $this->useWidgets = $condation;
        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel
            ->plugin(FilamentSettingsHubPlugin::make())
            ->resources([
                CompanyResource::class,
                ProductResource::class,
                OrderResource::class,
    //            CouponResource::class,
    //            DeliveryResource::class,
    //            GiftCard::class,
    //            ReferralCodeResource::class,
                ShippingVendorResource::class
            ])
            ->widgets($this->useWidgets ? [
                OrdersStateWidget::class,
                OrderPaymentMethodChart::class,
                OrderSourceChart::class,
                OrderStateChart::class
            ] : [])
            ->pages([
                OrderSettingsPage::class,
                OrderStatusSettingsPage::class,
                OrderReceiptSettingsPage::class
            ]);
    }

    public function boot(Panel $panel): void
    {

    }

    public static function make(): static
    {
        return new static();
    }
}
