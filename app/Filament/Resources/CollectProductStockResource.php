<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\CollectProductStock;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CollectProductStockResource\Pages;
use App\Filament\Resources\CollectProductStockResource\RelationManagers;

class CollectProductStockResource extends Resource
{
    protected static ?string $model = CollectProductStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('unique_number')->readOnly(),
                Select::make('admin_product_id')->disabledOn('edit')
                        ->relationship('AdminProduct','product_name')
                        ->label('Catagories'),
                TextInput::make('quantity'),
                TextInput::make('paid_price'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->rowIndex()->label('SL')->sortable()->searchable()->toggleable(), 
                TextColumn::make('unique_number')->label('Collection id')->sortable()->searchable()->toggleable(),
                TextColumn::make('admin_product_id')->label('Product id')->sortable()->searchable()->toggleable(),
                ImageColumn::make('AdminProduct.image')->label('Images'), 
                TextColumn::make('AdminProduct.product_name')->label('Product Name')->limit(25)->sortable()->searchable()->toggleable(), 
                TextColumn::make('AdminProduct.sku')->label('SKU')->sortable()->searchable()->toggleable(), 
                TextColumn::make('paid_price')->sortable()->searchable()->toggleable(), 
                TextColumn::make('quantity')->sortable()->searchable()->toggleable(), 
                TextColumn::make('collection_user')->sortable()->searchable()->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCollectProductStocks::route('/'),
            'create' => Pages\CreateCollectProductStock::route('/create'),
            'view' => Pages\ViewCollectProductStock::route('/{record}'),
            'edit' => Pages\EditCollectProductStock::route('/{record}/edit'),
        ];
    }
}
