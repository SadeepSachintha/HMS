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
        Report Period: {{ $from->format('M d, Y') }} - {{ $to->format('M d, Y') }}
    </div>

    @if($title === 'Occupancy Report')
        <table>
            <thead>
                <tr>
                    <th>Room no</th>
                    <th>Check-in date</th>
                    <th>Check-out date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        <td>{{ $row['room_no'] }}</td>
                        <td>{{ $row['check_in'] }}</td>
                        <td>{{ $row['check_out'] }}</td>
                        <td>{{ $row['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($title === 'Revenue Report')
        <table>
            <thead>
                <tr>
                    <th>Payment id</th>
                    <th>Payment method</th>
                    <th>Payment date</th>
                    <th>Total amount (LKR)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['rows'] as $row)
                    <tr>
                        <td>{{ $row['payment_id'] }}</td>
                        <td>{{ $row['payment_method'] }}</td>
                        <td>{{ $row['payment_date'] }}</td>
                        <td>{{ $row['total_amount'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align:right">Total</th>
                    <th>{{ $data['total'] }}</th>
                </tr>
            </tfoot>
        </table>
    @else
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Reservation date</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        <td>{{ $row['customer'] }}</td>
                        <td>{{ $row['reservation_date'] }}</td>
                        <td>{{ $row['check_in'] }}</td>
                        <td>{{ $row['check_out'] }}</td>
                        <td>{{ $row['status'] }}</td>
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
