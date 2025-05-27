<?php

namespace App\Filament\Resources\MovementResource\Pages;

use App\Filament\Resources\MovementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateMovement extends CreateRecord
{
    protected static string $resource = MovementResource::class;
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
            ->title('Movement created successfully')
            ->success()
            ->body('The Movement has been created successfully.')
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
