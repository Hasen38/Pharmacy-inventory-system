<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Purchase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseResource extends Resource
{
    protected static ?string $navigationGroup = "Transaction";

    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->afterStateUpdated(fn($get, $set) => self::updateformdata($get, $set)),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->afterStateUpdated(fn($get, $set) => self::updateformdata($get, $set)),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->disabled(),

                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->createOptionForm(function () {
                        return SupplierResource::Newform();
                    }),
                Forms\Components\DatePicker::make('purchase_date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('price')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->date()
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }


    public static function updateformdata($get, $set)
    {
        $price = $get('price');
        $quantity = $get('quantity');
        $total = $price * $quantity;
        $set('total', $total);
    }
}
