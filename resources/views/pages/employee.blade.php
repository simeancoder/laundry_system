@extends('layouts.navbar')

@section('title', 'Employee Management - Laundry 6 Plus')

@section('header')
<header class="bg-white px-6 sm:px-8 py-3.5 sm:py-4 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)] rounded-b-2xl sm:rounded-b-3xl flex items-center justify-between z-30 sticky top-0 border-b border-gray-100">
    <!-- Left: Hamburger & Page Title/Subtitle -->
    <div class="flex items-center space-x-3 sm:space-x-4">
        <button type="button" onclick="toggleSidebar()" class="p-1.5 -ml-1 text-gray-800 hover:text-blue-600 hover:bg-gray-100 rounded-xl transition focus:outline-none cursor-pointer" title="Toggle Navigation Menu">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight leading-tight">Employee Management</h1>
            <p class="text-[12px] sm:text-[13px] text-gray-400 font-medium leading-none mt-1">Manage staff, roles, and shift attendance.</p>
        </div>
    </div>

    <!-- Right: Notification Bell & Admin Profile -->
    <div class="flex items-center space-x-3 sm:space-x-5">
        <a href="{{ route('notifications.index') }}" class="relative p-2 text-blue-600 hover:bg-blue-50 rounded-full transition focus:outline-none" title="Notifications">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-[#2563EB] rounded-full ring-2 ring-white"></span>
        </a>

        <div class="flex items-center space-x-2.5 pl-2 pr-2.5 py-1.5 rounded-full bg-gray-50 border border-gray-100">
            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <span class="text-sm font-bold text-gray-800">{{ Auth::check() ? Auth::user()->name : 'Admin' }}</span>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="p-6 sm:p-8 space-y-6 max-w-[1600px] mx-auto">
    <!-- FLASH ALERTS -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">&times;</button>
        </div>
    @endif

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm font-medium text-gray-400">Total Employees</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['total'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#2563EB] flex items-center justify-center text-xl shadow-xs">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm font-medium text-gray-400">Active Staff</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['active'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fa-solid fa-user-check"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm font-medium text-gray-400">On Leave</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['on_leave'] ?? 0 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm font-medium text-gray-400">Roles / Depts</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">{{ $stats['departments'] ?? 4 }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fa-solid fa-sitemap"></i>
            </div>
        </div>
    </div>

    <!-- CONTROLS & FILTER TOOLBAR -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('employees.index') }}" class="flex flex-wrap items-center gap-3 flex-1 max-w-3xl">
            <div class="relative flex-1 min-w-[280px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search ?? '' }}" 
                       placeholder="Search by name, ID, phone, email..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition shadow-sm">
            </div>

            <!-- Role Filter -->
            <select name="role" onchange="this.form.submit()" class="bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-700 shadow-sm focus:outline-none">
                <option value="">All Roles</option>
                <option value="Manager" {{ ($roleFilter ?? '') === 'Manager' ? 'selected' : '' }}>Manager</option>
                <option value="Receptionist" {{ ($roleFilter ?? '') === 'Receptionist' ? 'selected' : '' }}>Receptionist</option>
                <option value="Laundry Staff" {{ ($roleFilter ?? '') === 'Laundry Staff' ? 'selected' : '' }}>Laundry Staff</option>
                <option value="Presser" {{ ($roleFilter ?? '') === 'Presser' ? 'selected' : '' }}>Presser</option>
                <option value="Delivery Staff" {{ ($roleFilter ?? '') === 'Delivery Staff' ? 'selected' : '' }}>Delivery Staff</option>
            </select>

            <!-- Status Filter -->
            <select name="status" onchange="this.form.submit()" class="bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-700 shadow-sm focus:outline-none">
                <option value="">All Statuses</option>
                <option value="Active" {{ ($statusFilter ?? '') === 'Active' ? 'selected' : '' }}>Active</option>
                <option value="On Leave" {{ ($statusFilter ?? '') === 'On Leave' ? 'selected' : '' }}>On Leave</option>
                <option value="Inactive" {{ ($statusFilter ?? '') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" class="bg-[#2563EB] hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm transition flex items-center space-x-2 text-sm">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                <span>Search</span>
            </button>
        </form>

        <!-- Add Employee Button -->
        <button type="button" 
                onclick="openAddEmployeeModal()" 
                class="bg-[#2563EB] hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm transition flex items-center justify-center space-x-2 text-sm flex-shrink-0 cursor-pointer">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Add Employee</span>
        </button>
    </div>

    <!-- EMPLOYEE TABLE -->
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 tracking-tight">Staff Roster</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                    Total: {{ $stats['total'] ?? (is_countable($employees) ? count($employees) : 0) }}
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/75 border-b border-gray-100 text-xs font-semibold uppercase tracking-wider text-gray-500">
                        <th class="py-4 px-6">Employee</th>
                        <th class="py-4 px-6">ID</th>
                        <th class="py-4 px-6">Role</th>
                        <th class="py-4 px-6">Contact</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-blue-50/30 transition">
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-3.5">
                                <img src="{{ $emp->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($emp->name) . '&background=0D8ABC&color=fff' }}" 
                                     alt="{{ $emp->name }}" 
                                     class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                <div>
                                    <div class="font-bold text-gray-900">{{ $emp->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $emp->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 font-mono text-xs font-semibold text-gray-600">
                            {{ $emp->employee_id ?? ('EMP' . str_pad($emp->id, 3, '0', STR_PAD_LEFT)) }}
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $roleBadge = 'bg-blue-50 text-blue-700 border-blue-200';
                                if ($emp->role === 'Manager') $roleBadge = 'bg-purple-50 text-purple-700 border-purple-200';
                                elseif ($emp->role === 'Delivery Staff') $roleBadge = 'bg-amber-50 text-amber-700 border-amber-200';
                                elseif ($emp->role === 'Presser') $roleBadge = 'bg-teal-50 text-teal-700 border-teal-200';
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold border {{ $roleBadge }}">
                                {{ $emp->role }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2 text-gray-600">
                                <i class="fa-solid fa-phone text-xs text-gray-400"></i>
                                <span>{{ $emp->phone }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            @if(($emp->status ?? 'Active') === 'Active')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    Active
                                </span>
                            @elseif(($emp->status ?? '') === 'On Leave')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                    On Leave
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-1.5"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <button type="button" 
                                        onclick="openEditEmployeeModal({{ json_encode($emp) }})" 
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition cursor-pointer" 
                                        title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <form method="POST" action="{{ route('employees.destroy', $emp->id) }}" onsubmit="return confirm('Are you sure you want to remove this employee?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer" title="Delete">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400 font-medium">
                            <i class="fa-solid fa-user-slash text-3xl mb-3 text-gray-300 block"></i>
                            No employees found matching the criteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($employees, 'links'))
        <div class="p-6 border-t border-gray-100">
            {{ $employees->links() }}
        </div>
        @endif
    </div>
</div>

<!-- ADD EMPLOYEE MODAL -->
<div id="addEmployeeModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl animate-fade-in border border-gray-100">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">Add New Staff Member</h3>
            <button onclick="closeAddEmployeeModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mt-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Full Name</label>
                <input type="text" name="name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Email Address</label>
                <input type="email" name="email" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Role</label>
                    <select name="role" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none bg-white">
                        <option value="Laundry Staff">Laundry Staff</option>
                        <option value="Presser">Presser</option>
                        <option value="Receptionist">Receptionist</option>
                        <option value="Delivery Staff">Delivery Staff</option>
                        <option value="Manager">Manager</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none bg-white">
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Phone Number</label>
                <input type="text" name="phone" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Avatar Photo (optional)</label>
                <input type="file" name="avatar" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeAddEmployeeModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white text-sm font-medium shadow-sm">Save Employee</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT EMPLOYEE MODAL -->
<div id="editEmployeeModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl animate-fade-in border border-gray-100">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">Edit Employee</h3>
            <button onclick="closeEditEmployeeModal()" class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
        </div>

        <form id="editEmployeeForm" method="POST" enctype="multipart/form-data" class="space-y-4 mt-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Full Name</label>
                <input type="text" id="editEmpName" name="name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Email Address</label>
                <input type="email" id="editEmpEmail" name="email" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Role</label>
                    <select id="editEmpRole" name="role" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none bg-white">
                        <option value="Laundry Staff">Laundry Staff</option>
                        <option value="Presser">Presser</option>
                        <option value="Receptionist">Receptionist</option>
                        <option value="Delivery Staff">Delivery Staff</option>
                        <option value="Manager">Manager</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Status</label>
                    <select id="editEmpStatus" name="status" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none bg-white">
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Phone Number</label>
                <input type="text" id="editEmpPhone" name="phone" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Avatar Photo (optional)</label>
                <input type="file" name="avatar" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="flex items-center justify-end space-x-3 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeEditEmployeeModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#2563EB] hover:bg-blue-700 text-white text-sm font-medium shadow-sm">Update Employee</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddEmployeeModal() {
        document.getElementById('addEmployeeModal').classList.remove('hidden');
    }
    function closeAddEmployeeModal() {
        document.getElementById('addEmployeeModal').classList.add('hidden');
    }
    function openEditEmployeeModal(emp) {
        document.getElementById('editEmpName').value = emp.name || '';
        document.getElementById('editEmpEmail').value = emp.email || '';
        document.getElementById('editEmpRole').value = emp.role || 'Laundry Staff';
        document.getElementById('editEmpStatus').value = emp.status || 'Active';
        document.getElementById('editEmpPhone').value = emp.phone || '';
        document.getElementById('editEmployeeForm').action = '/employees/' + emp.id;
        document.getElementById('editEmployeeModal').classList.remove('hidden');
    }
    function closeEditEmployeeModal() {
        document.getElementById('editEmployeeModal').classList.add('hidden');
    }
</script>
@endsection
