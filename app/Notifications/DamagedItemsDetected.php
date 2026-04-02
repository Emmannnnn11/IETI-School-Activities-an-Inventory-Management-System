<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DamagedItemsDetected extends Notification
{
    use Queueable;

    public function __construct(
        public string $itemName,
        public int $quantityDamaged,
        public ?string $remarks = null
    ) {
    }

    /**
     * Store the notification for in-app display (database channel).
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Damaged items were detected in your return.',
            'item_name' => $this->itemName,
            'quantity_damaged' => $this->quantityDamaged,
            'remarks' => $this->remarks,
        ];
    }
}

