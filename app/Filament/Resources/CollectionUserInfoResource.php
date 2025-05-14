<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\CollectionUserInfo;
use Illuminate\Support\Facades\DB;
use App\Models\CollectProductStock;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CollectionUserInfoResource\Pages;
use App\Filament\Resources\CollectionUserInfoResource\RelationManagers;

class CollectionUserInfoResource extends Resource
{
    protected static ?string $model = CollectionUserInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('collection_id')->default(Carbon::now()->format('dm'))->readOnly()->unique(),
                TextInput::make('admin')->default('admin')->readOnly(),
                TextInput::make('total_value')->default(0)->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('collection_id'),
                TextColumn::make('collection_user'),

                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->formatStateUsing(function ($record) {

                        $quantity = CollectProductStock::where('unique_number', $record->collection_id)
                            ->selectRaw('SUM(quantity) as total_quantity')
                            ->value('total_quantity') ?? 0;

                        return $quantity;
                    }),

                TextColumn::make('total_value')
                    ->label('Total')
                    ->formatStateUsing(function ($record) {
                        $price = CollectProductStock::where('unique_number', $record->collection_id)
                            ->selectRaw('SUM(quantity * paid_price) as total_value')
                            ->value('total_value');
                        return number_format($price, 2);
                    }),
                    
                TextColumn::make('created_at')->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollectionUserInfos::route('/'),
            'create' => Pages\CreateCollectionUserInfo::route('/create'),
            'view' => Pages\ViewCollectionUserInfo::route('/{record}'),
            'edit' => Pages\EditCollectionUserInfo::route('/{record}/edit'),
        ];
    }
}
