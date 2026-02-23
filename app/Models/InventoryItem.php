<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category',
        'quantity_available',
        'quantity_total',
        'status',
        'location',
        'notes',
    ];

    /**
     * Get the event items that use this inventory item
     */
    public function eventItems()
    {
        return $this->hasMany(EventItem::class);
    }

    /**
     * Get the status color for display
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'available' => 'green',
            'maintenance' => 'orange',
            'unavailable' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get the status badge class for display
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'available' => 'badge-success',
            'maintenance' => 'badge-warning',
            'unavailable' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    /**
     * Check if item is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->quantity_available > 0;
    }

    /**
     * Scope for available items
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('quantity_available', '>', 0);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get available quantity for a specific date
     * This checks how many items are already booked for that date
     */
    public function getAvailableQuantityForDate($date): int
    {
        // Convert date to proper format if it's a Carbon instance or string
        $dateString = is_object($date) && method_exists($date, 'format') 
            ? $date->format('Y-m-d') 
            : (is_string($date) ? $date : $date);
        
        // Get all approved event items for this inventory item on the given date
        $bookedQuantity = $this->eventItems()
            ->whereHas('event', function($query) use ($dateString) {
                $query->whereDate('event_date', $dateString)
                      ->where('status', 'approved');
            })
            ->where('status', 'approved')
            ->sum('quantity_approved');

        // Return available quantity (total available minus what's booked)
        return max(0, $this->quantity_available - $bookedQuantity);
    }

    /**
     * Check if item has enough quantity available for a specific date
     */
    public function hasEnoughQuantityForDate($date, $quantity): bool
    {
        return $this->getAvailableQuantityForDate($date) >= $quantity;
    }
}
