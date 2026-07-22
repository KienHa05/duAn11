<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('is_admin', true)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.admin-users.index', compact('admins'));
    }

    public function update(Request $request, User $adminUser)
    {
        $request->validate([
            'role' => 'required|in:super_admin,product_manager,order_manager',
        ]);

        $adminUser->update([
            'role' => $request->role,
        ]);

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Vai trò đã được cập nhật thành công.');
    }
}
