<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #4e73df;
            margin: 0;
        }
        .period {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
        }
        .stats-container {
            margin-bottom: 30px;
        }
        .stat-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
        }
        .stat-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 5px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #4e73df;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fc;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
    </div>

    <div class="period">
        Report Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
    </div>

    @if(isset($data['occupancy_rate']))
        <div class="stats-container">
            <div class="stat-box">
                <div class="stat-label">Occupancy Rate</div>
                <div class="stat-value">{{ $data['occupancy_rate'] }}%</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Rooms</div>
                <div class="stat-value">{{ $data['total_rooms'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Occupied Rooms</div>
                <div class="stat-value">{{ $data['occupied_rooms'] }}</div>
            </div>
        </div>
    @endif

    @if(isset($data['total_revenue']))
        <div class="stats-container">
            <div class="stat-box">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">${{ number_format($data['total_revenue'], 2) }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Average Revenue</div>
                <div class="stat-value">${{ number_format($data['average_revenue'], 2) }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Payments</div>
                <div class="stat-value">{{ $data['payment_count'] }}</div>
            </div>
        </div>
    @endif

    @if(isset($data['reservations']))
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['reservations'] as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->customer->name }}</td>
                        <td>{{ $reservation->room->number }}</td>
                        <td>{{ $reservation->check_in_date->format('M d, Y') }}</td>
                        <td>{{ $reservation->check_out_date->format('M d, Y') }}</td>
                        <td>{{ ucfirst($reservation->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Generated on {{ now()->format('M d, Y H:i:s') }}
    </div>
</body>
</html>
