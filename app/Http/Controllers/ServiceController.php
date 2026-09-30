<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceController extends Controller
{
    /**
     * Define the 9 official service types.
     */
    protected $serviceTypes = [
        'Wash Only',
        'Wash & Dry',
        'Wash, Dry & Fold',
        'Dry Cleaning',
        'Ironing',
        'Blanket Cleaning',
        'Curtain Cleaning',
        'Shoe Cleaning',
        'Carpet Cleaning'
    ];

    /**
     * Get baseline mock data matching the UI screenshot exactly.
     */
    protected function getBaselineServices()
    {
        return collect([
            (object)[
                'id' => 1,
                'service_id' => 1,
                'name' => 'Wash Only',
                'service_name' => 'Wash Only',
                'service_type' => 'Wash Only',
                'price' => 1.50,
                'price_per_kg' => 1.50,
                'price_per_item' => null,
                'estimated_time' => '1–2 days',
                'estimated_completion_hrs' => 24,
                'description' => 'Standard machine washing cycle using high-grade eco detergents.',
                'status' => 'Active',
            ],
            (object)[
                'id' => 2,
                'service_id' => 2,
                'name' => 'Wash & Dry',
                'service_name' => 'Wash & Dry',
                'service_type' => 'Wash & Dry',
                'price' => 2.50,
                'price_per_kg' => 2.50,
                'price_per_item' => null,
                'estimated_time' => '2–3 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Machine washing and full tumble drying with gentle fabric softener.',
                'status' => 'Active',
            ],
            (object)[
                'id' => 3,
                'service_id' => 3,
                'name' => 'Wash, Dry & Fold',
                'service_name' => 'Wash, Dry & Fold',
                'service_type' => 'Wash, Dry & Fold',
                'price' => 3.50,
                'price_per_kg' => 3.50,
                'price_per_item' => null,
                'estimated_time' => '2–3 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Complete laundry service: washed, tumble dried, and neatly crisply folded.',
                'status' => 'Active',
            ],
            (object)[
                'id' => 4,
                'service_id' => 4,
                'name' => 'Dry Cleaning',
                'service_name' => 'Dry Cleaning',
                'service_type' => 'Dry Cleaning',
                'price' => 4.00,
                'price_per_kg' => 4.00,
                'price_per_item' => null,
                'estimated_time' => '3–5 days',
                'estimated_completion_hrs' => 72,
                'description' => 'Eco-solvent dry cleaning for delicate fabrics, suits, blazers, and dresses.',
                'status' => 'Active',
            ],
            (object)[
                'id' => 5,
                'service_id' => 5,
                'name' => 'Ironing',
                'service_name' => 'Ironing',
                'service_type' => 'Ironing',
                'price' => 2.00,
                'price_per_kg' => 2.00,
                'price_per_item' => null,
                'estimated_time' => '1–2 days',
                'estimated_completion_hrs' => 24,
                'description' => 'Steam pressing and wrinkle-free ironing delivered on sturdy hangers.',
                'status' => 'Active',
            ],
            (object)[
                'id' => 6,
                'service_id' => 6,
                'name' => 'Blanket Cleaning',
                'service_name' => 'Blanket Cleaning',
                'service_type' => 'Blanket Cleaning',
                'price' => 2.80,
                'price_per_kg' => 2.80,
                'price_per_item' => null,
                'estimated_time' => '2–4 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Deep sanitization and washing for heavy blankets, comforters, and duvets.',
                'status' => 'Active',
            ],
            (object)[
                'id' => 7,
                'service_id' => 7,
                'name' => 'Curtain Cleaning',
                'service_name' => 'Curtain Cleaning',
                'service_type' => 'Curtain Cleaning',
                'price' => 3.00,
                'price_per_kg' => 3.00,
                'price_per_item' => null,
                'estimated_time' => '3–5 days',
                'estimated_completion_hrs' => 72,
                'description' => 'Professional dust removal, gentle steam wash and care for all curtain fabrics.',
                'status' => 'Active',
            ],
            (object)[
                'id' => 8,
                'service_id' => 8,
                'name' => 'Shoe Cleaning',
                'service_name' => 'Shoe Cleaning',
                'service_type' => 'Shoe Cleaning',
                'price' => 4.50,
                'price_per_kg' => 4.50,
                'price_per_item' => null,
                'estimated_time' => '2–4 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Meticulous deep scrubbing, stain extraction, and polishing for sneakers and shoes.',
                'status' => 'Active',
            ],
            (object)[
                'id' => 9,
                'service_id' => 9,
                'name' => 'Carpet Cleaning',
                'service_name' => 'Carpet Cleaning',
                'service_type' => 'Carpet Cleaning',
                'price' => 2.00,
                'price_per_kg' => 2.00,
                'price_per_item' => null,
                'estimated_time' => '2–4 days',
                'estimated_completion_hrs' => 48,
                'description' => 'Deep rug and carpet extraction shampooing, odor neutralization and sanitization.',
                'status' => 'Active',
            ],
        ]);
    }

    /**
     * Get detected table columns and primary key safely.
     */
    protected function getTableSchemaInfo()
    {
        $columns = [];
        $pk = 'service_id';
        $hasDb = false;

        try {
            if (Schema::hasTable('services')) {
                $columns = Schema::getColumnListing('services');
                if (in_array('service_id', $columns)) {
                    $pk = 'service_id';
                } elseif (in_array('id', $columns)) {
                    $pk = 'id';
                } elseif (!empty($columns)) {
                    $pk = $columns[0];
                }
                $hasDb = true;
            }
        } catch (\Throwable $e) {
            $hasDb = false;
        }

        return [$hasDb, $columns, $pk];
    }

    /**
     * Display a listing of services with search & filter.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $selectedType = trim($request->input('type', ''));

        list($hasDb, $columns, $pk) = $this->getTableSchemaInfo();

        $services = null;
        $totalServices = 0;

        if ($hasDb) {
            try {
                // If table is empty, auto-populate baseline services
                if (Service::count() === 0) {
                    $baseline = $this->getBaselineServices();
                    foreach ($baseline as $b) {
                        $payload = [];
                        if (in_array('name', $columns)) $payload['name'] = $b->name;
                        if (in_array('service_name', $columns)) $payload['service_name'] = $b->service_name;
                        if (in_array('service_type', $columns)) $payload['service_type'] = $b->service_type;
                        if (in_array('price', $columns)) $payload['price'] = $b->price;
                        if (in_array('price_per_kg', $columns)) $payload['price_per_kg'] = $b->price_per_kg;
                        if (in_array('price_per_item', $columns)) $payload['price_per_item'] = $b->price_per_item;
                        if (in_array('estimated_time', $columns)) $payload['estimated_time'] = $b->estimated_time;
                        if (in_array('estimated_completion_hrs', $columns)) $payload['estimated_completion_hrs'] = $b->estimated_completion_hrs;
                        if (in_array('description', $columns)) $payload['description'] = $b->description;
                        if (in_array('status', $columns)) $payload['status'] = $b->status;
                        Service::create($payload);
                    }
                }

                $query = Service::query();

                // 1. Search Query
                if (!empty($search)) {
                    $searchFields = array_intersect(['name', 'service_name', 'service_type', 'description'], $columns);
                    if (!empty($searchFields)) {
                        $query->where(function ($q) use ($search, $searchFields) {
                            foreach ($searchFields as $idx => $f) {
                                if ($idx === 0) {
                                    $q->where($f, 'like', "%{$search}%");
                                } else {
                                    $q->orWhere($f, 'like', "%{$search}%");
                                }
                            }
                        });
                    }
                }

                // 2. Type Filter
                if (!empty($selectedType)) {
                    if (in_array('service_type', $columns)) {
                        $query->where('service_type', $selectedType);
                    } elseif (in_array('service_name', $columns)) {
                        $query->where('service_name', 'like', "%{$selectedType}%");
                    } elseif (in_array('name', $columns)) {
                        $query->where('name', 'like', "%{$selectedType}%");
                    }
                }

                $totalServices = $query->count();
                // Safe order by detected PK (service_id or id)
                $services = $query->orderBy($pk, 'asc')->paginate(9)->withQueryString();
            } catch (\Throwable $e) {
                // If anything fails in DB execution, smoothly switch to session mock data
                $hasDb = false;
                $services = null;
            }
        }

        // Fallback to session mock data if DB query didn't execute
        if (!$hasDb || $services === null) {
            if (!session()->has('mock_services')) {
                session(['mock_services' => $this->getBaselineServices()]);
            }
            $allServices = session('mock_services', $this->getBaselineServices());

            // Apply search & type filter
            $filtered = $allServices->filter(function ($item) use ($search, $selectedType) {
                $matchesSearch = true;
                if (!empty($search)) {
                    $nameMatch = stripos($item->name ?? ($item->service_name ?? ''), $search) !== false;
                    $typeMatch = stripos($item->service_type ?? '', $search) !== false;
                    $descMatch = stripos($item->description ?? '', $search) !== false;
                    $matchesSearch = $nameMatch || $typeMatch || $descMatch;
                }

                $matchesType = true;
                if (!empty($selectedType)) {
                    $matchesType = ($item->service_type ?? ($item->name ?? '')) === $selectedType;
                }

                return $matchesSearch && $matchesType;
            })->values();

            $totalServices = $filtered->count();
            $page = (int)$request->input('page', 1);
            $perPage = 9;
            $offset = ($page - 1) * $perPage;

            $services = new LengthAwarePaginator(
                $filtered->slice($offset, $perPage)->values(),
                $totalServices,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'services' => $services,
                'total' => $totalServices
            ]);
        }

        $activeRole = session('active_role', 'Admin');
        $availableRoles = [
            'Admin' => ['name' => 'Administrator', 'badge_bg' => 'bg-blue-100', 'badge_text' => 'text-blue-700', 'description' => 'Full System Access'],
            'Staff' => ['name' => 'Laundry Staff', 'badge_bg' => 'bg-emerald-100', 'badge_text' => 'text-emerald-700', 'description' => 'Operations & Washing'],
            'Delivery' => ['name' => 'Delivery Driver', 'badge_bg' => 'bg-purple-100', 'badge_text' => 'text-purple-700', 'description' => 'Logistics & Dispatch'],
            'Receptionist' => ['name' => 'Receptionist', 'badge_bg' => 'bg-amber-100', 'badge_text' => 'text-amber-700', 'description' => 'Front Desk & Orders'],
        ];

        $viewName = view()->exists('service') 
            ? 'service' 
            : (view()->exists('pages.service') ? 'pages.service' : 'pages.service.index');

        return view($viewName, [
            'services' => $services,
            'totalServices' => $totalServices,
            'search' => $search,
            'selectedType' => $selectedType,
            'serviceTypes' => $this->serviceTypes,
            'hasDb' => $hasDb,
            'activeRole' => $activeRole,
            'availableRoles' => $availableRoles,
            'isDemoMode' => !$hasDb,
        ]);
    }

    /**
     * Show create page (fallback or redirect).
     */
    public function create()
    {
        return redirect()->route('services.index');
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'price_per_item' => 'nullable|numeric|min:0',
            'estimated_time' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'status' => 'nullable|string|in:Active,Inactive',
        ]);

        list($hasDb, $columns, $pk) = $this->getTableSchemaInfo();

        $priceKg = (float)$request->price_per_kg;
        $priceItem = $request->filled('price_per_item') ? (float)$request->price_per_item : null;
        $status = $request->input('status', 'Active') ?: 'Active';

        $hrs = 24;
        if (strpos($request->estimated_time, 'Same day') !== false) $hrs = 6;
        elseif (strpos($request->estimated_time, '24 hours') !== false) $hrs = 24;
        elseif (strpos($request->estimated_time, '1–2') !== false || strpos($request->estimated_time, '1-2') !== false) $hrs = 36;
        elseif (strpos($request->estimated_time, '2–3') !== false || strpos($request->estimated_time, '2-3') !== false) $hrs = 48;
        elseif (strpos($request->estimated_time, '2–4') !== false || strpos($request->estimated_time, '2-4') !== false) $hrs = 60;
        elseif (strpos($request->estimated_time, '3–5') !== false || strpos($request->estimated_time, '3-5') !== false) $hrs = 72;

        if ($hasDb && !empty($columns)) {
            try {
                $payload = [];
                if (in_array('name', $columns)) $payload['name'] = $request->name;
                if (in_array('service_name', $columns)) $payload['service_name'] = $request->name;
                if (in_array('service_type', $columns)) $payload['service_type'] = $request->service_type;
                if (in_array('price', $columns)) $payload['price'] = $priceKg;
                if (in_array('price_per_kg', $columns)) $payload['price_per_kg'] = $priceKg;
                if (in_array('price_per_item', $columns)) $payload['price_per_item'] = $priceItem;
                if (in_array('estimated_time', $columns)) $payload['estimated_time'] = $request->estimated_time;
                if (in_array('estimated_completion_hrs', $columns)) $payload['estimated_completion_hrs'] = $hrs;
                if (in_array('description', $columns)) $payload['description'] = $request->description;
                if (in_array('status', $columns)) $payload['status'] = $status;
                
                Service::create($payload);
            } catch (\Throwable $e) {
                // Fallback to session
            }
        }

        // Always sync in session as well
        $all = session('mock_services', $this->getBaselineServices());
        $newId = ($all->max('id') ?? $all->max('service_id') ?? 0) + 1;
        $newItem = (object)[
            'id' => $newId,
            'service_id' => $newId,
            'name' => $request->name,
            'service_name' => $request->name,
            'service_type' => $request->service_type,
            'price' => $priceKg,
            'price_per_kg' => $priceKg,
            'price_per_item' => $priceItem,
            'estimated_time' => $request->estimated_time,
            'estimated_completion_hrs' => $hrs,
            'description' => $request->description,
            'status' => $status,
        ];
        $all->prepend($newItem);
        session(['mock_services' => $all]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Service added successfully.',
                'service' => $newItem,
            ]);
        }

        return redirect()->route('services.index')->with('success', 'Service added successfully.');
    }

    /**
     * Show single service details.
     */
    public function show($id)
    {
        list($hasDb, $columns, $pk) = $this->getTableSchemaInfo();
        $service = null;

        if ($hasDb) {
            try {
                $service = Service::where($pk, $id)->first();
            } catch (\Throwable $e) {
                $service = null;
            }
        }

        if (!$service) {
            $all = session('mock_services', $this->getBaselineServices());
            $service = $all->first(function ($s) use ($id) {
                return (isset($s->id) && $s->id == $id) || (isset($s->service_id) && $s->service_id == $id);
            });
        }

        if (!$service) {
            return response()->json(['success' => false, 'message' => 'Service not found.'], 404);
        }

        return response()->json(['success' => true, 'service' => $service]);
    }

    /**
     * Show edit page (fallback to index modal).
     */
    public function edit($id)
    {
        return redirect()->route('services.index');
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'service_type' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'price_per_item' => 'nullable|numeric|min:0',
            'estimated_time' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'status' => 'nullable|string|in:Active,Inactive',
        ]);

        list($hasDb, $columns, $pk) = $this->getTableSchemaInfo();

        $priceKg = (float)$request->price_per_kg;
        $priceItem = $request->filled('price_per_item') ? (float)$request->price_per_item : null;
        $status = $request->input('status', 'Active') ?: 'Active';

        $hrs = 24;
        if (strpos($request->estimated_time, 'Same day') !== false) $hrs = 6;
        elseif (strpos($request->estimated_time, '24 hours') !== false) $hrs = 24;
        elseif (strpos($request->estimated_time, '1–2') !== false || strpos($request->estimated_time, '1-2') !== false) $hrs = 36;
        elseif (strpos($request->estimated_time, '2–3') !== false || strpos($request->estimated_time, '2-3') !== false) $hrs = 48;
        elseif (strpos($request->estimated_time, '2–4') !== false || strpos($request->estimated_time, '2-4') !== false) $hrs = 60;
        elseif (strpos($request->estimated_time, '3–5') !== false || strpos($request->estimated_time, '3-5') !== false) $hrs = 72;

        if ($hasDb && !empty($columns)) {
            try {
                $service = Service::where($pk, $id)->first();
                if ($service) {
                    $payload = [];
                    if (in_array('name', $columns)) $payload['name'] = $request->name;
                    if (in_array('service_name', $columns)) $payload['service_name'] = $request->name;
                    if (in_array('service_type', $columns)) $payload['service_type'] = $request->service_type;
                    if (in_array('price', $columns)) $payload['price'] = $priceKg;
                    if (in_array('price_per_kg', $columns)) $payload['price_per_kg'] = $priceKg;
                    if (in_array('price_per_item', $columns)) $payload['price_per_item'] = $priceItem;
                    if (in_array('estimated_time', $columns)) $payload['estimated_time'] = $request->estimated_time;
                    if (in_array('estimated_completion_hrs', $columns)) $payload['estimated_completion_hrs'] = $hrs;
                    if (in_array('description', $columns)) $payload['description'] = $request->description;
                    if (in_array('status', $columns)) $payload['status'] = $status;

                    $service->update($payload);
                }
            } catch (\Throwable $e) {
                // Fallback to session
            }
        }

        // Update in session
        $all = session('mock_services', $this->getBaselineServices());
        $all = $all->map(function ($item) use ($id, $request, $priceKg, $priceItem, $status, $hrs) {
            $itemId = $item->id ?? ($item->service_id ?? null);
            if ($itemId == $id) {
                $item->name = $request->name;
                $item->service_name = $request->name;
                $item->service_type = $request->service_type;
                $item->price = $priceKg;
                $item->price_per_kg = $priceKg;
                $item->price_per_item = $priceItem;
                $item->estimated_time = $request->estimated_time;
                $item->estimated_completion_hrs = $hrs;
                $item->description = $request->description;
                $item->status = $status;
            }
            return $item;
        });
        session(['mock_services' => $all]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully.'
            ]);
        }

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Request $request, $id)
    {
        list($hasDb, $columns, $pk) = $this->getTableSchemaInfo();

        if ($hasDb) {
            try {
                $service = Service::where($pk, $id)->first();
                if ($service) {
                    $service->delete();
                }
            } catch (\Throwable $e) {
                // Fallback
            }
        }

        // Delete from session
        $all = session('mock_services', $this->getBaselineServices());
        $all = $all->reject(function ($s) use ($id) {
            $itemId = $s->id ?? ($s->service_id ?? null);
            return $itemId == $id;
        })->values();
        session(['mock_services' => $all]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully.'
            ]);
        }

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}