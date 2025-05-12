<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminProductResource\Pages;
use App\Filament\Resources\AdminProductResource\RelationManagers;
use App\Models\AdminProduct;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdminProductResource extends Resource
{
    protected static ?string $model = AdminProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make('Information')->schema([
                    TextInput::make('product_name'),
                    TextInput::make('sku')->default('pro-'.rand())->readOnly(),
                    Select::make('categories_id')
                        ->relationship('Categories','name')
                        ->label('Catagories'),
                    TextInput::make('brand'),
                    RichEditor::make('description')->columnSpan(2),
                ])->collapsible()->columnspan(4),
                
                Section::make('Marking')->schema([
                    Section::make('Pricing')->schema([
                    TextInput::make('buy_price'),
                    TextInput::make('sell_price'),
                    ])->collapsible(),
                    Section::make('Files')->schema([
                        FileUpload::make('image')->disk('public')->directory('images')->multiple(),
                        TagsInput::make('tags'),
                        Checkbox::make('status'),
                    ])->collapsible(),
                ])->columnspan(3),
               
                
                
                
                
            ])->columns(7);
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
                TextColumn::make('buy_price')->sortable()->searchable()->toggleable(),
                TextColumn::make('sell_price')->sortable()->searchable()->toggleable(),
                TextColumn::make('brand')->sortable()->searchable()->toggleable(),
                TextColumn::make('tags')->sortable()->searchable()->toggleable(),
                CheckboxColumn::make('status')->sortable()->searchable()->toggleable(),
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
            'index' => Pages\ListAdminProducts::route('/'),
            'create' => Pages\CreateAdminProduct::route('/create'),
            'view' => Pages\ViewAdminProduct::route('/{record}'),
            'edit' => Pages\EditAdminProduct::route('/{record}/edit'),
        ];
    }
}
