<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Verification</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f0f2;
            color: #222;
        }
        .wrap {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border: 1px solid #d8c4cb;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }
        .header {
            background: #7f1737;
            color: #fff;
            padding: 16px 24px;
            font-size: 22px;
            font-weight: 700;
        }
        .content {
            padding: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        td {
            border: 1px solid #e4d8dc;
            padding: 10px 12px;
            vertical-align: top;
        }
        td:first-child {
            width: 35%;
            background: #fff6f8;
            font-weight: 700;
            color: #6e2139;
        }
        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #e8f7ee;
            color: #17693c;
            font-weight: 700;
        }
        .alert {
            background: #fff9db;
            border: 1px solid #efe1a5;
            color: #7b6200;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="header">TTD Ticket Verification</div>
        <div class="content">
            <div class="alert">This ticket is verified for the pilgrim below.</div>

            <table>
                <tr>
                    <td>Ticket ID</td>
                    <td>{{ $pilgrim->ticket_id }}</td>
                </tr>
                <tr>
                    <td>Pilgrim Name</td>
                    <td>{{ $pilgrim->name }}</td>
                </tr>
                <tr>
                    <td>Booking Group</td>
                    <td>{{ $pilgrim->booking->group_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Visit Date</td>
                    <td>{{ $pilgrim->booking->visiting_date ? $pilgrim->booking->visiting_date->format('d M, Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Time Slot</td>
                    <td>{{ $pilgrim->booking->slot_time ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Darshan Type</td>
                    <td>{{ $pilgrim->bookingType->title ?? 'General Darshan' }}</td>
                </tr>
                <tr>
                    <td>Payment Status</td>
                    <td><span class="status">{{ ucfirst($pilgrim->booking->payment_status ?? 'pending') }}</span></td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>{{ $pilgrim->phone_number }}</td>
                </tr>
                <tr>
                    <td>ID Proof</td>
                    <td>{{ strtoupper($pilgrim->id_type ?? 'Aadhar') }} - {{ $pilgrim->id_number }}</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>₹{{ number_format((float) ($pilgrim->amount ?? $pilgrim->booking->total_amount ?? 0), 2) }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
