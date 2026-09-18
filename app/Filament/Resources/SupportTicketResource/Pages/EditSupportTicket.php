<?php

namespace App\Filament\Resources\SupportTicketResource\Pages;

use App\Filament\Resources\SupportTicketResource;
use App\Models\SupportMessage;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditSupportTicket extends EditRecord
{
    protected static string $resource = SupportTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reply')
                ->label('Reply to Ticket')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->form([
                    Textarea::make('message')
                        ->label('Message')
                        ->required()
                        ->rows(4),
                ])
                ->action(function (array $data) {
                    SupportMessage::create([
                        'support_ticket_id' => $this->record->id,
                        'sender_type' => 'admin',
                        'message' => $data['message'],
                    ]);

                    Notification::make()
                        ->title('Reply Sent')
                        ->success()
                        ->send();

                    // Refresh the view so the new message shows up
                    $this->redirect(SupportTicketResource::getUrl('edit', ['record' => $this->record]));
                }),
                
            Actions\Action::make('resolve')
                ->label('Mark as Resolved')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'resolved']);
                    
                    SupportMessage::create([
                        'support_ticket_id' => $this->record->id,
                        'sender_type' => 'system',
                        'message' => 'Ticket marked as resolved by admin.',
                    ]);

                    Notification::make()
                        ->title('Ticket Resolved')
                        ->success()
                        ->send();
                        
                    $this->redirect(SupportTicketResource::getUrl('index'));
                }),
                
            Actions\DeleteAction::make(),
        ];
    }
}
