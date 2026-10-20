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
     * Get baseline services (no longer returning mock data).
     */
    protected function getBaselineServices()
    {
        return collect([]);
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
                $hasDb = false;
                $services = null;
            }
        }

        session()->forget('mock_services');

        if (!$hasDb || $services === null) {
            $services = new LengthAwarePaginator(
                [],
                0,
                9,
                1,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            $totalServices = 0;
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

        $service = null;
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
                
                $service = Service::create($payload);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Service create failed: " . $e->getMessage());
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Service added successfully.',
                'service' => $service,
            ]);
        }

        return redirect()->route('services.index')->with('success', 'Service added successfully.');
    }

    /**
     * Show single service details.
     *
     * @param int|string $id
     * @param int|string|null $optionalId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, $optionalId = null)
    {
        if ($id instanceof \Illuminate\Http\Request) {
            $id = $optionalId ?? $id->route('id') ?? $id->route('service');
        }

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
     *
     * @param \Illuminate\Http\Request $request
     * @param int|string $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
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
                \Illuminate\Support\Facades\Log::error("Service update failed: " . $e->getMessage());
            }
        }

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
     *
     * @param \Illuminate\Http\Request $request
     * @param int|string $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
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
                \Illuminate\Support\Facades\Log::error("Service delete failed: " . $e->getMessage());
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Service deleted successfully.'
            ]);
        }

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}