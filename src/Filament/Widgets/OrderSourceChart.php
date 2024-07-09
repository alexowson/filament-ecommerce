<?php

namespace TomatoPHP\FilamentEcommerce\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use TomatoPHP\FilamentEcommerce\Models\Order;
use TomatoPHP\FilamentTypes\Models\Type;

class OrderSourceChart extends ChartWidget
{
    protected static ?string $heading = 'Compare Order Sources';

    protected function getData(): array
    {
        $query = Order::query()->groupBy('source')->selectRaw('count(*) as count, source');
        $source = Type::query()->where('for', 'orders')
            ->where('type', 'source')
            ->get();


        return [
            'labels' => $source->pluck('name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Source',
                    'data' =>  $query->get()->whereIn('source', $source->pluck('key')->toArray())->pluck('count')->toArray(),
                    'backgroundColor' => $source->pluck('color')->toArray(),
                    'hoverOffset'=> 4
                ]
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
