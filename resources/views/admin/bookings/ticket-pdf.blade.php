<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Tickets</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 10px;
        }
        
        .ticket-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .ticket {
            background: white;
            border: 2px solid #2c3e50;
            margin-bottom: 20px;
            page-break-after: always;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .ticket-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 3px dashed #ffffff;
        }
        
        .ticket-header h1 {
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .ticket-code {
            display: inline-block;
            margin-top: 8px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.4);
            color: #fff;
            font-weight: bold;
            letter-spacing: 2px;
            padding: 8px 16px;
            border-radius: 6px;
        }
        
        .ticket-header p {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .ticket-body {
            padding: 20px;
        }
        
        .ticket-section {
            margin-bottom: 15px;
        }
        
        .section-title {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 8px 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 13px;
            text-transform: uppercase;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: 11px;
            color: #7f8c8d;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .info-value {
            font-size: 14px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .info-value-large {
            font-size: 16px;
            font-weight: bold;
            color: #667eea;
        }
        
        .full-width {
            grid-column: 1 / -1;
        }
        
        .divider {
            border-top: 2px dashed #bdc3c7;
            margin: 15px 0;
        }
        
        .pilgrim-info {
            background: #f0f4ff;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
        }
        
        .pilgrim-name {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .pilgrim-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            font-size: 12px;
        }
        
        .pilgrim-detail-item {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }
        
        .pilgrim-detail-label {
            color: #7f8c8d;
            font-weight: bold;
        }
        
        .pilgrim-detail-value {
            color: #2c3e50;
            font-weight: 500;
        }
        
        .amount-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .amount-label {
            font-size: 11px;
            color: #856404;
            text-transform: uppercase;
        }
        
        .amount-value {
            font-size: 22px;
            font-weight: bold;
            color: #ff6b6b;
        }
        
        .booking-type {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        
        .booking-type-title {
            font-size: 13px;
            font-weight: bold;
            color: #2e7d32;
            margin-bottom: 3px;
        }
        
        .booking-type-desc {
            font-size: 11px;
            color: #558b2f;
            line-height: 1.4;
        }
        
        .payment-info {
            background: #f3e5f5;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            border-left: 4px solid #9c27b0;
        }
        
        .payment-status {
            font-size: 13px;
            font-weight: bold;
            color: #6a1b9a;
            margin-bottom: 5px;
        }
        
        .payment-status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .badge-confirmed {
            background: #4caf50;
            color: white;
        }
        
        .badge-pending {
            background: #ff9800;
            color: white;
        }
        
        .bank-details {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 10px;
            border-radius: 3px;
            margin-bottom: 10px;
            font-size: 12px;
        }
        
        .bank-details-title {
            font-weight: bold;
            color: #1565c0;
            margin-bottom: 5px;
        }
        
        .bank-details-item {
            margin: 3px 0;
            color: #0d47a1;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-top: 2px dashed #bdc3c7;
            font-size: 11px;
            color: #7f8c8d;
        }
        
        .qr-code {
            text-align: center;
            margin: 15px 0;
        }
        
        .qr-code img {
            max-width: 150px;
            height: auto;
        }
        
        .important-note {
            background: #ffebee;
            border: 2px solid #f44336;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 11px;
            color: #c62828;
            line-height: 1.4;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .ticket {
                page-break-after: always;
                box-shadow: none;
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        @foreach($booking->pilgrims as $index => $pilgrim)
        <div class="ticket">
            <!-- Ticket Header -->
            <div class="ticket-header">
                <h1>✓ BOOKING TICKET</h1>
                <p>Booking ID: #{{ $booking->id }} | Ticket #{{ $index + 1 }}/{{ $booking->pilgrims->count() }}</p>
            </div>
            
            <!-- Ticket Body -->
            <div class="ticket-body">
                <!-- Pilgrim Information Section -->
                <div class="ticket-section">
                    <div class="section-title">👤 Pilgrim Information</div>
                    <div class="pilgrim-info">
                        <div class="pilgrim-name">{{ $pilgrim->name }}</div>
                        <div class="pilgrim-details">
                            <div class="pilgrim-detail-item">
                                <span class="pilgrim-detail-label">Age:</span>
                                <span class="pilgrim-detail-value">{{ $pilgrim->age }} years</span>
                            </div>
                            <div class="pilgrim-detail-item">
                                <span class="pilgrim-detail-label">Gender:</span>
                                <span class="pilgrim-detail-value">{{ ucfirst($pilgrim->gender) }}</span>
                            </div>
                            <div class="pilgrim-detail-item">
                                <span class="pilgrim-detail-label">Phone:</span>
                                <span class="pilgrim-detail-value">{{ $pilgrim->phone_number }}</span>
                            </div>
                            <div class="pilgrim-detail-item">
                                <span class="pilgrim-detail-label">{{ ucfirst($pilgrim->id_type) }}:</span>
                                <span class="pilgrim-detail-value">{{ $pilgrim->id_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="divider"></div>
                
                <!-- Booking Details Section -->
                <div class="ticket-section">
                    <div class="section-title">📅 Booking Details</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Group Name</span>
                            <span class="info-value">{{ $booking->group_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Main Contact Person</span>
                            <span class="info-value">{{ $booking->main_person_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value" style="font-size: 12px;">{{ $booking->email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Visiting Date</span>
                            <span class="info-value">{{ $booking->visiting_date->format('d M, Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Slot / Time</span>
                            <span class="info-value">{{ $booking->slot_time }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Booking Type</span>
                            <span class="info-value">{{ $pilgrim->bookingType->title }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="divider"></div>
                
                <!-- Booking Type Details -->
                <div class="ticket-section">
                    <div class="section-title">📋 Booking Type Information</div>
                    <div class="booking-type">
                        <div class="booking-type-title">{{ $pilgrim->bookingType->title }}</div>
                        @if($pilgrim->bookingType->description)
                            <div class="booking-type-desc">{{ $pilgrim->bookingType->description }}</div>
                        @endif
                    </div>
                </div>
                
                <!-- Amount Section -->
                <div class="ticket-section">
                    <div class="amount-box">
                        <div class="amount-label">Booking Amount</div>
                        <div class="amount-value">₹{{ number_format($pilgrim->amount, 2) }}</div>
                    </div>
                </div>
                
                <!-- Payment Status -->
                <div class="ticket-section">
                    <div class="payment-info">
                        <div class="payment-status">
                            Payment Status:
                            <span class="payment-status-badge {{ $booking->payment_status === 'confirmed' ? 'badge-confirmed' : 'badge-pending' }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>
                        @if($booking->ref_utr)
                            <div style="margin-top: 5px; font-size: 11px;">
                                <strong>Reference/UTR:</strong> {{ $booking->ref_utr }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Bank Account Details (if print_on_ticket is enabled) -->
                @php
                    $bankAccount = \App\Models\BankAccount::where('print_on_ticket', true)
                        ->where('status', 'active')
                        ->first();
                @endphp
                
                @if($bankAccount)
                <div class="ticket-section">
                    <div class="section-title">🏦 Bank Details for Payment</div>
                    <div class="bank-details">
                        <div class="bank-details-title">{{ $bankAccount->bank_name }}</div>
                        <div class="bank-details-item"><strong>Account Holder:</strong> {{ $bankAccount->account_holder_name }}</div>
                        <div class="bank-details-item"><strong>Account Number:</strong> {{ $bankAccount->account_number }}</div>
                        <div class="bank-details-item"><strong>IFSC Code:</strong> {{ $bankAccount->ifsc_code }}</div>
                        @if($bankAccount->upi_id)
                            <div class="bank-details-item"><strong>UPI ID:</strong> {{ $bankAccount->upi_id }}</div>
                        @endif
                    </div>
                    
                    @if($bankAccount->upi_scanner)
                    <div class="qr-code">
                        <img src="{{ asset('storage/' . $bankAccount->upi_scanner) }}" alt="UPI QR Code">
                    </div>
                    @endif
                </div>
                @endif
                
                <!-- Important Notes -->
                <div class="important-note">
                    <strong>⚠️ Important:</strong> Please keep this ticket safely. Present it during your visit. Make sure all details are correct before your visit date.
                </div>
                
                <!-- Footer -->
                <div class="footer">
                    <p><strong>Booking Confirmation</strong> | Generated on {{ now()->format('d M, Y H:i A') }}</p>
                    <p>Thank you for your booking! For any queries, please contact us at {{ $booking->email }}</p>
                    <p style="margin-top: 10px; font-size: 10px; color: #999;">
                        This is an electronically generated ticket and is valid with or without signature.
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
