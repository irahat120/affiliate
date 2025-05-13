<?php

namespace App\Filament\Resources\CollectProductStockResource\Pages;

use App\Filament\Resources\CollectProductStockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollectProductStock extends EditRecord
{
    protected static string $resource = CollectProductStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
