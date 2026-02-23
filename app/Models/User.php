<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'employee_id',
        'department',
        'allowed_inventory_categories',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'allowed_inventory_categories' => 'array',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is college head
     */
    public function isCollegeHead(): bool
    {
        return $this->role === 'college_head';
    }
    /**
     * Check if user is senior head
     */
    public function isSeniorHead(): bool
    {
        return $this->role === 'senior_head';
    }
    /**
     * Check if user is junior head
     */
    public function isJuniorHead(): bool
    {
        return $this->role === 'junior_head';
    }
    /**
     * Check if user is teacher
     */
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    /**
     * Check if user is staff
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**

     * Check if user can create events
     */
    public function canCreateEvents(): bool
    {
        return in_array($this->role, ['admin', 'college_head', 'senior_head', 'junior_head']);
    }

    /**
     * Check if user can approve events
     */
    public function canApproveEvents(): bool
    {
        return in_array($this->role, ['admin']);
    }

    /**
     * Check if user can manage inventory
     */
    public function canManageInventory(): bool
    {
        return in_array($this->role, ['admin', 'staff', 'Head Maintenance']) || 
               !empty($this->allowed_inventory_categories);
    }

    /**
     * Check if user can access a specific inventory category
     */
    public function canAccessInventoryCategory(?string $category): bool
    {
        // If user has allowed categories defined, they are restricted - check those first
        if (!empty($this->allowed_inventory_categories)) {
            return in_array($category, $this->allowed_inventory_categories);
        }

        // Admins, staff, and Head Maintenance without restrictions can access all categories
        if (in_array($this->role, ['admin', 'staff', 'Head Maintenance'])) {
            return true;
        }

        return false;
    }

    /**
     * Get allowed inventory categories for this user
     */
    public function getAllowedInventoryCategories(): array
    {
        // If user has allowed categories defined, return those (restricted access)
        if (!empty($this->allowed_inventory_categories)) {
            return $this->allowed_inventory_categories;
        }

        // Admins, staff, and Head Maintenance without restrictions can access all categories
        // Return empty array to indicate all categories are accessible
        if (in_array($this->role, ['admin', 'staff', 'Head Maintenance'])) {
            return []; // Empty array means all categories
        }

        return [];
    }

    /**
     * Check if user is admin or staff
     */
    public function isAdminOrStaff(): bool
    {
        return in_array($this->role, ['admin', 'staff']);
    }

    /**
     * Check if user can confirm item returns
     * Staff, admin, and Head Maintenance can confirm returns
     */
    public function canConfirmReturns(): bool
    {
        return $this->canManageInventory();
    }

    /**
     * Get events created by this user
     */
    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    /**
     * Get events approved by this user
     */
    public function approvedEvents()
    {
        return $this->hasMany(Event::class, 'approved_by');
    }
}
