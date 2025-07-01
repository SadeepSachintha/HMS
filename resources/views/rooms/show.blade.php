@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">
                &larr; Back to List
            </a>
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Room Details</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h3 class="h4 mb-3">ROOM AMENITIES</h3>
                            <div class="row g-3">
                                @if($room->roomType && $room->roomType->amenities)
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user fa-fw me-2"></i>
                                            <span>1-{{ $room->roomType->capacity }} Adults</span>
                                        </div>
                                    </div>
                                    @if(in_array('queen', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-bed fa-fw me-2"></i>
                                                <span>2 Queen Beds</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('double', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-bed fa-fw me-2"></i>
                                                <span>1 Double Bed</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('single', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-bed fa-fw me-2"></i>
                                                <span>1 Single Bed</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('bathroom', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-sink fa-fw me-2"></i>
                                                <span>Vanity with Sink in Bedroom</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('private_bathroom', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-bath fa-fw me-2"></i>
                                                <span class="d-flex align-items-center">
                                                    <span class="text-info me-1">Private</span> Bathrooms
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('hallway_bathroom', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-toilet fa-fw me-2"></i>
                                                <span>Hallway Bathrooms</span>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <h3 class="h4 mb-3">Additional Amenities</h3>
                            <div class="row g-3">
                                @if($room->roomType && $room->roomType->amenities)
                                    @if(in_array('ac', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-snowflake fa-fw me-2"></i>
                                                <span>Air Conditioning</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('coffee', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-coffee fa-fw me-2"></i>
                                                <span>Coffee Maker</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('wifi', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-wifi fa-fw me-2"></i>
                                                <span>Free WIFI</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('hair_dryer', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-wind fa-fw me-2"></i>
                                                <span>Hair Dryers</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('tv', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-tv fa-fw me-2"></i>
                                                <span>LCD TV</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('fridge', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-box fa-fw me-2"></i>
                                                <span>Mini Refrigerator</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('toiletries', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-pump-soap fa-fw me-2"></i>
                                                <span>Toiletries</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if(in_array('desk', $room->roomType->amenities))
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-desktop fa-fw me-2"></i>
                                                <span>Work Desk</span>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Room Number:</div>
                        <div class="col-md-8">{{ $room->number }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Room Type:</div>
                        <div class="col-md-8">{{ $room->roomType->name ?? 'N/A' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Floor:</div>
                        <div class="col-md-8">{{ $room->floor }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            <span class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'warning' : 'danger') }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </div>
                    </div>

                    @if($room->notes)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Notes:</div>
                        <div class="col-md-8">{{ $room->notes }}</div>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-1"></i> Edit Room
                        </a>
                        <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this room?')">
                                <i class="fas fa-trash me-1"></i> Delete Room
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
.h4 {
    color: #333;
    font-weight: 600;
}
.col-auto {
    margin-bottom: 1rem;
}
.d-flex.align-items-center {
    background: #f8f9fa;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    min-width: 180px;
}
.fas {
    color: #666;
}
.badge {
    padding: 0.5em 1em;
}
</style>
@endsection
@endsection
