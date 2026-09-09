@extends('layouts.admin')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    .yatra {
        --clr-bg: #FBF6EC;
        --clr-surface: #FFFFFF;
        --clr-ink: #2B2320;
        --clr-ink-soft: #7A6E5E;
        --clr-maroon: #7A2E2E;
        --clr-maroon-deep: #5C2222;
        --clr-saffron: #E08A1E;
        --clr-saffron-soft: #FBEBD3;
        --clr-teal: #2F6B4F;
        --clr-teal-soft: #E4F1E9;
        --clr-rose: #B23A3A;
        --clr-rose-soft: #FBE7E4;
        --clr-line: #E9DFCB;
        font-family: 'Manrope', sans-serif;
        color: var(--clr-ink);
        background: var(--clr-bg);
        margin: -15px -15px 0;
        padding: 0 0 32px;
    }

    .yatra .content-header { display: none; }

    /* ---------- Header banner with garland/toran signature border ---------- */
    .yatra-hero {
        background: linear-gradient(135deg, var(--clr-maroon) 0%, var(--clr-maroon-deep) 100%);
        padding: 34px 36px 46px;
        position: relative;
        color: #F8EFDF;
    }
    .yatra-hero__top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 16px;
    }
    .yatra-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700;
        font-size: 2.5rem;
        letter-spacing: .3px;
        margin: 0;
        line-height: 1.1;
    }
    .yatra-hero p.tagline {
        margin: 6px 0 0;
        color: #E7CFA9;
        font-size: .95rem;
        font-weight: 500;
    }
    .yatra-breadcrumb {
        list-style: none;
        display: flex;
        gap: 6px;
        padding: 0;
        margin: 0;
        font-size: .8rem;
        color: #E7CFA9;
    }
    .yatra-breadcrumb a { color: #F8EFDF; text-decoration: none; }
    .yatra-breadcrumb a:hover { text-decoration: underline; }
    .yatra-breadcrumb li + li::before { content: '/'; margin: 0 6px; opacity: .5; }

    .yatra-btn-new {
        background: var(--clr-saffron);
        border: none;
        color: #3A1F00;
        font-weight: 700;
        padding: 11px 20px;
        border-radius: 10px;
        font-size: .9rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 6px 16px rgba(224,138,30,.35);
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .yatra-btn-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(224,138,30,.45);
        color: #3A1F00;
    }

    /* marigold garland scalloped divider - the signature element */
    .yatra-garland {
        position: absolute;
        left: 0; right: 0; bottom: -1px;
        height: 26px;
        background:
            radial-gradient(circle at 13px 0, transparent 12px, var(--clr-bg) 13px) repeat-x;
        background-size: 26px 26px;
    }
    .yatra-garland::before {
        content: '';
        position: absolute;
        top: -6px; left: 0; right: 0; height: 6px;
        background: repeating-linear-gradient(90deg, var(--clr-saffron) 0 8px, var(--clr-teal) 8px 16px);
        opacity: .85;
    }

    /* ---------- Stat cards ---------- */
    .yatra-stats {
        margin-top: -18px;
        padding: 0 36px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        position: relative;
        z-index: 2;
    }
    .yatra-stat {
        background: var(--clr-surface);
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow: 0 10px 24px rgba(90,60,20,.08);
        border-left: 5px solid var(--clr-saffron);
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .yatra-stat.confirmed { border-left-color: var(--clr-teal); }
    .yatra-stat.pending { border-left-color: var(--clr-saffron); }
    .yatra-stat.revenue { border-left-color: var(--clr-maroon); }
    .yatra-stat__icon {
        width: 42px; height: 42px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        background: var(--clr-saffron-soft);
        color: var(--clr-maroon);
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .yatra-stat.confirmed .yatra-stat__icon { background: var(--clr-teal-soft); color: var(--clr-teal); }
    .yatra-stat.revenue .yatra-stat__icon { background: #F3E4D8; color: var(--clr-maroon); }
    .yatra-stat__num {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700;
        font-size: 1.7rem;
        line-height: 1;
    }
    .yatra-stat__label {
        font-size: .74rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--clr-ink-soft);
        font-weight: 600;
        margin-top: 3px;
    }

    /* ---------- Card / toolbar / table ---------- */
    .yatra-card {
        margin: 26px 36px 0;
        background: var(--clr-surface);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(90,60,20,.07);
        overflow: hidden;
    }
    .yatra-toolbar {
        padding: 18px 22px;
        border-bottom: 1px solid var(--clr-line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }
    .yatra-search {
        position: relative;
        width: 280px;
        max-width: 100%;
    }
    .yatra-search input {
        width: 100%;
        border: 1px solid var(--clr-line);
        background: var(--clr-bg);
        border-radius: 10px;
        padding: 9px 14px 9px 36px;
        font-size: .88rem;
        color: var(--clr-ink);
    }
    .yatra-search input:focus {
        outline: none;
        border-color: var(--clr-saffron);
        box-shadow: 0 0 0 3px rgba(224,138,30,.15);
    }
    .yatra-search i {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--clr-ink-soft);
        font-size: .85rem;
    }
    .yatra-filters { display: flex; gap: 8px; flex-wrap: wrap; }
    .yatra-filter {
        border: 1px solid var(--clr-line);
        background: var(--clr-bg);
        color: var(--clr-ink-soft);
        border-radius: 999px;
        padding: 7px 15px;
        font-size: .8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .15s ease;
    }
    .yatra-filter:hover { border-color: var(--clr-saffron); color: var(--clr-ink); }
    .yatra-filter.active {
        background: var(--clr-maroon);
        border-color: var(--clr-maroon);
        color: #fff;
    }

    .yatra table.dataTable {
        margin: 0 !important;
    }
    .yatra table.dataTable thead th {
        background: var(--clr-bg);
        color: var(--clr-ink-soft);
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-weight: 700;
        border-bottom: 2px solid var(--clr-line) !important;
        padding: 13px 14px;
    }
    .yatra table.dataTable tbody td {
        padding: 13px 14px;
        vertical-align: middle;
        border-top: 1px solid var(--clr-line);
        font-size: .87rem;
    }
    .yatra table.dataTable tbody tr:hover { background: #FDF9F0; }

    .yatra-person { display: flex; align-items: center; gap: 10px; }
    .yatra-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: var(--clr-saffron-soft);
        color: var(--clr-maroon);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700;
        font-size: .78rem;
        flex-shrink: 0;
    }
    .yatra-group { font-weight: 700; color: var(--clr-maroon); }
    .yatra-sub { color: var(--clr-ink-soft); font-size: .78rem; display: block; }

    .yatra-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 11px;
        border-radius: 999px;
        font-size: .74rem;
        font-weight: 700;
    }
    .yatra-pill .dot { width: 6px; height: 6px; border-radius: 50%; }
    .yatra-pill.status-completed { background: var(--clr-teal-soft); color: var(--clr-teal); }
    .yatra-pill.status-completed .dot { background: var(--clr-teal); }
    .yatra-pill.status-pending { background: var(--clr-saffron-soft); color: #8A5A0E; }
    .yatra-pill.status-pending .dot { background: var(--clr-saffron); }
    .yatra-pill.status-cancelled { background: var(--clr-rose-soft); color: var(--clr-rose); }
    .yatra-pill.status-cancelled .dot { background: var(--clr-rose); }
    .yatra-pill.pay-confirmed { background: var(--clr-teal-soft); color: var(--clr-teal); }
    .yatra-pill.pay-pending { background: #FBE7E4; color: var(--clr-rose); }

    .yatra-amount { font-weight: 800; color: var(--clr-maroon); }

    .yatra-actions { display: flex; align-items: center; gap: 6px; }
    .yatra-icon-btn {
        width: 32px; height: 32px;
        border-radius: 8px;
        border: 1px solid var(--clr-line);
        background: var(--clr-bg);
        color: var(--clr-ink-soft);
        display: inline-flex; align-items: center; justify-content: center;
        transition: all .15s ease;
        font-size: .82rem;
    }
    .yatra-icon-btn:hover { background: var(--clr-saffron-soft); color: var(--clr-maroon); border-color: var(--clr-saffron); }
    .yatra-icon-btn.danger:hover { background: var(--clr-rose-soft); color: var(--clr-rose); border-color: var(--clr-rose); }

    .yatra-dropdown { position: relative; }
    .yatra-dropdown-menu {
        display: none;
        position: absolute;
        right: 0; top: 38px;
        background: #fff;
        border: 1px solid var(--clr-line);
        border-radius: 10px;
        box-shadow: 0 12px 28px rgba(0,0,0,.12);
        min-width: 175px;
        z-index: 20;
        overflow: hidden;
        padding: 6px;
    }
    .yatra-dropdown-menu.show { display: block; }
    .yatra-dropdown-menu button, .yatra-dropdown-menu a {
        display: flex; align-items: center; gap: 9px;
        width: 100%;
        border: none; background: none;
        padding: 9px 10px;
        font-size: .83rem;
        border-radius: 7px;
        color: var(--clr-ink);
        text-align: left;
    }
    .yatra-dropdown-menu button:hover, .yatra-dropdown-menu a:hover { background: var(--clr-bg); }
    .yatra-dropdown-menu .text-danger-item { color: var(--clr-rose); }
    .yatra-dropdown-menu .divider { height: 1px; background: var(--clr-line); margin: 5px 2px; }

    .yatra-footer {
        padding: 14px 22px;
        text-align: center;
        color: var(--clr-ink-soft);
        font-size: .82rem;
        border-top: 1px solid var(--clr-line);
    }

    .yatra-empty {
        padding: 60px 20px;
        text-align: center;
    }
    .yatra-empty i { font-size: 2.4rem; color: var(--clr-saffron); }
    .yatra-empty h4 { font-family: 'Cormorant Garamond', serif; font-weight: 700; margin: 14px 0 4px; }
    .yatra-empty p { color: var(--clr-ink-soft); margin-bottom: 18px; }

    .yatra .alert-success {
        margin: 20px 36px 0;
        border-radius: 12px;
        border: none;
        background: var(--clr-teal-soft);
        color: var(--clr-teal);
        font-weight: 600;
    }

    @media (max-width: 991px) {
        .yatra-stats { grid-template-columns: repeat(2, 1fr); }
        .yatra-hero, .yatra-card { margin-left: 16px; margin-right: 16px; }
        .yatra-hero { padding: 26px 20px 40px; }
        .yatra-card { margin-left: 16px; margin-right: 16px; }
    }
    @media (max-width: 575px) {
        .yatra-stats { grid-template-columns: 1fr; padding: 0 16px; }
        .yatra-toolbar { flex-direction: column; align-items: stretch; }
        .yatra-search { width: 100%; }
    }
</style>

<div class="yatra">

    <div class="yatra-hero">
        <div class="yatra-hero__top">
            <div>
                <ol class="yatra-breadcrumb">
                    <li><a href="{{ route('dashboard') }}">Home</a></li>
                    <li>Bookings</li>
                </ol>
                <h1>Yatra Bookings</h1>
                <p class="tagline">Every group, every pilgrim, every journey — in one place.</p>
            </div>
            <a href="{{ route('admin.bookings.create') }}" class="yatra-btn-new">
                <i class="fas fa-plus-circle"></i> New Booking
            </a>
        </div>
        <div class="yatra-garland"></div>
    </div>

    <div class="yatra-stats">
        <div class="yatra-stat">
            <div class="yatra-stat__icon"><i class="fas fa-calendar-check"></i></div>
            <div>
                <div class="yatra-stat__num">{{ $bookings->count() }}</div>
                <div class="yatra-stat__label">Total Bookings</div>
            </div>
        </div>
        <div class="yatra-stat confirmed">
            <div class="yatra-stat__icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="yatra-stat__num">{{ $bookings->where('status', 'completed')->count() }}</div>
                <div class="yatra-stat__label">Completed</div>
            </div>
        </div>
        <div class="yatra-stat pending">
            <div class="yatra-stat__icon"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="yatra-stat__num">{{ $bookings->where('status', 'pending')->count() }}</div>
                <div class="yatra-stat__label">Pending</div>
            </div>
        </div>
        <div class="yatra-stat revenue">
            <div class="yatra-stat__icon"><i class="fas fa-coins"></i></div>
            <div>
                <div class="yatra-stat__num">₹{{ number_format($bookings->sum('total_amount'), 0) }}</div>
                <div class="yatra-stat__label">Total Revenue</div>
            </div>
        </div>
    </div>

    @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="yatra-card">

        <div class="yatra-toolbar">
            <div class="yatra-search">
                <i class="fas fa-search"></i>
                <input type="text" id="yatraSearch" placeholder="Search group, person or email…">
            </div>
            <div class="yatra-filters" id="yatraFilters">
                <button type="button" class="yatra-filter active" data-status="">All</button>
                <button type="button" class="yatra-filter" data-status="Completed">Completed</button>
                <button type="button" class="yatra-filter" data-status="Pending">Pending</button>
                <button type="button" class="yatra-filter" data-status="Cancelled">Cancelled</button>
            </div>
        </div>

        @if($bookings->count() === 0)
            <div class="yatra-empty">
                <i class="fas fa-calendar-times"></i>
                <h4>No bookings yet</h4>
                <p>New bookings will show up here as soon as pilgrims register.</p>
                <a href="{{ route('admin.bookings.create') }}" class="yatra-btn-new">
                    <i class="fas fa-plus-circle"></i> Create the first booking
                </a>
            </div>
        @else
        <div class="table-responsive">
            <table id="bookingsTable" class="table">
                <thead>
                    <tr>
                        <th style="width: 4%">#</th>
                        <th style="width: 16%">Group</th>
                        <th style="width: 15%">Main Person</th>
                        <th style="width: 11%">Visit Date</th>
                        <th style="width: 8%">Pilgrims</th>
                        <th style="width: 10%">Amount</th>
                        <th style="width: 9%">Payment</th>
                        <th style="width: 9%">Status</th>
                        <th style="width: 8%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr>
                        <td><span class="text-muted">#{{ $booking->id }}</span></td>
                        <td><span class="yatra-group">{{ $booking->group_name }}</span></td>
                        <td>
                            <div class="yatra-person">
                                <div class="yatra-avatar">{{ strtoupper(substr($booking->main_person_name, 0, 1)) }}</div>
                                <div>
                                    {{ $booking->main_person_name }}
                                    <span class="yatra-sub">{{ $booking->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-calendar-day text-muted"></i>
                            {{ $booking->visiting_date->format('d M, Y') }}
                        </td>
                        <td>
                            <span class="yatra-pill status-completed" style="background:var(--clr-saffron-soft);color:var(--clr-maroon);">
                                <i class="fas fa-users"></i> {{ $booking->pilgrims->count() }}
                            </span>
                        </td>
                        <td><span class="yatra-amount">₹{{ number_format($booking->total_amount, 2) }}</span></td>
                        <td>
                            @if($booking->payment_status === 'confirmed')
                                <span class="yatra-pill pay-confirmed"><span class="dot"></span> Confirmed</span>
                            @else
                                <span class="yatra-pill pay-pending"><span class="dot"></span> Pending</span>
                            @endif
                        </td>
                        <td>
                            @if($booking->status === 'completed')
                                <span class="yatra-pill status-completed"><span class="dot"></span> Completed</span>
                            @elseif($booking->status === 'pending')
                                <span class="yatra-pill status-pending"><span class="dot"></span> Pending</span>
                            @else
                                <span class="yatra-pill status-cancelled"><span class="dot"></span> Cancelled</span>
                            @endif
                        </td>
                        <td>
                            <div class="yatra-actions">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="yatra-icon-btn" title="View" data-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <div class="yatra-dropdown">
                                    <button type="button" class="yatra-icon-btn" onclick="yatraToggleMenu(this)" title="More actions">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="yatra-dropdown-menu">
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}">
                                            <i class="fas fa-edit text-muted"></i> Edit booking
                                        </a>
                                        <button type="button" onclick="openPdfPreview({{ $booking->id }})">
                                            <i class="fas fa-file-pdf text-muted"></i> Preview ticket PDF
                                        </button>
                                        <div class="divider"></div>
                                        <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" {{ $booking->status === 'completed' ? 'disabled' : '' }}>
                                                <i class="fas fa-check text-muted"></i> Mark as completed
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" {{ $booking->status === 'cancelled' ? 'disabled' : '' }}>
                                                <i class="fas fa-times text-muted"></i> Cancel booking
                                            </button>
                                        </form>
                                        <div class="divider"></div>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Delete this booking permanently?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger-item">
                                                <i class="fas fa-trash"></i> Delete booking
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="yatra-footer">
            Showing {{ $bookings->count() }} {{ Str::plural('booking', $bookings->count()) }}
        </div>
        @endif
    </div>
</div>

<!-- PDF Preview Modal -->
<div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: var(--clr-maroon, #7A2E2E); color: #fff; border: none;">
                <h5 class="modal-title" id="pdfPreviewModalLabel"><i class="fas fa-file-pdf"></i> Booking Ticket Preview</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" style="height: 80vh;">
                <iframe id="pdfPreviewFrame" src="" style="width: 100%; height: 100%; border: 0;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="pdfDownloadLink" href="#" class="btn btn-success" target="_blank">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openPdfPreview(bookingId) {
    const previewUrl = '{{ route('admin.bookings.download-pdf', ['booking' => '__bookingId__']) }}'.replace('__bookingId__', bookingId);
    const downloadUrl = previewUrl + '?download=1';

    $('#pdfPreviewFrame').attr('src', previewUrl);
    $('#pdfDownloadLink').attr('href', downloadUrl);
    $('#pdfPreviewModal').modal('show');
}

function yatraToggleMenu(btn) {
    const menu = btn.nextElementSibling;
    const isOpen = menu.classList.contains('show');
    document.querySelectorAll('.yatra-dropdown-menu.show').forEach(m => m.classList.remove('show'));
    if (!isOpen) menu.classList.add('show');
}
document.addEventListener('click', function (e) {
    if (!e.target.closest('.yatra-dropdown')) {
        document.querySelectorAll('.yatra-dropdown-menu.show').forEach(m => m.classList.remove('show'));
    }
});

$(function() {
    $('[data-toggle="tooltip"]').tooltip();

    const table = $('#bookingsTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10,
        "order": [[0, "desc"]],
        "dom": '<"d-none"lf>rtip', // hide default search/length UI, we use our own toolbar
        "columnDefs": [
            { "targets": [8], "orderable": false, "searchable": false }
        ],
        "language": {
            "paginate": {
                "first": '<i class="fas fa-step-backward"></i>',
                "last": '<i class="fas fa-step-forward"></i>',
                "next": '<i class="fas fa-chevron-right"></i>',
                "previous": '<i class="fas fa-chevron-left"></i>'
            }
        }
    });

    // custom search box
    $('#yatraSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    // status filter pills (column index 7 = Status)
    $('#yatraFilters .yatra-filter').on('click', function () {
        $('#yatraFilters .yatra-filter').removeClass('active');
        $(this).addClass('active');
        const status = $(this).data('status');
        table.column(7).search(status ? status : '', true, false).draw();
    });
});
</script>
@endsection