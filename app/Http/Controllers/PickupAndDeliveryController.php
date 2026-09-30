<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PickupAndDeliveryController extends Controller
{
    /**
     * Default Active Fleet dataset matching the design.
     */
    private function getDefaultFleet(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Marcus Lawson',
                'short_name' => 'Marcus L.',
                'status' => 'ON DUTY',
                'status_color' => 'bg-[#DCFCE7] text-[#15803D]',
                'vehicle' => 'Truck #402 (Standard Van)',
                'active_drops' => 12,
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
                'phone' => '+1 (555) 349-2810',
                'current_location' => 'Zone A - Near Ontario St',
                'is_online' => true,
            ],
            [
                'id' => 2,
                'name' => 'Sara Thompson',
                'short_name' => 'Sara T.',
                'status' => 'ON DUTY',
                'status_color' => 'bg-[#DCFCE7] text-[#15803D]',
                'vehicle' => 'Truck #211 (Heavy Duty)',
                'active_drops' => 8,
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80',
                'phone' => '+1 (555) 891-4472',
                'current_location' => 'Zone C - Near Huron St',
                'is_online' => true,
            ],
            [
                'id' => 3,
                'name' => 'David Miller',
                'short_name' => 'David M.',
                'status' => 'ON DUTY',
                'status_color' => 'bg-[#DCFCE7] text-[#15803D]',
                'vehicle' => 'Van #108 (Express Courier)',
                'active_drops' => 6,
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&auto=format&fit=crop&q=80',
                'phone' => '+1 (555) 672-1193',
                'current_location' => 'Zone B - Commercial Hub',
                'is_online' => true,
            ],
            [
                'id' => 4,
                'name' => 'Elena Rostova',
                'short_name' => 'Elena R.',
                'status' => 'STANDBY',
                'status_color' => 'bg-[#FEF3C7] text-[#D97706]',
                'vehicle' => 'Van #305 (Standard Van)',
                'active_drops' => 0,
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&auto=format&fit=crop&q=80',
                'phone' => '+1 (555) 438-9921',
                'current_location' => 'Central Depot',
                'is_online' => true,
            ],
        ];
    }

    /**
     * Default Upcoming Tasks dataset matching the design.
     */
    private function getDefaultTasks(): array
    {
        return [
            // Row 1 (Matching screenshot exactly)
            [
                'id' => 1,
                'date' => 'Today',
                'time' => '14:15',
                'customer' => 'River North Gym',
                'task_type' => 'PICKUP',
                'task_type_bg' => 'bg-[#DBEAFE] text-[#2563EB]',
                'address' => '320 W Ontario St',
                'staff_id' => 1,
                'staff_name' => 'Marcus L.',
                'staff_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
                'is_unassigned' => false,
                'status' => 'In Transit',
                'status_bg' => 'bg-[#FEF3C7] text-[#D97706]',
                'items_count' => '4 Towel Hampers',
                'estimated_arrival' => '14:28',
            ],
            // Row 2 (Matching screenshot exactly)
            [
                'id' => 2,
                'date' => 'Today',
                'time' => '15:30',
                'customer' => 'Hotel Aris',
                'task_type' => 'DELIVERY',
                'task_type_bg' => 'bg-[#CCFBF1] text-[#0D9488]',
                'address' => '10 E Huron St',
                'staff_id' => 2,
                'staff_name' => 'Sara T.',
                'staff_avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80',
                'is_unassigned' => false,
                'status' => 'Scheduled',
                'status_bg' => 'bg-[#F1F5F9] text-[#475569]',
                'items_count' => '120 Bed Linens & Duvets',
                'estimated_arrival' => '15:35',
            ],
            // Row 3 (Matching screenshot exactly)
            [
                'id' => 3,
                'date' => 'Today',
                'time' => '11:00',
                'customer' => 'Northside Spa',
                'task_type' => 'PICKUP',
                'task_type_bg' => 'bg-[#DBEAFE] text-[#2563EB]',
                'address' => '222 W Merchant St',
                'staff_id' => null,
                'staff_name' => 'Unassigned',
                'staff_avatar' => null,
                'is_unassigned' => true,
                'status' => 'Pending',
                'status_bg' => 'bg-[#FEE2E2] text-[#DC2626]',
                'items_count' => '3 Robe Bags + Essential Towels',
                'estimated_arrival' => 'Awaiting Driver',
            ],
            // Additional Tasks for expanded interaction
            [
                'id' => 4,
                'date' => 'Today',
                'time' => '16:45',
                'customer' => 'Grand Plaza Residences',
                'task_type' => 'DELIVERY',
                'task_type_bg' => 'bg-[#CCFBF1] text-[#0D9488]',
                'address' => '4402 Michigan Ave Suite 12',
                'staff_id' => 1,
                'staff_name' => 'Marcus L.',
                'staff_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
                'is_unassigned' => false,
                'status' => 'In Transit',
                'status_bg' => 'bg-[#FEF3C7] text-[#D97706]',
                'items_count' => '8 Dry Clean Garment Bags',
                'estimated_arrival' => '14:30',
            ],
            [
                'id' => 5,
                'date' => 'Today',
                'time' => '17:15',
                'customer' => 'Lakeside Bistro & Lounge',
                'task_type' => 'PICKUP',
                'task_type_bg' => 'bg-[#DBEAFE] text-[#2563EB]',
                'address' => '510 N Lake Shore Dr',
                'staff_id' => null,
                'staff_name' => 'Unassigned',
                'staff_avatar' => null,
                'is_unassigned' => true,
                'status' => 'Pending',
                'status_bg' => 'bg-[#FEE2E2] text-[#DC2626]',
                'items_count' => '40 Tablecloths & 150 Napkins',
                'estimated_arrival' => 'Awaiting Driver',
            ],
        ];
    }

    /**
     * Get active tasks list (session merged with defaults).
     */
    private function getTasks(): array
    {
        $sessionTasks = session('pickup_delivery_tasks');
        if (is_array($sessionTasks) && count($sessionTasks) > 0) {
            return $sessionTasks;
        }

        $default = $this->getDefaultTasks();
        session(['pickup_delivery_tasks' => $default]);
        return $default;
    }

    /**
     * Save tasks to session.
     */
    private function saveTasks(array $tasks): void
    {
        session(['pickup_delivery_tasks' => array_values($tasks)]);
    }

    /**
     * Display the Pickup & Delivery management page.
     */
    public function index(Request $request)
    {
        $kpi = [
            'today_pickups' => 24,
            'today_deliveries' => 18,
            'on_the_road' => 6,
            'pending_assignment' => 4,
        ];

        // Active Delivery Highlight on Map
        $activeDelivery = [
            'code' => '#4402',
            'title' => 'Grand Plaza Residences',
            'progress' => 85,
            'arrival_time' => '14:30',
            'remaining_time' => '12 MIN',
            'status' => 'On Track',
        ];

        $fleet = $this->getDefaultFleet();
        $tasks = $this->getTasks();

        // Search Filter
        $search = $request->get('search');
        if (!empty($search)) {
            $searchLower = strtolower(trim($search));
            $tasks = array_values(array_filter($tasks, function ($item) use ($searchLower) {
                return str_contains(strtolower($item['customer']), $searchLower)
                    || str_contains(strtolower($item['address']), $searchLower)
                    || str_contains(strtolower($item['task_type']), $searchLower)
                    || str_contains(strtolower($item['staff_name']), $searchLower)
                    || str_contains(strtolower($item['status']), $searchLower);
            }));
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'kpi' => $kpi,
                'active_delivery' => $activeDelivery,
                'fleet' => $fleet,
                'tasks' => $tasks,
            ]);
        }

        return view('pages.PickupAndDelivery', [
            'kpi' => $kpi,
            'activeDelivery' => $activeDelivery,
            'fleet' => $fleet,
            'tasks' => $tasks,
            'search' => $search,
        ]);
    }

    /**
     * Schedule a new pickup or delivery task.
     */
    public function scheduleTask(Request $request)
    {
        $validated = $request->validate([
            'customer' => 'required|string|max:150',
            'task_type' => 'required|in:PICKUP,DELIVERY',
            'address' => 'required|string|max:200',
            'time' => 'required|string|max:20',
            'staff_id' => 'nullable',
            'items_count' => 'nullable|string|max:100',
        ]);

        $tasks = $this->getTasks();
        $newId = count($tasks) > 0 ? max(array_column($tasks, 'id')) + 1 : 1;

        $staffName = 'Unassigned';
        $staffAvatar = null;
        $isUnassigned = true;
        $status = 'Pending';
        $statusBg = 'bg-[#FEE2E2] text-[#DC2626]';

        if (!empty($validated['staff_id'])) {
            $fleet = $this->getDefaultFleet();
            foreach ($fleet as $member) {
                if ($member['id'] == $validated['staff_id']) {
                    $staffName = $member['short_name'];
                    $staffAvatar = $member['avatar'];
                    $isUnassigned = false;
                    $status = 'Scheduled';
                    $statusBg = 'bg-[#F1F5F9] text-[#475569]';
                    break;
                }
            }
        }

        $typeBg = $validated['task_type'] === 'PICKUP' 
            ? 'bg-[#DBEAFE] text-[#2563EB]' 
            : 'bg-[#CCFBF1] text-[#0D9488]';

        $newTask = [
            'id' => $newId,
            'date' => 'Today',
            'time' => $validated['time'],
            'customer' => trim($validated['customer']),
            'task_type' => $validated['task_type'],
            'task_type_bg' => $typeBg,
            'address' => trim($validated['address']),
            'staff_id' => $validated['staff_id'] ? (int) $validated['staff_id'] : null,
            'staff_name' => $staffName,
            'staff_avatar' => $staffAvatar,
            'is_unassigned' => $isUnassigned,
            'status' => $status,
            'status_bg' => $statusBg,
            'items_count' => $validated['items_count'] ?? '1 Order Bundle',
            'estimated_arrival' => $validated['time'],
        ];

        array_unshift($tasks, $newTask);
        $this->saveTasks($tasks);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$validated['task_type']} task for '{$validated['customer']}' scheduled successfully!",
                'task' => $newTask,
            ]);
        }

        return redirect()->back()->with('success', 'New logistics task scheduled successfully!');
    }

    /**
     * Assign staff to an unassigned task.
     */
    public function assignStaff(Request $request, $id)
    {
        $validated = $request->validate([
            'staff_id' => 'required|integer',
        ]);

        $tasks = $this->getTasks();
        $fleet = $this->getDefaultFleet();

        $selectedDriver = null;
        foreach ($fleet as $member) {
            if ($member['id'] == $validated['staff_id']) {
                $selectedDriver = $member;
                break;
            }
        }

        if (!$selectedDriver) {
            return response()->json(['success' => false, 'message' => 'Driver not found.'], 404);
        }

        $updated = false;
        foreach ($tasks as &$task) {
            if ($task['id'] == $id) {
                $task['staff_id'] = $selectedDriver['id'];
                $task['staff_name'] = $selectedDriver['short_name'];
                $task['staff_avatar'] = $selectedDriver['avatar'];
                $task['is_unassigned'] = false;
                $task['status'] = 'Scheduled';
                $task['status_bg'] = 'bg-[#F1F5F9] text-[#475569]';
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $this->saveTasks($tasks);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Task #{$id} assigned to {$selectedDriver['name']}!",
            ]);
        }

        return redirect()->back()->with('success', 'Driver assigned successfully!');
    }

    /**
     * Export tasks report to CSV.
     */
    public function export($format = 'csv')
    {
        $tasks = $this->getTasks();
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
            fputcsv($file, ['Task ID', 'Date', 'Time', 'Customer', 'Task Type', 'Address', 'Driver Staff', 'Status', 'Cargo Details']);

            foreach ($tasks as $task) {
                fputcsv($file, [
                    $task['id'],
                    $task['date'],
                    $task['time'],
                    $task['customer'],
                    $task['task_type'],
                    $task['address'],
                    $task['staff_name'],
                    $task['status'],
                    $task['items_count'] ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
