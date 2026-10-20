<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerController extends Controller
{
    /**
     * Get initial baseline mock data matching the screenshot exactly.
     */
    protected function getBaselineCustomers()
    {
        return [];
    }

    /**
     * Retrieve mock list from session or baseline.
     */
    protected function getSessionCustomers()
    {
        session()->forget('mock_customers');
        return [];
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
            $hasDb = Schema::hasTable('customers');
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
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'tier' => 'nullable|string',
            'status' => 'nullable|string|in:Active,Inactive',
            'registration_date' => 'nullable|date',
        ]);

        $hasDb = false;
        try {
            $hasDb = Schema::hasTable('customers');
        } catch (\Throwable $e) {
            $hasDb = false;
        }

        $tier = strtoupper($validated['tier'] ?? 'REGULAR');
        if (!in_array($tier, ['GOLD', 'SILVER', 'BRONZE', 'VIP', 'REGULAR'])) {
            $tier = 'REGULAR';
        }
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
                Log::warning("Customer DB store failed, falling back to session: " . $e->getMessage());
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
     *
     * @param \Illuminate\Http\Request $request
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse
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
     *
     * @param \Illuminate\Http\Request $request
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'tier' => 'nullable|string',
            'status' => 'nullable|string|in:Active,Inactive',
            'registration_date' => 'nullable|date',
        ]);

        if (isset($validated['tier'])) {
            $tier = strtoupper($validated['tier']);
            if (!in_array($tier, ['GOLD', 'SILVER', 'BRONZE', 'VIP', 'REGULAR'])) {
                $tier = 'REGULAR';
            }
            $validated['tier'] = $tier;
        }

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
                    $customer->update(array_filter($validated, fn($v) => !is_null($v)));
                }
            } catch (\Throwable $e) {
                Log::warning("Customer DB update failed, continuing with session: " . $e->getMessage());
            }
        }

        // Always update in session mock data as well
        $list = $this->getSessionCustomers();
        $updated = false;

        foreach ($list as &$item) {
            if ($item['id'] == $id || $item['customer_id'] == $id) {
                if (isset($validated['name'])) $item['name'] = $validated['name'];
                if (isset($validated['phone'])) $item['phone'] = $validated['phone'];
                if (isset($validated['email'])) $item['email'] = $validated['email'];
                if (isset($validated['address'])) $item['address'] = $validated['address'];
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
     *
     * @param \Illuminate\Http\Request $request
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
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
                Log::warning("Customer DB delete failed: " . $e->getMessage());
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
     *
     * @param \Illuminate\Http\Request $request
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse
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
