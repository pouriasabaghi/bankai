<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstallmentNotification extends Notification
{
    use Queueable;
    public $installment ;
    /**
     * Create a new notification instance.
     */
    public function __construct($installment)
    {
        $this->installment = $installment ;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase  (object $notifiable): array
    {

        return [
            'installment_id'=>$this->installment->id,
            'contract_name'=>$this->installment->contract->name,
            'amount'=>$this->installment->amount,
            'due_at'=>$this->installment->due_at,
            'type'=>'danger',
        ];
    }
}
