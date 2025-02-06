<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Sale;
use Filament\Tables;
use App\Models\Invoice;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SaleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SaleResource\RelationManagers;

class SaleResource extends Resource
{
    protected static ?string $navigationGroup = "Transaction";
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')->schema([
                    Forms\Components\Select::make('product_id')
                        ->label('Product')
                        ->relationship('product', 'name')
                        ->createOptionForm([
                            ProductResource::class,
                            'form'
                        ])
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, $get, $set) {
                            if ($state) {
                                $set('price', $get('product.price') ?? 0);
                                self::updateformdata($get, $set);
                            }
                        }),
                    Forms\Components\TextInput::make('price')
                        ->label('Price')
                        ->required()
                        ->numeric()
                        ->live()
                        ->afterStateUpdated(fn($state, $get, $set) => self::updateformdata($get, $set)),
                    Forms\Components\TextInput::make('quantity')
                        ->label('Quantity')
                        ->required()
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->live()
                        ->afterStateUpdated(fn($state, $get, $set) => self::updateformdata($get, $set)),

                    Forms\Components\TextInput::make('total')
                        ->label('Total')
                        ->required()
                        ->numeric()
                        ->disabled()
                        ->dehydrated()
                        ->default(fn($get) => $get('price') * $get('quantity')),
                    Forms\Components\Select::make('customer_id')
                        ->label('Customer')
                        ->relationship('customer', 'name')
                        ->createOptionForm([
                            CustomerResource::class,
                            'form'
                        ])
                        ->required(),
                    Forms\Components\DatePicker::make('sale_date')
                        ->label('Sale Date')
                        ->required()
                        ->default(now()),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->getStateUsing(fn($record) => $record->product->price)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->searchable()
                    ->sortable()
                    ->label('Total Amount'),
                Tables\Columns\TextColumn::make('customer_id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_date')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('generate-invoice')
                    ->label('Generate Invoice')
                    ->icon('heroicon-o-document-text')
                    ->url(fn(Sale $record) => route('invoices.create', ['sale' => $record]))

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
            'generate-invoice' => Pages\GenerateInvoice::route('/{record}/generate-invoice'),
        ];
    }

    public static function updateformdata($get, $set)
    {
        $price = $get('price');
        $quantity = $get('quantity');
        $total = (int)$price * (int)$quantity;
        $set('total', $total);
    }
}
