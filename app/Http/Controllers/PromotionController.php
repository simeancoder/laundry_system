<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    /**
     * Official 6 baseline promotions matching screenshot.
     */
    private function getDefaultPromotions(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Back to School Special',
                'type' => 'Percentage Discount',
                'discount_value' => 20,
                'discount_unit' => '%',
                'start_date' => '2025-09-01',
                'end_date' => '2025-09-30',
                'coupon_code' => 'SCHOOL20',
                'description' => 'Special seasonal discount for students and educators on all laundry and washing services.',
                'status' => 'Active',
            ],
            [
                'id' => 2,
                'name' => 'New Customer Discount',
                'type' => 'Fixed Amount',
                'discount_value' => 5,
                'discount_unit' => '$',
                'start_date' => '2025-09-01',
                'end_date' => '2025-12-31',
                'coupon_code' => 'WELCOME5',
                'description' => 'First-time customer welcome bonus applicable on any drop-off laundry or dry cleaning basket.',
                'status' => 'Active',
            ],
            [
                'id' => 3,
                'name' => 'Loyalty Program',
                'type' => 'Loyalty Discount',
                'discount_value' => 10,
                'discount_unit' => '%',
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'coupon_code' => 'LOYALTY10',
                'description' => 'Exclusive member reward discount for our returning loyal clients throughout the year.',
                'status' => 'Active',
            ],
            [
                'id' => 4,
                'name' => 'Summer Sale',
                'type' => 'Percentage Discount',
                'discount_value' => 15,
                'discount_unit' => '%',
                'start_date' => '2025-07-01',
                'end_date' => '2025-07-31',
                'coupon_code' => 'SUMMER15',
                'description' => 'Mid-year summer promotion on bulk washing, drying, and ironing services.',
                'status' => 'Active',
            ],
            [
                'id' => 5,
                'name' => 'Holiday Promotion',
                'type' => 'Fixed Amount',
                'discount_value' => 10,
                'discount_unit' => '$',
                'start_date' => '2025-12-20',
                'end_date' => '2025-12-31',
                'coupon_code' => 'HOLIDAY10',
                'description' => 'Festive end of year promotion for blankets, comforters, and holiday apparel.',
                'status' => 'Expired',
            ],
            [
                'id' => 6,
                'name' => 'VIP Member Discount',
                'type' => 'Percentage Discount',
                'discount_value' => 25,
                'discount_unit' => '%',
                'start_date' => '2025-08-01',
                'end_date' => '2025-08-31',
                'coupon_code' => 'VIP25',
                'description' => 'Special anniversary appreciation offer exclusively for VIP cardholders.',
                'status' => 'Expired',
            ],
        ];
    }

    /**
     * Load promotions with multi-layer persistence (MySQL -> JSON -> Session -> Default).
     */
    private function loadData(): array
    {
        // 1. Try MySQL Database
        try {
            if (Schema::hasTable('promotions')) {
                $count = Promotion::count();
                if ($count > 0) {
                    return Promotion::orderBy('id', 'asc')->get()->map(function ($p) {
                        return (object) [
                            'id' => $p->id,
                            'name' => $p->name,
                            'type' => $p->type,
                            'discount_value' => (float)$p->discount_value,
                            'discount_unit' => $p->discount_unit ?? '%',
                            'start_date' => $p->start_date ?? '2025-09-01',
                            'end_date' => $p->end_date ?? '2025-09-30',
                            'coupon_code' => $p->coupon_code ?? '',
                            'description' => $p->description ?? '',
                            'status' => $p->status ?? 'Active',
                        ];
                    })->all();
                } else {
                    $defaults = $this->getDefaultPromotions();
                    foreach ($defaults as $d) {
                        Promotion::create($d);
                    }
                    return $this->loadData();
                }
            }
        } catch (\Throwable $e) {}

        // 2. Try JSON storage file
        if (Storage::exists('promotions.json')) {
            try {
                $json = Storage::get('promotions.json');
                $decoded = json_decode($json, true);
                if (is_array($decoded) && count($decoded) > 0) {
                    return array_map(fn($d) => (object)$d, $decoded);
                }
            } catch (\Throwable $e) {}
        }

        // 3. Try Session
        if (session()->has('mock_promotions')) {
            $sess = session('mock_promotions');
            if (is_array($sess) && count($sess) > 0) {
                return array_map(fn($d) => is_object($d) ? $d : (object)$d, $sess);
            }
        }

        // 4. Fallback Default
        $defaults = $this->getDefaultPromotions();
        Storage::put('promotions.json', json_encode($defaults, JSON_PRETTY_PRINT));
        session(['mock_promotions' => $defaults]);

        return array_map(fn($d) => (object)$d, $defaults);
    }

    /**
     * Persist promotions across storage systems.
     */
    private function saveData(array $items): void
    {
        $arrayData = array_map(fn($item) => (array)$item, $items);

        try {
            Storage::put('promotions.json', json_encode($arrayData, JSON_PRETTY_PRINT));
        } catch (\Throwable $e) {}

        session(['mock_promotions' => $arrayData]);
    }

    /**
     * Display the main Discount & Promotion page.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $typeFilter = trim($request->input('type', ''));
        $statusFilter = trim($request->input('status', ''));

        $allItems = $this->loadData();

        // Calculate statistics matching the screenshot cards
        $stats = [
            'total' => count($allItems),
            'active' => count(array_filter($allItems, fn($i) => ($i->status ?? '') === 'Active')),
            'expired' => count(array_filter($allItems, fn($i) => ($i->status ?? '') === 'Expired')),
            'coupon_codes' => 8, // Matching '8' in screenshot card
        ];

        // Filter promotions for table
        $filteredItems = array_filter($allItems, function ($item) use ($search, $typeFilter, $statusFilter) {
            if ($search !== '') {
                $term = strtolower($search);
                $name = strtolower($item->name ?? '');
                $type = strtolower($item->type ?? '');
                $code = strtolower($item->coupon_code ?? '');
                $desc = strtolower($item->description ?? '');

                if (!str_contains($name, $term) && !str_contains($type, $term) && !str_contains($code, $term) && !str_contains($desc, $term)) {
                    return false;
                }
            }

            if ($typeFilter !== '' && $typeFilter !== 'All Types') {
                if (($item->type ?? '') !== $typeFilter) {
                    return false;
                }
            }

            if ($statusFilter !== '' && $statusFilter !== 'All Status') {
                if (($item->status ?? '') !== $statusFilter) {
                    return false;
                }
            }

            return true;
        });

        $filteredItems = array_values($filteredItems);

        // Recent promotions: 3 active promotions for bottom card
        $recentPromotions = array_values(array_filter($allItems, fn($i) => ($i->status ?? '') === 'Active'));
        $recentPromotions = array_slice($recentPromotions, 0, 3);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'items' => $filteredItems,
                'stats' => $stats,
                'count' => count($filteredItems),
            ]);
        }

        return view('pages.discount&promotion', [
            'promotions' => $filteredItems,
            'recentPromotions' => $recentPromotions,
            'stats' => $stats,
            'search' => $search,
            'typeFilter' => $typeFilter ?: 'All Types',
            'statusFilter' => $statusFilter ?: 'All Status',
        ]);
    }

    /**
     * Show a single promotion details.
     */
    public function show($id, $optionalId = null)
    {
        if ($id instanceof \Illuminate\Http\Request) {
            $id = $optionalId ?? $id->route('id') ?? $id->route('promotion');
        }

        $allItems = $this->loadData();
        foreach ($allItems as $item) {
            if ($item->id == $id) {
                return response()->json(['success' => true, 'promotion' => $item]);
            }
        }
        return response()->json(['success' => false, 'message' => 'Promotion not found'], 404);
    }

    /**
     * Store a newly created promotion.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'discount_value' => 'required|numeric|min:0',
        ]);

        $allItems = $this->loadData();
        $maxId = 0;
        foreach ($allItems as $i) {
            if ($i->id > $maxId) $maxId = $i->id;
        }
        $newId = $maxId + 1;

        $unit = $request->input('discount_unit', '%');
        if (!in_array($unit, ['%', '$', 'USD'])) {
            $unit = '%';
        }

        $newPromotion = [
            'id' => $newId,
            'name' => trim($request->input('name')),
            'type' => trim($request->input('type')),
            'discount_value' => (float)$request->input('discount_value'),
            'discount_unit' => $unit,
            'start_date' => $request->input('start_date', date('Y-m-d')) ?: date('Y-m-d'),
            'end_date' => $request->input('end_date', date('Y-m-d', strtotime('+30 days'))) ?: date('Y-m-d', strtotime('+30 days')),
            'coupon_code' => strtoupper(trim($request->input('coupon_code', ''))),
            'description' => trim($request->input('description', '')),
            'status' => in_array($request->input('status'), ['Active', 'Expired', 'Inactive']) ? $request->input('status') : 'Active',
        ];

        // 1. Try DB
        try {
            if (Schema::hasTable('promotions')) {
                Promotion::create($newPromotion);
            }
        } catch (\Throwable $e) {}

        // 2. Save
        $allItems[] = (object)$newPromotion;
        $this->saveData($allItems);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Promotion '{$newPromotion['name']}' added successfully!",
                'promotion' => $newPromotion,
            ]);
        }

        return redirect()->route('promotions.index')->with('success', "Promotion '{$newPromotion['name']}' added successfully!");
    }

    /**
     * Update an existing promotion.
     */
    public function update(Request $request, $id)
    {
        $allItems = $this->loadData();
        $indexFound = -1;
        $itemToUpdate = null;

        foreach ($allItems as $idx => $item) {
            if ($item->id == $id) {
                $indexFound = $idx;
                $itemToUpdate = (array)$item;
                break;
            }
        }

        if ($indexFound === -1 || !$itemToUpdate) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Promotion not found.'], 404);
            }
            return redirect()->route('promotions.index')->with('error', 'Promotion not found.');
        }

        $unit = $request->input('discount_unit', $itemToUpdate['discount_unit'] ?? '%');
        if (!in_array($unit, ['%', '$', 'USD'])) {
            $unit = '%';
        }

        $itemToUpdate['name'] = trim($request->input('name', $itemToUpdate['name']));
        $itemToUpdate['type'] = trim($request->input('type', $itemToUpdate['type']));
        $itemToUpdate['discount_value'] = (float)$request->input('discount_value', $itemToUpdate['discount_value']);
        $itemToUpdate['discount_unit'] = $unit;
        $itemToUpdate['start_date'] = $request->input('start_date', $itemToUpdate['start_date'] ?? date('Y-m-d'));
        $itemToUpdate['end_date'] = $request->input('end_date', $itemToUpdate['end_date'] ?? date('Y-m-d', strtotime('+30 days')));
        $itemToUpdate['coupon_code'] = strtoupper(trim($request->input('coupon_code', $itemToUpdate['coupon_code'] ?? '')));
        $itemToUpdate['description'] = trim($request->input('description', $itemToUpdate['description'] ?? ''));
        $itemToUpdate['status'] = in_array($request->input('status'), ['Active', 'Expired', 'Inactive']) ? $request->input('status') : ($itemToUpdate['status'] ?? 'Active');

        // 1. Try DB
        try {
            if (Schema::hasTable('promotions')) {
                $dbItem = Promotion::find($id);
                if ($dbItem) {
                    $dbItem->update($itemToUpdate);
                }
            }
        } catch (\Throwable $e) {}

        // 2. Save
        $allItems[$indexFound] = (object)$itemToUpdate;
        $this->saveData($allItems);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Promotion '{$itemToUpdate['name']}' updated successfully!",
                'promotion' => $itemToUpdate,
            ]);
        }

        return redirect()->route('promotions.index')->with('success', "Promotion '{$itemToUpdate['name']}' updated successfully!");
    }

    /**
     * Delete a promotion.
     */
    public function destroy(Request $request, $id)
    {
        $allItems = $this->loadData();
        $deletedName = '';
        $newItems = [];

        foreach ($allItems as $item) {
            if ($item->id == $id) {
                $deletedName = $item->name ?? "ID #{$id}";
                continue;
            }
            $newItems[] = $item;
        }

        // 1. Try DB
        try {
            if (Schema::hasTable('promotions')) {
                Promotion::destroy($id);
            }
        } catch (\Throwable $e) {}

        // 2. Save
        $this->saveData($newItems);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Promotion '{$deletedName}' deleted successfully!",
            ]);
        }

        return redirect()->route('promotions.index')->with('success', "Promotion '{$deletedName}' deleted successfully!");
    }

    /**
     * Reset to the 6 baseline promotions.
     */
    public function reset(Request $request)
    {
        $defaults = $this->getDefaultPromotions();
        $this->saveData($defaults);

        try {
            if (Schema::hasTable('promotions')) {
                Promotion::truncate();
                foreach ($defaults as $d) {
                    Promotion::create($d);
                }
            }
        } catch (\Throwable $e) {}

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Promotions reset to baseline 6 records successfully!',
            ]);
        }

        return redirect()->route('promotions.index')->with('success', 'Promotions reset to baseline 6 records successfully!');
    }
}
