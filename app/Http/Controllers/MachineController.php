<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class MachineController extends Controller
{
    /**
     * Official 12 baseline machines matching the teacher's screenshot.
     */
    private function getDefaultMachines(): array
    {
        return [
            [
                'id' => 1,
                'machine_id' => 'WM-001',
                'name' => 'Washer 1',
                'type' => 'Front Load',
                'capacity' => '10',
                'model' => 'LG WD-10',
                'location' => 'Laundry Room 1',
                'status' => 'In Use',
                'last_maintenance' => '2025-09-12',
                'next_maintenance' => '2025-10-12',
                'maintenance_history' => [
                    ['date' => '2025-09-12', 'type' => 'Routine Check', 'note' => 'Normal'],
                    ['date' => '2025-08-10', 'type' => 'Cleaning', 'note' => 'Cleaned filter'],
                    ['date' => '2025-07-05', 'type' => 'Repair', 'note' => 'Replaced belt'],
                ],
                'notes' => 'Heavy duty front load commercial washing unit.',
            ],
            [
                'id' => 2,
                'machine_id' => 'WM-002',
                'name' => 'Washer 2',
                'type' => 'Front Load',
                'capacity' => '10',
                'model' => 'LG WD-10',
                'location' => 'Laundry Room 1',
                'status' => 'Available',
                'last_maintenance' => '2025-09-10',
                'next_maintenance' => '2025-10-10',
                'maintenance_history' => [
                    ['date' => '2025-09-10', 'type' => 'Routine Check', 'note' => 'Normal'],
                    ['date' => '2025-08-01', 'type' => 'Cleaning', 'note' => 'Drum sanitization'],
                ],
                'notes' => 'Standard daily commercial washer.',
            ],
            [
                'id' => 3,
                'machine_id' => 'WM-003',
                'name' => 'Washer 3',
                'type' => 'Front Load',
                'capacity' => '15',
                'model' => 'Samsung WF-15',
                'location' => 'Laundry Room 2',
                'status' => 'Available',
                'last_maintenance' => '2025-09-08',
                'next_maintenance' => '2025-10-08',
                'maintenance_history' => [
                    ['date' => '2025-09-08', 'type' => 'Routine Check', 'note' => 'Normal'],
                    ['date' => '2025-07-15', 'type' => 'Inspection', 'note' => 'Water inlet checked'],
                ],
                'notes' => 'Large capacity washing machine for bedsheets and blankets.',
            ],
            [
                'id' => 4,
                'machine_id' => 'WM-004',
                'name' => 'Washer 4',
                'type' => 'Front Load',
                'capacity' => '15',
                'model' => 'Samsung WF-15',
                'location' => 'Laundry Room 2',
                'status' => 'In Use',
                'last_maintenance' => '2025-09-13',
                'next_maintenance' => '2025-10-13',
                'maintenance_history' => [
                    ['date' => '2025-09-13', 'type' => 'Routine Check', 'note' => 'Normal'],
                ],
                'notes' => 'Running express wash cycle.',
            ],
            [
                'id' => 5,
                'machine_id' => 'WM-005',
                'name' => 'Washer 5',
                'type' => 'Top Load',
                'capacity' => '20',
                'model' => 'Whirlpool Heavy',
                'location' => 'Main Laundry Bay',
                'status' => 'Available',
                'last_maintenance' => '2025-09-09',
                'next_maintenance' => '2025-10-09',
                'maintenance_history' => [
                    ['date' => '2025-09-09', 'type' => 'Routine Check', 'note' => 'Normal'],
                    ['date' => '2025-07-20', 'type' => 'Cleaning', 'note' => 'Agitator cleaned'],
                ],
                'notes' => 'Industrial bulk washing machine.',
            ],
            [
                'id' => 6,
                'machine_id' => 'WM-006',
                'name' => 'Dryer 1',
                'type' => 'Dryer',
                'capacity' => '15',
                'model' => 'Electrolux Dry',
                'location' => 'Drying Zone A',
                'status' => 'In Use',
                'last_maintenance' => '2025-09-13',
                'next_maintenance' => '2025-10-13',
                'maintenance_history' => [
                    ['date' => '2025-09-13', 'type' => 'Routine Check', 'note' => 'Heating coil tested'],
                    ['date' => '2025-08-15', 'type' => 'Cleaning', 'note' => 'Lint trap cleared'],
                ],
                'notes' => 'Gas-powered high-efficiency tumbling dryer.',
            ],
            [
                'id' => 7,
                'machine_id' => 'WM-007',
                'name' => 'Dryer 2',
                'type' => 'Dryer',
                'capacity' => '15',
                'model' => 'Electrolux Dry',
                'location' => 'Drying Zone A',
                'status' => 'Available',
                'last_maintenance' => '2025-09-11',
                'next_maintenance' => '2025-10-11',
                'maintenance_history' => [
                    ['date' => '2025-09-11', 'type' => 'Routine Check', 'note' => 'Normal'],
                ],
                'notes' => 'Commercial dryer ready for cycle.',
            ],
            [
                'id' => 8,
                'machine_id' => 'WM-008',
                'name' => 'Dryer 3',
                'type' => 'Dryer',
                'capacity' => '20',
                'model' => 'SpeedQueen Pro',
                'location' => 'Drying Zone B',
                'status' => 'Under Maintenance',
                'last_maintenance' => '2025-09-05',
                'next_maintenance' => '2025-09-20',
                'maintenance_history' => [
                    ['date' => '2025-09-05', 'type' => 'Repair', 'note' => 'Drum bearing replacement scheduled'],
                    ['date' => '2025-08-01', 'type' => 'Inspection', 'note' => 'Bearing noise detected'],
                ],
                'notes' => 'Awaiting replacement parts from technician.',
            ],
            [
                'id' => 9,
                'machine_id' => 'WM-009',
                'name' => 'Ironing Machine 1',
                'type' => 'Ironing',
                'capacity' => '-',
                'model' => 'Rowenta ProPress',
                'location' => 'Finishing Area',
                'status' => 'Available',
                'last_maintenance' => '2025-09-10',
                'next_maintenance' => '2025-10-10',
                'maintenance_history' => [
                    ['date' => '2025-09-10', 'type' => 'Routine Check', 'note' => 'Plate temperature verified'],
                ],
                'notes' => 'Roller iron press for bed sheets and shirts.',
            ],
            [
                'id' => 10,
                'machine_id' => 'WM-010',
                'name' => 'Ironing Machine 2',
                'type' => 'Ironing',
                'capacity' => '-',
                'model' => 'Rowenta ProPress',
                'location' => 'Finishing Area',
                'status' => 'Available',
                'last_maintenance' => '2025-09-09',
                'next_maintenance' => '2025-10-09',
                'maintenance_history' => [
                    ['date' => '2025-09-09', 'type' => 'Routine Check', 'note' => 'Steam nozzle descaled'],
                ],
                'notes' => 'Secondary ironing press station.',
            ],
            [
                'id' => 11,
                'machine_id' => 'WM-011',
                'name' => 'Ironing Machine 3',
                'type' => 'Ironing',
                'capacity' => '-',
                'model' => 'Rowenta ProPress',
                'location' => 'Finishing Area',
                'status' => 'Available',
                'last_maintenance' => '2025-09-13',
                'next_maintenance' => '2025-10-13',
                'maintenance_history' => [
                    ['date' => '2025-09-13', 'type' => 'Routine Check', 'note' => 'Normal'],
                ],
                'notes' => 'Finishing garment station.',
            ],
            [
                'id' => 12,
                'machine_id' => 'WM-012',
                'name' => 'Boiler',
                'type' => 'Steam',
                'capacity' => '-',
                'model' => 'Karcher SteamMax',
                'location' => 'Utility Room',
                'status' => 'Available',
                'last_maintenance' => '2025-09-08',
                'next_maintenance' => '2025-10-08',
                'maintenance_history' => [
                    ['date' => '2025-09-08', 'type' => 'Safety Inspection', 'note' => 'Pressure valve certified'],
                    ['date' => '2025-07-10', 'type' => 'Routine Check', 'note' => 'Descaling completed'],
                ],
                'notes' => 'Central steam generator boiler unit.',
            ],
        ];
    }

    /**
     * Load machines from Database, JSON Storage, or Session.
     */
    private function loadData(): array
    {
        // 1. Try MySQL Database
        try {
            if (Schema::hasTable('machines')) {
                $count = Machine::count();
                if ($count > 0) {
                    return Machine::orderBy('id', 'asc')->get()->map(function ($item) {
                        return (object) [
                            'id' => $item->id,
                            'machine_id' => $item->machine_id,
                            'name' => $item->name,
                            'type' => $item->type,
                            'capacity' => $item->capacity ?? '-',
                            'model' => $item->model ?? 'Standard Model',
                            'location' => $item->location ?? 'Laundry Room 1',
                            'status' => $item->status,
                            'last_maintenance' => $item->last_maintenance ?? '2025-09-10',
                            'next_maintenance' => $item->next_maintenance ?? '2025-10-10',
                            'maintenance_history' => is_array($item->maintenance_history) ? $item->maintenance_history : json_decode($item->maintenance_history ?? '[]', true),
                            'notes' => $item->notes ?? '',
                        ];
                    })->all();
                } else {
                    // Seed initial 12 items into DB
                    $defaults = $this->getDefaultMachines();
                    foreach ($defaults as $d) {
                        Machine::create($d);
                    }
                    return $this->loadData();
                }
            }
        } catch (\Throwable $e) {
            // Fall back to file/session
        }

        // 2. Try JSON storage file
        if (Storage::exists('machines.json')) {
            try {
                $json = Storage::get('machines.json');
                $decoded = json_decode($json, true);
                if (is_array($decoded) && count($decoded) > 0) {
                    return array_map(function ($d) {
                        return (object) $d;
                    }, $decoded);
                }
            } catch (\Throwable $e) {
                // Continue to session
            }
        }

        // 3. Try Session
        if (session()->has('mock_machines')) {
            $sess = session('mock_machines');
            if (is_array($sess) && count($sess) > 0) {
                return array_map(function ($d) {
                    return is_object($d) ? $d : (object) $d;
                }, $sess);
            }
        }

        // 4. Default baseline items
        $defaults = $this->getDefaultMachines();
        Storage::put('machines.json', json_encode($defaults, JSON_PRETTY_PRINT));
        session(['mock_machines' => $defaults]);

        return array_map(function ($d) {
            return (object) $d;
        }, $defaults);
    }

    /**
     * Persist machines list across Database, JSON, and Session.
     */
    private function saveData(array $items): void
    {
        $arrayData = array_map(function ($item) {
            return (array) $item;
        }, $items);

        // Update JSON file
        try {
            Storage::put('machines.json', json_encode($arrayData, JSON_PRETTY_PRINT));
        } catch (\Throwable $e) {
            // Ignore file error
        }

        // Update Session
        session(['mock_machines' => $arrayData]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $statusFilter = trim($request->input('status', ''));
        $typeFilter = trim($request->input('type', ''));

        $allItems = $this->loadData();

        // Calculate global summary stats
        $stats = [
            'total' => count($allItems),
            'available' => count(array_filter($allItems, fn($i) => ($i->status ?? '') === 'Available')),
            'in_use' => count(array_filter($allItems, fn($i) => ($i->status ?? '') === 'In Use')),
            'maintenance' => count(array_filter($allItems, fn($i) => ($i->status ?? '') === 'Under Maintenance')),
        ];

        // Apply filtering
        $filteredItems = array_filter($allItems, function ($item) use ($search, $statusFilter, $typeFilter) {
            if ($search !== '') {
                $term = strtolower($search);
                $name = strtolower($item->name ?? '');
                $mid = strtolower($item->machine_id ?? '');
                $model = strtolower($item->model ?? '');
                $type = strtolower($item->type ?? '');
                $loc = strtolower($item->location ?? '');

                if (!str_contains($name, $term) && !str_contains($mid, $term) && !str_contains($model, $term) && !str_contains($type, $term) && !str_contains($loc, $term)) {
                    return false;
                }
            }

            if ($statusFilter !== '' && $statusFilter !== 'All Status') {
                if (($item->status ?? '') !== $statusFilter) {
                    return false;
                }
            }

            if ($typeFilter !== '' && $typeFilter !== 'All Types') {
                if (($item->type ?? '') !== $typeFilter) {
                    return false;
                }
            }

            return true;
        });

        // Re-index array
        $filteredItems = array_values($filteredItems);

        // Unique types for dropdown
        $types = array_values(array_unique(array_filter(array_map(fn($i) => $i->type ?? null, $allItems))));
        sort($types);

        // AJAX JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'items' => $filteredItems,
                'stats' => $stats,
                'count' => count($filteredItems),
            ]);
        }

        return view('pages.machine', [
            'machines' => $filteredItems,
            'stats' => $stats,
            'types' => $types,
            'search' => $search,
            'statusFilter' => $statusFilter ?: 'All Status',
            'typeFilter' => $typeFilter ?: 'All Types',
        ]);
    }

    /**
     * Get a specific machine's details.
     */
    public function show($id, $optionalId = null)
    {
        if ($id instanceof \Illuminate\Http\Request) {
            $id = $optionalId ?? $id->route('id') ?? $id->route('machine');
        }

        $allItems = $this->loadData();
        $found = null;

        foreach ($allItems as $item) {
            if ($item->id == $id || ($item->machine_id ?? '') == $id) {
                $found = $item;
                break;
            }
        }

        if (!$found) {
            return response()->json([
                'success' => false,
                'message' => 'Machine not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'machine' => $found,
        ]);
    }

    /**
     * Store a newly created machine in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
        ]);

        $allItems = $this->loadData();

        // Generate next ID and Machine ID if not provided
        $maxId = 0;
        foreach ($allItems as $item) {
            if ($item->id > $maxId) {
                $maxId = $item->id;
            }
        }
        $newId = $maxId + 1;

        $machineId = trim($request->input('machine_id', ''));
        if (empty($machineId)) {
            $machineId = sprintf('WM-%03d', $newId);
        }

        $nowDate = date('Y-m-d');
        $nextDate = date('Y-m-d', strtotime('+30 days'));

        $newMachine = [
            'id' => $newId,
            'machine_id' => $machineId,
            'name' => trim($request->input('name')),
            'type' => trim($request->input('type')),
            'capacity' => trim($request->input('capacity', '-')) ?: '-',
            'model' => trim($request->input('model', 'Standard Model')) ?: 'Standard Model',
            'location' => trim($request->input('location', 'Laundry Room 1')) ?: 'Laundry Room 1',
            'status' => in_array($request->input('status'), ['Available', 'In Use', 'Under Maintenance']) ? $request->input('status') : 'Available',
            'last_maintenance' => $request->input('last_maintenance', $nowDate) ?: $nowDate,
            'next_maintenance' => $request->input('next_maintenance', $nextDate) ?: $nextDate,
            'maintenance_history' => [
                [
                    'date' => $nowDate,
                    'type' => 'Initial Setup',
                    'note' => 'Machine registered into system',
                ],
            ],
            'notes' => trim($request->input('notes', 'Registered laundry unit.')),
        ];

        // 1. Try DB
        try {
            if (Schema::hasTable('machines')) {
                Machine::create($newMachine);
            }
        } catch (\Throwable $e) {
            // Ignore DB error and continue to file/session
        }

        // 2. Save in array
        $allItems[] = (object) $newMachine;
        $this->saveData($allItems);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Machine {$machineId} ({$newMachine['name']}) registered successfully!",
                'machine' => $newMachine,
            ]);
        }

        return redirect()->route('machines.index')->with('success', "Machine {$machineId} registered successfully!");
    }

    /**
     * Update the specified machine in storage.
     */
    public function update(Request $request, $id)
    {
        $allItems = $this->loadData();
        $updatedItem = null;
        $indexFound = -1;

        foreach ($allItems as $idx => $item) {
            if ($item->id == $id || ($item->machine_id ?? '') == $id) {
                $indexFound = $idx;
                $updatedItem = (array) $item;
                break;
            }
        }

        if ($indexFound === -1 || !$updatedItem) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Machine not found.'], 404);
            }
            return redirect()->route('machines.index')->with('error', 'Machine not found.');
        }

        $oldStatus = $updatedItem['status'] ?? 'Available';
        $newStatus = $request->input('status', $oldStatus);

        $updatedItem['name'] = trim($request->input('name', $updatedItem['name']));
        $updatedItem['type'] = trim($request->input('type', $updatedItem['type']));
        $updatedItem['capacity'] = trim($request->input('capacity', $updatedItem['capacity'] ?? '-')) ?: '-';
        $updatedItem['model'] = trim($request->input('model', $updatedItem['model'] ?? ''));
        $updatedItem['location'] = trim($request->input('location', $updatedItem['location'] ?? 'Laundry Room 1'));
        $updatedItem['status'] = in_array($newStatus, ['Available', 'In Use', 'Under Maintenance']) ? $newStatus : $oldStatus;
        $updatedItem['last_maintenance'] = $request->input('last_maintenance', $updatedItem['last_maintenance'] ?? date('Y-m-d'));
        $updatedItem['next_maintenance'] = $request->input('next_maintenance', $updatedItem['next_maintenance'] ?? date('Y-m-d', strtotime('+30 days')));
        $updatedItem['notes'] = trim($request->input('notes', $updatedItem['notes'] ?? ''));

        // If status changed to Under Maintenance, automatically log it in maintenance history
        if ($newStatus === 'Under Maintenance' && $oldStatus !== 'Under Maintenance') {
            $history = is_array($updatedItem['maintenance_history'] ?? null) ? $updatedItem['maintenance_history'] : [];
            array_unshift($history, [
                'date' => date('Y-m-d'),
                'type' => 'Maintenance Scheduled',
                'note' => 'Status changed to Under Maintenance: ' . ($request->input('notes') ?: 'Routine service required'),
            ]);
            $updatedItem['maintenance_history'] = $history;
        }

        // If user submitted an extra maintenance log entry
        if ($request->filled('log_type') && $request->filled('log_note')) {
            $history = is_array($updatedItem['maintenance_history'] ?? null) ? $updatedItem['maintenance_history'] : [];
            array_unshift($history, [
                'date' => $request->input('log_date', date('Y-m-d')),
                'type' => trim($request->input('log_type')),
                'note' => trim($request->input('log_note')),
            ]);
            $updatedItem['maintenance_history'] = $history;
        }

        // 1. Try DB
        try {
            if (Schema::hasTable('machines')) {
                $dbItem = Machine::where('id', $updatedItem['id'])->orWhere('machine_id', $updatedItem['machine_id'])->first();
                if ($dbItem) {
                    $dbItem->update($updatedItem);
                }
            }
        } catch (\Throwable $e) {
            // Ignore DB error
        }

        // 2. Save
        $allItems[$indexFound] = (object) $updatedItem;
        $this->saveData($allItems);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Machine {$updatedItem['machine_id']} updated successfully!",
                'machine' => $updatedItem,
            ]);
        }

        return redirect()->route('machines.index')->with('success', "Machine {$updatedItem['machine_id']} updated successfully!");
    }

    /**
     * Remove the specified machine from storage.
     */
    public function destroy(Request $request, $id)
    {
        $allItems = $this->loadData();
        $deletedName = '';
        $newItems = [];

        foreach ($allItems as $item) {
            if ($item->id == $id || ($item->machine_id ?? '') == $id) {
                $deletedName = ($item->machine_id ?? '') . ' - ' . ($item->name ?? '');
                continue;
            }
            $newItems[] = $item;
        }

        // 1. Try DB
        try {
            if (Schema::hasTable('machines')) {
                Machine::where('id', $id)->orWhere('machine_id', $id)->delete();
            }
        } catch (\Throwable $e) {
            // Ignore DB error
        }

        // 2. Save
        $this->saveData($newItems);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Machine {$deletedName} deleted successfully!",
            ]);
        }

        return redirect()->route('machines.index')->with('success', "Machine {$deletedName} deleted successfully!");
    }

    /**
     * Quick status update endpoint.
     */
    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
        if (!in_array($status, ['Available', 'In Use', 'Under Maintenance'])) {
            return response()->json(['success' => false, 'message' => 'Invalid status'], 422);
        }

        $allItems = $this->loadData();
        $found = null;

        foreach ($allItems as $item) {
            if ($item->id == $id || ($item->machine_id ?? '') == $id) {
                $item->status = $status;
                $found = $item;
                break;
            }
        }

        if ($found) {
            $this->saveData($allItems);
            try {
                if (Schema::hasTable('machines')) {
                    Machine::where('id', $id)->orWhere('machine_id', $id)->update(['status' => $status]);
                }
            } catch (\Throwable $e) {}

            return response()->json([
                'success' => true,
                'message' => "Machine status updated to {$status}",
                'machine' => $found,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Machine not found'], 404);
    }

    /**
     * Reset machines to the original 12 baseline units.
     */
    public function reset(Request $request)
    {
        $defaults = $this->getDefaultMachines();
        $this->saveData($defaults);

        try {
            if (Schema::hasTable('machines')) {
                Machine::truncate();
                foreach ($defaults as $d) {
                    Machine::create($d);
                }
            }
        } catch (\Throwable $e) {}

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Machines reset to official 12 units successfully!',
            ]);
        }

        return redirect()->route('machines.index')->with('success', 'Machines reset to official 12 units successfully!');
    }
}
