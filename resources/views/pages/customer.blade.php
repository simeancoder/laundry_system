@extends('layouts.navbar')

@section('title', 'Customer Management - Laundry 6 Plus')

@section('header')
<header class="bg-white px-6 sm:px-8 py-3.5 sm:py-4 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.06)] rounded-b-2xl sm:rounded-b-3xl flex items-center justify-between z-30 sticky top-0 border-b border-gray-100">
    <!-- Left: Hamburger & Page Title/Subtitle -->
    <div class="flex items-center space-x-3 sm:space-x-4">
        <!-- Hamburger Button -->
        <button type="button" onclick="toggleSidebar()" class="p-1.5 -ml-1 text-gray-800 hover:text-blue-600 hover:bg-gray-100 rounded-xl transition focus:outline-none" title="Toggle Navigation Menu" aria-label="Toggle navigation menu">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight leading-tight">Customer Management</h1>
            <p class="text-[12px] sm:text-[13px] text-gray-400 font-medium leading-none mt-1">Manage your customers easily and efficiently.</p>
        </div>
    </div>

    <!-- Right: Notification Bell & Role Switcher User Profile -->
    <div class="flex items-center space-x-3 sm:space-x-5">
        <!-- Blue Notification Bell with Solid Dot -->
        <a href="{{ route('notifications.index') }}" class="relative p-2 text-blue-600 hover:bg-blue-50 rounded-full transition focus:outline-none" title="Notifications">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-[#2563EB] rounded-full ring-2 ring-white"></span>
        </a>

        <!-- User Role Switcher Dropdown Trigger -->
        <div class="relative" id="role-switcher-container">
            <button id="role-menu-button" type="button" onclick="toggleRoleMenu()" aria-haspopup="menu" aria-expanded="false" aria-controls="role-menu" class="flex items-center space-x-2.5 pl-2 pr-2.5 py-1.5 rounded-full hover:bg-gray-100 transition focus:outline-none cursor-pointer group">
                <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-200 group-hover:border-blue-400 transition-colors">
                    <i class="fa-solid fa-circle-user text-2xl text-[#2563EB]"></i>
                </div>
                <span class="text-sm sm:text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $activeRole ?? 'Admin' }}</span>
                <i id="role-chevron" class="fa-solid fa-chevron-down text-[11px] text-gray-500 transition-transform duration-200"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="role-menu" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 transform origin-top-right transition-all duration-150" role="menu" aria-labelledby="role-menu-button" tabindex="-1">
                <div class="px-4 py-2 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Active Role</p>
                        <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name ?? 'Admin User' }}</p>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full bg-blue-100 text-blue-700">
                        {{ $isDemoMode ?? false ? 'Demo Mode' : 'Role-Based' }}
                    </span>
                </div>

                <div class="py-1">
                    @foreach($availableRoles ?? ['Admin' => ['name' => 'Administrator', 'badge_bg' => 'bg-blue-100', 'badge_text' => 'text-blue-700', 'description' => 'Full System Access']] as $roleKey => $roleInfo)
                        @php
                            $isActive = (($activeRole ?? 'Admin') === $roleKey);
                        @endphp
                        <a href="{{ route('dashboard.switch-role', $roleKey) }}" 
                           class="role-menu-item flex items-center justify-between px-4 py-3 transition hover:bg-blue-50/60 {{ $isActive ? 'bg-blue-50/90 text-blue-700 font-semibold border-l-4 border-blue-600' : 'text-gray-700' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center {{ $roleInfo['badge_bg'] }} {{ $roleInfo['badge_text'] }}">
                                    <i class="fa-solid fa-shield-halved text-sm"></i>
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold leading-tight">{{ $roleInfo['name'] }}</div>
                                    <div class="text-[11px] text-gray-400 font-normal leading-tight mt-0.5">{{ $roleInfo['description'] }}</div>
                                </div>
                            </div>
                            @if($isActive)
                                <i class="fa-solid fa-check text-blue-600 text-sm"></i>
                            @endif
                        </a>
                    @endforeach
                </div>
                <div class="border-t border-gray-100 my-1"></div>
                <button type="button" onclick="openLogoutModal()" class="w-full flex items-center space-x-3 px-4 py-2.5 text-rose-600 hover:bg-rose-50 transition text-sm font-semibold cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket text-sm text-rose-500"></i>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="max-w-[1700px] mx-auto space-y-6">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-sm animate-fade-in">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 text-base leading-none">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between shadow-sm animate-fade-in">
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 text-base leading-none">&times;</button>
        </div>
    @endif

    <!-- CONTROLS & FILTER TOOLBAR -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <!-- Search & Filter Form (Left side) -->
        <form method="GET" action="{{ route('customers.index') }}" id="searchForm" class="flex flex-wrap items-center gap-3 flex-1 max-w-3xl">
            <!-- Search Input Box with Icon -->
            <div class="relative flex-1 min-w-[280px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </div>
                <input type="text" 
                       name="search" 
                       id="customerSearchInput"
                       value="{{ $search ?? '' }}" 
                       placeholder="Search by name, phone, email, customer ID..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition shadow-sm">
            </div>

            <!-- Blue Search Button -->
            <button type="submit" 
                    class="bg-[#2563EB] hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition flex items-center space-x-2 text-sm">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                <span>Search</span>
            </button>

            <!-- Filter Dropdown Trigger with Funnel Icon -->
            <div class="relative" id="filterDropdownContainer">
                <button type="button" 
                        onclick="toggleFilterDropdown()" 
                        class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium px-4 py-2.5 rounded-xl shadow-sm transition flex items-center space-x-2.5 text-sm focus:outline-none">
                    <i class="fa-solid fa-filter text-gray-800 text-xs"></i>
                    <span id="selectedFilterLabel">{{ $currentFilter && $currentFilter !== 'All' ? $currentFilter : 'All Customers' }}</span>
                    <i id="filterChevron" class="fa-solid fa-chevron-down text-[10px] text-gray-400 transition-transform"></i>
                </button>

                <!-- Filter Dropdown Menu -->
                <div id="filterDropdownMenu" class="hidden absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1.5 z-40 text-xs">
                    <a href="{{ route('customers.index', array_merge(request()->query(), ['filter' => 'All'])) }}" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 {{ ($currentFilter ?? 'All') === 'All' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 font-medium' }}">All Customers</a>
                    <a href="{{ route('customers.index', array_merge(request()->query(), ['filter' => 'Active'])) }}" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 {{ ($currentFilter ?? '') === 'Active' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 font-medium' }}">Active</a>
                    <a href="{{ route('customers.index', array_merge(request()->query(), ['filter' => 'Inactive'])) }}" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 {{ ($currentFilter ?? '') === 'Inactive' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 font-medium' }}">Inactive</a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <div class="px-4 py-1 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Customer Tier</div>
                    <a href="{{ route('customers.index', array_merge(request()->query(), ['filter' => 'GOLD'])) }}" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 {{ ($currentFilter ?? '') === 'GOLD' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 font-medium' }}">GOLD Tier</a>
                    <a href="{{ route('customers.index', array_merge(request()->query(), ['filter' => 'SILVER'])) }}" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 {{ ($currentFilter ?? '') === 'SILVER' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 font-medium' }}">SILVER Tier</a>
                    <a href="{{ route('customers.index', array_merge(request()->query(), ['filter' => 'BRONZE'])) }}" class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-600 {{ ($currentFilter ?? '') === 'BRONZE' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 font-medium' }}">BRONZE Tier</a>
                </div>
            </div>
        </form>

        <!-- Register Customer Button (Right side) -->
        <button type="button" 
                onclick="openRegisterModal()" 
                class="bg-[#2563EB] hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition flex items-center justify-center space-x-2 text-sm flex-shrink-0 cursor-pointer">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Register Customer</span>
        </button>
    </div>

    <!-- CUSTOMER LIST TABLE (Full Width) -->
    <div class="w-full bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-7 shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col justify-between">
        
        <!-- Table Header Section: Title & Total Badge -->
        <div class="flex items-center justify-between pb-5 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 tracking-tight">Customer List</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100/60">
                    Total: {{ $totalCustomers ?? count($customers) }}
                </span>
            </div>
            
            @if(!empty($search))
                <a href="{{ route('customers.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold flex items-center space-x-1">
                    <i class="fa-solid fa-xmark"></i>
                    <span>Clear Search</span>
                </a>
            @endif
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto mt-2">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="text-gray-400 font-semibold text-xs border-b border-gray-100">
                        <th class="py-3.5 px-3">#</th>
                        <th class="py-3.5 px-3">Customer ID</th>
                        <th class="py-3.5 px-3">Full Name</th>
                        <th class="py-3.5 px-3">Phone Number</th>
                        <th class="py-3.5 px-3">Email</th>
                        <th class="py-3.5 px-3">Address</th>
                        <th class="py-3.5 px-3">Registration Date</th>
                        <th class="py-3.5 px-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-normal">
                    @forelse($customers as $index => $customer)
                        @php
                            $item = is_array($customer) ? (object)$customer : $customer;
                            $rowNumber = (method_exists($customers, 'firstItem') && $customers->firstItem()) 
                                ? ($customers->firstItem() + $index) 
                                : ($index + 1);
                            $custOrders = is_array($item->orders ?? null) ? $item->orders : (isset($item->orders) ? $item->orders->toArray() : []);
                        @endphp
                        <tr id="row-customer-{{ $item->id }}" 
                            class="hover:bg-blue-50/40 transition-colors">
                            <!-- # -->
                            <td class="py-4 px-3 text-gray-400 font-medium text-xs">{{ $rowNumber }}</td>
                            
                            <!-- Customer ID -->
                            <td class="py-4 px-3 font-semibold text-gray-700 tracking-tight">{{ $item->customer_id }}</td>
                            
                            <!-- Full Name -->
                            <td class="py-4 px-3 font-bold text-gray-900 whitespace-nowrap">{{ $item->name }}</td>
                            
                            <!-- Phone Number -->
                            <td class="py-4 px-3 text-gray-600 font-medium whitespace-nowrap">{{ $item->phone }}</td>
                            
                            <!-- Email -->
                            <td class="py-4 px-3 text-gray-500 text-xs sm:text-sm">{{ $item->email }}</td>
                            
                            <!-- Address -->
                            <td class="py-4 px-3 text-gray-600 text-xs sm:text-sm max-w-[200px] truncate" title="{{ $item->address }}">
                                {{ $item->address }}
                            </td>
                            
                            <!-- Registration Date -->
                            <td class="py-4 px-3 text-gray-500 text-xs sm:text-sm whitespace-nowrap">
                                {{ is_string($item->registration_date) ? substr($item->registration_date, 0, 10) : $item->registration_date->format('Y-m-d') }}
                            </td>
                            
                            <!-- Action Buttons (Blue Eye: Profile, Green Pencil: Edit, Red Trash: Delete) -->
                            <td class="py-4 px-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <!-- Blue Eye (View Customer Profile Modal) -->
                                    <button type="button" 
                                            onclick="openCustomerProfileModal({{ json_encode($item) }}, {{ json_encode($custOrders) }})" 
                                            class="w-8 h-8 rounded-lg bg-[#2563EB] hover:bg-blue-700 text-white flex items-center justify-center transition shadow-sm cursor-pointer"
                                            title="View Customer Profile">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </button>

                                    <!-- Green Pencil (Edit Customer) -->
                                    <button type="button" 
                                            onclick="openEditModal({{ json_encode($item) }})" 
                                            class="w-8 h-8 rounded-lg bg-[#10B981] hover:bg-emerald-600 text-white flex items-center justify-center transition shadow-sm cursor-pointer"
                                            title="Edit Customer">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>

                                    <!-- Red Trash (Delete Customer) -->
                                    <button type="button" 
                                            onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->name) }}', '{{ $item->customer_id }}')" 
                                            class="w-8 h-8 rounded-lg bg-[#EF4444] hover:bg-rose-600 text-white flex items-center justify-center transition shadow-sm cursor-pointer"
                                            title="Delete Customer">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-users-slash text-4xl mb-3 text-gray-300"></i>
                                    <p class="font-medium text-gray-600">No customers found.</p>
                                    <p class="text-xs text-gray-400 mt-1">Try adjusting your search or filter criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Section -->
        <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
            <!-- Showing counter -->
            <div>
                @if(method_exists($customers, 'total'))
                    Showing <span class="font-semibold text-gray-900">{{ $customers->firstItem() ?? 0 }}</span> - 
                    <span class="font-semibold text-gray-900">{{ $customers->lastItem() ?? 0 }}</span> of 
                    <span class="font-semibold text-gray-900">{{ $customers->total() }}</span> customers
                @else
                    Showing <span class="font-semibold text-gray-900">1</span> - 
                    <span class="font-semibold text-gray-900">{{ count($customers) }}</span> of 
                    <span class="font-semibold text-gray-900">{{ $totalCustomers ?? count($customers) }}</span> customers
                @endif
            </div>

            <!-- Pagination Controls -->
            <div class="flex items-center space-x-1.5">
                @if(method_exists($customers, 'previousPageUrl') && $customers->previousPageUrl())
                    <a href="{{ $customers->previousPageUrl() }}" class="w-8 h-8 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 flex items-center justify-center text-gray-600 transition">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </a>
                @else
                    <span class="w-8 h-8 rounded-lg border border-gray-100 bg-gray-50 flex items-center justify-center text-gray-300 cursor-not-allowed">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </span>
                @endif

                @if(method_exists($customers, 'lastPage'))
                    @for($p = 1; $p <= $customers->lastPage(); $p++)
                        @if($p == $customers->currentPage())
                            <span class="w-8 h-8 rounded-lg bg-[#2563EB] text-white font-semibold flex items-center justify-center shadow-sm">
                                {{ $p }}
                            </span>
                        @else
                            <a href="{{ $customers->url($p) }}" class="w-8 h-8 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 font-medium text-gray-700 flex items-center justify-center transition">
                                {{ $p }}
                            </a>
                        @endif
                    @endfor
                @else
                    <span class="w-8 h-8 rounded-lg bg-[#2563EB] text-white font-semibold flex items-center justify-center shadow-sm">1</span>
                    <span class="w-8 h-8 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 font-medium text-gray-700 flex items-center justify-center transition">2</span>
                @endif

                @if(method_exists($customers, 'nextPageUrl') && $customers->nextPageUrl())
                    <a href="{{ $customers->nextPageUrl() }}" class="w-8 h-8 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 flex items-center justify-center text-gray-600 transition">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                @else
                    <span class="w-8 h-8 rounded-lg border border-gray-100 bg-gray-50 flex items-center justify-center text-gray-300 cursor-not-allowed">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </span>
                @endif
            </div>
        </div>

    </div>

</div>

<!-- ======================================================== -->
<!-- MODAL: CUSTOMER PROFILE MODAL (Matches User Image Exactly) -->
<!-- ======================================================== -->
<div id="customerProfileModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-gray-100 transform transition-all animate-fade-in relative">
        
        <!-- Header: Customer Profile Title & Close X Icon -->
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 tracking-tight">Customer Profile</h3>
            <button type="button" 
                    onclick="closeCustomerProfileModal()" 
                    class="p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer" 
                    title="Close">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Profile Summary (Avatar, Name, Badges, Phone, Email) -->
        <div class="flex items-center space-x-4 mt-5">
            <!-- Avatar Circle -->
            <div class="w-16 h-16 rounded-full bg-[#E0F2FE] border-2 border-white ring-2 ring-blue-100 flex items-center justify-center flex-shrink-0 text-blue-600 shadow-sm relative overflow-hidden">
                <img id="modalAvatarImg" 
                     src="https://api.dicebear.com/7.x/bottts/svg?seed=User&backgroundColor=b6e3f4" 
                     alt="Avatar" 
                     class="w-full h-full object-cover">
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-2 flex-wrap gap-y-1">
                    <h4 id="modalCustomerName" class="text-lg font-bold text-gray-900 truncate">
                        Sokha Dara
                    </h4>
                    <!-- Tier Badge (GOLD) -->
                    <span id="modalCustomerTier" class="text-[11px] font-bold px-2.5 py-0.5 rounded bg-[#DBEAFE] text-[#1D4ED8] tracking-wider uppercase">
                        GOLD
                    </span>
                    <!-- Status Badge (Active) -->
                    <span id="modalCustomerStatus" class="text-[11px] font-medium px-2.5 py-0.5 rounded-full bg-[#ECFDF5] text-[#059669] border border-emerald-100">
                        Active
                    </span>
                </div>

                <!-- Contact Details under avatar -->
                <div class="mt-1.5 space-y-0.5 text-xs text-gray-500 font-medium">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-phone text-[11px] text-gray-400 w-3.5"></i>
                        <span id="modalCustomerPhoneTop">012 345 678</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-envelope text-[11px] text-gray-400 w-3.5"></i>
                        <span id="modalCustomerEmailTop" class="truncate">sokha@example.com</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information Section -->
        <div class="mt-6 space-y-2.5">
            <h5 class="text-sm font-bold text-gray-900 tracking-tight">Customer Information</h5>
            
            <div class="space-y-2 text-xs">
                <!-- Customer ID -->
                <div class="flex items-center justify-between py-1">
                    <div class="flex items-center space-x-2.5 text-gray-500 font-medium">
                        <i class="fa-regular fa-id-card text-gray-400 w-4"></i>
                        <span>Customer ID</span>
                    </div>
                    <span id="modalCustomerId" class="font-bold text-gray-900 tracking-tight">C0001</span>
                </div>

                <!-- Full Name -->
                <div class="flex items-center justify-between py-1">
                    <div class="flex items-center space-x-2.5 text-gray-500 font-medium">
                        <i class="fa-regular fa-user text-gray-400 w-4"></i>
                        <span>Full Name</span>
                    </div>
                    <span id="modalCustomerFullName" class="font-semibold text-gray-800">Sokha Dara</span>
                </div>

                <!-- Phone Number -->
                <div class="flex items-center justify-between py-1">
                    <div class="flex items-center space-x-2.5 text-gray-500 font-medium">
                        <i class="fa-solid fa-phone text-gray-400 w-4"></i>
                        <span>Phone Number</span>
                    </div>
                    <span id="modalCustomerPhone" class="font-semibold text-gray-800">012 345 678</span>
                </div>

                <!-- Email -->
                <div class="flex items-center justify-between py-1">
                    <div class="flex items-center space-x-2.5 text-gray-500 font-medium">
                        <i class="fa-regular fa-envelope text-gray-400 w-4"></i>
                        <span>Email</span>
                    </div>
                    <span id="modalCustomerEmail" class="font-semibold text-gray-800 truncate max-w-[200px]">sokha@example.com</span>
                </div>

                <!-- Address -->
                <div class="flex items-center justify-between py-1">
                    <div class="flex items-center space-x-2.5 text-gray-500 font-medium">
                        <i class="fa-solid fa-location-dot text-gray-400 w-4"></i>
                        <span>Address</span>
                    </div>
                    <span id="modalCustomerAddress" class="font-semibold text-gray-800 text-right truncate max-w-[200px]">Svay Dongkum, Siem Reap</span>
                </div>

                <!-- Registration Date -->
                <div class="flex items-center justify-between py-1">
                    <div class="flex items-center space-x-2.5 text-gray-500 font-medium">
                        <i class="fa-regular fa-calendar text-gray-400 w-4"></i>
                        <span>Registration Date</span>
                    </div>
                    <span id="modalCustomerRegDate" class="font-bold text-gray-900">2025-08-01</span>
                </div>
            </div>
        </div>

        <!-- Order History Section -->
        <div class="mt-6">
            <div class="flex items-center justify-between mb-3">
                <h5 class="text-sm font-bold text-gray-900 tracking-tight">Order History</h5>
                <button type="button" 
                        onclick="openViewAllOrdersFromProfile()" 
                        class="text-xs font-semibold text-blue-600 hover:text-blue-800 cursor-pointer">
                    View All
                </button>
            </div>

            <!-- Order Cards Container -->
            <div id="modalOrdersContainer" class="space-y-2.5 max-h-[220px] overflow-y-auto pr-1">
                <!-- Populated dynamically via JS -->
            </div>
        </div>

        <!-- Bottom Action Buttons: Edit Customer (pencil) & Delete Customer (trash) -->
        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center space-x-3">
            <button type="button" 
                    id="modalEditBtn"
                    onclick="editCustomerFromProfile()" 
                    class="flex-1 py-2.5 px-3 border border-blue-200 bg-blue-50/70 hover:bg-blue-100 text-blue-600 text-xs font-semibold rounded-xl flex items-center justify-center space-x-1.5 transition cursor-pointer">
                <i class="fa-solid fa-pen text-xs"></i>
                <span>Edit Customer</span>
            </button>

            <button type="button" 
                    id="modalDeleteBtn"
                    onclick="deleteCustomerFromProfile()" 
                    class="flex-1 py-2.5 px-3 bg-[#EF4444] hover:bg-rose-600 text-white text-xs font-semibold rounded-xl flex items-center justify-center space-x-1.5 transition shadow-sm cursor-pointer">
                <i class="fa-solid fa-trash-can text-xs"></i>
                <span>Delete Customer</span>
            </button>
        </div>

    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 1: REGISTER CUSTOMER MODAL -->
<!-- ======================================================== -->
<div id="registerCustomerModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 transform transition-all">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-user-plus text-base"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Register New Customer</h3>
                    <p class="text-xs text-gray-400">Fill in the customer information below.</p>
                </div>
            </div>
            <button type="button" onclick="closeRegisterModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('customers.store') }}" class="mt-5 space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Customer ID -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Customer ID (Optional)</label>
                    <input type="text" name="customer_id" placeholder="Auto (e.g. C0013)" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>

                <!-- Registration Date -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Registration Date</label>
                    <input type="date" name="registration_date" value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
            </div>

            <!-- Full Name -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="e.g. Sokha Dara" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Phone Number -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" required placeholder="e.g. 012 345 678" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" required placeholder="e.g. sokha@example.com" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Address <span class="text-rose-500">*</span></label>
                <input type="text" name="address" required placeholder="e.g. Svay Dangkum, Siem Reap" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Tier -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Membership Tier</label>
                    <select name="tier" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        <option value="REGULAR">REGULAR</option>
                        <option value="BRONZE">BRONZE</option>
                        <option value="SILVER">SILVER</option>
                        <option value="GOLD" selected>GOLD</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Status</label>
                    <select name="status" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        <option value="Active" selected>Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                <button type="button" onclick="closeRegisterModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#2563EB] hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    Register Customer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 2: EDIT CUSTOMER MODAL -->
<!-- ======================================================== -->
<div id="editCustomerModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-gray-100 transform transition-all">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-user-pen text-base"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Update Customer Information</h3>
                    <p class="text-xs text-gray-400">Modify the customer's details below.</p>
                </div>
            </div>
            <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="editCustomerForm" method="POST" action="" class="mt-5 space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Customer ID (Read-only) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Customer ID</label>
                    <input type="text" id="editCustomerId" readonly class="w-full px-3.5 py-2.5 bg-gray-100 text-gray-500 border border-gray-200 rounded-xl text-sm cursor-not-allowed">
                </div>

                <!-- Registration Date -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Registration Date</label>
                    <input type="date" id="editRegistrationDate" name="registration_date" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
            </div>

            <!-- Full Name -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                <input type="text" id="editName" name="name" required class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Phone Number -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                    <input type="text" id="editPhone" name="phone" required class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" id="editEmail" name="email" required class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Address <span class="text-rose-500">*</span></label>
                <input type="text" id="editAddress" name="address" required class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Tier -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Membership Tier</label>
                    <select id="editTier" name="tier" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        <option value="REGULAR">REGULAR</option>
                        <option value="BRONZE">BRONZE</option>
                        <option value="SILVER">SILVER</option>
                        <option value="GOLD">GOLD</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Status</label>
                    <select id="editStatus" name="status" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#10B981] hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 3: DELETE CONFIRMATION MODAL -->
<!-- ======================================================== -->
<div id="deleteCustomerModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-gray-100 transform transition-all text-center">
        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        
        <h3 class="text-lg font-bold text-gray-900">Delete Customer?</h3>
        <p class="text-xs text-gray-500 mt-2">
            Are you sure you want to remove <strong id="deleteCustomerName" class="text-gray-800"></strong> (<span id="deleteCustomerIdSpan"></span>)?
            This will permanently remove their records and laundry order history.
        </p>

        <form id="deleteCustomerForm" method="POST" action="" class="mt-6 flex items-center justify-center space-x-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 px-4 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl transition">
                Cancel
            </button>
            <button type="submit" class="flex-1 py-2.5 px-4 bg-[#EF4444] hover:bg-rose-600 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                Yes, Delete
            </button>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 4: VIEW ALL ORDERS MODAL -->
<!-- ======================================================== -->
<div id="viewAllOrdersModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl border border-gray-100 transform transition-all">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-clipboard-list text-base"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">All Order History</h3>
                    <p id="viewAllOrdersSubtitle" class="text-xs text-gray-400">Order history for customer</p>
                </div>
            </div>
            <button type="button" onclick="closeViewAllOrdersModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="mt-4 max-h-[400px] overflow-y-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="text-gray-400 font-semibold border-b border-gray-100">
                        <th class="py-2.5 px-3">Order Number</th>
                        <th class="py-2.5 px-3">Date</th>
                        <th class="py-2.5 px-3">Service Type</th>
                        <th class="py-2.5 px-3">Amount</th>
                        <th class="py-2.5 px-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody id="viewAllOrdersTableBody" class="divide-y divide-gray-50">
                    <!-- Populated dynamically via JS -->
                </tbody>
            </table>
        </div>

        <div class="pt-4 border-t border-gray-100 text-right">
            <button type="button" onclick="closeViewAllOrdersModal()" class="px-5 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                Close
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // State tracking current customer selected
    let currentCustomerData = null;
    let currentCustomerOrders = [];

    // 1. OPEN CUSTOMER PROFILE MODAL (When clicking Eye icon in Action column)
    function openCustomerProfileModal(customer, orders) {
        currentCustomerData = customer;
        currentCustomerOrders = orders || (customer && customer.orders ? customer.orders : []);

        const modal = document.getElementById('customerProfileModal');
        if (!modal) return;

        // Avatar
        const avatarEl = document.getElementById('modalAvatarImg');
        if (avatarEl) {
            avatarEl.src = `https://api.dicebear.com/7.x/bottts/svg?seed=${encodeURIComponent(customer.name)}&backgroundColor=b6e3f4`;
        }

        // Header basic info
        document.getElementById('modalCustomerName').innerText = customer.name || 'N/A';
        document.getElementById('modalCustomerPhoneTop').innerText = customer.phone || 'N/A';
        document.getElementById('modalCustomerEmailTop').innerText = customer.email || 'N/A';

        // Badges
        const tierEl = document.getElementById('modalCustomerTier');
        if (tierEl) tierEl.innerText = (customer.tier || 'REGULAR').toUpperCase();

        const statusEl = document.getElementById('modalCustomerStatus');
        if (statusEl) {
            statusEl.innerText = customer.status || 'Active';
            if (customer.status === 'Inactive') {
                statusEl.className = 'text-[11px] font-medium px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-600 border border-gray-200';
            } else {
                statusEl.className = 'text-[11px] font-medium px-2.5 py-0.5 rounded-full bg-[#ECFDF5] text-[#059669] border border-emerald-100';
            }
        }

        // Detailed Customer Information
        document.getElementById('modalCustomerId').innerText = customer.customer_id || 'N/A';
        document.getElementById('modalCustomerFullName').innerText = customer.name || 'N/A';
        document.getElementById('modalCustomerPhone').innerText = customer.phone || 'N/A';
        document.getElementById('modalCustomerEmail').innerText = customer.email || 'N/A';
        document.getElementById('modalCustomerAddress').innerText = customer.address || 'N/A';
        
        const rawDate = customer.registration_date || '';
        document.getElementById('modalCustomerRegDate').innerText = typeof rawDate === 'string' ? rawDate.substring(0, 10) : rawDate;

        // Render Order History list in Modal
        renderModalOrders(currentCustomerOrders);

        // Highlight selected row in table
        document.querySelectorAll('tbody tr').forEach(tr => tr.classList.remove('bg-blue-50/40'));
        const row = document.getElementById(`row-customer-${customer.id}`);
        if (row) row.classList.add('bg-blue-50/40');

        modal.classList.remove('hidden');
    }

    function closeCustomerProfileModal() {
        const modal = document.getElementById('customerProfileModal');
        if (modal) modal.classList.add('hidden');
    }

    function editCustomerFromProfile() {
        if (currentCustomerData) {
            closeCustomerProfileModal();
            openEditModal(currentCustomerData);
        }
    }

    function deleteCustomerFromProfile() {
        if (currentCustomerData) {
            closeCustomerProfileModal();
            openDeleteModal(currentCustomerData.id, currentCustomerData.name, currentCustomerData.customer_id);
        }
    }

    function openViewAllOrdersFromProfile() {
        closeCustomerProfileModal();
        openViewAllOrdersModal();
    }

    // Helper to render order history cards in profile modal
    function renderModalOrders(orders) {
        const container = document.getElementById('modalOrdersContainer');
        if (!container) return;

        if (!orders || orders.length === 0) {
            container.innerHTML = `
                <div class="p-4 text-center text-gray-400 text-xs bg-gray-50 rounded-2xl border border-gray-100">
                    No orders found for this customer.
                </div>
            `;
            return;
        }

        container.innerHTML = orders.map(ord => {
            let statusStyle = 'bg-emerald-50 text-emerald-600 border-emerald-100';
            if (ord.status === 'Ready for Pickup') {
                statusStyle = 'bg-amber-50 text-amber-600 border-amber-100';
            } else if (ord.status === 'Completed') {
                statusStyle = 'bg-teal-50 text-teal-600 border-teal-100';
            } else if (ord.status === 'In Progress' || ord.status === 'Processing') {
                statusStyle = 'bg-blue-50 text-blue-600 border-blue-100';
            }

            const dateStr = typeof ord.order_date === 'string' ? ord.order_date.substring(0, 10) : ord.order_date;

            return `
                <div class="p-3 bg-gray-50/70 hover:bg-gray-100/70 border border-gray-100 rounded-2xl transition flex items-center justify-between">
                    <div>
                        <div class="font-bold text-xs text-gray-900 tracking-tight">${ord.order_number}</div>
                        <div class="text-[11px] text-gray-400 mt-0.5">${dateStr}</div>
                    </div>
                    <div class="text-center font-medium text-xs text-gray-700">
                        ${ord.service_type}
                    </div>
                    <div>
                        <span class="px-2.5 py-1 text-[10px] font-semibold rounded-full border ${statusStyle}">
                            ${ord.status}
                        </span>
                    </div>
                </div>
            `;
        }).join('');
    }

    // 2. REGISTER CUSTOMER MODAL
    function openRegisterModal() {
        document.getElementById('registerCustomerModal').classList.remove('hidden');
    }
    function closeRegisterModal() {
        document.getElementById('registerCustomerModal').classList.add('hidden');
    }

    // 3. EDIT CUSTOMER MODAL (Pencil icon)
    function openEditModal(customer) {
        const modal = document.getElementById('editCustomerModal');
        const form = document.getElementById('editCustomerForm');
        
        form.action = `{{ url('/customers') }}/${customer.id}`;
        document.getElementById('editCustomerId').value = customer.customer_id || '';
        document.getElementById('editName').value = customer.name || '';
        document.getElementById('editPhone').value = customer.phone || '';
        document.getElementById('editEmail').value = customer.email || '';
        document.getElementById('editAddress').value = customer.address || '';
        document.getElementById('editTier').value = (customer.tier || 'REGULAR').toUpperCase();
        document.getElementById('editStatus').value = customer.status || 'Active';
        
        const rawDate = customer.registration_date || '';
        document.getElementById('editRegistrationDate').value = typeof rawDate === 'string' ? rawDate.substring(0, 10) : '';

        modal.classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editCustomerModal').classList.add('hidden');
    }

    // 4. DELETE CUSTOMER MODAL (Trash icon)
    function openDeleteModal(id, name, customerId) {
        const modal = document.getElementById('deleteCustomerModal');
        const form = document.getElementById('deleteCustomerForm');
        
        form.action = `{{ url('/customers') }}/${id}`;
        document.getElementById('deleteCustomerName').innerText = name;
        document.getElementById('deleteCustomerIdSpan').innerText = customerId;

        modal.classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteCustomerModal').classList.add('hidden');
    }

    // 5. VIEW ALL ORDERS MODAL
    function openViewAllOrdersModal() {
        const modal = document.getElementById('viewAllOrdersModal');
        const subtitle = document.getElementById('viewAllOrdersSubtitle');
        const tbody = document.getElementById('viewAllOrdersTableBody');

        if (currentCustomerData) {
            subtitle.innerText = `Order history for ${currentCustomerData.name} (${currentCustomerData.customer_id})`;
        }

        if (!currentCustomerOrders || currentCustomerOrders.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="py-6 text-center text-gray-400">No order history available.</td></tr>`;
        } else {
            tbody.innerHTML = currentCustomerOrders.map(ord => {
                let statusStyle = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                if (ord.status === 'Ready for Pickup') {
                    statusStyle = 'bg-amber-50 text-amber-600 border-amber-100';
                } else if (ord.status === 'Completed') {
                    statusStyle = 'bg-teal-50 text-teal-600 border-teal-100';
                } else if (ord.status === 'In Progress' || ord.status === 'Processing') {
                    statusStyle = 'bg-blue-50 text-blue-600 border-blue-100';
                }

                const dateStr = typeof ord.order_date === 'string' ? ord.order_date.substring(0, 10) : ord.order_date;
                const amt = ord.total_amount ? `$${parseFloat(ord.total_amount).toFixed(2)}` : '$0.00';

                return `
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-3 font-bold text-gray-900">${ord.order_number}</td>
                        <td class="py-3 px-3 text-gray-500">${dateStr}</td>
                        <td class="py-3 px-3 font-medium text-gray-700">${ord.service_type}</td>
                        <td class="py-3 px-3 font-semibold text-gray-900">${amt}</td>
                        <td class="py-3 px-3 text-center">
                            <span class="px-2.5 py-0.5 text-[10px] font-semibold rounded-full border ${statusStyle}">
                                ${ord.status}
                            </span>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        modal.classList.remove('hidden');
    }
    function closeViewAllOrdersModal() {
        document.getElementById('viewAllOrdersModal').classList.add('hidden');
    }

    // 6. FILTER DROPDOWN TOGGLE
    function toggleFilterDropdown() {
        const menu = document.getElementById('filterDropdownMenu');
        const chevron = document.getElementById('filterChevron');
        if (menu) {
            menu.classList.toggle('hidden');
            if (chevron) chevron.classList.toggle('rotate-180');
        }
    }

    // 7. ROLE MENU TOGGLE (Matching Dashboard)
    function toggleRoleMenu() {
        const menu = document.getElementById('role-menu');
        const chevron = document.getElementById('role-chevron');
        if (!menu) return;
        menu.classList.toggle('hidden');
        if (chevron) chevron.classList.toggle('rotate-180');
    }

    // Click outside handler for dropdowns and modal backdrops
    document.addEventListener('click', function(e) {
        // Filter dropdown
        const filterContainer = document.getElementById('filterDropdownContainer');
        const filterMenu = document.getElementById('filterDropdownMenu');
        const filterChevron = document.getElementById('filterChevron');
        if (filterContainer && !filterContainer.contains(e.target) && filterMenu && !filterMenu.classList.contains('hidden')) {
            filterMenu.classList.add('hidden');
            if (filterChevron) filterChevron.classList.remove('rotate-180');
        }

        // Role menu
        const roleContainer = document.getElementById('role-switcher-container');
        const roleMenu = document.getElementById('role-menu');
        const roleChevron = document.getElementById('role-chevron');
        if (roleContainer && !roleContainer.contains(e.target) && roleMenu && !roleMenu.classList.contains('hidden')) {
            roleMenu.classList.add('hidden');
            if (roleChevron) roleChevron.classList.remove('rotate-180');
        }

        // Modal backdrop click to close
        const profileModal = document.getElementById('customerProfileModal');
        if (profileModal && e.target === profileModal) {
            closeCustomerProfileModal();
        }
        const regModal = document.getElementById('registerCustomerModal');
        if (regModal && e.target === regModal) {
            closeRegisterModal();
        }
        const editModal = document.getElementById('editCustomerModal');
        if (editModal && e.target === editModal) {
            closeEditModal();
        }
        const deleteModal = document.getElementById('deleteCustomerModal');
        if (deleteModal && e.target === deleteModal) {
            closeDeleteModal();
        }
        const ordersModal = document.getElementById('viewAllOrdersModal');
        if (ordersModal && e.target === ordersModal) {
            closeViewAllOrdersModal();
        }
    });

    // Close modals on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCustomerProfileModal();
            closeRegisterModal();
            closeEditModal();
            closeDeleteModal();
            closeViewAllOrdersModal();
            if (typeof closeLogoutModal === 'function') {
                closeLogoutModal();
            }
        }
    });
</script>
@endpush
