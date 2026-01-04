<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // List of all available permissions in the system
    private $permissions = [
        'management' => [
            'product.view', 'product.create', 'product.edit', 'product.delete',
            'mitra.view', 'mitra.create', 'mitra.edit', 'mitra.delete',
            'portfolio.view', 'portfolio.create', 'portfolio.edit', 'portfolio.delete',
        ],
        'settings' => [
            'setting.view', 'setting.edit',
        ],
        'admin_access' => [
            'admin.view', 'admin.create', 'admin.edit', 'admin.delete',
            'role.view', 'role.create', 'role.edit', 'role.delete',
        ]
    ];

    public function index()
    {
        $roles = Role::withCount('admins')->latest()->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissions;
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array'
        ]);

        Role::create([
            'name' => $request->name,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dibuat');
    }

    public function edit(Role $role)
    {
        $permissions = $this->permissions;
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        // Prevent editing Super Admin permissions to avoid lockout
        if ($role->name === 'Super Admin') {
            return redirect()->back()->with('error', 'Super Admin role tidak bisa diedit secara manual.');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array'
        ]);

        $role->update([
            'name' => $request->name,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diperbarui');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()->back()->with('error', 'Super Admin tidak bisa dihapus.');
        }

        if ($role->admins()->count() > 0) {
            return redirect()->back()->with('error', 'Role ini masih digunakan oleh beberapa admin. Pindahkan mereka dulu.');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus');
    }
}
