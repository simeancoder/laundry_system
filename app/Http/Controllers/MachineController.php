<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Get all machines with session persistence.
     */
    private function getAllMachines(): array
    {
        if (session()->has('mock_machines')) {
            return session('mock_machines');
        }
        $defaults = $this->getBaselineMachines();
        session(['mock_machines' => $defaults]);
        return $defaults;
    }

    /**
     * Complete 24 Machine Units Dataset matching "Total Units: 24" in screenshot.
     */
    private function getBaselineMachines(): array
    {
        return [
            // Page 1 (Matching screenshot exactly)
            [
                'id' => 1,
                'serial_id' => 'WM-101',
                'model' => 'TuboWash 9000',
                'type' => 'Washer',
                'full_model' => "TuboWash\n9000\n(Washer)",
                'installation_date' => '15 Jan 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Main Floor - Zone A',
                'cycles_today' => 8,
                'total_cycles' => 1240,
                'temperature' => '60°C',
                'motor_health' => '98%',
                'last_serviced' => '10 Aug 2026',
            ],
            [
                'id' => 2,
                'serial_id' => 'WM-111',
                'model' => 'EcoWash Lite',
                'type' => 'Washer',
                'full_model' => "EcoWash\nLite\n(Washer)",
                'installation_date' => '05 Mar 2024',
                'status' => 'Idle',
                'status_color' => 'bg-blue-100 text-blue-700',
                'location' => 'Express Bay - Zone B',
                'cycles_today' => 3,
                'total_cycles' => 420,
                'temperature' => 'Room Temp',
                'motor_health' => '100%',
                'last_serviced' => '01 Sep 2026',
            ],
            [
                'id' => 3,
                'serial_id' => 'WM-112',
                'model' => 'HeatDry Pro',
                'type' => 'Dryer',
                'full_model' => "HeatDry\nPro (Dryer)",
                'installation_date' => '25 Oct 2022',
                'status' => 'Alert',
                'status_color' => 'bg-amber-100 text-amber-700',
                'location' => 'Commercial Wing',
                'cycles_today' => 12,
                'total_cycles' => 3100,
                'temperature' => '78°C (High)',
                'motor_health' => '72%',
                'last_serviced' => '15 Jun 2026',
            ],
            [
                'id' => 4,
                'serial_id' => 'WM-102',
                'model' => 'SpeedClean Super',
                'type' => 'Washer',
                'full_model' => "SpeedClean\nSuper\n(Washer)",
                'installation_date' => '12 Feb 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Main Floor - Zone A',
                'cycles_today' => 9,
                'total_cycles' => 1480,
                'temperature' => '40°C',
                'motor_health' => '95%',
                'last_serviced' => '12 Jul 2026',
            ],
            [
                'id' => 5,
                'serial_id' => 'HD-102',
                'model' => 'AeroDry Industrial',
                'type' => 'Dryer',
                'full_model' => "AeroDry\nIndustrial\n(Dryer)",
                'installation_date' => '18 Jun 2023',
                'status' => 'Repairing',
                'status_color' => 'bg-rose-100 text-rose-700',
                'location' => 'Maintenance Bay',
                'cycles_today' => 0,
                'total_cycles' => 2950,
                'temperature' => 'Offline',
                'motor_health' => '64%',
                'last_serviced' => 'Under Repair',
            ],
            // Page 2
            [
                'id' => 6,
                'serial_id' => 'WM-103',
                'model' => 'AquaMaster 500',
                'type' => 'Washer',
                'full_model' => "AquaMaster\n500\n(Washer)",
                'installation_date' => '02 Apr 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Main Floor - Zone A',
                'cycles_today' => 7,
                'total_cycles' => 1120,
                'temperature' => '50°C',
                'motor_health' => '96%',
                'last_serviced' => '05 Aug 2026',
            ],
            [
                'id' => 7,
                'serial_id' => 'WM-104',
                'model' => 'TuboWash 9000',
                'type' => 'Washer',
                'full_model' => "TuboWash\n9000\n(Washer)",
                'installation_date' => '15 Jan 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Main Floor - Zone B',
                'cycles_today' => 6,
                'total_cycles' => 1280,
                'temperature' => '40°C',
                'motor_health' => '97%',
                'last_serviced' => '10 Aug 2026',
            ],
            [
                'id' => 8,
                'serial_id' => 'HD-103',
                'model' => 'HeatDry Pro',
                'type' => 'Dryer',
                'full_model' => "HeatDry\nPro (Dryer)",
                'installation_date' => '10 Nov 2022',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Commercial Wing',
                'cycles_today' => 11,
                'total_cycles' => 2840,
                'temperature' => '65°C',
                'motor_health' => '91%',
                'last_serviced' => '20 Jul 2026',
            ],
            [
                'id' => 9,
                'serial_id' => 'PR-101',
                'model' => 'SteamPress Max',
                'type' => 'Presser',
                'full_model' => "SteamPress\nMax (Presser)",
                'installation_date' => '08 Aug 2023',
                'status' => 'Idle',
                'status_color' => 'bg-blue-100 text-blue-700',
                'location' => 'VIP Section',
                'cycles_today' => 4,
                'total_cycles' => 650,
                'temperature' => '120°C',
                'motor_health' => '99%',
                'last_serviced' => '15 Aug 2026',
            ],
            [
                'id' => 10,
                'serial_id' => 'WM-105',
                'model' => 'EcoWash Lite',
                'type' => 'Washer',
                'full_model' => "EcoWash\nLite\n(Washer)",
                'installation_date' => '20 Mar 2024',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Express Bay - Zone B',
                'cycles_today' => 8,
                'total_cycles' => 380,
                'temperature' => '30°C',
                'motor_health' => '100%',
                'last_serviced' => '25 Aug 2026',
            ],
            // Page 3
            [
                'id' => 11,
                'serial_id' => 'WM-106',
                'model' => 'HeavyDuty 1200',
                'type' => 'Washer',
                'full_model' => "HeavyDuty\n1200\n(Washer)",
                'installation_date' => '14 May 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Commercial Wing',
                'cycles_today' => 10,
                'total_cycles' => 2100,
                'temperature' => '60°C',
                'motor_health' => '93%',
                'last_serviced' => '02 Jul 2026',
            ],
            [
                'id' => 12,
                'serial_id' => 'HD-104',
                'model' => 'HeatDry Pro',
                'type' => 'Dryer',
                'full_model' => "HeatDry\nPro (Dryer)",
                'installation_date' => '22 Dec 2022',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Commercial Wing',
                'cycles_today' => 9,
                'total_cycles' => 2750,
                'temperature' => '70°C',
                'motor_health' => '89%',
                'last_serviced' => '18 Jun 2026',
            ],
            [
                'id' => 13,
                'serial_id' => 'WM-107',
                'model' => 'TuboWash 9000',
                'type' => 'Washer',
                'full_model' => "TuboWash\n9000\n(Washer)",
                'installation_date' => '15 Jan 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Main Floor - Zone A',
                'cycles_today' => 7,
                'total_cycles' => 1310,
                'temperature' => '40°C',
                'motor_health' => '96%',
                'last_serviced' => '10 Aug 2026',
            ],
            [
                'id' => 14,
                'serial_id' => 'WM-108',
                'model' => 'EcoWash Lite',
                'type' => 'Washer',
                'full_model' => "EcoWash\nLite\n(Washer)",
                'installation_date' => '05 Apr 2024',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Express Bay - Zone B',
                'cycles_today' => 5,
                'total_cycles' => 290,
                'temperature' => '30°C',
                'motor_health' => '100%',
                'last_serviced' => '28 Aug 2026',
            ],
            [
                'id' => 15,
                'serial_id' => 'PR-102',
                'model' => 'SteamPress Max',
                'type' => 'Presser',
                'full_model' => "SteamPress\nMax (Presser)",
                'installation_date' => '15 Sep 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'VIP Section',
                'cycles_today' => 6,
                'total_cycles' => 780,
                'temperature' => '130°C',
                'motor_health' => '97%',
                'last_serviced' => '12 Aug 2026',
            ],
            // Page 4
            [
                'id' => 16,
                'serial_id' => 'WM-109',
                'model' => 'AquaMaster 500',
                'type' => 'Washer',
                'full_model' => "AquaMaster\n500\n(Washer)",
                'installation_date' => '10 May 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Main Floor - Zone B',
                'cycles_today' => 8,
                'total_cycles' => 1190,
                'temperature' => '40°C',
                'motor_health' => '95%',
                'last_serviced' => '08 Aug 2026',
            ],
            [
                'id' => 17,
                'serial_id' => 'HD-105',
                'model' => 'AeroDry Industrial',
                'type' => 'Dryer',
                'full_model' => "AeroDry\nIndustrial\n(Dryer)",
                'installation_date' => '30 Jul 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Commercial Wing',
                'cycles_today' => 10,
                'total_cycles' => 1950,
                'temperature' => '65°C',
                'motor_health' => '92%',
                'last_serviced' => '14 Jul 2026',
            ],
            [
                'id' => 18,
                'serial_id' => 'WM-110',
                'model' => 'SpeedClean Super',
                'type' => 'Washer',
                'full_model' => "SpeedClean\nSuper\n(Washer)",
                'installation_date' => '01 Jul 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Main Floor - Zone A',
                'cycles_today' => 7,
                'total_cycles' => 1390,
                'temperature' => '45°C',
                'motor_health' => '96%',
                'last_serviced' => '22 Jul 2026',
            ],
            [
                'id' => 19,
                'serial_id' => 'HD-106',
                'model' => 'HeatDry Pro',
                'type' => 'Dryer',
                'full_model' => "HeatDry\nPro (Dryer)",
                'installation_date' => '12 Jan 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Commercial Wing',
                'cycles_today' => 9,
                'total_cycles' => 2480,
                'temperature' => '68°C',
                'motor_health' => '90%',
                'last_serviced' => '03 Aug 2026',
            ],
            [
                'id' => 20,
                'serial_id' => 'WM-113',
                'model' => 'EcoWash Lite',
                'type' => 'Washer',
                'full_model' => "EcoWash\nLite\n(Washer)",
                'installation_date' => '15 Apr 2024',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Express Bay - Zone B',
                'cycles_today' => 4,
                'total_cycles' => 210,
                'temperature' => '30°C',
                'motor_health' => '100%',
                'last_serviced' => '02 Sep 2026',
            ],
            // Page 5
            [
                'id' => 21,
                'serial_id' => 'WM-114',
                'model' => 'TuboWash 9000',
                'type' => 'Washer',
                'full_model' => "TuboWash\n9000\n(Washer)",
                'installation_date' => '15 Jan 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Main Floor - Zone A',
                'cycles_today' => 6,
                'total_cycles' => 1290,
                'temperature' => '40°C',
                'motor_health' => '96%',
                'last_serviced' => '10 Aug 2026',
            ],
            [
                'id' => 22,
                'serial_id' => 'HD-107',
                'model' => 'HeatDry Pro',
                'type' => 'Dryer',
                'full_model' => "HeatDry\nPro (Dryer)",
                'installation_date' => '18 Feb 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Commercial Wing',
                'cycles_today' => 8,
                'total_cycles' => 2340,
                'temperature' => '65°C',
                'motor_health' => '93%',
                'last_serviced' => '19 Jul 2026',
            ],
            [
                'id' => 23,
                'serial_id' => 'PR-103',
                'model' => 'SteamPress Max',
                'type' => 'Presser',
                'full_model' => "SteamPress\nMax (Presser)",
                'installation_date' => '25 Oct 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'VIP Section',
                'cycles_today' => 5,
                'total_cycles' => 510,
                'temperature' => '125°C',
                'motor_health' => '98%',
                'last_serviced' => '05 Aug 2026',
            ],
            [
                'id' => 24,
                'serial_id' => 'WM-115',
                'model' => 'HeavyDuty 1200',
                'type' => 'Washer',
                'full_model' => "HeavyDuty\n1200\n(Washer)",
                'installation_date' => '12 Jun 2023',
                'status' => 'Running',
                'status_color' => 'bg-emerald-100 text-emerald-700',
                'location' => 'Commercial Wing',
                'cycles_today' => 9,
                'total_cycles' => 1890,
                'temperature' => '60°C',
                'motor_health' => '94%',
                'last_serviced' => '15 Jul 2026',
            ],
        ];
    }

    /**
     * Display Machine Management dashboard.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $typeFilter = $request->get('type', 'all');
        $statusFilter = $request->get('status', 'all');
        $locationFilter = $request->get('location', 'all');
        $page = (int) $request->get('page', 1);
        $perPage = 5;

        // 4 KPI Stats matching the screenshot exactly
        $stats = [
            'total_units' => 24,
            'total_units_change' => '+2 this month',
            'active_cycles' => 20,
            'active_cycles_pct' => '83%',
            'maintenance_alerts' => 2,
            'maintenance_status' => 'Critical',
            'upcoming_service' => 24,
            'upcoming_period' => 'This week',
        ];

        $allMachines = collect($this->getAllMachines());

        // Apply Type Filter
        if (!empty($typeFilter) && $typeFilter !== 'all') {
            $allMachines = $allMachines->filter(function ($item) use ($typeFilter) {
                return strtolower($item['type']) === strtolower($typeFilter);
            });
        }

        // Apply Status Filter
        if (!empty($statusFilter) && $statusFilter !== 'all') {
            $allMachines = $allMachines->filter(function ($item) use ($statusFilter) {
                return strtolower($item['status']) === strtolower($statusFilter);
            });
        }

        // Apply Location Filter
        if (!empty($locationFilter) && $locationFilter !== 'all') {
            $allMachines = $allMachines->filter(function ($item) use ($locationFilter) {
                return str_contains(strtolower($item['location']), strtolower($locationFilter));
            });
        }

        // Apply Search Filter
        if (!empty($search)) {
            $searchLower = strtolower($search);
            $allMachines = $allMachines->filter(function ($item) use ($searchLower) {
                return str_contains(strtolower($item['serial_id']), $searchLower)
                    || str_contains(strtolower($item['model']), $searchLower)
                    || str_contains(strtolower($item['type']), $searchLower)
                    || str_contains(strtolower($item['location']), $searchLower)
                    || str_contains(strtolower($item['installation_date']), $searchLower);
            });
        }

        $totalFiltered = $allMachines->count();
        $totalPages = max(1, (int) ceil($totalFiltered / $perPage));
        $currentPage = min(max(1, $page), $totalPages);
        $offset = ($currentPage - 1) * $perPage;

        $pagedItems = $allMachines->slice($offset, $perPage)->values();
        $from = $totalFiltered > 0 ? $offset + 1 : 0;
        $to = min($offset + $perPage, $totalFiltered);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pagedItems,
                'all' => $this->getAllMachines(),
                'pagination' => [
                    'current_page' => $currentPage,
                    'last_page' => $totalPages,
                    'per_page' => $perPage,
                    'total' => $totalFiltered,
                    'from' => $from,
                    'to' => $to,
                ],
                'stats' => $stats,
            ]);
        }

        $promotions = $this->getAllPromotions();
        $promoStats = $this->getPromoStats();

        return view('pages.machine', [
            'stats' => $stats,
            'machines' => $pagedItems,
            'allMachines' => $this->getAllMachines(),
            'promotions' => $promotions,
            'promoStats' => $promoStats,
            'search' => $search,
            'typeFilter' => $typeFilter,
            'statusFilter' => $statusFilter,
            'locationFilter' => $locationFilter,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'from' => $from,
            'to' => $to,
            'totalItems' => $totalFiltered,
        ]);
    }

    /**
     * Store a newly created machine unit.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial_id' => 'required|string|max:50',
            'model' => 'required|string|max:100',
            'type' => 'required|string|in:Washer,Dryer,Presser',
            'installation_date' => 'required|string|max:50',
            'status' => 'required|string|in:Running,Idle,Alert,Repairing',
            'location' => 'required|string|max:100',
        ]);

        $machines = $this->getAllMachines();
        $newId = count($machines) > 0 ? (max(array_column($machines, 'id')) + 1) : 1;

        $statusColors = [
            'Running' => 'bg-emerald-100 text-emerald-700',
            'Idle' => 'bg-blue-100 text-blue-700',
            'Alert' => 'bg-amber-100 text-amber-700',
            'Repairing' => 'bg-rose-100 text-rose-700',
        ];

        $newMachine = [
            'id' => $newId,
            'serial_id' => trim($validated['serial_id']),
            'model' => trim($validated['model']),
            'type' => trim($validated['type']),
            'full_model' => "{$validated['model']}\n({$validated['type']})",
            'installation_date' => $validated['installation_date'],
            'status' => $validated['status'],
            'status_color' => $statusColors[$validated['status']] ?? 'bg-blue-100 text-blue-700',
            'location' => trim($validated['location']),
            'cycles_today' => 0,
            'total_cycles' => 0,
            'temperature' => 'Room Temp',
            'motor_health' => '100%',
            'last_serviced' => date('d M Y'),
        ];

        array_unshift($machines, $newMachine);
        session(['mock_machines' => $machines]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Machine unit {$validated['serial_id']} registered successfully!",
                'data' => $newMachine,
            ]);
        }

        return redirect()->back()->with('success', "Machine unit {$validated['serial_id']} added successfully!");
    }

    /**
     * Update existing machine unit.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'serial_id' => 'required|string|max:50',
            'model' => 'required|string|max:100',
            'type' => 'required|string',
            'status' => 'required|string',
            'location' => 'required|string',
        ]);

        $machines = $this->getAllMachines();
        $statusColors = [
            'Running' => 'bg-emerald-100 text-emerald-700',
            'Idle' => 'bg-blue-100 text-blue-700',
            'Alert' => 'bg-amber-100 text-amber-700',
            'Repairing' => 'bg-rose-100 text-rose-700',
        ];

        foreach ($machines as &$m) {
            if ($m['id'] == $id || ($m['serial_id'] ?? '') == $id) {
                $m['serial_id'] = trim($validated['serial_id']);
                $m['model'] = trim($validated['model']);
                $m['type'] = trim($validated['type']);
                $m['full_model'] = "{$validated['model']}\n({$validated['type']})";
                $m['status'] = $validated['status'];
                $m['status_color'] = $statusColors[$validated['status']] ?? 'bg-blue-100 text-blue-700';
                $m['location'] = trim($validated['location']);
                break;
            }
        }
        unset($m);

        session(['mock_machines' => $machines]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Machine #{$id} ({$validated['serial_id']}) updated successfully!",
                'data' => $validated,
            ]);
        }

        return redirect()->back()->with('success', "Machine #{$id} updated successfully!");
    }

    /**
     * Delete or decommission a machine unit.
     */
    public function destroy(Request $request, $id)
    {
        $machines = $this->getAllMachines();
        $machines = array_values(array_filter($machines, function ($m) use ($id) {
            return $m['id'] != $id && ($m['serial_id'] ?? '') != $id;
        }));

        session(['mock_machines' => $machines]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Machine unit #{$id} has been decommissioned and archived.",
                'id' => $id,
            ]);
        }

        return redirect()->back()->with('success', "Machine unit #{$id} decommissioned successfully!");
    }

    /**
     * Export machine inventory report.
     */
    public function export($format = 'csv')
    {
        $machines = $this->getAllMachines();
        $format = strtolower($format);

        if ($format === 'csv' || $format === 'excel') {
            $filename = 'machine_inventory_' . date('Y_m_d_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];

            $callback = function () use ($machines) {
                $file = fopen('php://output', 'w');
                // UTF-8 BOM for Microsoft Excel compatibility
                fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
                fputcsv($file, ['ID', 'Serial ID', 'Model', 'Type', 'Installation Date', 'Status', 'Location', 'Total Cycles', 'Health', 'Last Serviced']);

                foreach ($machines as $m) {
                    fputcsv($file, [
                        $m['id'],
                        $m['serial_id'],
                        $m['model'],
                        $m['type'],
                        $m['installation_date'],
                        $m['status'],
                        $m['location'],
                        $m['total_cycles'],
                        $m['motor_health'],
                        $m['last_serviced'] ?? 'N/A',
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        if ($format === 'pdf') {
            return view('pages.service.machine_print', [
                'machines' => $machines,
                'stats' => [
                    'total_units' => 24,
                    'active_cycles' => 20,
                    'maintenance_alerts' => 2,
                    'upcoming_service' => 24,
                ],
                'printedAt' => date('d/M/Y H:i:s'),
                'printedBy' => auth()->check() ? auth()->user()->name : 'Admin',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Machine inventory report ready for export ({$format}).",
            'total' => count($machines),
        ]);
    }

    /**
     * Get all promotions with session & database persistence.
     */
    public function getAllPromotions(): array
    {
        if (session()->has('mock_promotions')) {
            return session('mock_promotions');
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('promotions')) {
                $dbPromos = \App\Models\Promotion::orderBy('id', 'desc')->get()->toArray();
                if (!empty($dbPromos)) {
                    session(['mock_promotions' => $dbPromos]);
                    return $dbPromos;
                }
            }
        } catch (\Throwable $e) {}

        $defaults = $this->getBaselinePromotions();
        session(['mock_promotions' => $defaults]);
        return $defaults;
    }

    /**
     * Baseline promotional campaigns dataset.
     */
    public function getBaselinePromotions(): array
    {
        return [
            [
                'id' => 1,
                'code' => 'WASHER20',
                'title' => 'Washer Wednesday Special',
                'description' => '20% off all front-load washing cycles on Wednesdays and weekends.',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'applies_to' => 'Washers',
                'min_spend' => 10.00,
                'max_discount' => 15.00,
                'start_date' => '2026-09-01',
                'end_date' => '2026-12-31',
                'usage_limit' => 100,
                'used_count' => 58,
                'status' => 'Active',
            ],
            [
                'id' => 2,
                'code' => 'DRYFREESHIP',
                'title' => 'Free Drying & Express Dispatch',
                'description' => 'Save $5.00 instantly on all heavy dryer tumble cycles.',
                'discount_type' => 'fixed',
                'discount_value' => 5.00,
                'applies_to' => 'Dryers',
                'min_spend' => 20.00,
                'max_discount' => 5.00,
                'start_date' => '2026-09-10',
                'end_date' => '2026-11-15',
                'usage_limit' => 50,
                'used_count' => 34,
                'status' => 'Active',
            ],
            [
                'id' => 3,
                'code' => 'NEWCLEAN10',
                'title' => 'First-Time Customer Bonus',
                'description' => 'Welcome coupon for $3.00 off on any machine cycle or laundry service.',
                'discount_type' => 'fixed',
                'discount_value' => 3.00,
                'applies_to' => 'All Machines',
                'min_spend' => 5.00,
                'max_discount' => 3.00,
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
                'usage_limit' => 500,
                'used_count' => 89,
                'status' => 'Active',
            ],
            [
                'id' => 4,
                'code' => 'VIPBULK25',
                'title' => 'Commercial Wing Bulk Discount',
                'description' => 'Exclusive 25% discount for bulk commercial orders with 3+ machines.',
                'discount_type' => 'percentage',
                'discount_value' => 25,
                'applies_to' => 'Commercial Wing',
                'min_spend' => 50.00,
                'max_discount' => 35.00,
                'start_date' => '2026-09-01',
                'end_date' => '2026-11-30',
                'usage_limit' => 50,
                'used_count' => 21,
                'status' => 'Active',
            ],
            [
                'id' => 5,
                'code' => 'PRESSPRO15',
                'title' => 'Steam Pressing Weekend Rush',
                'description' => '15% off pressing & ironing units for delicate garments.',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'applies_to' => 'Presser Units',
                'min_spend' => 15.00,
                'max_discount' => 10.00,
                'start_date' => '2026-10-15',
                'end_date' => '2026-10-25',
                'usage_limit' => 75,
                'used_count' => 0,
                'status' => 'Scheduled',
            ],
            [
                'id' => 6,
                'code' => 'SUMMERDEAL',
                'title' => 'Sanitized High-Heat Clearance',
                'description' => '30% off high-temperature wash cycles and sanitized steam.',
                'discount_type' => 'percentage',
                'discount_value' => 30,
                'applies_to' => 'All Machines',
                'min_spend' => 30.00,
                'max_discount' => 20.00,
                'start_date' => '2026-08-01',
                'end_date' => '2026-09-01',
                'usage_limit' => 120,
                'used_count' => 120,
                'status' => 'Expired',
            ],
        ];
    }

    /**
     * Compute Promotion KPIs.
     */
    public function getPromoStats(): array
    {
        $promos = $this->getAllPromotions();
        $activeCount = count(array_filter($promos, fn($p) => ($p['status'] ?? '') === 'Active'));
        $totalRedemptions = array_sum(array_column($promos, 'used_count'));

        return [
            'total_promotions' => count($promos),
            'active_promotions' => $activeCount,
            'total_savings' => '$1,280.50',
            'total_redemptions' => $totalRedemptions,
            'top_code' => 'WASHER20',
        ];
    }

    /**
     * Handle Promotions Index API / Direct View.
     */
    public function promotionsIndex(Request $request)
    {
        $promotions = $this->getAllPromotions();
        $stats = $this->getPromoStats();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'promotions' => $promotions,
                'stats' => $stats,
            ]);
        }

        return redirect()->route('machines.index', ['#discountsPromotionsSection']);
    }

    /**
     * Store a newly created Promotion.
     */
    public function storePromotion(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'title' => 'required|string|max:150',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'applies_to' => 'required|string|max:100',
            'min_spend' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|string|max:50',
            'end_date' => 'nullable|string|max:50',
            'usage_limit' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:500',
            'status' => 'nullable|in:Active,Scheduled,Paused,Expired',
        ]);

        $promos = $this->getAllPromotions();
        $newId = count($promos) > 0 ? (max(array_column($promos, 'id')) + 1) : 1;

        $codeClean = strtoupper(trim($validated['code']));

        $newPromo = [
            'id' => $newId,
            'code' => $codeClean,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? 'Promotion campaign for laundry machines and wash cycles.',
            'discount_type' => $validated['discount_type'],
            'discount_value' => (float) $validated['discount_value'],
            'applies_to' => $validated['applies_to'],
            'min_spend' => (float) ($validated['min_spend'] ?? 0),
            'max_discount' => isset($validated['max_discount']) && $validated['max_discount'] > 0 ? (float) $validated['max_discount'] : null,
            'start_date' => $validated['start_date'] ?: date('Y-m-d'),
            'end_date' => $validated['end_date'] ?: date('Y-m-d', strtotime('+30 days')),
            'usage_limit' => (int) ($validated['usage_limit'] ?? 100),
            'used_count' => 0,
            'status' => $validated['status'] ?? 'Active',
        ];

        array_unshift($promos, $newPromo);
        session(['mock_promotions' => $promos]);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('promotions')) {
                \App\Models\Promotion::create($newPromo);
            }
        } catch (\Throwable $e) {}

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Promotion code {$codeClean} registered successfully!",
                'promotion' => $newPromo,
                'stats' => $this->getPromoStats(),
            ]);
        }

        return redirect()->route('machines.index')
            ->with('success', "Promotion code {$codeClean} added successfully!");
    }

    /**
     * Update an existing Promotion.
     */
    public function updatePromotion(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'applies_to' => 'required|string|max:100',
            'min_spend' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|string|max:50',
            'end_date' => 'nullable|string|max:50',
            'usage_limit' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:500',
            'status' => 'nullable|in:Active,Scheduled,Paused,Expired',
        ]);

        $promos = $this->getAllPromotions();
        $updatedItem = null;

        foreach ($promos as &$p) {
            if ($p['id'] == $id) {
                $p['title'] = $validated['title'];
                $p['discount_type'] = $validated['discount_type'];
                $p['discount_value'] = (float) $validated['discount_value'];
                $p['applies_to'] = $validated['applies_to'];
                $p['min_spend'] = (float) ($validated['min_spend'] ?? 0);
                $p['max_discount'] = isset($validated['max_discount']) && $validated['max_discount'] > 0 ? (float) $validated['max_discount'] : null;
                if (!empty($validated['start_date'])) $p['start_date'] = $validated['start_date'];
                if (!empty($validated['end_date'])) $p['end_date'] = $validated['end_date'];
                if (!empty($validated['usage_limit'])) $p['usage_limit'] = (int) $validated['usage_limit'];
                if (!empty($validated['description'])) $p['description'] = $validated['description'];
                if (!empty($validated['status'])) $p['status'] = $validated['status'];
                $updatedItem = $p;
                break;
            }
        }
        unset($p);

        session(['mock_promotions' => $promos]);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('promotions')) {
                \App\Models\Promotion::where('id', $id)->update(array_filter($validated));
            }
        } catch (\Throwable $e) {}

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Promotion updated successfully!",
                'promotion' => $updatedItem,
                'stats' => $this->getPromoStats(),
            ]);
        }

        return redirect()->route('machines.index')
            ->with('success', "Promotion updated successfully!");
    }

    /**
     * Delete / Deactivate a Promotion.
     */
    public function destroyPromotion(Request $request, $id)
    {
        $promos = $this->getAllPromotions();
        $promos = array_values(array_filter($promos, fn($p) => $p['id'] != $id));
        session(['mock_promotions' => $promos]);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('promotions')) {
                \App\Models\Promotion::where('id', $id)->delete();
            }
        } catch (\Throwable $e) {}

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Promotion removed successfully.",
                'stats' => $this->getPromoStats(),
            ]);
        }

        return redirect()->route('machines.index')
            ->with('success', "Promotion deleted successfully.");
    }

    /**
     * Toggle Promotion Active / Paused.
     */
    public function togglePromotion(Request $request, $id)
    {
        $promos = $this->getAllPromotions();
        $newStatus = 'Active';

        foreach ($promos as &$p) {
            if ($p['id'] == $id) {
                $p['status'] = ($p['status'] === 'Active') ? 'Paused' : 'Active';
                $newStatus = $p['status'];
                break;
            }
        }
        unset($p);

        session(['mock_promotions' => $promos]);

        return response()->json([
            'success' => true,
            'new_status' => $newStatus,
            'message' => "Promotion status updated to {$newStatus}.",
            'stats' => $this->getPromoStats(),
        ]);
    }

    /**
     * Test and Apply Discount Calculation.
     */
    public function applyPromotion(Request $request)
    {
        $code = strtoupper(trim($request->input('code', '')));
        $amount = (float) $request->input('amount', 0);

        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Please enter a valid promotion code.'], 422);
        }

        $promos = $this->getAllPromotions();
        $promo = collect($promos)->firstWhere('code', $code);

        if (!$promo) {
            return response()->json(['success' => false, 'message' => "Promo code '{$code}' not found."], 404);
        }

        if ($promo['status'] !== 'Active') {
            return response()->json(['success' => false, 'message' => "Promotion '{$code}' is currently {$promo['status']}."], 400);
        }

        if ($promo['min_spend'] > 0 && $amount < $promo['min_spend']) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order amount of $" . number_format($promo['min_spend'], 2) . " required for code '{$code}'."
            ], 400);
        }

        $discount = 0.00;
        if ($promo['discount_type'] === 'percentage') {
            $discount = round(($amount * $promo['discount_value']) / 100, 2);
            if (!empty($promo['max_discount']) && $discount > $promo['max_discount']) {
                $discount = (float) $promo['max_discount'];
            }
        } else {
            $discount = (float) $promo['discount_value'];
        }

        $discount = min($discount, $amount);
        $finalAmount = max(0, $amount - $discount);

        return response()->json([
            'success' => true,
            'valid' => true,
            'code' => $code,
            'title' => $promo['title'],
            'discount_type' => $promo['discount_type'],
            'discount_value' => $promo['discount_value'],
            'discount_amount' => $discount,
            'original_amount' => $amount,
            'final_amount' => $finalAmount,
            'applies_to' => $promo['applies_to'],
            'message' => "Promo code '{$code}' applied! You saved $" . number_format($discount, 2) . ".",
        ]);
    }
}
