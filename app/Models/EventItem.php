<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'inventory_item_id',
        'quantity_requested',
        'quantity_approved',
        'status',
        'notes',
        'returned_at',
    ];

    protected $attributes = [
        'status' => 'pending',
        'quantity_approved' => 0,
    ];

    protected $casts = [
        'returned_at' => 'datetime',
    ];

    /**
     * Get the event that owns this event item
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the inventory item for this event item
     */
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    /**
     * Scope for approved items
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending items
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for rejected items
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope for unreturned items (approved items that haven't been returned)
     */
    public function scopeUnreturned($query)
    {
        return $query->where('status', 'approved')
                     ->whereNull('returned_at')
                     ->where('quantity_approved', '>', 0);
    }

    /**
     * Check if item has been returned
     */
    public function isReturned(): bool
    {
        return $this->returned_at !== null;
    }
}

