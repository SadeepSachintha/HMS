@extends('layouts.app')

@section('styles')
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Events Management</h2>
        <div class="d-flex align-items-center">
            <form method="GET" action="{{ route('events.index') }}" class="d-flex me-3">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                       placeholder="Search by name, location, or description..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
            <a href="{{ route('events.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Event
            </a>
        </div>
    </div>

    @if(request('search'))
        <div class="alert alert-info">
            <i class="fas fa-search"></i> Search results for: <strong>"{{ request('search') }}"</strong>
            <a href="{{ route('events.index') }}" class="float-end">Clear search</a>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Upcoming Events</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => request('sort') == 'name' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            Name
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'name' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'name' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'start_date', 'order' => request('sort') == 'start_date' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            Start Time
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'start_date' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'start_date' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'end_date', 'order' => request('sort') == 'end_date' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            End Time
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'end_date' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'end_date' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'location', 'order' => request('sort') == 'location' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            Location
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'location' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'location' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => request('sort') == 'status' && request('order') == 'asc' ? 'desc' : 'asc']) }}"
                                           class="text-decoration-none text-dark d-flex align-items-center justify-content-between">
                                            Status
                                            <div class="d-flex flex-column">
                                                <i class="fas fa-sort-up {{ request('sort') == 'status' && request('order') == 'asc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                                <i class="fas fa-sort-down {{ request('sort') == 'status' && request('order') == 'desc' ? 'text-primary' : 'text-muted' }}" style="font-size: 0.7em;"></i>
                                            </div>
                                        </a>
                                    </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events as $event)
                                    <tr>
                                        <td>{{ $event->name }}</td>
                                        <td>{{ $event->start_time->format('Y-m-d H:i') }}</td>
                                        <td>{{ $event->end_time->format('Y-m-d H:i') }}</td>
                                        <td>{{ $event->location }}</td>
                                        <td>
                                            <span class="badge bg-{{ $event->status === 'scheduled' ? 'primary' : ($event->status === 'in_progress' ? 'warning' : ($event->status === 'completed' ? 'success' : 'danger')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $event->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this event?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            @if(request('search'))
                                                No events found matching your search criteria.
                                            @else
                                                No events found.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: '/events/calendar',
            eventClick: function(event) {
                window.location.href = '/events/' + event.id;
            },
            eventRender: function(event, element) {
                element.attr('title', event.name + '\n' +
                           'Location: ' + event.location + '\n' +
                           'Start: ' + moment(event.start).format('YYYY-MM-DD HH:mm') + '\n' +
                           'End: ' + moment(event.end).format('YYYY-MM-DD HH:mm'));
            }
        });
    });
</script>
@endsection
