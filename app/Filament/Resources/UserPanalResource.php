<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserPanalResource\Pages;
use App\Filament\Resources\UserPanalResource\RelationManagers;
use App\Models\UserPanal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserPanalResource extends Resource
{
    protected static ?string $model = UserPanal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Access';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Affiliate User';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUserPanals::route('/'),
            'create' => Pages\CreateUserPanal::route('/create'),
            'view' => Pages\ViewUserPanal::route('/{record}'),
            'edit' => Pages\EditUserPanal::route('/{record}/edit'),
        ];
    }
}
