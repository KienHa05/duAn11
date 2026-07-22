@extends('admin.layout')

@section('title', 'Quản lý tài khoản Admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Quản lý tài khoản Admin</h1>
            <p class="text-sm text-base-content/70">Quản trị vai trò cho từng tài khoản quản trị viên.</p>
        </div>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <span class="badge badge-outline">
                                    {{ str_replace('_', ' ', $admin->role ?: 'super_admin') }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.admin-users.update', $admin) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="select select-sm select-bordered">
                                        <option value="super_admin" {{ ($admin->role ?: 'super_admin') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                        <option value="product_manager" {{ ($admin->role ?: 'super_admin') === 'product_manager' ? 'selected' : '' }}>Product Manager</option>
                                        <option value="order_manager" {{ ($admin->role ?: 'super_admin') === 'order_manager' ? 'selected' : '' }}>Order Manager</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
