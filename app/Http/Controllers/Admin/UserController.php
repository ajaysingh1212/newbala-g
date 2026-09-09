<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function accessControl()
    {
        if (! auth()->user() || ! auth()->user()->isSuperAdmin()) {
            abort(403, 'Only super admin can view user access control.');
        }

        $users = User::with('roles')->get()->map(function ($user) {
            $user->login_history = DB::table('sessions')
                ->where('user_id', $user->id)
                ->orderByDesc('last_activity')
                ->get()
                ->map(function ($session) {
                    $session->last_activity_formatted = \Carbon\Carbon::createFromTimestamp((int) $session->last_activity)->format('d M Y, h:i A');
                    return $session;
                });

            return $user;
        });

        return view('admin.users.access-control', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'roles' => 'required|array',
            'max_devices' => 'required|integer|min:1|max:20',
            'allow_phone' => 'nullable|boolean',
            'allow_laptop' => 'nullable|boolean',
            'blocked_ips' => 'nullable|string',
        ]);

        if (auth()->check() && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'Only super admin can manage device access settings.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'max_devices' => (int) $request->max_devices,
            'allow_phone' => $request->boolean('allow_phone'),
            'allow_laptop' => $request->boolean('allow_laptop'),
            'blocked_ips' => $this->parseBlockedIps($request->input('blocked_ips')),
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User Created');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles' => 'required|array',
            'max_devices' => 'required|integer|min:1|max:20',
            'allow_phone' => 'nullable|boolean',
            'allow_laptop' => 'nullable|boolean',
            'blocked_ips' => 'nullable|string',
        ]);

        if (auth()->check() && ! auth()->user()->isSuperAdmin()) {
            abort(403, 'Only super admin can manage device access settings.');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'max_devices' => (int) $request->max_devices,
            'allow_phone' => $request->boolean('allow_phone'),
            'allow_laptop' => $request->boolean('allow_laptop'),
            'blocked_ips' => $this->parseBlockedIps($request->input('blocked_ips')),
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User Updated');
    }

    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User Deleted');
    }

    protected function parseBlockedIps(?string $rawIps): array
    {
        if ($rawIps === null || trim($rawIps) === '') {
            return [];
        }

        return collect(explode("\n", $rawIps))
            ->map(fn ($ip) => trim($ip))
            ->filter(fn ($ip) => $ip !== '')
            ->values()
            ->all();
    }
}
