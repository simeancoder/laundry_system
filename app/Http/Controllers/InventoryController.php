<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class InventoryController extends Controller
{
    /**
     * Official 6 baseline inventory items matching the screenshot.
     */
    private function getDefaultInventory(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Detergent',
                'category' => 'Cleaning',
                'stock' => 50,
                'unit' => 'L',
                'status' => 'In Stock',
                'min_stock' => 20,
                'notes' => 'Commercial grade liquid laundry detergent for heavy soiled wash cycles.',
                'supplier' => 'EcoChem Supplies Co.',
                'unit_price' => 12.50,
                'last_restocked' => '2026-10-01',
            ],
            [
                'id' => 2,
                'name' => 'Softener',
                'category' => 'Cleaning',
                'stock' => 40,
                'unit' => 'L',
                'status' => 'In Stock',
                'min_stock' => 15,
                'notes' => 'Floral scented fabric conditioner for delicate and everyday fabrics.',
                'supplier' => 'SilkTouch Chemical Ltd',
                'unit_price' => 10.00,
                'last_restocked' => '2026-10-02',
            ],
            [
                'id' => 3,
                'name' => 'Bleach',
                'category' => 'Cleaning',
                'stock' => 10,
                'unit' => 'L',
                'status' => 'Low Stock',
                'min_stock' => 15,
                'notes' => 'Color-safe chlorine bleach for stain removal on white linens.',
                'supplier' => 'CleanMaster Ind.',
                'unit_price' => 8.00,
                'last_restocked' => '2026-09-28',
            ],
            [
                'id' => 4,
                'name' => 'Packing Bags',
                'category' => 'Packaging',
                'stock' => 100,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_stock' => 30,
                'notes' => 'Heavy-duty polythene laundry carry bags with sealed base.',
                'supplier' => 'Khmer Pack Solutions',
                'unit_price' => 0.25,
                'last_restocked' => '2026-10-03',
            ],
            [
                'id' => 5,
                'name' => 'Hangers',
                'category' => 'Accessories',
                'stock' => 200,
                'unit' => 'Pcs',
                'status' => 'In Stock',
                'min_stock' => 50,
                'notes' => 'Heavy gauge galvanized wire & plastic finished garment hangers.',
                'supplier' => 'Universal Hanger Ltd',
                'unit_price' => 0.15,
                'last_restocked' => '2026-10-02',
            ],
            [
                'id' => 6,
                'name' => 'Cleaning Chemicals',
                'category' => 'Chemicals',
                'stock' => 15,
                'unit' => 'L',
                'status' => 'Low Stock',
                'min_stock' => 20,
                'notes' => 'Enzyme-based grease and tannin chemical spotting reagents.',
                'supplier' => 'ProWash Chemicals Global',
                'unit_price' => 22.00,
                'last_restocked' => '2026-09-25',
            ],
        ];
    }

    /**
     * Retrieve active inventory items with fallback strategy.
     */
    public function getInventoryData()
    {
        $jsonFile = storage_path('app/inventory.json');
        $defaults = collect($this->getDefaultInventory())->map(function ($item) {
            return (object)$item;
        });

        // 1. If database table exists and has rows, load from DB
        try {
            if (Schema::hasTable('inventories') && Inventory::count() > 0) {
                return Inventory::all()->map(function ($item) {
                    return (object)$item->toArray();
                });
            }
        } catch (\Throwable $e) {}

        // 2. Load from storage/app/inventory.json
        if (file_exists($jsonFile) && !request()->has('reset')) {
            try {
                $content = file_get_contents($jsonFile);
                $decoded = json_decode($content, true);
                if (is_array($decoded) && count($decoded) > 0) {
                    $coll = collect($decoded)->map(function ($item) {
                        return is_array($item) ? (object)$item : $item;
                    });
                    if ($coll->contains('name', 'Detergent')) {
                        session(['laundry_inventory_items' => $coll->toArray()]);
                        return $coll;
                    }
                }
            } catch (\Throwable $e) {}
        }

        // 3. Load from Session
        if (session()->has('laundry_inventory_items') && !request()->has('reset')) {
            $sess = session('laundry_inventory_items');
            $coll = collect($sess)->map(function ($item) {
                return is_array($item) ? (object)$item : $item;
            });
            if ($coll->contains('name', 'Detergent')) {
                $this->saveInventoryStorage($coll);
                return $coll;
            }
        }

        // 4. Default Seed
        $this->saveInventoryStorage($defaults);
        session(['laundry_inventory_items' => $defaults->toArray()]);
        return $defaults;
    }

    /**
     * Save inventory collection to disk and session.
     */
    protected function saveInventoryStorage($collection)
    {
        try {
            $jsonFile = storage_path('app/inventory.json');
            $dir = dirname($jsonFile);
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            file_put_contents($jsonFile, json_encode($collection->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } catch (\Throwable $e) {}
    }

    /**
     * Compute item status from stock and min_stock.
     */
    protected function determineStatus($stock, $minStock = 15): string
    {
        $stock = (int)$stock;
        $minStock = (int)$minStock;
        if ($stock <= 0) {
            return 'Out of Stock';
        }
        if ($stock <= $minStock) {
            return 'Low Stock';
        }
        return 'In Stock';
    }

    /**
     * Display inventory dashboard list.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryFilter = $request->input('category', 'all');
        $statusFilter = $request->input('status', 'all');

        $all = $this->getInventoryData();

        // Calculate card stats
        $totalItems = $all->count();
        $inStockCount = $all->filter(function ($item) {
            return ($item->status ?? '') === 'In Stock';
        })->count();
        $lowStockCount = $all->filter(function ($item) {
            return in_array($item->status ?? '', ['Low Stock', 'Out of Stock']);
        })->count();

        $stats = [
            'total' => $totalItems,
            'in_stock' => $inStockCount,
            'low_stock' => $lowStockCount,
        ];

        // Filter items
        $filtered = $all->filter(function ($item) use ($search, $categoryFilter, $statusFilter) {
            if ($search) {
                $s = strtolower(trim($search));
                $nameMatch = str_contains(strtolower($item->name ?? ''), $s);
                $catMatch = str_contains(strtolower($item->category ?? ''), $s);
                $unitMatch = str_contains(strtolower($item->unit ?? ''), $s);
                $statusMatch = str_contains(strtolower($item->status ?? ''), $s);
                if (!$nameMatch && !$catMatch && !$unitMatch && !$statusMatch) {
                    return false;
                }
            }

            if ($categoryFilter && $categoryFilter !== 'all' && $categoryFilter !== 'All Categories') {
                if (strtolower($item->category ?? '') !== strtolower($categoryFilter)) {
                    return false;
                }
            }

            if ($statusFilter && $statusFilter !== 'all' && $statusFilter !== 'All Status') {
                if (strtolower($item->status ?? '') !== strtolower($statusFilter)) {
                    return false;
                }
            }

            return true;
        })->values();

        // Default categories and statuses for dropdown filters
        $categories = ['Cleaning', 'Packaging', 'Accessories', 'Chemicals'];
        $statuses = ['In Stock', 'Low Stock', 'Out of Stock'];

        $viewName = view()->exists('pages.inventory') ? 'pages.inventory' : 'inventory';

        return view($viewName, [
            'items' => $filtered,
            'stats' => $stats,
            'categories' => $categories,
            'statuses' => $statuses,
            'search' => $search,
            'categoryFilter' => $categoryFilter,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Show single inventory item details.
     */
    public function show($id, $optionalId = null)
    {
        $request = request();
        if ($id instanceof Request) {
            $request = $id;
            $id = $optionalId ?? $request->route('id') ?? $request->route('inventory');
        }

        $id = is_object($id) ? ($id->id ?? 1) : $id;
        $all = $this->getInventoryData();
        $item = $all->firstWhere('id', (int)$id);

        return response()->json([
            'success' => (bool)$item,
            'item' => $item
        ]);
    }

    /**
     * Add Laundry Supplies / Create new item.
     */
    public function store(Request $request)
    {
        $name = $request->input('name') ?? $request->input('item_name');
        $stock = $request->input('stock') ?? $request->input('quantity', 0);
        $request->merge([
            'name' => $name,
            'stock' => $stock
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'min_stock' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'supplier' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        $stock = (int)$request->input('stock', 0);
        $minStock = (int)$request->input('min_stock', 15);
        $status = $this->determineStatus($stock, $minStock);

        $all = $this->getInventoryData();
        $nextId = ($all->max('id') ?? 6) + 1;

        $newItem = (object)[
            'id' => $nextId,
            'name' => trim($request->name),
            'category' => trim($request->category),
            'stock' => $stock,
            'unit' => trim($request->unit),
            'status' => $status,
            'min_stock' => $minStock,
            'notes' => $request->notes ?? '',
            'supplier' => $request->supplier ?? 'Standard Supplier',
            'unit_price' => (float)($request->unit_price ?? 0.00),
            'last_restocked' => date('Y-m-d'),
        ];

        // Database save
        try {
            if (Schema::hasTable('inventories')) {
                Inventory::create((array)$newItem);
            }
        } catch (\Throwable $e) {}

        $all->push($newItem);
        $this->saveInventoryStorage($all);
        session(['laundry_inventory_items' => $all->toArray()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Supplies added successfully!',
                'item' => $newItem
            ]);
        }

        return redirect()->back()->with('success', 'Supplies item "' . $request->name . '" added successfully!');
    }

    /**
     * Update Inventory Item.
     */
    public function update(Request $request, $id)
    {
        $id = is_object($id) ? ($id->id ?? 1) : $id;

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'min_stock' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'supplier' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        $stock = (int)$request->input('stock', 0);
        $minStock = (int)$request->input('min_stock', 15);
        $status = $this->determineStatus($stock, $minStock);

        // Database update
        try {
            if (Schema::hasTable('inventories')) {
                $dbItem = Inventory::find($id);
                if ($dbItem) {
                    $dbItem->update([
                        'name' => $request->name,
                        'category' => $request->category,
                        'stock' => $stock,
                        'unit' => $request->unit,
                        'status' => $status,
                        'min_stock' => $minStock,
                        'notes' => $request->notes,
                        'supplier' => $request->supplier,
                        'unit_price' => (float)($request->unit_price ?? $dbItem->unit_price),
                    ]);
                }
            }
        } catch (\Throwable $e) {}

        $all = $this->getInventoryData()->map(function ($item) use ($id, $request, $stock, $minStock, $status) {
            if ($item->id == $id) {
                $item->name = $request->name;
                $item->category = $request->category;
                $item->stock = $stock;
                $item->unit = $request->unit;
                $item->status = $status;
                $item->min_stock = $minStock;
                $item->notes = $request->notes ?? $item->notes ?? '';
                if ($request->has('supplier')) {
                    $item->supplier = $request->supplier;
                }
                if ($request->has('unit_price')) {
                    $item->unit_price = (float)$request->unit_price;
                }
            }
            return $item;
        });

        $this->saveInventoryStorage($all);
        session(['laundry_inventory_items' => $all->toArray()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Inventory updated successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Item "' . $request->name . '" updated successfully!');
    }

    /**
     * Stock In function: Increases quantity and updates status.
     */
    public function stockIn(Request $request, $id)
    {
        $id = is_object($id) ? ($id->id ?? 1) : $id;
        $qty = abs((int)$request->input('quantity', 10));

        $updatedItem = null;

        // DB update
        try {
            if (Schema::hasTable('inventories')) {
                $dbItem = Inventory::find($id);
                if ($dbItem) {
                    $dbItem->stock += $qty;
                    $dbItem->last_restocked = date('Y-m-d');
                    $dbItem->updateStatusBasedOnStock();
                    $updatedItem = $dbItem;
                }
            }
        } catch (\Throwable $e) {}

        $all = $this->getInventoryData()->map(function ($item) use ($id, $qty, &$updatedItem) {
            if ($item->id == $id) {
                $item->stock += $qty;
                $item->last_restocked = date('Y-m-d');
                $item->status = $this->determineStatus($item->stock, $item->min_stock ?? 15);
                $updatedItem = $item;
            }
            return $item;
        });

        $this->saveInventoryStorage($all);
        session(['laundry_inventory_items' => $all->toArray()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Stock in of +{$qty} successfully recorded!",
                'item' => $updatedItem
            ]);
        }

        return redirect()->back()->with('success', "Stock in of +{$qty} recorded successfully!");
    }

    /**
     * Stock Out function: Deducts quantity and triggers low stock alert if needed.
     */
    public function stockOut(Request $request, $id)
    {
        $id = is_object($id) ? ($id->id ?? 1) : $id;
        $qty = abs((int)$request->input('quantity', 5));

        $updatedItem = null;

        // DB update
        try {
            if (Schema::hasTable('inventories')) {
                $dbItem = Inventory::find($id);
                if ($dbItem) {
                    $dbItem->stock = max(0, $dbItem->stock - $qty);
                    $dbItem->updateStatusBasedOnStock();
                    $updatedItem = $dbItem;
                }
            }
        } catch (\Throwable $e) {}

        $all = $this->getInventoryData()->map(function ($item) use ($id, $qty, &$updatedItem) {
            if ($item->id == $id) {
                $item->stock = max(0, $item->stock - $qty);
                $item->status = $this->determineStatus($item->stock, $item->min_stock ?? 15);
                $updatedItem = $item;
            }
            return $item;
        });

        $this->saveInventoryStorage($all);
        session(['laundry_inventory_items' => $all->toArray()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Stock out of -{$qty} recorded!",
                'item' => $updatedItem
            ]);
        }

        return redirect()->back()->with('success', "Stock out of -{$qty} recorded successfully!");
    }

    /**
     * Delete Inventory Item.
     */
    public function destroy(Request $request, $id)
    {
        $id = is_object($id) ? ($id->id ?? 1) : $id;

        try {
            if (Schema::hasTable('inventories')) {
                $dbItem = Inventory::find($id);
                if ($dbItem) {
                    $dbItem->delete();
                }
            }
        } catch (\Throwable $e) {}

        $all = $this->getInventoryData()->reject(function ($item) use ($id) {
            return $item->id == $id;
        })->values();

        $this->saveInventoryStorage($all);
        session(['laundry_inventory_items' => $all->toArray()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Inventory item deleted successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Inventory item removed successfully!');
    }

    /**
     * Reset to default 6 items.
     */
    public function reset(Request $request)
    {
        $defaults = collect($this->getDefaultInventory())->map(function ($item) {
            return (object)$item;
        });

        $this->saveInventoryStorage($defaults);
        session(['laundry_inventory_items' => $defaults->toArray()]);

        return redirect()->back()->with('success', 'Inventory reset to default 6 items.');
    }
}
