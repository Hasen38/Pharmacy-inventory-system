<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = "Product Manegment";
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {

        return $form
            ->schema(self::Newform());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier_id')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function Newform()
    {
        return [
            Forms\Components\Section::make()->schema([
                // Forms\Components\Repeater::make('product')
                // ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->placeholder('Enter Product Name'),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->placeholder('Enter Product Price'),
                Forms\Components\TextInput::make('description')
                    ->label('Description')
                    ->required()
                    ->placeholder('Enter Product Description'),
                Forms\Components\TextInput::make('stock')
                    ->label(' stock')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->placeholder('Enter Product Stock Quantity'),
                Forms\Components\DatePicker::make('expire_date')
                    ->label('Expire_date')
                    ->required(),
                Forms\Components\TextInput::make('dosage')
                    ->label('dosage'),
                Forms\Components\TextInput::make('brand')
                    ->label('brand')
                    ->placeholder('Enter Brand name')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->createOptionForm(function () {
                        return CategoryResource::Newform();
                    })
                    ->required(),
                Forms\Components\Select::make('supplier_id')
                    ->label('Supplier_id')
                    ->relationship('supplier', 'name')
                    ->createOptionForm(function () {
                        return SupplierResource::Newform();
                    })
                    ->required(),

            ])
            // ]),
        ];
    }
}
