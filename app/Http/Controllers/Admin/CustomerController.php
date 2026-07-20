<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(Request $request)
    {
        $query = User::where('is_admin', false);

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Display the specified customer.
     */
    public function show(User $customer)
    {
        if ($customer->is_admin) {
            return redirect()->route('admin.customers.index')->with('error', 'Không thể xem chi tiết quản trị viên từ màn hình này.');
        }

        // Load orders for this customer
        $customer->load(['orders' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Update customer (e.g. block/unblock, edit basic info)
     */
    public function update(Request $request, User $customer)
    {
        if ($customer->is_admin) {
            return redirect()->route('admin.customers.index')->with('error', 'Không thể chỉnh sửa quản trị viên từ màn hình này.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Thông tin khách hàng đã được cập nhật.');
    }
}
