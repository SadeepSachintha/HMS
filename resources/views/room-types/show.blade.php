@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Room Type Details</h2>
                        <div class="d-flex gap-2">
                            <a href="{{ route('room-types.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                            <a href="{{ route('room-types.edit', $roomType) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Image Gallery -->
                            <div class="card mb-4">
                                <div class="card-body p-0">
                                    @if($roomType->images->count() > 0)
                                        <div id="roomTypeCarousel" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                @foreach($roomType->images as $index => $image)
                                                    <button type="button" data-bs-target="#roomTypeCarousel"
                                                            data-bs-slide-to="{{ $index }}"
                                                            class="{{ $index === 0 ? 'active' : '' }}"
                                                            aria-label="Slide {{ $index + 1 }}"></button>
                                                @endforeach
                                            </div>
                                            <div class="carousel-inner">
                                                @foreach($roomType->images as $index => $image)
                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                        <img src="{{ $image->image_url }}"
                                                             class="d-block w-100"
                                                             alt="{{ $image->caption ?: 'Room Type Image' }}"
                                                             style="height: 400px; object-fit: cover;">
                                                        @if($image->caption)
                                                            <div class="carousel-caption d-none d-md-block">
                                                                <p class="mb-0">{{ $image->caption }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#roomTypeCarousel" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                    data-bs-target="#roomTypeCarousel" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                        <!-- Thumbnails -->
                                        <div class="d-flex gap-2 p-2 bg-light">
                                            @foreach($roomType->images as $index => $image)
                                                <img src="{{ $image->image_url }}"
                                                     class="thumbnail cursor-pointer"
                                                     alt="Thumbnail"
                                                     data-bs-target="#roomTypeCarousel"
                                                     data-bs-slide-to="{{ $index }}"
                                                     style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;">
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" style="width: 30%">Name</th>
                                        <td>{{ $roomType->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Description</th>
                                        <td>{{ $roomType->description }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Price Per Night</th>
                                        <td>${{ number_format($roomType->price_per_night, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Capacity</th>
                                        <td>{{ $roomType->capacity }} persons</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Created At</th>
                                        <td>{{ $roomType->created_at->format('F d, Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Last Updated</th>
                                        <td>{{ $roomType->updated_at->format('F d, Y H:i:s') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Associated Rooms</h5>
                                </div>
                                <div class="card-body">
                                    @if($roomType->rooms->count() > 0)
                                        <div class="list-group">
                                            @foreach($roomType->rooms as $room)
                                                <a href="{{ route('rooms.show', $room) }}" class="list-group-item list-group-item-action">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1">Room {{ $room->number }}</h6>
                                                        <small>Floor {{ $room->floor }}</small>
                                                    </div>
                                                    <small class="text-muted">Status: {{ $room->status }}</small>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">No rooms associated with this type.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form action="{{ route('room-types.destroy', $roomType) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this room type? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Delete Room Type
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
    .table th {
        background-color: #f8f9fa;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .gap-2 {
        gap: 0.5rem !important;
    }
    .carousel-item img {
        border-radius: 4px;
    }
    .thumbnail {
        border: 2px solid transparent;
        border-radius: 4px;
        transition: border-color 0.2s;
    }
    .thumbnail:hover {
        border-color: #0d6efd;
    }
    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 4px;
        padding: 10px;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('roomTypeCarousel');
    if (carousel) {
        const thumbnails = document.querySelectorAll('.thumbnail');
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const slideIndex = this.getAttribute('data-bs-slide-to');
                const carouselInstance = new bootstrap.Carousel(carousel);
                carouselInstance.to(parseInt(slideIndex));
            });
        });
    }
});
</script>
@endsection
@endsection
