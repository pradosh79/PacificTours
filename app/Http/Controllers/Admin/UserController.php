<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\RoleName;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(private readonly UserRepositoryInterface $users)
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request)
    {
        $type = $request->string('type', 'customers')->toString();

        $users = $type === 'staff'
            ? $this->users->staff($request->all())
            : $this->users->customers($request->all());

        return view('admin.users.index', compact('users', 'type') + [
            'roles' => Role::whereIn('name', RoleName::staff())->get(),
        ]);
    }

    public function show(User $user)
    {
        $user->load(['profile', 'roles'])
            ->loadCount('bookings')
            ->loadSum(['bookings' => fn ($q) => $q->revenueCounted()], 'grand_total');

        return view('admin.users.show', [
            'user'     => $user,
            'bookings' => $user->bookings()->with('tour:id,title')->latest('id')->limit(20)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['nullable', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'phone'      => ['nullable', 'string', 'max:32'],
            'password'   => ['required', 'confirmed', Password::min(10)->mixedCase()->numbers()],
            'role'       => ['required', Rule::in(array_merge(RoleName::staff(), [RoleName::Customer->value]))],
            'status'     => ['required', Rule::enum(UserStatus::class)],
        ]);

        $user = $this->users->create(array_merge(
            collect($data)->except('role')->toArray(),
            ['password' => Hash::make($data['password']), 'created_by' => auth()->id(), 'email_verified_at' => now()]
        ));

        $user->assignRole($data['role']);

        return back()->with('success', 'User created.');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['nullable', 'string', 'max:100'],
            'email'      => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone'      => ['nullable', 'string', 'max:32'],
            'status'     => ['required', Rule::enum(UserStatus::class)],
            'role'       => ['nullable', Rule::in(array_merge(RoleName::staff(), [RoleName::Customer->value]))],
            'password'   => ['nullable', 'confirmed', Password::min(10)->mixedCase()->numbers()],
        ]);

        $this->users->update($user, array_filter([
            ...collect($data)->except(['role', 'password'])->toArray(),
            'password' => filled($data['password'] ?? null) ? Hash::make($data['password']) : null,
        ], fn ($v) => $v !== null));

        if (filled($data['role'] ?? null)) {
            $user->syncRoles([$data['role']]);
        }

        return back()->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User deactivated.');
    }
}
