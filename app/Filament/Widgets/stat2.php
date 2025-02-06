<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use SebastianBergmann\CodeCoverage\Report\Html\Colors;

class stat2 extends BaseWidget
{
    protected static ?int $sort = -5;

    protected function getStats(): array
    {
        return [
            stat::make('Total Sales', Sale::count())
                ->icon('heroicon-o-currency-dollar')
                ->chart([1, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60])
                ->Color('green'),
            Stat::make('Total Category', Category::count())
                ->icon('heroicon-o-tag'),
            Stat::make('Expired Medication', Product::count())
                ->icon('heroicon-o-backspace')
        ];
    }
}
