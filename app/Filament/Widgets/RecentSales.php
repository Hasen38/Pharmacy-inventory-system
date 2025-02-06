<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn as Text;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentSales  extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Sale::with('customer')->with('product')->latest()->take(5)
            )
            ->columns([
                Text::make('customer.name')->label('Customer'),
                Text::make('product.name')->label('Product'),
                Text::make('quantity')->label('Quantity'),
                Text::make('total')->label('Total'),
                Text::make('created_at')->label('Date'),
            ]);
    }
}
