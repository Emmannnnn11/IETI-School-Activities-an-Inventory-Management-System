@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-box me-2"></i>
                    Inventory Item Details
                </h2>
                <div>
                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Inventory
                    </a>
                    <a href="{{ route('inventory.edit', $inventoryItem) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-2"></i>
                        Edit Item
                    </a>
                    @php
                        $canDelete = in_array(Auth::user()->role, ['admin', 'Head Maintenance']);
                    @endphp
                    @if($canDelete)
                    <form action="{{ route('inventory.destroy', $inventoryItem) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this inventory item? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>
                            Delete
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Item Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Item Name</h6>
                            <p class="h5">{{ $inventoryItem->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status</h6>
                            <span class="badge {{ $inventoryItem->status_badge_class }} fs-6">
                                {{ ucfirst($inventoryItem->status) }}
                            </span>
                        </div>
                    </div>

                    @if($inventoryItem->description)
                    <hr>
                    <div>
                        <h6 class="text-muted">Description</h6>
                        <p>{{ $inventoryItem->description }}</p>
                    </div>
                    @endif

                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <h6 class="text-muted">Category</h6>
                            <p class="h6">{{ $inventoryItem->category }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Total Quantity</h6>
                            <p class="h6">{{ $inventoryItem->quantity_total }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Available Quantity</h6>
                            <p class="h6">{{ $inventoryItem->quantity_available }}</p>
                        </div>
                    </div>

                    @if($inventoryItem->location)
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Location</h6>
                            <p class="h6">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                {{ $inventoryItem->location }}
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($inventoryItem->notes)
                    <hr>
                    <div>
                        <h6 class="text-muted">Notes</h6>
                        <p>{{ $inventoryItem->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            @if($inventoryItem->eventItems->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar me-2"></i>
                        Related Events ({{ $inventoryItem->eventItems->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date</th>
                                    <th>Quantity Requested</th>
                                    <th>Quantity Approved</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventoryItem->eventItems->sortByDesc('event.event_date') as $eventItem)
                                <tr>
                                    <td>
                                        <a href="{{ route('events.show', $eventItem->event) }}">
                                            {{ $eventItem->event->title }}
                                        </a>
                                    </td>
                                    <td>{{ $eventItem->event->event_date->format('M d, Y') }}</td>
                                    <td>{{ $eventItem->quantity_requested }}</td>
                                    <td>{{ $eventItem->quantity_approved ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $eventItem->event->status_badge_class }}">
                                            {{ ucfirst($eventItem->event->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('events.show', $eventItem->event) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Total Quantity</h6>
                        <p class="h4">{{ $inventoryItem->quantity_total }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted">Available</h6>
                        <p class="h4 text-success">{{ $inventoryItem->quantity_available }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted">In Use</h6>
                        <p class="h4 text-warning">
                            {{ $inventoryItem->quantity_total - $inventoryItem->quantity_available }}
                        </p>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <h6 class="text-muted">Usage Rate</h6>
                        @php
                            $usageRate = $inventoryItem->quantity_total > 0 
                                ? round((($inventoryItem->quantity_total - $inventoryItem->quantity_available) / $inventoryItem->quantity_total) * 100, 1)
                                : 0;
                        @endphp
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar {{ $usageRate > 80 ? 'bg-danger' : ($usageRate > 50 ? 'bg-warning' : 'bg-success') }}" 
                                 role="progressbar" 
                                 style="width: {{ $usageRate }}%"
                                 aria-valuenow="{{ $usageRate }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                {{ $usageRate }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

