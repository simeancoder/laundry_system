<?php

namespace App\Http\Controllers;

use App\Models\PickupDelivery;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class PickupAndDeliveryController extends Controller
{
    /**
     * Get list of delivery staff for assignment from database.
     */
    private function getDeliveryStaffList(): array
    {
        try {
            if (Schema::hasTable('employees')) {
                $emps = Employee::where('status', 'Active')
                    ->where(function ($q) {
                        $q->where('role', 'LIKE', '%delivery%')
                          ->orWhere('role', 'LIKE', '%staff%')
                          ->orWhere('role', 'LIKE', '%driver%');
                    })
                    ->orderBy('name', 'asc')
                    ->get(['id', 'name', 'role', 'phone']);

                if ($emps->count() === 0) {
                    $emps = Employee::where('status', 'Active')
                        ->orderBy('name', 'asc')
                        ->get(['id', 'name', 'role', 'phone']);
                }

                return $emps->map(function ($emp) {
                    return [
                        'id' => $emp->id,
                        'name' => $emp->name,
                        'role' => $emp->role,
                        'phone' => $emp->phone ?? '',
                    ];
                })->toArray();
            }
        } catch (\Throwable $e) {
            Log::error('Error fetching delivery staff: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Display the Pickup & Delivery Management page.
     * Fulfills:
     * 1. Schedule Pickup
     * 2. Schedule Delivery
     * 3. Assign Delivery Staff
     * 4. Track Pickup & Delivery Status
     * 5. Delivery History
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'pickups'); // pickups, deliveries, in_progress, history
        $statusFilter = $request->get('status');
        $dateFilter = $request->get('date');
        $search = $request->get('search');
        $perPage = 10;

        // Auto-clean mock test records from database so only real data is used
        try {
            if (Schema::hasTable('pickup_deliveries')) {
                $mockNames = [
                    'Sokha Dara', 'Chan Sreyneath', 'Heng Channa', 'Kim Sovannary',
                    'Neang Pheaktra', 'Lim Vannak', 'Thon Sreynich', 'Pich Sothey',
                    'Chea Ratanak', 'Va Sovan', 'Keo Pisey', 'Meng Chhay'
                ];
                PickupDelivery::whereIn('customer_name', $mockNames)->delete();

                if ($request->has('reset') || $request->has('clear')) {
                    DB::table('pickup_deliveries')->truncate();
                }
            }
        } catch (\Throwable $e) {
            Log::error('Error cleaning mock data: ' . $e->getMessage());
        }

        $totalPickups = 0;
        $totalDeliveries = 0;
        $inProgress = 0;
        $completed = 0;

        try {
            if (Schema::hasTable('pickup_deliveries')) {
                $totalPickups = PickupDelivery::whereNotNull('pickup_date')->count();
                $totalDeliveries = PickupDelivery::whereNotNull('delivery_date')->count();
                $inProgress = PickupDelivery::whereIn('status', ['In Transit', 'Picked Up', 'Assigned'])->count();
                $completed = PickupDelivery::whereIn('status', ['Delivered', 'Completed'])->count();
            }
        } catch (\Throwable $e) {
            Log::error('Error calculating pickup & delivery statistics: ' . $e->getMessage());
        }

        $tasksQuery = PickupDelivery::query();

        // 1. Tab filter
        if ($activeTab === 'pickups') {
            $tasksQuery->where(function ($q) {
                $q->whereIn('status', ['Scheduled', 'Pending', 'Assigned', 'In Transit']);
            });
        } elseif ($activeTab === 'deliveries') {
            $tasksQuery->where(function ($q) {
                $q->whereIn('status', ['Scheduled', 'Assigned', 'In Transit']);
            });
        } elseif ($activeTab === 'in_progress') {
            $tasksQuery->whereIn('status', ['In Transit', 'Picked Up', 'Assigned']);
        } elseif ($activeTab === 'history') {
            $tasksQuery->whereIn('status', ['Delivered', 'Completed']);
        }

        // 2. Status dropdown filter
        if (!empty($statusFilter) && $statusFilter !== 'All Status') {
            $tasksQuery->where('status', $statusFilter);
        }

        // 3. Date dropdown filter
        if (!empty($dateFilter) && $dateFilter !== 'Date') {
            if ($dateFilter === 'Today') {
                $tasksQuery->where(function ($q) {
                    $q->whereDate('pickup_date', today())
                      ->orWhereDate('delivery_date', today());
                });
            } elseif ($dateFilter === 'This Week') {
                $tasksQuery->where(function ($q) {
                    $q->whereBetween('pickup_date', [now()->startOfWeek(), now()->endOfWeek()])
                      ->orWhereBetween('delivery_date', [now()->startOfWeek(), now()->endOfWeek()]);
                });
            } elseif ($dateFilter === 'This Month') {
                $tasksQuery->where(function ($q) {
                    $q->whereMonth('pickup_date', now()->month)
                      ->orWhereMonth('delivery_date', now()->month);
                });
            }
        }

        // 4. Search input filter
        if (!empty($search)) {
            $term = trim($search);
            $tasksQuery->where(function ($q) use ($term) {
                $q->where('order_number', 'LIKE', "%{$term}%")
                  ->orWhere('customer_name', 'LIKE', "%{$term}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$term}%")
                  ->orWhere('service_type', 'LIKE', "%{$term}%")
                  ->orWhere('pickup_address', 'LIKE', "%{$term}%")
                  ->orWhere('delivery_address', 'LIKE', "%{$term}%")
                  ->orWhere('delivery_staff_name', 'LIKE', "%{$term}%");
            });
        }

        $tasks = $tasksQuery->orderBy('id', 'desc')
                            ->paginate($perPage)
                            ->withQueryString();

        $stats = [
            'total_pickups' => $totalPickups,
            'total_deliveries' => $totalDeliveries,
            'in_progress' => $inProgress,
            'completed' => $completed,
        ];

        $staffList = $this->getDeliveryStaffList();
        $selectedTask = $tasks->count() > 0 ? $tasks->first() : null;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'stats' => $stats,
                'tasks' => $tasks,
                'staffList' => $staffList,
                'selectedTask' => $selectedTask,
            ]);
        }

        return view('pages.PickupAndDelivery', [
            'tasks' => $tasks,
            'stats' => $stats,
            'staffList' => $staffList,
            'selectedTask' => $selectedTask,
            'activeTab' => $activeTab,
            'statusFilter' => $statusFilter,
            'dateFilter' => $dateFilter,
            'search' => $search,
        ]);
    }

    /**
     * Requirement 1 & 2: Schedule Pickup & Schedule Delivery.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'nullable|string|max:50',
            'customer_name' => 'required|string|max:150',
            'customer_phone' => 'nullable|string|max:50',
            'service_type' => 'required|string|max:100',
            'total_amount' => 'nullable|numeric',
            'pickup_date' => 'nullable|date',
            'pickup_time' => 'nullable|string|max:30',
            'pickup_address' => 'nullable|string|max:255',
            'delivery_date' => 'nullable|date',
            'delivery_time' => 'nullable|string|max:30',
            'delivery_address' => 'nullable|string|max:255',
            'delivery_staff_id' => 'nullable|integer',
            'delivery_staff_name' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        if (empty($validated['order_number'])) {
            $nextId = (PickupDelivery::max('id') ?? 0) + 1;
            $validated['order_number'] = sprintf('ORD-%04d', $nextId);
        }

        if (empty($validated['status'])) {
            $validated['status'] = !empty($validated['delivery_staff_id']) ? 'Assigned' : 'Scheduled';
        }

        // Resolve staff name if id is given
        if (!empty($validated['delivery_staff_id']) && empty($validated['delivery_staff_name'])) {
            $staff = Employee::find($validated['delivery_staff_id']);
            if ($staff) {
                $validated['delivery_staff_name'] = $staff->name;
            }
        }

        $task = PickupDelivery::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Pickup & Delivery task {$task->order_number} scheduled successfully!",
                'task' => $task,
            ]);
        }

        return redirect()->route('pickup-and-delivery.index')->with('success', "Task {$task->order_number} scheduled successfully!");
    }

    /**
     * Alias for store to maintain backwards route compatibility.
     */
    public function scheduleTask(Request $request)
    {
        return $this->store($request);
    }

    /**
     * Requirement 4: Track Pickup & Delivery Status.
     * Return single task details as JSON for drawer / modal.
     */
    public function show($id, $optionalId = null)
    {
        if ($id instanceof \Illuminate\Http\Request) {
            $id = $optionalId ?? $id->route('id') ?? $id->route('task');
        }

        $task = PickupDelivery::find($id);
        if (!$task) {
            $task = PickupDelivery::where('order_number', $id)->first();
        }

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task record not found.'], 404);
        }

        return response()->json([
            'success' => true,
            'task' => $task,
        ]);
    }

    /**
     * Update Pickup & Delivery Details.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:150',
            'customer_phone' => 'nullable|string|max:50',
            'service_type' => 'nullable|string|max:100',
            'total_amount' => 'nullable|numeric',
            'pickup_date' => 'nullable|date',
            'pickup_time' => 'nullable|string|max:30',
            'pickup_address' => 'nullable|string|max:255',
            'delivery_date' => 'nullable|date',
            'delivery_time' => 'nullable|string|max:30',
            'delivery_address' => 'nullable|string|max:255',
            'delivery_staff_id' => 'nullable|integer',
            'delivery_staff_name' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);

        $task = PickupDelivery::findOrFail($id);

        if (!empty($validated['delivery_staff_id']) && empty($validated['delivery_staff_name'])) {
            $staff = Employee::find($validated['delivery_staff_id']);
            if ($staff) {
                $validated['delivery_staff_name'] = $staff->name;
            }
        }

        $task->update(array_filter($validated, fn($val) => !is_null($val)));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Pickup & Delivery details for {$task->order_number} updated successfully!",
                'task' => $task,
            ]);
        }

        return redirect()->route('pickup-and-delivery.index')->with('success', 'Details updated successfully!');
    }

    /**
     * Requirement 3: Assign Delivery Staff.
     */
    public function assignStaff(Request $request, $id)
    {
        $validated = $request->validate([
            'staff_id' => 'required',
            'staff_name' => 'nullable|string|max:100',
        ]);

        $task = PickupDelivery::findOrFail($id);

        $staffName = $validated['staff_name'] ?? null;
        if (!$staffName) {
            $staff = Employee::find($validated['staff_id']);
            $staffName = $staff ? $staff->name : ('Staff #' . $validated['staff_id']);
        }

        $task->delivery_staff_id = $validated['staff_id'];
        $task->delivery_staff_name = $staffName;
        if ($task->status === 'Pending' || empty($task->status)) {
            $task->status = 'Assigned';
        }
        $task->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Order {$task->order_number} assigned to {$staffName} successfully!",
                'task' => $task,
            ]);
        }

        return redirect()->route('pickup-and-delivery.index')->with('success', "Order assigned to {$staffName} successfully!");
    }

    /**
     * Requirement 4: Track & Update Status (Scheduled -> Picked Up -> In Transit -> Delivered).
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Scheduled,Picked Up,In Transit,Delivered,Assigned,Pending,Completed',
        ]);

        $task = PickupDelivery::findOrFail($id);
        $task->status = $validated['status'];
        $task->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Order {$task->order_number} status updated to {$validated['status']}!",
                'task' => $task,
            ]);
        }

        return redirect()->route('pickup-and-delivery.index')->with('success', "Status updated to {$validated['status']}!");
    }

    /**
     * Delete task.
     */
    public function destroy(Request $request, $id)
    {
        $task = PickupDelivery::findOrFail($id);
        $ordNo = $task->order_number;
        $task->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Task {$ordNo} removed successfully!",
            ]);
        }

        return redirect()->route('pickup-and-delivery.index')->with('success', "Task {$ordNo} removed successfully!");
    }

    /**
     * Export tasks report to CSV.
     */
    public function export($format = 'csv')
    {
        $tasks = PickupDelivery::orderBy('id', 'desc')->get();
        $filename = 'pickup_and_delivery_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($tasks) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($file, [
                'Order No',
                'Customer',
                'Phone',
                'Service Type',
                'Total Amount ($)',
                'Pickup Date',
                'Pickup Time',
                'Pickup Address',
                'Delivery Date',
                'Delivery Time',
                'Delivery Address',
                'Delivery Staff',
                'Status',
                'Notes',
            ]);

            foreach ($tasks as $item) {
                fputcsv($file, [
                    $item->order_number,
                    $item->customer_name,
                    $item->customer_phone ?? '',
                    $item->service_type,
                    number_format($item->total_amount ?? 0, 2),
                    $item->pickup_date instanceof \DateTimeInterface ? $item->pickup_date->format('Y-m-d') : ($item->pickup_date ?? ''),
                    $item->pickup_time ?? '',
                    $item->pickup_address ?? '',
                    $item->delivery_date instanceof \DateTimeInterface ? $item->delivery_date->format('Y-m-d') : ($item->delivery_date ?? ''),
                    $item->delivery_time ?? '',
                    $item->delivery_address ?? '',
                    $item->delivery_staff_name ?? 'Unassigned',
                    $item->status ?? 'Scheduled',
                    $item->notes ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
