<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AdminProduct;
use Filament\Resources\Resource;
use App\Models\CollectProductStock;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AdminProductResource\Pages;
use App\Filament\Resources\AdminProductResource\RelationManagers;

class AdminProductResource extends Resource
{
    protected static ?string $model = AdminProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Information')
                    ->schema([
                        TextInput::make('product_name'),
                        TextInput::make('sku')
                            ->default('pro-' . rand())
                            ->readOnly(),
                        Select::make('categories_id')->relationship('Categories', 'name')->label('Catagories'),
                        TextInput::make('brand'),
                        RichEditor::make('description')->columnSpan(2),
                    ])->collapsible()->columnspan(4),

                Section::make('Marking')
                    ->schema([
                        Section::make('Pricing')
                            ->schema([
                                TextInput::make('buy_price'), 
                                TextInput::make('sell_price')])
                            ->collapsible(),
                        Section::make('Files')
                            ->schema([
                                FileUpload::make('image')->disk('public')->directory('images')->multiple(), 
                                TagsInput::make('tags'), Checkbox::make('status')])
                            ->collapsible(),
                    ])
                    ->columnspan(3),
            ])
            ->columns(7);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')->rowIndex()->label('SL')->sortable()->searchable()->toggleable(), 
                ImageColumn::make('image'), 
                TextColumn::make('product_name')->limit(25)->sortable()->searchable()->toggleable(), 
                TextColumn::make('sku')->sortable()->searchable()->toggleable(), 
                TextColumn::make('Categories.name')->sortable()->searchable()->toggleable(), 
                TextColumn::make('collectProductStock.paid_price')
                ->label('Buy Price')
                ->formatStateUsing(function ($record) {
                    
                   $stock = CollectProductStock::where('admin_product_id', $record->id)
                        ->orderBy('id', 'desc')
                        ->first();
                    return number_format($stock->paid_price);
                }),
                // TextColumn::make('buy_price')->label('buy price')->sortable()->searchable()->toggleable(), 
                TextColumn::make('sell_price')->sortable()->searchable()->toggleable(), 
                TextColumn::make('brand')->sortable()->searchable()->toggleable(), 
                TextColumn::make('tags')->sortable()->searchable()->toggleable(), 
                TextColumn::make('stock')->sortable()->searchable()->toggleable(), 
                CheckboxColumn::make('status')->sortable()->searchable()->toggleable()
                ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Add Collect Stock')
                    ->label('Stock')
                    ->icon('heroicon-m-plus-circle')
                    ->modalHeading('Add Stock')
                    ->form([
                        Section::make('Info')->schema([
                        TextInput::make('unique_number')->default(\Carbon\Carbon::now()->format('dm'))->label('Collection Date')->required()->readOnly(),
                        TextInput::make('admin_product_id')->label('Product Id')->default(fn($record) => $record->id)->readOnly(),
                        TextInput::make('quantity')->label('Add Quantity')->numeric()->required(),
                        TextInput::make('paid_price')->label('Buy Price')->numeric()->required(),
                        ])->columns(2),
                    ])
                    ->action(function (array $data) {
                        // Insert the quantity
                        CollectProductStock::insert([
                            'unique_number' => $data['unique_number'],
                            'admin_product_id' => $data['admin_product_id'],
                            'quantity' => $data['quantity'],
                            'paid_price' => $data['paid_price'],
                        ]);

                        AdminProduct::where('id', $data['admin_product_id'])->increment('stock', $data['quantity']);
                    })->color('success'),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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
            'index' => Pages\ListAdminProducts::route('/'),
            'create' => Pages\CreateAdminProduct::route('/create'),
            'view' => Pages\ViewAdminProduct::route('/{record}'),
            'edit' => Pages\EditAdminProduct::route('/{record}/edit'),
        ];
    }
}
