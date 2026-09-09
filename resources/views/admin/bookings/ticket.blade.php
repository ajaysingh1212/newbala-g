@php
    /*
    |--------------------------------------------------------------------------
    | TTD ORGANIZATION LOGO
    |--------------------------------------------------------------------------
    | DomPDF ke liye logo ko Base64 mein embed kiya gaya hai.
    |--------------------------------------------------------------------------
    */

    $orgLogo = null;

    $logoPath = public_path('images/org-logo.png');

    if (file_exists($logoPath)) {
        $logoData = file_get_contents($logoPath);
        $logoMime = mime_content_type($logoPath);

        if ($logoData) {
            $orgLogo = 'data:' . $logoMime . ';base64,' . base64_encode($logoData);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | FALLBACK LOGO
    |--------------------------------------------------------------------------
    */

    if (!$orgLogo) {
        $fallbackLogoPath = public_path('logo.png');

        if (file_exists($fallbackLogoPath)) {
            $fallbackLogoData = file_get_contents($fallbackLogoPath);
            $fallbackLogoMime = mime_content_type($fallbackLogoPath);

            if ($fallbackLogoData) {
                $orgLogo = 'data:' . $fallbackLogoMime . ';base64,' . base64_encode($fallbackLogoData);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CALENDAR ICON
    |--------------------------------------------------------------------------
    */

    $calIcon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAA9klEQVR4nO2aQQ6CMBAAq/EV/P9tfENPXIxtl1QYls4cNamzI7YYLUVEZuYxusCyLO/vx9Z1HV73rNd7junkxwC0AI0BaAEaA9ACNOHz89f5e3Ui9wehKyDj8KXEvLsBsg6/0fNvBsg+/EZrjmqAuwy/UZvntWeRI7/k/JvoGzj9MWgAWoBm+gC7NsG7nQyleAUYwAC0AI13gkeLXB0D0AI0BqAFaAxAC9AYgBagMQAtQGMAWoDGALQAjQFoARoD0AI0BqAFaAxAC9AYgBagmT6A/w+oPZHpd8AItXmaH4G7RGjN0d0Dskfo+Yc2wawRsnqLiJzGB1IqNw8G9CFsAAAAAElFTkSuQmCC';
@endphp


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>TTD Ticket</title>

    <style>

        @page {
            margin: 8px;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
            color: #111111;
        }

        body {
            width: 100%;
        }

        /*
        |--------------------------------------------------------------------------
        | MAIN TICKET WRAPPER
        |--------------------------------------------------------------------------
        */

        .ticket-page {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
        }

        /*
        |--------------------------------------------------------------------------
        | TICKET
        |--------------------------------------------------------------------------
        */

        .ticket {
            width: 100%;
            background: #ffffff;
            border: 1px solid #cfcfcf;
            border-radius: 12px;
            overflow: hidden;
        }

        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .header {
            width: 100%;
            text-align: center;
            padding: 14px 12px 5px;
        }

        .logo-image {
            width: 62px;
            height: 62px;
            display: block;
            margin: 0 auto 5px;
            object-fit: contain;
        }

        .logo-placeholder {
            width: 62px;
            height: 62px;
            display: block;
            margin: 0 auto 5px;
            border-radius: 50%;
            border: 2px solid #2f6b3c;
            color: #2f6b3c;
            background: #ffffff;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            line-height: 58px;
        }

        .org-name {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 21px;
            line-height: 1.2;
            font-weight: 700;
            color: #171717;
            letter-spacing: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | DARSHAN TITLE BOX
        |--------------------------------------------------------------------------
        */

        .banner {
            width: 100%;
            text-align: center;
            padding: 7px 12px 5px;
        }

        .title-box {
            width: 62%;
            margin: 0 auto;
            padding: 8px 10px;
            border: 1px solid #cfcfcf;
            border-radius: 10px;
            background: #ffffff;
        }

        .banner-title {
            font-size: 14px;
            line-height: 1.35;
            font-weight: 500;
            color: #333333;
        }

        .banner-title strong {
            font-weight: 700;
        }

        .report-at {
            margin-top: 2px;
            font-size: 13px;
            line-height: 1.35;
            font-weight: 700;
            color: #222222;
        }

        /*
        |--------------------------------------------------------------------------
        | TIME / QR SLOT CARD
        |--------------------------------------------------------------------------
        */

        .slot-card {
            width: calc(100% - 70px);
            margin: 7px auto 0;
            border: 1px solid #cfcfcf;
            border-radius: 11px;
            background: #ffffff;
            display: table;
            table-layout: fixed;
            min-height: 120px;
            overflow: hidden;
        }

        .slot-left {
            display: table-cell;
            width: 55%;
            vertical-align: middle;
            padding: 13px 14px;
        }

        .slot-time {
            font-size: 30px;
            line-height: 1.1;
            color: #071d2d;
            font-weight: 700;
            letter-spacing: 0;
        }

        .slot-date {
            margin-top: 9px;
            font-size: 16px;
            line-height: 1.2;
            color: #7890a7;
            font-weight: 700;
            white-space: nowrap;
        }

        .cal-icon {
            width: 16px;
            height: 16px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 5px;
        }

        /*
        |--------------------------------------------------------------------------
        | QR SECTION
        |--------------------------------------------------------------------------
        */

        .qr-box {
            display: table-cell;
            width: 45%;
            vertical-align: middle;
            border-left: 3px solid #d7d7d7;

            padding: 9px 12px;
        }

        .qr-wrapper {
            width: 100%;
            display: table;
            table-layout: fixed;
        }

        .qr-image-cell {
            display: table-cell;
            width: 88px;
            vertical-align: middle;
            text-align: center;
        }

        .qr-image {
            width: 82px;
            height: 82px;
            display: block;
            margin: 0 auto;
        }

        .ticket-id-cell {
            display: table-cell;
            vertical-align: middle;
            padding-left: 7px;
            font-size: 11px;
            line-height: 1.3;
            color: #222222;
            font-weight: 600;
            word-break: break-all;
        }

        /*
        |--------------------------------------------------------------------------
        | MAIN CONTENT
        |--------------------------------------------------------------------------
        */

        .content {
            width: 100%;
            display: table;
            table-layout: fixed;
            margin-top: 13px;
        }

        /*
        |--------------------------------------------------------------------------
        | LEFT PILGRIM DETAILS
        |--------------------------------------------------------------------------
        */

        .left-col {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            padding: 13px 12px 15px 17px;
            background: #eee8fa;
        }

        /*
        |--------------------------------------------------------------------------
        | RIGHT IMPORTANT INFORMATION
        |--------------------------------------------------------------------------
        */

        .right-col {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            padding: 13px 14px 13px 13px;
            background: #fafafa;
        }

        /*
        |--------------------------------------------------------------------------
        | DETAIL TABLE
        |--------------------------------------------------------------------------
        */

        table.detail-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }

        table.detail-table td {
            padding: 3.8px 1px;
            vertical-align: top;
            line-height: 1.35;
            color: #111111;
        }

        table.detail-table td:first-child {
            width: 56%;
            font-weight: 400;
            white-space: nowrap;
        }

        table.detail-table td:last-child {
            width: 44%;
            font-weight: 700;
        }

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT INFORMATION
        |--------------------------------------------------------------------------
        */

        .details-title {
            font-size: 11.5px;
            line-height: 1.3;
            color: #111111;
            font-weight: 700;
            margin: 0 0 7px;
        }

        .important-list {
            margin: 0;
            padding-left: 15px;
            font-size: 8.8px;
            line-height: 1.45;
            color: #222222;
        }

        .important-list li {
            margin-bottom: 3px;
            padding-left: 1px;
        }

        .important-list li.strong {
            font-weight: 700;
        }

        /*
        |--------------------------------------------------------------------------
        | SMALL QR
        |--------------------------------------------------------------------------
        */

        .small-qr-container {
            width: 100%;
            text-align: right;
            margin-top: 5px;
        }

        .small-qr-image {
            width: 70px;
            height: 70px;
            display: inline-block;
        }

        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .footer {
            width: 100%;
            display: table;
            table-layout: fixed;
            border-top: 1px solid #d5d5d5;
            background: #ffffff;
        }

        .footer-left,
        .footer-right {
            display: table-cell;
            vertical-align: middle;
            padding: 8px 13px;
            font-size: 8.8px;
            line-height: 1.3;
            color: #333333;
        }

        .footer-left {
            width: 70%;
        }

        .footer-right {
            width: 30%;
            text-align: right;
            font-weight: 700;
            font-style: italic;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | MULTIPLE TICKETS
        |--------------------------------------------------------------------------
        | Har pilgrim same PDF/page flow mein rahega.
        | Tickets ke beech screenshot jaisa dashed separator.
        |--------------------------------------------------------------------------
        */

        .ticket-separator {
            width: 100%;
            border-top: 3px dashed #111111;
            margin: 12px 0;
            height: 1px;
        }

        /*
        |--------------------------------------------------------------------------
        | DOMPDF SAFETY
        |--------------------------------------------------------------------------
        */

        img {
            max-width: 100%;
        }

        table {
            page-break-inside: avoid;
        }

        tr {
            page-break-inside: avoid;
        }

        .ticket {
            page-break-inside: avoid;
            break-inside: avoid;
        }

    </style>

</head>


<body>

@foreach($booking->pilgrims as $index => $pilgrim)

    @php

        /*
        |--------------------------------------------------------------------------
        | BOOKING TYPE
        |--------------------------------------------------------------------------
        */

        $bookingType = $pilgrim->bookingType
            ?? $booking->bookingType
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | TICKET ID
        |--------------------------------------------------------------------------
        */

        $ticketId = $pilgrim->ticket_id
            ?? 'IDJ' . $booking->id . str_pad(
                (string) $pilgrim->id,
                6,
                '0',
                STR_PAD_LEFT
            );
            $status = $pilgrim->status
                ?? $booking->status
                ?? '-';

            $paymentStatus = $pilgrim->payment_status
            ?? $booking->payment_status
            ?? '-';
        $ticketId = strtoupper($ticketId);


        /*
        |--------------------------------------------------------------------------
        | QR VERIFICATION URL
        |--------------------------------------------------------------------------
        */

        $verifyUrl = route('ticket.verify', [
            'ticketId' => $ticketId
        ]);


        /*
        |--------------------------------------------------------------------------
        | QR CODE
        |--------------------------------------------------------------------------
        */

        $qrCode = (new \chillerlan\QRCode\QRCode(
            new \chillerlan\QRCode\QROptions([
                'eccLevel' => \chillerlan\QRCode\Common\EccLevel::L,
                'outputInterface' =>
                    \chillerlan\QRCode\Output\QRGdImagePNG::class,
                'outputBase64' => true,
                'margin' => 1,
                'scale' => 4,
            ])
        ))->render($verifyUrl);


        /*
        |--------------------------------------------------------------------------
        | TIME
        |--------------------------------------------------------------------------
        */

        $slotTime = $booking->slot_time ?? '10:00 AM';


        /*
        |--------------------------------------------------------------------------
        | VISITING DATE
        |--------------------------------------------------------------------------
        */

        $visitDate = $booking->visiting_date
            ? \Carbon\Carbon::parse($booking->visiting_date)->format('d/m/Y')
            : '-';


        /*
        |--------------------------------------------------------------------------
        | REPORT AT
        |--------------------------------------------------------------------------
        */

        $reportAt = $booking->report_at ?? 'ATC Circle';


        /*
        |--------------------------------------------------------------------------
        | AMOUNT
        |--------------------------------------------------------------------------
        */

        $amount =
            $pilgrim->amount
            ?? $bookingType->amount
            ?? $booking->total_amount
            ?? 0;


        /*
        |--------------------------------------------------------------------------
        | DARSHAN TITLE
        |--------------------------------------------------------------------------
        */

        $darshanTitle =
            $bookingType->title
            ?? 'Special Entry Darshan';

    @endphp


    <div class="ticket-page">

        <div class="ticket">


            {{-- =========================================================
                 HEADER
            ========================================================== --}}

            <div class="header">

                @if($orgLogo)

                    <img
                        src="{{ $orgLogo }}"
                        alt="Organization Logo"
                        class="logo-image"
                    >

                @else

                    <div class="logo-placeholder">
                        TTD
                    </div>

                @endif


                <div class="org-name">
                    Tirumala Tirupati Devasthanams
                </div>

            </div>


            {{-- =========================================================
                 DARSHAN INFORMATION
            ========================================================== --}}

            <div class="banner">

                <div class="title-box">

                    <div class="banner-title">

                        {{ $darshanTitle }}

                        <strong>
                            (Rs.{{ number_format((float)$amount, 0) }})
                        </strong>

                    </div>


                    <div class="report-at">

                        Report at :

                        <strong>
                            {{ $reportAt }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 TIME + DATE + QR
            ========================================================== --}}

            <div class="slot-card">


                {{-- LEFT SIDE --}}

                <div class="slot-left">

                    <div class="slot-time">
                        {{ $slotTime }}
                    </div>


                    <div class="slot-date">

                        <img
                            src="{{ $calIcon }}"
                            alt=""
                            class="cal-icon"
                        >

                        {{ $visitDate }}

                    </div>

                </div>


                {{-- RIGHT SIDE QR --}}

                <div class="qr-box">

                    <div class="qr-wrapper">

                        <div class="qr-image-cell">

                            <img
                                src="{{ $qrCode }}"
                                alt="QR Code"
                                class="qr-image"
                            >
                            <div class="">

                                <span style="font-size: 11px;">{{ $ticketId }}</span>

                            </div>
                        </div>


                        {{-- <div class="">

                            {{ $ticketId }}

                        </div> --}}

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 DETAILS + IMPORTANT INFORMATION
            ========================================================== --}}

            <div class="content">


                {{-- =====================================================
                     PILGRIM DETAILS
                ====================================================== --}}

                <div class="left-col">

                    <table class="detail-table">

                        <tr>

                            <td>
                                No. of free Laddus
                            </td>

                            <td>
                                : {{ $pilgrim->free_laddus ?? 1 }}
                            </td>

                        </tr>
                        <tr>
                            <td>Booking Status</td>
                            <td>: {{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                        </tr>

                        <tr>
                            <td>Payment Status</td>
                            <td>: {{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}</td>
                        </tr>
                        <tr>

                            <td>
                                Amount
                            </td>

                            <td>
                                : Rs {{ number_format((float)$amount, 0) }}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                Group Booking ID
                            </td>

                            <td>
                                : {{ $ticketId }}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                Booking Date
                            </td>

                            <td>
                                : {{ $visitDate }}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                Pilgrim Name
                            </td>

                            <td>
                                : {{ $pilgrim->name ?? '-' }}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                Contact No.
                            </td>

                            <td>
                                : {{ $pilgrim->phone_number ?? '-' }}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                Gender/Age
                            </td>

                            <td>
                                :
                                {{ ucfirst($pilgrim->gender ?? 'Male') }}
                                /
                                {{ $pilgrim->age ?? '-' }}
                            </td>

                        </tr>


                        <tr>

                            <td>
                                Photo ID Number
                            </td>

                            <td>
                                :
                                {{ strtoupper($pilgrim->id_type ?? 'AADHAAR') }}
                                /
                                {{ $pilgrim->id_number ?? '-' }}
                            </td>

                        </tr>

                    </table>

                </div>


                {{-- =====================================================
                     IMPORTANT INFORMATION
                ====================================================== --}}

                <div class="right-col">

                    <div class="details-title">

                        Important Information to the Pilgrims:

                    </div>


                    <ol class="important-list">

                        <li>
                            At the time of entry, all the pilgrims should
                            carry individual ticket and shall produce the
                            original photo ID used during booking.
                        </li>


                        <li>
                            The original ticket holder must be present to
                            avail the Darshan; proxies are strictly not
                            permitted.
                        </li>


                        <li>
                            Prasadam is a sacred offering and will be given
                            at no cost only when the original ticket holder
                            avails the Darshan.
                        </li>


                        <li>
                            Pilgrims shall collect the Prasadam within
                            24 hours from the time of reporting for Darshan.
                        </li>


                        <li>
                            The pilgrims shall wear traditional dress only.
                            Male: Dhoti, Shirt/Kurtha, Pyjama.
                            Female: Saree/Half-Chudidar with dupatta.
                        </li>


                        <li class="strong">
                            All the pilgrims shall report as per their
                            Time-Slot only and should not carry any
                            luggage/electronic gadgets while reporting.
                            The pilgrims will be allowed in Q-lines prior
                            to one hour from their scheduled slots only.
                        </li>


                        <li>
                            All bookings are final.
                            Postponement/advancement/cancellation/Refund
                            are not allowed.
                        </li>


                        <li>
                            Pilgrims with cardiac disease and other
                            comorbidities likes diabetes, hypertension
                            are advised to avoid climbing.
                        </li>


                        <li>
                            All Legal Options (ALO) shall alone have
                            exclusive jurisdiction of Tirupati only or
                            High Court of Andhra Pradesh.
                        </li>


                        <li>
                            TTD reserves the right of cancellation of
                            Darshan under Special Circumstances.
                        </li>

                    </ol>


                    {{-- BOTTOM QR --}}

                    <div class="small-qr-container">

                        <img
                            src="{{ $qrCode }}"
                            alt="QR Code"
                            class="small-qr-image"
                        >

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 FOOTER
            ========================================================== --}}

            <div class="footer">

                <div class="footer-left">

                    Note: Electronically generated details do not require
                    any signature

                </div>


                <div class="footer-right">

                    Executive Officer, TTD

                </div>

            </div>


        </div>

    </div>


    {{-- =============================================================
         DASHED SEPARATOR BETWEEN PILGRIM TICKETS
    ============================================================== --}}

    @if(!$loop->last)

        <div class="ticket-separator"></div>

    @endif


@endforeach


</body>

</html>
