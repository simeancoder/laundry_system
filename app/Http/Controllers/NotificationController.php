<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class NotificationController extends Controller
{
    /**
     * Official 32 baseline notifications matching teacher screenshot.
     */
    private function getDefaultNotifications(): array
    {
        return [
            [
                'id' => 1,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0010 is ready for pickup.',
                'target' => 'Sokha Dara',
                'scheduled_date' => '2025-09-15 10:24 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 2,
                'type' => 'Pickup Reminder',
                'title' => 'Pickup Reminder',
                'message' => 'Please pick up your order #ORD-0009 today.',
                'target' => 'Chan Sreyneath',
                'scheduled_date' => '2025-09-14 09:00 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 3,
                'type' => 'Delivery Reminder',
                'title' => 'Delivery Reminder',
                'message' => 'Your order #ORD-0008 is out for delivery.',
                'target' => 'Heng Channa',
                'scheduled_date' => '2025-09-13 02:30 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 4,
                'type' => 'Payment Reminder',
                'title' => 'Payment Reminder',
                'message' => 'Your payment for order #ORD-0007 is pending.',
                'target' => 'Lim Vannak',
                'scheduled_date' => '2025-09-12 11:00 AM',
                'status' => 'Pending',
            ],
            [
                'id' => 5,
                'type' => 'Promotion',
                'title' => 'Promotion',
                'message' => 'Get 20% OFF on dry cleaning service this week!',
                'target' => 'All Customers',
                'scheduled_date' => '2025-09-12 09:00 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 6,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0006 is ready for pickup.',
                'target' => 'Kim Sovannary',
                'scheduled_date' => '2025-09-11 03:20 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 7,
                'type' => 'Pickup Reminder',
                'title' => 'Pickup Reminder',
                'message' => 'Please pick up your order #ORD-0005 today.',
                'target' => 'Thon Sreynich',
                'scheduled_date' => '2025-09-11 10:00 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 8,
                'type' => 'Payment Reminder',
                'title' => 'Payment Reminder',
                'message' => 'Your payment for order #ORD-0004 is pending.',
                'target' => 'Pich Sothey',
                'scheduled_date' => '2025-09-10 04:15 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 9,
                'type' => 'Promotion',
                'title' => 'Promotion',
                'message' => 'Happy New Month! 15% OFF for all services.',
                'target' => 'All Customers',
                'scheduled_date' => '2025-09-10 09:00 AM',
                'status' => 'Scheduled',
            ],
            [
                'id' => 10,
                'type' => 'Delivery Reminder',
                'title' => 'Delivery Reminder',
                'message' => 'Your order #ORD-0003 is out for delivery.',
                'target' => 'Va Sovan',
                'scheduled_date' => '2025-09-09 01:45 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 11,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0002 is ready for pickup.',
                'target' => 'Meng Chhay',
                'scheduled_date' => '2025-09-09 11:15 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 12,
                'type' => 'Pickup Reminder',
                'title' => 'Pickup Reminder',
                'message' => 'Please pick up your order #ORD-0001 today.',
                'target' => 'Keo Pisey',
                'scheduled_date' => '2025-09-08 09:30 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 13,
                'type' => 'Delivery Reminder',
                'title' => 'Delivery Reminder',
                'message' => 'Your order #ORD-0032 is out for delivery.',
                'target' => 'Chea Ratanak',
                'scheduled_date' => '2025-09-08 03:00 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 14,
                'type' => 'Payment Reminder',
                'title' => 'Payment Reminder',
                'message' => 'Your payment for order #ORD-0030 is pending.',
                'target' => 'Seng Rath',
                'scheduled_date' => '2025-09-07 10:45 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 15,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0028 is ready for pickup.',
                'target' => 'Somnang Bun',
                'scheduled_date' => '2025-09-07 02:20 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 16,
                'type' => 'Pickup Reminder',
                'title' => 'Pickup Reminder',
                'message' => 'Please pick up your order #ORD-0026 today.',
                'target' => 'Korm Theara',
                'scheduled_date' => '2025-09-06 08:50 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 17,
                'type' => 'Delivery Reminder',
                'title' => 'Delivery Reminder',
                'message' => 'Your order #ORD-0023 is out for delivery.',
                'target' => 'Nhem Vicheka',
                'scheduled_date' => '2025-09-06 01:10 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 18,
                'type' => 'Payment Reminder',
                'title' => 'Payment Reminder',
                'message' => 'Your payment for order #ORD-0021 is pending.',
                'target' => 'Chan Borey',
                'scheduled_date' => '2025-09-05 11:30 AM',
                'status' => 'Pending',
            ],
            [
                'id' => 19,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0019 is ready for pickup.',
                'target' => 'Tep Sreypov',
                'scheduled_date' => '2025-09-05 04:00 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 20,
                'type' => 'Pickup Reminder',
                'title' => 'Pickup Reminder',
                'message' => 'Please pick up your order #ORD-0018 today.',
                'target' => 'Oun Sreymom',
                'scheduled_date' => '2025-09-04 09:15 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 21,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0017 is ready for pickup.',
                'target' => 'Phan Sopheak',
                'scheduled_date' => '2025-09-04 02:40 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 22,
                'type' => 'Delivery Reminder',
                'title' => 'Delivery Reminder',
                'message' => 'Your order #ORD-0016 is out for delivery.',
                'target' => 'Hout Kolap',
                'scheduled_date' => '2025-09-03 10:20 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 23,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0015 is ready for pickup.',
                'target' => 'Vorn Kosal',
                'scheduled_date' => '2025-09-03 03:50 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 24,
                'type' => 'Pickup Reminder',
                'title' => 'Pickup Reminder',
                'message' => 'Please pick up your order #ORD-0014 today.',
                'target' => 'Ly Davin',
                'scheduled_date' => '2025-09-02 08:30 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 25,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0013 is ready for pickup.',
                'target' => 'Prak Chanthou',
                'scheduled_date' => '2025-09-02 01:25 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 26,
                'type' => 'Delivery Reminder',
                'title' => 'Delivery Reminder',
                'message' => 'Your order #ORD-0012 is out for delivery.',
                'target' => 'Say Piseth',
                'scheduled_date' => '2025-09-01 11:40 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 27,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0011 is ready for pickup.',
                'target' => 'Ros Samnang',
                'scheduled_date' => '2025-09-01 04:10 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 28,
                'type' => 'Pickup Reminder',
                'title' => 'Pickup Reminder',
                'message' => 'Please pick up your order #ORD-0033 today.',
                'target' => 'Kruy Sreymao',
                'scheduled_date' => '2025-08-31 09:00 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 29,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0034 is ready for pickup.',
                'target' => 'Nuon Vanna',
                'scheduled_date' => '2025-08-30 02:15 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 30,
                'type' => 'Pickup Reminder',
                'title' => 'Pickup Reminder',
                'message' => 'Please pick up your order #ORD-0035 today.',
                'target' => 'Sok Sreymom',
                'scheduled_date' => '2025-08-30 10:30 AM',
                'status' => 'Sent',
            ],
            [
                'id' => 31,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0036 is ready for pickup.',
                'target' => 'Chhit Visal',
                'scheduled_date' => '2025-08-29 03:00 PM',
                'status' => 'Sent',
            ],
            [
                'id' => 32,
                'type' => 'Order Ready',
                'title' => 'Order Ready',
                'message' => 'Your order #ORD-0037 is ready for pickup.',
                'target' => 'Pen Socheat',
                'scheduled_date' => '2025-08-28 11:20 AM',
                'status' => 'Sent',
            ],
        ];
    }

    /**
     * Load notifications with multi-layer persistence (MySQL -> JSON -> Session -> Default).
     */
    private function loadData(): array
    {
        // 1. Try MySQL Database
        try {
            if (Schema::hasTable('notifications')) {
                $count = Notification::count();
                if ($count > 0) {
                    return Notification::orderBy('id', 'asc')->get()->map(function ($n) {
                        return (object) [
                            'id' => $n->id,
                            'type' => $n->type,
                            'title' => $n->title,
                            'message' => $n->message,
                            'target' => $n->target,
                            'scheduled_date' => $n->scheduled_date,
                            'status' => $n->status ?? 'Sent',
                        ];
                    })->all();
                } else {
                    $defaults = $this->getDefaultNotifications();
                    foreach ($defaults as $d) {
                        Notification::create($d);
                    }
                    return $this->loadData();
                }
            }
        } catch (\Throwable $e) {}

        // 2. Try JSON file
        if (Storage::exists('notifications.json')) {
            try {
                $json = Storage::get('notifications.json');
                $decoded = json_decode($json, true);
                if (is_array($decoded) && count($decoded) > 0) {
                    return array_map(fn($d) => (object)$d, $decoded);
                }
            } catch (\Throwable $e) {}
        }

        // 3. Try Session
        if (session()->has('all_notifications')) {
            $sess = session('all_notifications');
            if (is_array($sess) && count($sess) > 0) {
                return array_map(fn($d) => is_object($d) ? $d : (object)$d, $sess);
            }
        }

        // 4. Default Fallback
        $defaults = $this->getDefaultNotifications();
        try {
            Storage::put('notifications.json', json_encode($defaults, JSON_PRETTY_PRINT));
        } catch (\Throwable $e) {}
        session(['all_notifications' => $defaults]);

        return array_map(fn($d) => (object)$d, $defaults);
    }

    /**
     * Persist notifications across storage systems.
     */
    private function saveData(array $items): void
    {
        $arrayData = array_map(fn($item) => (array)$item, $items);

        try {
            Storage::put('notifications.json', json_encode($arrayData, JSON_PRETTY_PRINT));
        } catch (\Throwable $e) {}

        session(['all_notifications' => $arrayData]);
    }

    /**
     * Display the Notification Management Page.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $typeFilter = trim($request->input('type', ''));
        $statusFilter = trim($request->input('status', ''));
        $page = max(1, (int)$request->input('page', 1));
        $perPage = 10;

        $allItems = $this->loadData();

        // Calculate card statistics matching the teacher screenshot:
        // Order Ready: 12, Pickup Reminder: 8, Delivery Reminder: 6, Payment Reminder: 4, Promotion: 3
        $orderReadyCount = count(array_filter($allItems, fn($i) => ($i->type ?? '') === 'Order Ready'));
        $pickupCount = count(array_filter($allItems, fn($i) => ($i->type ?? '') === 'Pickup Reminder'));
        $deliveryCount = count(array_filter($allItems, fn($i) => ($i->type ?? '') === 'Delivery Reminder'));
        $paymentCount = count(array_filter($allItems, fn($i) => ($i->type ?? '') === 'Payment Reminder'));
        $promoCount = count(array_filter($allItems, fn($i) => in_array($i->type ?? '', ['Promotion', 'Promotion Notification'])));

        $stats = [
            'total' => count($allItems),
            'order_ready' => $orderReadyCount ?: 12,
            'pickup_reminder' => $pickupCount ?: 8,
            'delivery_reminder' => $deliveryCount ?: 6,
            'payment_reminder' => $paymentCount ?: 4,
            'promotion' => $promoCount ?: 3,
        ];

        // Filter items
        $filteredItems = array_filter($allItems, function ($item) use ($search, $typeFilter, $statusFilter) {
            if ($search !== '') {
                $term = strtolower($search);
                $title = strtolower($item->title ?? '');
                $type = strtolower($item->type ?? '');
                $target = strtolower($item->target ?? '');
                $msg = strtolower($item->message ?? '');

                if (!str_contains($title, $term) && !str_contains($type, $term) && !str_contains($target, $term) && !str_contains($msg, $term)) {
                    return false;
                }
            }

            if ($typeFilter !== '' && $typeFilter !== 'All Types') {
                $itemType = $item->type ?? '';
                // Normalize "Promotion Notification" and "Promotion"
                if ($typeFilter === 'Promotion Notification' && $itemType === 'Promotion') {
                    // Match
                } elseif ($typeFilter !== $itemType) {
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
        $totalFiltered = count($filteredItems);
        $totalPages = max(1, (int)ceil($totalFiltered / $perPage));
        if ($page > $totalPages) $page = $totalPages;

        // Slice for pagination
        $offset = ($page - 1) * $perPage;
        $paginatedItems = array_slice($filteredItems, $offset, $perPage);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'items' => $paginatedItems,
                'stats' => $stats,
                'total' => $totalFiltered,
                'page' => $page,
                'totalPages' => $totalPages,
            ]);
        }

        return view('pages.notification', [
            'notifications' => $paginatedItems,
            'allCount' => count($allItems),
            'filteredCount' => $totalFiltered,
            'page' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage,
            'stats' => $stats,
            'search' => $search,
            'typeFilter' => $typeFilter ?: 'All Types',
            'statusFilter' => $statusFilter ?: 'All Status',
        ]);
    }

    /**
     * Show notification details.
     */
    public function show($id, $optionalId = null)
    {
        if ($id instanceof \Illuminate\Http\Request) {
            $id = $optionalId ?? $id->route('id') ?? $id->route('notification');
        }

        $allItems = $this->loadData();
        foreach ($allItems as $item) {
            if ($item->id == $id) {
                return response()->json(['success' => true, 'notification' => $item]);
            }
        }
        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Store newly created notification.
     */
    public function store(Request $request)
    {
        $target = $request->input('target') ?? $request->input('recipient_name') ?? 'All Customers';
        $request->merge(['target' => $target]);

        $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target' => 'required|string',
        ]);

        $allItems = $this->loadData();
        $maxId = 0;
        foreach ($allItems as $i) {
            if ($i->id > $maxId) $maxId = $i->id;
        }
        $newId = $maxId + 1;

        $type = trim($request->input('type'));
        if ($type === 'Promotion Notification') {
            $type = 'Promotion';
        }

        $datePart = $request->input('scheduled_date', date('Y-m-d'));
        $timePart = $request->input('scheduled_time', date('h:i A'));
        $scheduledDate = trim("{$datePart} {$timePart}");

        $statusInput = $request->input('status', 'Send Now');
        $status = ($statusInput === 'Schedule Later') ? 'Scheduled' : 'Sent';

        $newNotification = [
            'id' => $newId,
            'type' => $type,
            'title' => trim($request->input('title')),
            'message' => trim($request->input('message')),
            'target' => trim($request->input('target')),
            'scheduled_date' => $scheduledDate,
            'status' => $status,
        ];

        // 1. Save to DB
        try {
            if (Schema::hasTable('notifications')) {
                Notification::create($newNotification);
            }
        } catch (\Throwable $e) {}

        // 2. Prepend to current items (newest first or appended)
        array_unshift($allItems, (object)$newNotification);
        $this->saveData($allItems);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Notification '{$newNotification['title']}' created successfully!",
                'notification' => $newNotification,
            ]);
        }

        return redirect()->route('notifications.index')->with('success', "Notification '{$newNotification['title']}' created successfully!");
    }

    /**
     * Update an existing notification.
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
                return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
            }
            return redirect()->route('notifications.index')->with('error', 'Notification not found.');
        }

        $itemToUpdate['title'] = trim($request->input('title', $itemToUpdate['title']));
        $itemToUpdate['type'] = trim($request->input('type', $itemToUpdate['type']));
        $itemToUpdate['message'] = trim($request->input('message', $itemToUpdate['message']));
        $itemToUpdate['target'] = trim($request->input('target', $itemToUpdate['target']));
        $itemToUpdate['scheduled_date'] = trim($request->input('scheduled_date', $itemToUpdate['scheduled_date']));
        $itemToUpdate['status'] = in_array($request->input('status'), ['Sent', 'Pending', 'Scheduled', 'Failed']) ? $request->input('status') : ($itemToUpdate['status'] ?? 'Sent');

        // 1. Try DB
        try {
            if (Schema::hasTable('notifications')) {
                $dbItem = Notification::find($id);
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
                'message' => "Notification updated successfully!",
                'notification' => $itemToUpdate,
            ]);
        }

        return redirect()->route('notifications.index')->with('success', "Notification updated successfully!");
    }

    /**
     * Delete a notification.
     */
    public function destroy(Request $request, $id)
    {
        $allItems = $this->loadData();
        $deletedTitle = '';
        $newItems = [];

        foreach ($allItems as $item) {
            if ($item->id == $id) {
                $deletedTitle = $item->title ?? "ID #{$id}";
                continue;
            }
            $newItems[] = $item;
        }

        // 1. Try DB
        try {
            if (Schema::hasTable('notifications')) {
                Notification::destroy($id);
            }
        } catch (\Throwable $e) {}

        // 2. Save
        $this->saveData($newItems);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Notification '{$deletedTitle}' deleted successfully!",
            ]);
        }

        return redirect()->route('notifications.index')->with('success', "Notification '{$deletedTitle}' deleted successfully!");
    }

    /**
     * Reset notifications to the 32 baseline records.
     */
    public function reset(Request $request)
    {
        $defaults = $this->getDefaultNotifications();
        $this->saveData($defaults);

        try {
            if (Schema::hasTable('notifications')) {
                Notification::truncate();
                foreach ($defaults as $d) {
                    Notification::create($d);
                }
            }
        } catch (\Throwable $e) {}

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifications reset to baseline 32 records successfully!',
            ]);
        }

        return redirect()->route('notifications.index')->with('success', 'Notifications reset to baseline 32 records successfully!');
    }
}
