<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $range = $request->input('range', 'month');
        [$start, $end] = $this->dateRange($request, $range);

        $query = Booking::query()->visibleTo($user);
        $selectedAdmin = null;
        $admins = collect();

        if ($user->isSuperAdmin()) {
            $admins = User::whereHas('roles', fn ($role) => $role->whereIn('slug', ['admin', 'super-admin']))
                ->orderBy('name')->get(['id', 'name']);
            if ($request->filled('admin_id') && $admins->contains('id', (int) $request->admin_id)) {
                $selectedAdmin = (int) $request->admin_id;
                $query->where('created_by', $selectedAdmin);
            }
        }

        $query->whereBetween('created_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()]);
        $metrics = (clone $query)->selectRaw("COUNT(*) as bookings, COALESCE(SUM(CASE WHEN payment_status = 'confirmed' THEN total_amount ELSE 0 END), 0) as paid_amount, COALESCE(SUM(CASE WHEN payment_status = 'pending' THEN total_amount ELSE 0 END), 0) as unpaid_amount, COALESCE(SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END), 0) as completed, COALESCE(SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END), 0) as pending")->first();

        $recentBookings = (clone $query)->with(['pilgrims', 'creator'])->latest()->limit(8)->get();
        $chartRows = (clone $query)->selectRaw('DATE(created_at) as day, COALESCE(SUM(total_amount), 0) as amount, COUNT(*) as bookings')
            ->groupBy(DB::raw('DATE(created_at)'))->orderBy('day')->get();

        return view('admin.dashboard', [
            'metrics' => $metrics,
            'recentBookings' => $recentBookings,
            'chartLabels' => $chartRows->map(fn ($row) => Carbon::parse($row->day)->format('d M'))->values(),
            'chartAmounts' => $chartRows->pluck('amount')->map(fn ($amount) => (float) $amount)->values(),
            'chartBookings' => $chartRows->pluck('bookings')->map(fn ($count) => (int) $count)->values(),
            'range' => $range,
            'start' => $start,
            'end' => $end,
            'admins' => $admins,
            'selectedAdmin' => $selectedAdmin,
            'isSuperAdmin' => $user->isSuperAdmin(),
        ]);
    }

    private function dateRange(Request $request, string $range): array
    {
        $today = now();
        return match ($range) {
            'today' => [$today->copy(), $today->copy()],
            'week' => [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()],
            'last_month' => [$today->copy()->subMonthNoOverflow()->startOfMonth(), $today->copy()->subMonthNoOverflow()->endOfMonth()],
            'quarter' => [$today->copy()->subMonths(2)->startOfMonth(), $today->copy()->endOfMonth()],
            'custom' => [Carbon::parse($request->input('start', $today->toDateString())), Carbon::parse($request->input('end', $today->toDateString()))],
            default => [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()],
        };
    }
}
