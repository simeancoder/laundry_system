<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerController extends Controller
{
    /**
     * Get initial baseline mock data matching the screenshot exactly.
     */
    protected function getBaselineCustomers()
    {
        return [
            [
                'id' => 1,
                'customer_id' => 'C0001',
                'name' => 'Sokha Dara',
                'phone' => '012 345 678',
                'email' => 'sokha@example.com',
                'address' => 'Svay Dangkum, SR',
                'tier' => 'GOLD',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-08-01',
                'orders' => [
                    ['id' => 1, 'order_number' => '#ORD-0001', 'service_type' => 'Wash & Fold', 'status' => 'Delivered', 'order_date' => '2025-09-15', 'total_amount' => 12.50],
                    ['id' => 2, 'order_number' => '#ORD-0002', 'service_type' => 'Wash Only', 'status' => 'Delivered', 'order_date' => '2025-09-10', 'total_amount' => 8.00],
                    ['id' => 3, 'order_number' => '#ORD-0003', 'service_type' => 'Dry Cleaning', 'status' => 'Ready for Pickup', 'order_date' => '2025-09-05', 'total_amount' => 25.00],
                    ['id' => 4, 'order_number' => '#ORD-0004', 'service_type' => 'Wash & Fold', 'status' => 'Delivered', 'order_date' => '2025-08-28', 'total_amount' => 15.00],
                    ['id' => 5, 'order_number' => '#ORD-0005', 'service_type' => 'Ironing', 'status' => 'Completed', 'order_date' => '2025-08-09', 'total_amount' => 6.50],
                ]
            ],
            [
                'id' => 2,
                'customer_id' => 'C0002',
                'name' => 'Chan Sreyneath',
                'phone' => '011 234 567',
                'email' => 'sreyneath@example.com',
                'address' => 'Taphul, SR',
                'tier' => 'SILVER',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-08-05',
                'orders' => [
                    ['id' => 6, 'order_number' => '#ORD-0006', 'service_type' => 'Dry Cleaning', 'status' => 'Delivered', 'order_date' => '2025-09-12', 'total_amount' => 30.00],
                    ['id' => 7, 'order_number' => '#ORD-0007', 'service_type' => 'Wash & Fold', 'status' => 'Completed', 'order_date' => '2025-09-01', 'total_amount' => 14.00],
                ]
            ],
            [
                'id' => 3,
                'customer_id' => 'C0003',
                'name' => 'Heng Chana',
                'phone' => '017 890 123',
                'email' => 'channa@example.com',
                'address' => 'Sala Kamreuk, SR',
                'tier' => 'BRONZE',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-08-10',
                'orders' => [
                    ['id' => 8, 'order_number' => '#ORD-0008', 'service_type' => 'Wash Only', 'status' => 'Delivered', 'order_date' => '2025-09-11', 'total_amount' => 9.50],
                    ['id' => 9, 'order_number' => '#ORD-0009', 'service_type' => 'Ironing', 'status' => 'Completed', 'order_date' => '2025-08-20', 'total_amount' => 7.00],
                ]
            ],
            [
                'id' => 4,
                'customer_id' => 'C0004',
                'name' => 'Kim Sovannary',
                'phone' => '015 678 901',
                'email' => 'sovannary@example.com',
                'address' => 'Svay Dangkum, SR',
                'tier' => 'GOLD',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-08-14',
                'orders' => [
                    ['id' => 10, 'order_number' => '#ORD-0010', 'service_type' => 'Wash & Fold', 'status' => 'Ready for Pickup', 'order_date' => '2025-09-18', 'total_amount' => 18.00],
                    ['id' => 11, 'order_number' => '#ORD-0011', 'service_type' => 'Dry Cleaning', 'status' => 'Delivered', 'order_date' => '2025-09-03', 'total_amount' => 22.00],
                ]
            ],
            [
                'id' => 5,
                'customer_id' => 'C0005',
                'name' => 'Neang Pheaktra',
                'phone' => '010 555 888',
                'email' => 'pheaktra@example.com',
                'address' => 'Kok Chork, SR',
                'tier' => 'REGULAR',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-08-18',
                'orders' => [
                    ['id' => 12, 'order_number' => '#ORD-0012', 'service_type' => 'Wash Only', 'status' => 'Delivered', 'order_date' => '2025-09-14', 'total_amount' => 10.00],
                ]
            ],
            [
                'id' => 6,
                'customer_id' => 'C0006',
                'name' => 'Lim Vannak',
                'phone' => '016 222 333',
                'email' => 'vannak@example.com',
                'address' => 'National Road 6, SR',
                'tier' => 'SILVER',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-08-22',
                'orders' => [
                    ['id' => 13, 'order_number' => '#ORD-0013', 'service_type' => 'Wash & Fold', 'status' => 'Delivered', 'order_date' => '2025-09-16', 'total_amount' => 16.50],
                    ['id' => 14, 'order_number' => '#ORD-0014', 'service_type' => 'Ironing', 'status' => 'Completed', 'order_date' => '2025-09-02', 'total_amount' => 8.00],
                ]
            ],
            [
                'id' => 7,
                'customer_id' => 'C0007',
                'name' => 'Thon Sreynich',
                'phone' => '092 777 666',
                'email' => 'sreynich@example.com',
                'address' => 'Taphul, SR',
                'tier' => 'REGULAR',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-08-26',
                'orders' => [
                    ['id' => 15, 'order_number' => '#ORD-0015', 'service_type' => 'Dry Cleaning', 'status' => 'Delivered', 'order_date' => '2025-09-09', 'total_amount' => 28.00],
                ]
            ],
            [
                'id' => 8,
                'customer_id' => 'C0008',
                'name' => 'Pich Sothy',
                'phone' => '012 999 444',
                'email' => 'sothy@example.com',
                'address' => 'Sla Kram, SR',
                'tier' => 'GOLD',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-08-30',
                'orders' => [
                    ['id' => 16, 'order_number' => '#ORD-0016', 'service_type' => 'Wash & Fold', 'status' => 'Delivered', 'order_date' => '2025-09-17', 'total_amount' => 20.00],
                    ['id' => 17, 'order_number' => '#ORD-0017', 'service_type' => 'Dry Cleaning', 'status' => 'Ready for Pickup', 'order_date' => '2025-09-04', 'total_amount' => 35.00],
                ]
            ],
            [
                'id' => 9,
                'customer_id' => 'C0009',
                'name' => 'Chea Ratanak',
                'phone' => '097 333 222',
                'email' => 'ratanak@example.com',
                'address' => 'Bakheng, SR',
                'tier' => 'BRONZE',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-09-02',
                'orders' => [
                    ['id' => 18, 'order_number' => '#ORD-0018', 'service_type' => 'Wash Only', 'status' => 'Delivered', 'order_date' => '2025-09-13', 'total_amount' => 11.00],
                ]
            ],
            [
                'id' => 10,
                'customer_id' => 'C0010',
                'name' => 'Va Sovan',
                'phone' => '099 666 777',
                'email' => 'sovan@example.com',
                'address' => 'Tor Ang, SR',
                'tier' => 'REGULAR',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-09-05',
                'orders' => [
                    ['id' => 19, 'order_number' => '#ORD-0019', 'service_type' => 'Ironing', 'status' => 'Completed', 'order_date' => '2025-09-07', 'total_amount' => 7.50],
                ]
            ],
            [
                'id' => 11,
                'customer_id' => 'C0011',
                'name' => 'Keo Bopha',
                'phone' => '070 123 456',
                'email' => 'bopha@example.com',
                'address' => 'Wat Bo, SR',
                'tier' => 'SILVER',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-09-08',
                'orders' => [
                    ['id' => 20, 'order_number' => '#ORD-0020', 'service_type' => 'Wash & Fold', 'status' => 'Delivered', 'order_date' => '2025-09-10', 'total_amount' => 13.00],
                ]
            ],
            [
                'id' => 12,
                'customer_id' => 'C0012',
                'name' => 'Seng Samnang',
                'phone' => '088 456 789',
                'email' => 'samnang@example.com',
                'address' => 'Kouk Chak, SR',
                'tier' => 'GOLD',
                'status' => 'Active',
                'avatar' => null,
                'registration_date' => '2025-09-12',
                'orders' => [
                    ['id' => 21, 'order_number' => '#ORD-0021', 'service_type' => 'Dry Cleaning', 'status' => 'Delivered', 'order_date' => '2025-09-14', 'total_amount' => 32.00],
                ]
            ],
        ];
    }

    /**
     * Retrieve mock list from session or baseline.
     */
    protected function getSessionCustomers()
    {
        if (!session()->has('mock_customers')) {
            session(['mock_customers' => $this->getBaselineCustomers()]);
        }
        return session('mock_customers');
    }

    /**
     * Display a listing of customers with filtering, search, and selected profile.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $filter = $request->input('filter', 'All');
        $selectedId = $request->input('selected_id');
        $page = (int)$request->input('page', 1);
        $perPage = 10;

        $hasDb = false;
        try {
            $hasDb = Schema::hasTable('customers') && Customer::count() > 0;
        } catch (\Throwable $e) {
            $hasDb = false;
        }

        if ($hasDb) {
            $query = Customer::with('orders');

            if (!empty($search)) {
                $query->search($search);
            }

            if (!empty($filter) && $filter !== 'All' && $filter !== 'All Customers') {
                $query->filter($filter);
            }

            $totalCustomers = $query->count();
            $customers = $query->orderBy('customer_id', 'asc')
                               ->paginate($perPage)
                               ->appends($request->all());

            // Determine active/selected customer for the Aside panel
            $selectedCustomer = null;
            if ($selectedId) {
                $selectedCustomer = Customer::with('orders')->find($selectedId)
                    ?? Customer::with('orders')->where('customer_id', $selectedId)->first();
            }
            if (!$selectedCustomer && $customers->count() > 0) {
                $selectedCustomer = $customers->first();
            }
        } else {
            // Memory/Session collection fallback
            $allData = collect($this->getSessionCustomers());

            // Search
            if (!empty($search)) {
                $searchLower = strtolower($search);
                $allData = $allData->filter(function ($item) use ($searchLower) {
                    return str_contains(strtolower($item['customer_id']), $searchLower)
                        || str_contains(strtolower($item['name']), $searchLower)
                        || str_contains(strtolower($item['phone']), $searchLower)
                        || str_contains(strtolower($item['email']), $searchLower)
                        || str_contains(strtolower($item['address']), $searchLower);
                });
            }

            // Filter (All, Active, Inactive, GOLD, SILVER, BRONZE)
            if (!empty($filter) && $filter !== 'All' && $filter !== 'All Customers') {
                $filterUpper = strtoupper($filter);
                $allData = $allData->filter(function ($item) use ($filterUpper) {
                    return strtoupper($item['tier']) === $filterUpper
                        || strtoupper($item['status']) === $filterUpper;
                });
            }

            $totalCustomers = $allData->count();
            $offset = ($page - 1) * $perPage;
            $itemsForCurrentPage = $allData->slice($offset, $perPage)->values();

            $customers = new LengthAwarePaginator(
                $itemsForCurrentPage,
                $totalCustomers,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            // Determine active customer for aside
            $selectedCustomer = null;
            if ($selectedId) {
                $selectedCustomer = $allData->firstWhere('id', (int)$selectedId)
                    ?? $allData->firstWhere('customer_id', $selectedId);
            }
            if (!$selectedCustomer && $itemsForCurrentPage->count() > 0) {
                $selectedCustomer = $itemsForCurrentPage->first();
            }
        }

        // Return JSON if requested via AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'customers' => $customers,
                'selectedCustomer' => $selectedCustomer,
                'total' => $totalCustomers
            ]);
        }

        $customerView = view()->exists('customer') ? 'customer' : 'pages.customer';
        return view($customerView, [
            'customers' => $customers,
            'selectedCustomer' => $selectedCustomer,
            'totalCustomers' => $totalCustomers,
            'search' => $search,
            'currentFilter' => $filter,
            'hasDb' => $hasDb,
            'activeRole' => session('active_role', 'Admin'),
            'availableRoles' => [
                'Admin' => ['name' => 'Administrator', 'badge_bg' => 'bg-blue-100', 'badge_text' => 'text-blue-700', 'description' => 'Full System Access'],
                'Staff' => ['name' => 'Laundry Staff', 'badge_bg' => 'bg-emerald-100', 'badge_text' => 'text-emerald-700', 'description' => 'Operations & Washing'],
                'Delivery' => ['name' => 'Delivery Driver', 'badge_bg' => 'bg-purple-100', 'badge_text' => 'text-purple-700', 'description' => 'Logistics & Dispatch'],
                'Receptionist' => ['name' => 'Receptionist', 'badge_bg' => 'bg-amber-100', 'badge_text' => 'text-amber-700', 'description' => 'Front Desk & Orders'],
            ],
            'isDemoMode' => !$hasDb,
        ]);
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'tier' => 'nullable|string|in:GOLD,SILVER,BRONZE,REGULAR',
            'status' => 'nullable|string|in:Active,Inactive',
            'registration_date' => 'nullable|date',
        ]);

        $hasDb = false;
        try {
            $hasDb = Schema::hasTable('customers');
        } catch (\Throwable $e) {
            $hasDb = false;
        }

        $tier = $validated['tier'] ?? 'REGULAR';
        $status = $validated['status'] ?? 'Active';
        $registrationDate = $validated['registration_date'] ?? date('Y-m-d');

        $customer = null;
        $custId = $validated['customer_id'] ?? null;

        if ($hasDb) {
            try {
                if (empty($custId)) {
                    $nextNum = 1;
                    if (Schema::hasColumn('customers', 'id')) {
                        $lastCust = Customer::orderBy('id', 'desc')->first();
                        $nextNum = $lastCust ? ($lastCust->id + 1) : 1;
                    } elseif (Schema::hasColumn('customers', 'customer_id')) {
                        $lastCust = Customer::orderBy('customer_id', 'desc')->first();
                        if ($lastCust && preg_match('/(\d+)/', $lastCust->customer_id, $matches)) {
                            $nextNum = ((int)$matches[1]) + 1;
                        } else {
                            $nextNum = Customer::count() + 1;
                        }
                    }
                    $custId = 'C' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
                }

                $customer = Customer::create([
                    'customer_id' => $custId,
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'email' => $validated['email'],
                    'address' => $validated['address'],
                    'tier' => $tier,
                    'status' => $status,
                    'registration_date' => $registrationDate,
                ]);
            } catch (\Throwable $e) {
                \Log::warning("Customer DB store failed, falling back to session: " . $e->getMessage());
                $customer = null;
            }
        }

        // Always ensure customer exists in session mock data as well
        $list = $this->getSessionCustomers();
        $maxId = collect($list)->max('id') ?? 0;
        $newId = $customer && isset($customer->id) ? $customer->id : ($maxId + 1);
        if (empty($custId)) {
            $custId = 'C' . str_pad($newId, 4, '0', STR_PAD_LEFT);
        }

        $sessionRecord = [
            'id' => $newId,
            'customer_id' => $custId,
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'tier' => $tier,
            'status' => $status,
            'avatar' => null,
            'registration_date' => $registrationDate,
            'orders' => []
        ];

        array_unshift($list, $sessionRecord);
        session(['mock_customers' => $list]);

        $selectedKey = $customer ? ($customer->id ?? $customer->customer_id ?? $newId) : $newId;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Customer {$validated['name']} ({$custId}) registered successfully!",
                'customer' => $customer ?? $sessionRecord,
                'selected_id' => $selectedKey
            ]);
        }

        return redirect()->route('customers.index', ['selected_id' => $selectedKey])
                         ->with('success', "Customer {$validated['name']} ({$custId}) registered successfully!");
    }

    /**
     * Display the specified customer details (e.g. for profile drawer or AJAX).
     */
    public function show(Request $request, $id)
    {
        $hasDb = false;
        try {
            $hasDb = Schema::hasTable('customers');
        } catch (\Throwable $e) {
            $hasDb = false;
        }

        if ($hasDb) {
            $customer = Customer::with('orders')->find($id)
                ?? Customer::with('orders')->where('customer_id', $id)->first();
            
            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 404);
            }

            return response()->json([
                'success' => true,
                'customer' => $customer,
                'orders' => $customer->orders
            ]);
        } else {
            $list = $this->getSessionCustomers();
            $customer = collect($list)->firstWhere('id', (int)$id)
                ?? collect($list)->firstWhere('customer_id', $id);

            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 404);
            }

            return response()->json([
                'success' => true,
                'customer' => $customer,
                'orders' => $customer['orders'] ?? []
            ]);
        }
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'tier' => 'nullable|string|in:GOLD,SILVER,BRONZE,REGULAR',
            'status' => 'nullable|string|in:Active,Inactive',
            'registration_date' => 'nullable|date',
        ]);

        $hasDb = false;
        try {
            $hasDb = Schema::hasTable('customers');
        } catch (\Throwable $e) {
            $hasDb = false;
        }

        if ($hasDb) {
            try {
                $customer = null;
                if (Schema::hasColumn('customers', 'id')) {
                    $customer = Customer::find($id);
                }
                if (!$customer && Schema::hasColumn('customers', 'customer_id')) {
                    $customer = Customer::where('customer_id', $id)->first();
                }
                if ($customer) {
                    $customer->update($validated);
                }
            } catch (\Throwable $e) {
                \Log::warning("Customer DB update failed, continuing with session: " . $e->getMessage());
            }
        }

        // Always update in session mock data as well
        $list = $this->getSessionCustomers();
        $updated = false;

        foreach ($list as &$item) {
            if ($item['id'] == $id || $item['customer_id'] == $id) {
                $item['name'] = $validated['name'];
                $item['phone'] = $validated['phone'];
                $item['email'] = $validated['email'];
                $item['address'] = $validated['address'];
                if (isset($validated['tier'])) $item['tier'] = $validated['tier'];
                if (isset($validated['status'])) $item['status'] = $validated['status'];
                if (isset($validated['registration_date'])) $item['registration_date'] = $validated['registration_date'];
                $updated = true;
                break;
            }
        }
        unset($item);

        if ($updated) {
            session(['mock_customers' => $list]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Customer {$validated['name']} updated successfully!"
            ]);
        }

        return redirect()->route('customers.index', ['selected_id' => $id])
                         ->with('success', "Customer {$validated['name']} updated successfully!");
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Request $request, $id)
    {
        $hasDb = false;
        try {
            $hasDb = Schema::hasTable('customers');
        } catch (\Throwable $e) {
            $hasDb = false;
        }

        if ($hasDb) {
            try {
                $customer = null;
                if (Schema::hasColumn('customers', 'id')) {
                    $customer = Customer::find($id);
                }
                if (!$customer && Schema::hasColumn('customers', 'customer_id')) {
                    $customer = Customer::where('customer_id', $id)->first();
                }
                if ($customer) {
                    $customer->delete();
                }
            } catch (\Throwable $e) {
                \Log::warning("Customer DB delete failed: " . $e->getMessage());
            }
        }

        // Always delete from session mock data as well
        $list = $this->getSessionCustomers();
        $filtered = collect($list)->reject(function ($item) use ($id) {
            return $item['id'] == $id || $item['customer_id'] == $id;
        })->values()->all();

        session(['mock_customers' => $filtered]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Customer deleted successfully!",
                'id' => $id
            ]);
        }

        return redirect()->route('customers.index')
                         ->with('success', "Customer deleted successfully!");
    }

    /**
     * Get order history of a specific customer.
     */
    public function orders(Request $request, $id)
    {
        $hasDb = false;
        try {
            $hasDb = Schema::hasTable('customers');
        } catch (\Throwable $e) {
            $hasDb = false;
        }

        if ($hasDb) {
            $orders = CustomerOrder::where('customer_id', $id)->orderBy('order_date', 'desc')->get();
            return response()->json(['success' => true, 'orders' => $orders]);
        } else {
            $list = $this->getSessionCustomers();
            $customer = collect($list)->firstWhere('id', (int)$id)
                ?? collect($list)->firstWhere('customer_id', $id);
            $orders = $customer['orders'] ?? [];
            return response()->json(['success' => true, 'orders' => $orders]);
        }
    }
}
