<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditCategory extends EditRecord
{
  protected static string $resource = CategoryResource::class;


    protected function getCreatedNotification(): ?Notification
    {
        return Null; 
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Category updated successfully')
            ->warning()
            ->body('The category has been updated successfully.')
            ->send();
    }

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make()
        ->successNotification(
          Notification::make()
            ->title('Category deleted successfully')
            ->success()
            ->body('The category has been deleted successfully.')
        ),
    ];
  }
  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
