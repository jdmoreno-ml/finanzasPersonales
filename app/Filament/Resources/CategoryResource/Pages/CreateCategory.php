<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getCreatedNotification(): ?Notification
    {
        return Null; 
    }
    protected function afterCreate(): void
    {
        parent::afterCreate();

        Notification::make()
            ->title('Category created successfully')
            ->success()
            ->body('The category has been created successfully.')
            ->send();
    }
    protected function getFormActions(): array
    {
         return [
            $this->getCreateFormAction()
            ->label('Save')
            ->color('info')
            ->icon('heroicon-m-document-check'),

            // $this->getCreateAnotherFormAction()
            // ->label('Create Another Category')
            // ->color('secondary')
            // ->icon('heroicon-o-plus'),

            $this->getCancelFormAction()
            ->label('Cancel')
            ->color('danger')
            ->icon('heroicon-o-x-circle'),
        ];
    }
}
