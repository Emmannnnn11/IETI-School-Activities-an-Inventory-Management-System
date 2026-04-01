<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventItem;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        // Active/upcoming events only (end_datetime > now). Rejected events belong in history.
        $events = Event::with(['creator', 'approver', 'eventItems.inventoryItem'])
            ->where('status', '!=', 'rejected')
            ->future()
            ->orderBy('event_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        $now = now();
        $today = $now->toDateString();
        $nowTime = $now->format('H:i:s');

        $rejectedEventsCount = Event::where('status', 'rejected')->count();
        $completedEventsCount = Event::where('status', '!=', 'rejected')
            ->where(function ($q) use ($today, $nowTime) {
                // Multi-day events (end_date set)
                $q->where(function ($sub) use ($today, $nowTime) {
                    $sub->whereNotNull('end_date')
                        ->where(function ($inner) use ($today, $nowTime) {
                            $inner->where('end_date', '<', $today)
                                  ->orWhere(function ($q2) use ($today, $nowTime) {
                                      $q2->where('end_date', $today)
                                         ->where('end_time', '<=', $nowTime);
                                  });
                        });
                })
                // Legacy single-day events (no end_date)
                ->orWhere(function ($sub) use ($today, $nowTime) {
                    $sub->whereNull('end_date')
                        ->where(function ($inner) use ($today, $nowTime) {
                            $inner->where('event_date', '<', $today)
                                  ->orWhere(function ($q2) use ($today, $nowTime) {
                                      $q2->where('event_date', $today)
                                         ->where('end_time', '<=', $nowTime);
                                  });
                        });
                });
            })
            ->count();

        $archivedEventsCount = $rejectedEventsCount + $completedEventsCount;
        $approvedEventsCount = $events->where('status', 'approved')->count();
        $pendingEventsCount = $events->where('status', 'pending')->count();

        // Get inventory items for staff and admin
        $inventoryItems = collect();
        if ($user->canManageInventory()) {
            $inventoryItems = InventoryItem::with('eventItems.event')
                ->orderBy('name', 'asc')
                ->get();
        }

        // Get pending borrowed items (approved event items that haven't been returned)
        // This includes items from both future and past events
        $pendingBorrowedItemsQuery = EventItem::with(['event.creator', 'inventoryItem'])
            ->unreturned()
            ->whereHas('event', function($query) {
                $query->where('status', 'approved');
            });

        // College Head, Senior Head, Junior Head: only see pending items for events they created
        if (in_array($user->role, ['college_head', 'senior_head', 'junior_head'])) {
            $pendingBorrowedItemsQuery->whereHas('event', function ($query) use ($user) {
                $query->where('created_by', $user->id);
            });
        } else {
            // Staff / Head Maintenance with restricted categories: only see items they handle
            $allowedCategories = $user->getAllowedInventoryCategories();
            if (!empty($allowedCategories)) {
                $pendingBorrowedItemsQuery->whereHas('inventoryItem', function ($query) use ($allowedCategories) {
                    $query->whereIn('category', $allowedCategories);
                });
            }
        }

        $pendingBorrowedItems = $pendingBorrowedItemsQuery
            ->orderBy('created_at', 'desc')
            ->get();

        $dashboardCards = [
            [
                'title' => 'Approved Events',
                'count' => $approvedEventsCount,
                'icon' => 'fas fa-calendar-check',
                'textClass' => 'text-success',
                'route' => route('events.index', ['status' => 'approved']),
                'enabled' => true,
            ],
            [
                'title' => 'Pending Events',
                'count' => $pendingEventsCount,
                'icon' => 'fas fa-clock',
                'textClass' => 'text-warning',
                'route' => route('events.index', ['status' => 'pending']),
                'enabled' => true,
            ],
            [
                'title' => 'Archived (Completed/Rejected)',
                'count' => $archivedEventsCount,
                'icon' => 'fas fa-archive',
                'textClass' => 'text-secondary',
                'route' => route('events.history'),
                'enabled' => $user->isAdmin(),
            ],
            [
                'title' => 'Inventory Items',
                'count' => $inventoryItems->count(),
                'icon' => 'fas fa-boxes',
                'textClass' => 'text-info',
                'route' => route('inventory.index'),
                'enabled' => $user->canManageInventory(),
            ],
        ];

        return view('home', compact('events', 'inventoryItems', 'user', 'pendingBorrowedItems', 'archivedEventsCount', 'dashboardCards'));
    }
}
