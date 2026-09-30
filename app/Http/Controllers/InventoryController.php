<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Complete 25 Inventory Items Dataset matching "Showing 1 to 6 of 25 items" in screenshot.
     */
    private function getDefaultInventory(): array
    {
        return [
            // Page 1 (Matching screenshot exactly)
            [
                'id' => 1,
                'name' => 'Detergent',
                'category' => 'Cleaning',
                'stock' => 50,
                'unit' => 'L',
                'status' => 'In Stock',
                'min_threshold' => 20,
                'notes' => 'Commercial grade liquid laundry detergent for heavy soiled wash cycles.',
                'last_restocked' => '18 Sep 2026',
            ],
            [
                'id' => 2,
                'name' => 'Softener',
                'category' => 'Cleaning',
                'stock' => 40,
                'unit' => 'L',
                'status' => 'In Stock',
                'min_threshold' => 15,
                'notes' => 'Floral scented fabric conditioner for delicate and everyday fabrics.',
                'last_restocked' => '17 Sep 2026',
            ],
            [
                'id' => 3,
                'name' => 'Bleach',
                'category' => 'Cleaning',
                'stock' => 10,
                'unit' => 'L',
                'status' => 'Low Stock',
                'min_threshold' => 15,
                'notes' => 'Color-safe chlorine bleach for stain removal on white linens.',
                'last_restocked' => '10 Sep 2026',
            ],
            [
                'id' => 4,
                'name' => 'Packing Bags',
                'category' => 'Packing',
                'stock' => 100,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 30,
                'notes' => 'Heavy-duty polythene laundry carry bags with sealed base.',
                'last_restocked' => '20 Sep 2026',
            ],
            [
                'id' => 5,
                'name' => 'Hangers',
                'category' => 'Accessories',
                'stock' => 200,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 50,
                'notes' => 'Heavy gauge galvanized wire & plastic finished garment hangers.',
                'last_restocked' => '19 Sep 2026',
            ],
            [
                'id' => 6,
                'name' => 'Cleaning Chemicals',
                'category' => 'Chemicals',
                'stock' => 15,
                'unit' => 'L',
                'status' => 'Low Stock',
                'min_threshold' => 20,
                'notes' => 'Enzyme-based grease and tannin chemical spotting reagents.',
                'last_restocked' => '12 Sep 2026',
            ],

            // Page 2
            [
                'id' => 7,
                'name' => 'Stain Remover Pro',
                'category' => 'Cleaning',
                'stock' => 25,
                'unit' => 'L',
                'status' => 'In Stock',
                'min_threshold' => 10,
                'notes' => 'Targeted pre-wash formulation for collar and cuff grime.',
                'last_restocked' => '14 Sep 2026',
            ],
            [
                'id' => 8,
                'name' => 'Fabric Conditioner',
                'category' => 'Cleaning',
                'stock' => 35,
                'unit' => 'L',
                'status' => 'In Stock',
                'min_threshold' => 10,
                'notes' => 'Hypoallergenic anti-static finishing conditioner.',
                'last_restocked' => '15 Sep 2026',
            ],
            [
                'id' => 9,
                'name' => 'Garment Poly Rolls',
                'category' => 'Packing',
                'stock' => 80,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 20,
                'notes' => 'Transparent dry clean cover rolls for suit hanging.',
                'last_restocked' => '16 Sep 2026',
            ],
            [
                'id' => 10,
                'name' => 'Laundry ID Tags',
                'category' => 'Accessories',
                'stock' => 500,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 100,
                'notes' => 'Waterproof barcode order identification tags.',
                'last_restocked' => '18 Sep 2026',
            ],
            [
                'id' => 11,
                'name' => 'Ironing Starch Spray',
                'category' => 'Chemicals',
                'stock' => 8,
                'unit' => 'L',
                'status' => 'Low Stock',
                'min_threshold' => 15,
                'notes' => 'Crisp finish fabric sizing and ironing starch agent.',
                'last_restocked' => '08 Sep 2026',
            ],
            [
                'id' => 12,
                'name' => 'Collar Supports',
                'category' => 'Accessories',
                'stock' => 300,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 80,
                'notes' => 'Plastic collar butterfly strips for folded dress shirts.',
                'last_restocked' => '19 Sep 2026',
            ],

            // Page 3
            [
                'id' => 13,
                'name' => 'Lint Rollers & Refills',
                'category' => 'Accessories',
                'stock' => 45,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 15,
                'notes' => 'Adhesive lint collection rolls for woolens and suits.',
                'last_restocked' => '11 Sep 2026',
            ],
            [
                'id' => 14,
                'name' => 'Descaling Chemical',
                'category' => 'Chemicals',
                'stock' => 5,
                'unit' => 'L',
                'status' => 'Low Stock',
                'min_threshold' => 10,
                'notes' => 'Commercial boiler and steam iron descaling acid solution.',
                'last_restocked' => '05 Sep 2026',
            ],
            [
                'id' => 15,
                'name' => 'Biodegradable Laundry Bags',
                'category' => 'Packing',
                'stock' => 85,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 25,
                'notes' => 'Eco-friendly biodegradable hotel laundry sacks.',
                'last_restocked' => '15 Sep 2026',
            ],
            [
                'id' => 16,
                'name' => 'Scent Boosters Granules',
                'category' => 'Cleaning',
                'stock' => 22,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 10,
                'notes' => 'Slow-release freshness booster beads.',
                'last_restocked' => '13 Sep 2026',
            ],
            [
                'id' => 17,
                'name' => 'Washing Mesh Bags',
                'category' => 'Accessories',
                'stock' => 60,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 20,
                'notes' => 'Zippered mesh bags for delicate lingerie and silks.',
                'last_restocked' => '14 Sep 2026',
            ],
            [
                'id' => 18,
                'name' => 'Spotting Chemical Solvent',
                'category' => 'Chemicals',
                'stock' => 6,
                'unit' => 'L',
                'status' => 'Low Stock',
                'min_threshold' => 12,
                'notes' => 'Target solvent for ink, lipstick, and oily spot removal.',
                'last_restocked' => '06 Sep 2026',
            ],

            // Page 4
            [
                'id' => 19,
                'name' => 'Safety Pins (Brass)',
                'category' => 'Accessories',
                'stock' => 1000,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 200,
                'notes' => 'Rust-proof brass tagging safety pins.',
                'last_restocked' => '10 Sep 2026',
            ],
            [
                'id' => 20,
                'name' => 'Dry Cleaning Hydrocarbon Solvent',
                'category' => 'Chemicals',
                'stock' => 30,
                'unit' => 'L',
                'status' => 'In Stock',
                'min_threshold' => 15,
                'notes' => 'Odorless high-purity dry cleaning solvent drum.',
                'last_restocked' => '17 Sep 2026',
            ],
            [
                'id' => 21,
                'name' => 'Plastic Trouser Clips',
                'category' => 'Accessories',
                'stock' => 400,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 100,
                'notes' => 'Non-marking plastic suspension clips for slacks and skirts.',
                'last_restocked' => '16 Sep 2026',
            ],
            [
                'id' => 22,
                'name' => 'Heat Seal Label Rolls',
                'category' => 'Packing',
                'stock' => 12,
                'unit' => 'Pcs',
                'status' => 'Low Stock',
                'min_threshold' => 15,
                'notes' => 'Thermal adhesive garment tag label ribbons.',
                'last_restocked' => '07 Sep 2026',
            ],
            [
                'id' => 23,
                'name' => 'Oxygen Bleach Powder',
                'category' => 'Cleaning',
                'stock' => 18,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 10,
                'notes' => 'Sodium percarbonate color-safe active oxygen compound.',
                'last_restocked' => '14 Sep 2026',
            ],
            [
                'id' => 24,
                'name' => 'Leather & Suede Conditioner',
                'category' => 'Chemicals',
                'stock' => 4,
                'unit' => 'L',
                'status' => 'Low Stock',
                'min_threshold' => 8,
                'notes' => 'Natural oil nourishing cream for leather jackets and shoes.',
                'last_restocked' => '04 Sep 2026',
            ],

            // Page 5
            [
                'id' => 25,
                'name' => 'Thermal Receipt Paper Rolls',
                'category' => 'Accessories',
                'stock' => 50,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_threshold' => 20,
                'notes' => '80mm BPA-free POS register thermal receipt paper rolls.',
                'last_restocked' => '18 Sep 2026',
            ],
        ];
    }

    /**
     * Get active inventory list (session merged with defaults).
     */
    private function getInventoryItems(): array
    {
        $sessionItems = session('inventory_items');
        if (is_array($sessionItems) && count($sessionItems) > 0) {
            return $sessionItems;
        }

        $default = $this->getDefaultInventory();
        session(['inventory_items' => $default]);
        return $default;
    }

    /**
     * Save inventory items to session.
     */
    private function saveInventoryItems(array $items): void
    {
        session(['inventory_items' => array_values($items)]);
    }

    /**
     * Display the Inventory Management page.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $categoryFilter = $request->get('category', 'all');
        $statusFilter = $request->get('status', 'all');
        $page = (int) $request->get('page', 1);
        $perPage = 6; // Exactly 6 items per page matching "Showing 1 to 6 of 25 items"

        $allItems = collect($this->getInventoryItems());

        // 1. Filter by Category
        if (!empty($categoryFilter) && $categoryFilter !== 'all') {
            $allItems = $allItems->filter(function ($item) use ($categoryFilter) {
                return strcasecmp($item['category'], $categoryFilter) === 0;
            });
        }

        // 2. Filter by Status
        if (!empty($statusFilter) && $statusFilter !== 'all') {
            $allItems = $allItems->filter(function ($item) use ($statusFilter) {
                return strcasecmp($item['status'], $statusFilter) === 0;
            });
        }

        // 3. Search Filter
        if (!empty($search)) {
            $searchLower = strtolower(trim($search));
            $allItems = $allItems->filter(function ($item) use ($searchLower) {
                return str_contains(strtolower($item['name']), $searchLower)
                    || str_contains(strtolower($item['category']), $searchLower)
                    || str_contains(strtolower($item['unit']), $searchLower)
                    || str_contains(strtolower($item['status']), $searchLower);
            });
        }

        $totalFiltered = $allItems->count();
        $totalPages = max(1, (int) ceil($totalFiltered / $perPage));
        $currentPage = min(max(1, $page), $totalPages);
        $offset = ($currentPage - 1) * $perPage;

        $pagedItems = $allItems->slice($offset, $perPage)->values();
        $from = $totalFiltered > 0 ? $offset + 1 : 0;
        $to = min($offset + $perPage, $totalFiltered);

        // Get unique categories and statuses for dropdown filters
        $allInventory = $this->getInventoryItems();
        $categories = collect($allInventory)->pluck('category')->unique()->values()->all();
        $statuses = ['In Stock', 'Low Stock', 'Out of Stock'];

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pagedItems,
                'pagination' => [
                    'current_page' => $currentPage,
                    'last_page' => $totalPages,
                    'per_page' => $perPage,
                    'total' => $totalFiltered,
                    'from' => $from,
                    'to' => $to,
                ],
            ]);
        }

        return view('pages.inventory', [
            'items' => $pagedItems,
            'allItems' => $allInventory,
            'categories' => $categories,
            'statuses' => $statuses,
            'search' => $search,
            'categoryFilter' => $categoryFilter,
            'statusFilter' => $statusFilter,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'from' => $from,
            'to' => $to,
            'totalFiltered' => $totalFiltered,
            'totalItems' => count($allInventory),
        ]);
    }

    /**
     * Store a new inventory item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'status' => 'required|string|max:50',
            'min_threshold' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $items = $this->getInventoryItems();
        $newId = count($items) > 0 ? max(array_column($items, 'id')) + 1 : 1;

        $newItem = [
            'id' => $newId,
            'name' => trim($validated['name']),
            'category' => trim($validated['category']),
            'stock' => (int) $validated['stock'],
            'unit' => trim($validated['unit']),
            'status' => trim($validated['status']),
            'min_threshold' => (int) ($validated['min_threshold'] ?? 10),
            'notes' => $validated['notes'] ?? '',
            'last_restocked' => date('d M Y'),
        ];

        // Add to beginning of inventory
        array_unshift($items, $newItem);
        $this->saveInventoryItems($items);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Item '{$newItem['name']}' added successfully!",
                'data' => $newItem,
            ]);
        }

        return redirect()->back()->with('success', "Item '{$newItem['name']}' added successfully!");
    }

    /**
     * Update an existing inventory item.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'status' => 'required|string|max:50',
            'min_threshold' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $items = $this->getInventoryItems();
        $updated = false;

        foreach ($items as &$item) {
            if ($item['id'] == $id) {
                $item['name'] = trim($validated['name']);
                $item['category'] = trim($validated['category']);
                $item['stock'] = (int) $validated['stock'];
                $item['unit'] = trim($validated['unit']);
                $item['status'] = trim($validated['status']);
                if (isset($validated['min_threshold'])) {
                    $item['min_threshold'] = (int) $validated['min_threshold'];
                }
                if (isset($validated['notes'])) {
                    $item['notes'] = $validated['notes'];
                }
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $this->saveInventoryItems($items);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Item #{$id} updated successfully!",
            ]);
        }

        return redirect()->back()->with('success', "Item updated successfully!");
    }

    /**
     * Delete an inventory item.
     */
    public function destroy(Request $request, $id)
    {
        $items = $this->getInventoryItems();
        $filtered = array_filter($items, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        $this->saveInventoryItems($filtered);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Item #{$id} deleted successfully!",
                'id' => $id,
            ]);
        }

        return redirect()->back()->with('success', "Item removed successfully!");
    }

    /**
     * Reset inventory dataset to initial default (25 items).
     */
    public function reset(Request $request)
    {
        session()->forget('inventory_items');
        $default = $this->getDefaultInventory();
        session(['inventory_items' => $default]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Inventory refreshed to default state.',
            ]);
        }

        return redirect()->route('inventory.index')->with('success', 'Inventory data refreshed successfully!');
    }

    /**
     * Export inventory report to CSV / Excel format.
     */
    public function export($format = 'csv')
    {
        $items = $this->getInventoryItems();
        $filename = 'inventory_report_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($items) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($file, ['ID', 'Item Name', 'Category', 'Stock Level', 'Unit', 'Status', 'Min Threshold', 'Last Restocked', 'Notes']);

            foreach ($items as $item) {
                fputcsv($file, [
                    $item['id'],
                    $item['name'],
                    $item['category'],
                    $item['stock'],
                    $item['unit'],
                    $item['status'],
                    $item['min_threshold'] ?? 10,
                    $item['last_restocked'] ?? '',
                    $item['notes'] ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
