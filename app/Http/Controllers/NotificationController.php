<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
    /**
     * Get all notifications dataset with session backing.
     */
    private function getAllNotifications(): array
    {
        if (session()->has('all_notifications')) {
            return session('all_notifications');
        }
        $defaults = $this->getBaselineNotifications();
        session(['all_notifications' => $defaults]);
        return $defaults;
    }

    private function getBaselineNotifications(): array
    {
        return [
            // Page 1 (Matching screenshot exactly)
            [
                'id' => 1,
                'name' => 'John Doe',
                'initials' => 'JD',
                'phone' => '+1 (555) 234-8901',
                'avatar_bg' => 'bg-[#D8D4FD]',
                'avatar_text' => 'text-[#4F39F6]',
                'type' => 'Order Ready',
                'type_bg' => 'bg-[#DFD7FE]',
                'type_text' => 'text-[#5B46F6]',
                'message' => '"Your laundry #WM-101 is ready for pickup! Locker: #12, PIN: 4821."',
                'short_message' => '"Your laundry #WM-101 is ready for pickup! L...',
                'status' => 'Delivered',
                'channel' => 'SMS & FCM Push',
                'time' => '2 mins ago',
                'latency' => '94ms',
            ],
            [
                'id' => 2,
                'name' => 'Sarah Smith',
                'initials' => 'SS',
                'phone' => '+1 (555) 892-1144',
                'avatar_bg' => 'bg-[#FED7D7]',
                'avatar_text' => 'text-[#C53030]',
                'type' => 'Payment Reminder',
                'type_bg' => 'bg-[#FED7D7]',
                'type_text' => 'text-[#E53E3E]',
                'message' => '"Invoice #INV-204 is pending ($48.50). Click pay.laundry6plus.com/204 to complete payment."',
                'short_message' => '"Invoice #INV-204 is pending ($48.50). Click p...',
                'status' => 'Delivered',
                'channel' => 'SMS Direct',
                'time' => '15 mins ago',
                'latency' => '108ms',
            ],
            [
                'id' => 3,
                'name' => 'Alex Wong',
                'initials' => 'AW',
                'phone' => '+1 (555) 431-7728',
                'avatar_bg' => 'bg-[#CBD5E1]',
                'avatar_text' => 'text-[#334155]',
                'type' => 'Pickup Reminder',
                'type_bg' => 'bg-[#E2E8F0]',
                'type_text' => 'text-[#475569]',
                'message' => '"Reminder: Clothes ready at store Downtown branch. Storage fees apply after 48 hours."',
                'short_message' => '"Reminder: Clothes ready at store Downtown...',
                'status' => 'Delivered',
                'channel' => 'SMS Direct',
                'time' => '32 mins ago',
                'latency' => '115ms',
            ],
            [
                'id' => 4,
                'name' => 'Marcus Sterling',
                'initials' => 'MS',
                'phone' => '+1 (555) 902-3318',
                'avatar_bg' => 'bg-[#BAE6FD]',
                'avatar_text' => 'text-[#0284C7]',
                'type' => 'Delivery Reminder',
                'type_bg' => 'bg-[#E0F2FE]',
                'type_text' => 'text-[#0284C7]',
                'message' => '"Van #02 en route with your fresh laundry. ETA is approximately 15 minutes."',
                'short_message' => '"Van #02 en route with your fresh laundry. ET...',
                'status' => 'Delivered',
                'channel' => 'Live GPS Link + Push',
                'time' => '1 hour ago',
                'latency' => '89ms',
            ],
            [
                'id' => 5,
                'name' => 'Elena Rostova',
                'initials' => 'ER',
                'phone' => '+1 (555) 762-9930',
                'avatar_bg' => 'bg-[#E9D5FF]',
                'avatar_text' => 'text-[#7E22CE]',
                'type' => 'Promotion Broadcast',
                'type_bg' => 'bg-[#F3E8FF]',
                'type_text' => 'text-[#9333EA]',
                'message' => '"Flash 20% off all duvet & winter jacket dry cleaning until Sunday midnight! Code: FRESH20"',
                'short_message' => '"Flash 20% off all duvet & winter jacket dry cl...',
                'status' => 'Delivered',
                'channel' => 'Push & Geofence',
                'time' => '3 hours ago',
                'latency' => '120ms',
            ],
            // Page 2
            [
                'id' => 6,
                'name' => 'Michael Chen',
                'initials' => 'MC',
                'phone' => '+1 (555) 349-8812',
                'avatar_bg' => 'bg-[#D8D4FD]',
                'avatar_text' => 'text-[#4F39F6]',
                'type' => 'Order Ready',
                'type_bg' => 'bg-[#DFD7FE]',
                'type_text' => 'text-[#5B46F6]',
                'message' => '"Your laundry #WM-102 is dried, pressed and ready at Counter 2."',
                'short_message' => '"Your laundry #WM-102 is dried, pressed and rea...',
                'status' => 'Delivered',
                'channel' => 'SMS / App Alert',
                'time' => '4 hours ago',
                'latency' => '98ms',
            ],
            [
                'id' => 7,
                'name' => 'Jessica Taylor',
                'initials' => 'JT',
                'phone' => '+1 (555) 612-9923',
                'avatar_bg' => 'bg-[#BAE6FD]',
                'avatar_text' => 'text-[#0284C7]',
                'type' => 'Delivery Reminder',
                'type_bg' => 'bg-[#E0F2FE]',
                'type_text' => 'text-[#0284C7]',
                'message' => '"Driver Van #01 departed store. Live tracking: live.laundry6plus.com/van1"',
                'short_message' => '"Driver Van #01 departed store. Live tracking: l...',
                'status' => 'Delivered',
                'channel' => 'Live GPS Link + Push',
                'time' => '5 hours ago',
                'latency' => '92ms',
            ],
            [
                'id' => 8,
                'name' => 'David Kim',
                'initials' => 'DK',
                'phone' => '+1 (555) 823-4411',
                'avatar_bg' => 'bg-[#CBD5E1]',
                'avatar_text' => 'text-[#334155]',
                'type' => 'Pickup Reminder',
                'type_bg' => 'bg-[#E2E8F0]',
                'type_text' => 'text-[#475569]',
                'message' => '"Final notice: 2 suits ready for pickup at Main Street branch."',
                'short_message' => '"Final notice: 2 suits ready for pickup at Main...',
                'status' => 'Delivered',
                'channel' => 'SMS Direct',
                'time' => '6 hours ago',
                'latency' => '110ms',
            ],
            [
                'id' => 9,
                'name' => 'Sophia Martinez',
                'initials' => 'SM',
                'phone' => '+1 (555) 456-7890',
                'avatar_bg' => 'bg-[#FED7D7]',
                'avatar_text' => 'text-[#C53030]',
                'type' => 'Payment Reminder',
                'type_bg' => 'bg-[#FED7D7]',
                'type_text' => 'text-[#E53E3E]',
                'message' => '"Receipt for Order #ORD-882: $32.00 paid successfully via Apple Pay."',
                'short_message' => '"Receipt for Order #ORD-882: $32.00 paid succe...',
                'status' => 'Delivered',
                'channel' => 'SMS & Email Dunning',
                'time' => '8 hours ago',
                'latency' => '102ms',
            ],
            [
                'id' => 10,
                'name' => 'Robert Johnson',
                'initials' => 'RJ',
                'phone' => '+1 (555) 987-6543',
                'avatar_bg' => 'bg-[#E9D5FF]',
                'avatar_text' => 'text-[#7E22CE]',
                'type' => 'Promotion Broadcast',
                'type_bg' => 'bg-[#F3E8FF]',
                'type_text' => 'text-[#9333EA]',
                'message' => '"VIP Exclusive: Free pickup & delivery on all orders this weekend!"',
                'short_message' => '"VIP Exclusive: Free pickup & delivery on all o...',
                'status' => 'Delivered',
                'channel' => 'Push & Geofence',
                'time' => '10 hours ago',
                'latency' => '118ms',
            ],
            // Page 3
            [
                'id' => 11,
                'name' => 'Emily Davis',
                'initials' => 'ED',
                'phone' => '+1 (555) 234-5678',
                'avatar_bg' => 'bg-[#D8D4FD]',
                'avatar_text' => 'text-[#4F39F6]',
                'type' => 'Order Ready',
                'type_bg' => 'bg-[#DFD7FE]',
                'type_text' => 'text-[#5B46F6]',
                'message' => '"Your laundry #WM-103 is ready for pickup! Locker: #08, PIN: 1920."',
                'short_message' => '"Your laundry #WM-103 is ready for pickup! L...',
                'status' => 'Delivered',
                'channel' => 'SMS / App Alert',
                'time' => '12 hours ago',
                'latency' => '96ms',
            ],
            [
                'id' => 12,
                'name' => 'James Wilson',
                'initials' => 'JW',
                'phone' => '+1 (555) 345-6789',
                'avatar_bg' => 'bg-[#BAE6FD]',
                'avatar_text' => 'text-[#0284C7]',
                'type' => 'Delivery Reminder',
                'type_bg' => 'bg-[#E0F2FE]',
                'type_text' => 'text-[#0284C7]',
                'message' => '"Van #04 en route with clean curtains and bedding. ETA 20 mins."',
                'short_message' => '"Van #04 en route with clean curtains and beddi...',
                'status' => 'Delivered',
                'channel' => 'Live GPS Link + Push',
                'time' => '14 hours ago',
                'latency' => '90ms',
            ],
            [
                'id' => 13,
                'name' => 'Olivia Brown',
                'initials' => 'OB',
                'phone' => '+1 (555) 456-7891',
                'avatar_bg' => 'bg-[#FED7D7]',
                'avatar_text' => 'text-[#C53030]',
                'type' => 'Payment Reminder',
                'type_bg' => 'bg-[#FED7D7]',
                'type_text' => 'text-[#E53E3E]',
                'message' => '"Invoice #INV-210 pending for $65.20. Pay online to release order."',
                'short_message' => '"Invoice #INV-210 pending for $65.20. Pay onli...',
                'status' => 'Delivered',
                'channel' => 'SMS & Email Dunning',
                'time' => '16 hours ago',
                'latency' => '105ms',
            ],
            [
                'id' => 14,
                'name' => 'William Lee',
                'initials' => 'WL',
                'phone' => '+1 (555) 567-8902',
                'avatar_bg' => 'bg-[#CBD5E1]',
                'avatar_text' => 'text-[#334155]',
                'type' => 'Pickup Reminder',
                'type_bg' => 'bg-[#E2E8F0]',
                'type_text' => 'text-[#475569]',
                'message' => '"Reminder: Express dry cleaning ready for collection at front desk."',
                'short_message' => '"Reminder: Express dry cleaning ready for colle...',
                'status' => 'Delivered',
                'channel' => 'SMS Direct',
                'time' => '18 hours ago',
                'latency' => '112ms',
            ],
            [
                'id' => 15,
                'name' => 'Amanda Miller',
                'initials' => 'AM',
                'phone' => '+1 (555) 678-9013',
                'avatar_bg' => 'bg-[#E9D5FF]',
                'avatar_text' => 'text-[#7E22CE]',
                'type' => 'Promotion Broadcast',
                'type_bg' => 'bg-[#F3E8FF]',
                'type_text' => 'text-[#9333EA]',
                'message' => '"Special: 15% off winter coat water-proofing service this week."',
                'short_message' => '"Special: 15% off winter coat water-proofing s...',
                'status' => 'Delivered',
                'channel' => 'Push & Geofence',
                'time' => '20 hours ago',
                'latency' => '116ms',
            ],
            // Page 4
            [
                'id' => 16,
                'name' => 'Daniel Garcia',
                'initials' => 'DG',
                'phone' => '+1 (555) 789-0124',
                'avatar_bg' => 'bg-[#D8D4FD]',
                'avatar_text' => 'text-[#4F39F6]',
                'type' => 'Order Ready',
                'type_bg' => 'bg-[#DFD7FE]',
                'type_text' => 'text-[#5B46F6]',
                'message' => '"Your laundry #WM-104 is sorted, folded and ready on rack #3."',
                'short_message' => '"Your laundry #WM-104 is sorted, folded and rea...',
                'status' => 'Delivered',
                'channel' => 'SMS / App Alert',
                'time' => '1 day ago',
                'latency' => '95ms',
            ],
            [
                'id' => 17,
                'name' => 'Mia Rodriguez',
                'initials' => 'MR',
                'phone' => '+1 (555) 890-1235',
                'avatar_bg' => 'bg-[#BAE6FD]',
                'avatar_text' => 'text-[#0284C7]',
                'type' => 'Delivery Reminder',
                'type_bg' => 'bg-[#E0F2FE]',
                'type_text' => 'text-[#0284C7]',
                'message' => '"Van #03 delivered your package to concierge. Signed by Front Desk."',
                'short_message' => '"Van #03 delivered your package to concierge. S...',
                'status' => 'Delivered',
                'channel' => 'Live GPS Link + Push',
                'time' => '1 day ago',
                'latency' => '91ms',
            ],
            [
                'id' => 18,
                'name' => 'Lucas White',
                'initials' => 'LW',
                'phone' => '+1 (555) 901-2346',
                'avatar_bg' => 'bg-[#FED7D7]',
                'avatar_text' => 'text-[#C53030]',
                'type' => 'Payment Reminder',
                'type_bg' => 'bg-[#FED7D7]',
                'type_text' => 'text-[#E53E3E]',
                'message' => '"Invoice #INV-215 paid ($19.50). Thank you for your business!"',
                'short_message' => '"Invoice #INV-215 paid ($19.50). Thank you for...',
                'status' => 'Delivered',
                'channel' => 'SMS & Email Dunning',
                'time' => '1 day ago',
                'latency' => '104ms',
            ],
            [
                'id' => 19,
                'name' => 'Chloe Harris',
                'initials' => 'CH',
                'phone' => '+1 (555) 012-3457',
                'avatar_bg' => 'bg-[#CBD5E1]',
                'avatar_text' => 'text-[#334155]',
                'type' => 'Pickup Reminder',
                'type_bg' => 'bg-[#E2E8F0]',
                'type_text' => 'text-[#475569]',
                'message' => '"Gentle reminder: Order #WM-98 is ready for collection."',
                'short_message' => '"Gentle reminder: Order #WM-98 is ready for co...',
                'status' => 'Delivered',
                'channel' => 'SMS Direct',
                'time' => '2 days ago',
                'latency' => '113ms',
            ],
            [
                'id' => 20,
                'name' => 'Ethan Clark',
                'initials' => 'EC',
                'phone' => '+1 (555) 123-4568',
                'avatar_bg' => 'bg-[#E9D5FF]',
                'avatar_text' => 'text-[#7E22CE]',
                'type' => 'Promotion Broadcast',
                'type_bg' => 'bg-[#F3E8FF]',
                'type_text' => 'text-[#9333EA]',
                'message' => '"Summer blankets wash & fold bundle only $15 per load."',
                'short_message' => '"Summer blankets wash & fold bundle only $15 pe...',
                'status' => 'Delivered',
                'channel' => 'Push & Geofence',
                'time' => '2 days ago',
                'latency' => '119ms',
            ],
            // Page 5
            [
                'id' => 21,
                'name' => 'Benjamin Lewis',
                'initials' => 'BL',
                'phone' => '+1 (555) 234-5679',
                'avatar_bg' => 'bg-[#D8D4FD]',
                'avatar_text' => 'text-[#4F39F6]',
                'type' => 'Order Ready',
                'type_bg' => 'bg-[#DFD7FE]',
                'type_text' => 'text-[#5B46F6]',
                'message' => '"Your dry cleaning #DC-551 is completed with luxury protective cover."',
                'short_message' => '"Your dry cleaning #DC-551 is completed with l...',
                'status' => 'Delivered',
                'channel' => 'SMS / App Alert',
                'time' => '2 days ago',
                'latency' => '97ms',
            ],
            [
                'id' => 22,
                'name' => 'Grace Walker',
                'initials' => 'GW',
                'phone' => '+1 (555) 345-6780',
                'avatar_bg' => 'bg-[#BAE6FD]',
                'avatar_text' => 'text-[#0284C7]',
                'type' => 'Delivery Reminder',
                'type_bg' => 'bg-[#E0F2FE]',
                'type_text' => 'text-[#0284C7]',
                'message' => '"Delivery van scheduled for tomorrow morning 9:00 AM - 11:00 AM."',
                'short_message' => '"Delivery van scheduled for tomorrow morning 9:...',
                'status' => 'Delivered',
                'channel' => 'Live GPS Link + Push',
                'time' => '3 days ago',
                'latency' => '93ms',
            ],
            [
                'id' => 23,
                'name' => 'Alexander Hall',
                'initials' => 'AH',
                'phone' => '+1 (555) 456-7892',
                'avatar_bg' => 'bg-[#FED7D7]',
                'avatar_text' => 'text-[#C53030]',
                'type' => 'Payment Reminder',
                'type_bg' => 'bg-[#FED7D7]',
                'type_text' => 'text-[#E53E3E]',
                'message' => '"Payment received for Commercial Account #CORP-104 ($180.00)."',
                'short_message' => '"Payment received for Commercial Account #CORP-...',
                'status' => 'Delivered',
                'channel' => 'SMS & Email Dunning',
                'time' => '3 days ago',
                'latency' => '106ms',
            ],
            [
                'id' => 24,
                'name' => 'Zoe Allen',
                'initials' => 'ZA',
                'phone' => '+1 (555) 567-8903',
                'avatar_bg' => 'bg-[#CBD5E1]',
                'avatar_text' => 'text-[#334155]',
                'type' => 'Pickup Reminder',
                'type_bg' => 'bg-[#E2E8F0]',
                'type_text' => 'text-[#475569]',
                'message' => '"Ready for pickup: Wedding dress dry clean & restoration."',
                'short_message' => '"Ready for pickup: Wedding dress dry clean & re...',
                'status' => 'Delivered',
                'channel' => 'SMS Direct',
                'time' => '4 days ago',
                'latency' => '114ms',
            ],
            [
                'id' => 25,
                'name' => 'Henry Young',
                'initials' => 'HY',
                'phone' => '+1 (555) 678-9014',
                'avatar_bg' => 'bg-[#E9D5FF]',
                'avatar_text' => 'text-[#7E22CE]',
                'type' => 'Promotion Broadcast',
                'type_bg' => 'bg-[#F3E8FF]',
                'type_text' => 'text-[#9333EA]',
                'message' => '"Earn double loyalty stars on all dry clean drop-offs."',
                'short_message' => '"Earn double loyalty stars on all dry clean dro...',
                'status' => 'Delivered',
                'channel' => 'Push & Geofence',
                'time' => '5 days ago',
                'latency' => '117ms',
            ],
        ];
    }

    /**
     * Display the Notification Management dashboard.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $statusFilter = $request->get('status', 'all');
        $page = (int) $request->get('page', 1);
        $perPage = 5;

        // KPI Summary Statistics
        $stats = [
            'notifications_sent' => '3,890',
            'sent_change' => '+14.2%',
            'delivery_rate' => '99.2%',
            'delivery_latency' => '1.1s',
            'delivery_status' => 'Optimal',
            'pending_pickup_alerts' => '14',
            'rack_load' => '78%',
            'pickup_status' => 'Attention needed',
            'unpaid_reminders' => '28',
            'payment_recovery' => '84%',
            'unpaid_period' => 'This week',
        ];

        // 5 Automated Triggers Matching Design
        $triggers = [
            [
                'id' => 1,
                'name' => 'Order Ready Notification',
                'badge' => 'SMS / App Alert',
                'badge_bg' => 'bg-[#EBE6FF]',
                'badge_text' => 'text-[#635BFF]',
                'sync' => 'Twilio & FCM synced',
                'description' => 'Dispatched immediately once garments are dried, folded, and placed on rack or locker.',
                'template' => '"Your laundry #{order_id} is ready for pickup! Locker: #',
                'active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Pickup Reminder',
                'badge' => 'SMS Direct',
                'badge_bg' => 'bg-[#E2E8F0]',
                'badge_text' => 'text-gray-700',
                'sync' => 'Auto-trigger after 24 hours',
                'description' => 'Gentle nudge to free up storage racks before overflow holding fees apply.',
                'template' => null,
                'active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Delivery Reminder',
                'badge' => 'Live GPS Link + Push',
                'badge_bg' => 'bg-[#E0F2FE]',
                'badge_text' => 'text-[#0284C7]',
                'sync' => 'Driver dispatch alert',
                'description' => 'Dispatches live route map tracking and ETA countdown when delivery van departs.',
                'template' => null,
                'active' => true,
            ],
            [
                'id' => 4,
                'name' => 'Payment Reminder',
                'badge' => 'SMS & Email Dunning',
                'badge_bg' => 'bg-[#EDE9FE]',
                'badge_text' => 'text-[#7C3AED]',
                'sync' => 'Digital invoice alert',
                'description' => 'Sends 1-click mobile payment link for commercial accounts & unpaid drop-offs.',
                'template' => null,
                'active' => true,
            ],
            [
                'id' => 5,
                'name' => 'Promotion Broadcast',
                'badge' => 'Push & Geofence',
                'badge_bg' => 'bg-[#DBEAFE]',
                'badge_text' => 'text-[#1D4ED8]',
                'sync' => 'Manual / Scheduled',
                'description' => 'Blast seasonal discounts to inactive customers and VIP segments.',
                'template' => null,
                'active' => false,
            ],
        ];

        // All Notification Records
        $allNotifications = collect($this->getAllNotifications());

        // Apply Status Filter
        if (!empty($statusFilter) && $statusFilter !== 'all') {
            $allNotifications = $allNotifications->filter(function ($item) use ($statusFilter) {
                return strtolower($item['type']) === strtolower($statusFilter);
            });
        }

        // Apply Search Filter
        if (!empty($search)) {
            $searchLower = strtolower($search);
            $allNotifications = $allNotifications->filter(function ($item) use ($searchLower) {
                return str_contains(strtolower($item['name']), $searchLower)
                    || str_contains(strtolower($item['phone']), $searchLower)
                    || str_contains(strtolower($item['type']), $searchLower)
                    || str_contains(strtolower($item['message']), $searchLower);
            });
        }

        $totalFiltered = $allNotifications->count();
        $totalPages = max(1, (int) ceil($totalFiltered / $perPage));
        $currentPage = min(max(1, $page), $totalPages);
        $offset = ($currentPage - 1) * $perPage;

        $pagedItems = $allNotifications->slice($offset, $perPage)->values();
        $from = $totalFiltered > 0 ? $offset + 1 : 0;
        $to = min($offset + $perPage, $totalFiltered);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $pagedItems,
                'all' => $this->getAllNotifications(),
                'pagination' => [
                    'current_page' => $currentPage,
                    'last_page' => $totalPages,
                    'per_page' => $perPage,
                    'total' => '3,890',
                    'filtered_total' => $totalFiltered,
                    'from' => $from,
                    'to' => $to,
                ],
            ]);
        }

        return view('pages.notification', [
            'stats' => $stats,
            'triggers' => $triggers,
            'notifications' => $pagedItems,
            'allNotifications' => $this->getAllNotifications(),
            'statusFilter' => $statusFilter,
            'search' => $search,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'from' => $from,
            'to' => $to,
            'totalFiltered' => $totalFiltered,
            'totalItems' => $totalFiltered,
            'totalLogs' => $totalFiltered,
        ]);
    }

    /**
     * Send a broadcast notification.
     */
    public function sendBroadcast(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'audience' => 'required|string',
            'channel' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        $notifications = $this->getAllNotifications();
        $newId = count($notifications) > 0 ? (max(array_column($notifications, 'id')) + 1) : 1;
        $newNotif = [
            'id' => $newId,
            'name' => $validated['title'],
            'initials' => 'BC',
            'phone' => 'Audience: ' . ucfirst($validated['audience']),
            'avatar_bg' => 'bg-[#DBEAFE]',
            'avatar_text' => 'text-[#2563EB]',
            'type' => 'Broadcast',
            'type_bg' => 'bg-[#DBEAFE]',
            'type_text' => 'text-[#2563EB]',
            'message' => '"' . $validated['message'] . '"',
            'short_message' => '"' . \Illuminate\Support\Str::limit($validated['message'], 40) . '"',
            'status' => 'Delivered',
            'channel' => strtoupper($validated['channel']),
            'time' => 'Just now',
            'latency' => rand(80, 110) . 'ms',
        ];
        array_unshift($notifications, $newNotif);
        session(['all_notifications' => $notifications]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Broadcast notification sent successfully to target audience via ' . strtoupper($validated['channel']) . '!',
                'data' => $newNotif,
            ]);
        }

        return redirect()->back()->with('success', 'Broadcast notification dispatched successfully!');
    }

    /**
     * Toggle trigger switch status.
     */
    public function toggleTrigger(Request $request)
    {
        $id = $request->input('id');
        $active = $request->boolean('active');

        return response()->json([
            'success' => true,
            'message' => 'Trigger rule #' . $id . ' status updated to ' . ($active ? 'Active' : 'Paused'),
            'id' => $id,
            'active' => $active,
        ]);
    }

    /**
     * Dry Run Sandbox Test.
     */
    public function dryRunSandbox(Request $request)
    {
        return response()->json([
            'success' => true,
            'title' => 'Sandbox Simulation Successful',
            'details' => [
                'Twilio SMS Gateway' => 'HTTP 200 OK (Latency 98ms)',
                'Firebase Cloud Messaging' => 'HTTP 200 OK (Queued: 0, Sent: 5)',
                'Driver GPS Telemetry Stream' => 'Active (4 Vans synced)',
                'Test Batch' => '5 simulated lifecycle triggers executed without drop errors.',
            ],
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
