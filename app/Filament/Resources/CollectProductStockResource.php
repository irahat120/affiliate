<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AdminProduct;
use Filament\Resources\Resource;
use App\Models\CollectionUserInfo;
use App\Models\CollectProductStock;
use Filament\Forms\Components\Select;
use App\Models\CollectProductStockList;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CollectProductStockResource\Pages;
use App\Filament\Resources\CollectProductStockResource\RelationManagers;
use App\Filament\Resources\CollectProductStockResource\RelationManagers\CollectproductstocklistRelationManager;

class CollectProductStockResource extends Resource
{
    protected static ?string $model = CollectProductStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->label('Collect product stock id')->readOnly(),
                TextInput::make('admin_product_id')->label('Admin Product Id')->readOnly(),
                TextInput::make('unique_number')->label('Collection Id')->readOnly(),
                Select::make('product_name')->disabledOn('edit')
                        ->relationship('AdminProduct','product_name')
                        ->label('Product Name'),
                Select::make('sku')->disabledOn('edit')
                        ->relationship('AdminProduct','sku')
                        ->label('SKU'),
                TextInput::make('quantity')
                ->afterStateUpdated(function ($state, callable $get) {
                        $collectProductStockId = $get('id');
                        $newQuantity = $state;

                        // Get the current stock list count
                        $listCount = CollectProductStockList::where('collect_product_stock_id', $collectProductStockId)->count();

                        // If new quantity is higher, add the difference
                        if ($newQuantity > $listCount) {
                            $rowsToAdd = $newQuantity - $listCount;

                            for ($i = 0; $i < $rowsToAdd; $i++) {
                                CollectProductStockList::create([
                                    'collect_product_stock_id' => $collectProductStockId,
                                    'unique_number' => $get('unique_number'),
                                    'admin_product_id' => $get('admin_product_id'),
                                    'buy_price' => $get('paid_price'),
                                ]);
                            }
                            Notification::make()
                                ->title('Stock list updated successfully!')
                                ->success()
                                ->send();
                        }
                        
                        // product stock list buy price updated start -------------------
                        CollectProductStockList::where('collect_product_stock_id',$collectProductStockId)->update([
                            'buy_price' => $get('paid_price'),
                        ]);
                        Notification::make()
                                ->title('Stock list Buy price updated successfully!')
                                ->success()
                                ->send();
                        // product stock list buy price updated end -------------------
                        


                        // admin product stock and buy price updated start -------------------
                        $stocks =collectProductStockList::where('stock_status', 'Instock')
                            ->where('admin_product_id', $get('admin_product_id'))
                            ->count();

                        AdminProduct::where('id', $get('admin_product_id'))->update([
                            'buy_price' => $get('paid_price'),
                            'stock' => $stocks,
                            ]);

                        Notification::make()
                            ->title('Buy price and Stock updated successfully!')
                            ->success()
                            ->send();

                        // admin product stock and buy price updated end -------------------


                    }),
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
                Tables\Actions\DeleteAction::make(),
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
            CollectproductstocklistRelationManager::class
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
