<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Role definitions and metadata.
     */
    protected array $roles = [
        'Admin' => [
            'id' => 1,
            'name' => 'Admin',
            'icon' => 'shield-check',
            'color' => 'text-blue-600',
            'badge_bg' => 'bg-blue-100',
            'badge_text' => 'text-blue-700',
            'description' => 'Full Administrative Access',
        ],
        'Staff' => [
            'id' => 2,
            'name' => 'Staff',
            'icon' => 'users',
            'color' => 'text-indigo-600',
            'badge_bg' => 'bg-indigo-100',
            'badge_text' => 'text-indigo-700',
            'description' => 'Laundry & Machine Operations',
        ],
        'Delivery' => [
            'id' => 3,
            'name' => 'Delivery',
            'icon' => 'truck',
            'color' => 'text-rose-600',
            'badge_bg' => 'bg-rose-100',
            'badge_text' => 'text-rose-700',
            'description' => 'Routes & Fleet Logistics',
        ],
        'Receptionist' => [
            'id' => 4,
            'name' => 'Receptionist',
            'icon' => 'concierge-bell',
            'color' => 'text-amber-600',
            'badge_bg' => 'bg-amber-100',
            'badge_text' => 'text-amber-700',
            'description' => 'Front Desk & Customer In-take',
        ],
    ];

    /**
     * Check if free role switching is permitted.
     */
    private function isDemoSwitcherEnabled(): bool
    {
        return env('ROLE_SWITCHER', true) || app()->environment('local');
    }

    /**
     * Check if a user possesses a specific role.
     *
     * @param \App\Models\User|null $user
     * @param string $role
     * @return bool
     */
    private function userHasRole(?\App\Models\User $user, string $role): bool
    {
        if (!$user) {
            return false;
        }

        // Admin has access to all roles
        if ($user->role_id == 1 || strtolower($user->name) === 'admin' || strtolower($user->email ?? '') === 'admin@gmail.com') {
            return true;
        }

        $roleMap = [
            1 => 'Admin',
            2 => 'Staff',
            3 => 'Delivery',
            4 => 'Receptionist',
        ];

        return isset($roleMap[$user->role_id]) && strtolower($roleMap[$user->role_id]) === strtolower($role);
    }

    /**
     * Determine active role for current request.
     */
    private function resolveActiveRole(Request $request): string
    {
        $isDemo = $this->isDemoSwitcherEnabled();

        // 1. Direct query parameter change
        if ($request->has('role')) {
            $requested = ucfirst(strtolower($request->query('role')));
            if (isset($this->roles[$requested])) {
                if ($isDemo || (Auth::check() && $this->userHasRole(Auth::user(), $requested))) {
                    session(['active_role' => $requested]);
                    return $requested;
                }
                abort(403, 'Unauthorized role access.');
            }
        }

        // 2. Stored in session
        if (session()->has('active_role') && isset($this->roles[session('active_role')])) {
            $sessRole = session('active_role');
            if ($isDemo || (Auth::check() && $this->userHasRole(Auth::user(), $sessRole))) {
                return $sessRole;
            }
        }

        // 3. User default role
        if (Auth::check() && Auth::user()->role_id) {
            $map = [1 => 'Admin', 2 => 'Staff', 3 => 'Delivery', 4 => 'Receptionist'];
            $userRole = $map[Auth::user()->role_id] ?? 'Admin';
            session(['active_role' => $userRole]);
            return $userRole;
        }

        // 4. Default to Admin
        session(['active_role' => 'Admin']);
        return 'Admin';
    }

    /**
     * Get available roles for the current user.
     */
    private function getAvailableRoles(): array
    {
        $isDemo = $this->isDemoSwitcherEnabled();

        if ($isDemo) {
            return $this->roles;
        }

        $user = Auth::user();
        if (!$user) {
            return ['Admin' => $this->roles['Admin']];
        }

        // Admin has access to all roles
        if ($user->role_id == 1) {
            return $this->roles;
        }

        // Filter to only roles the user possesses
        $filtered = [];
        foreach ($this->roles as $key => $data) {
            if ($this->userHasRole($user, $key)) {
                $filtered[$key] = $data;
            }
        }

        return !empty($filtered) ? $filtered : ['Staff' => $this->roles['Staff']];
    }

    /**
     * Eight Stat Cards data generator.
     */
    private function getStatCards(string $role): array
    {
        // Default / Admin Cards (Exact match to design screenshot)
        $adminCards = [
            [
                'id' => 'total_customers',
                'label' => 'Total Customers',
                'value' => '128',
                'trend_pct' => '12%',
                'trend_direction' => 'up',
                'trend_text' => 'compared to last month',
                'icon' => 'users',
                'icon_fa' => 'fa-solid fa-users',
                'icon_color' => '#2563EB', // Blue
                'card_bg' => 'bg-[#EEF4FF]',
                'icon_box_bg' => 'bg-[#3B82F6]',
            ],
            [
                'id' => 'total_laundry_orders',
                'label' => 'Total Laundry Orders',
                'value' => '245',
                'trend_pct' => '8%',
                'trend_direction' => 'up',
                'trend_text' => 'compared to last month',
                'icon' => 'clipboard-list',
                'icon_fa' => 'fa-solid fa-clipboard-list',
                'icon_color' => '#4F46E5', // Indigo
                'card_bg' => 'bg-[#EEF2FF]',
                'icon_box_bg' => 'bg-[#4F46E5]',
            ],
            [
                'id' => 'pending_orders',
                'label' => 'Pending Orders',
                'value' => '32',
                'trend_pct' => '5%',
                'trend_direction' => 'up',
                'trend_text' => 'compared to yesterday',
                'icon' => 'history',
                'icon_fa' => 'fa-solid fa-clock-rotate-left',
                'icon_color' => '#F59E0B', // Amber
                'card_bg' => 'bg-[#FFFBEB]',
                'icon_box_bg' => 'bg-[#F59E0B]',
            ],
            [
                'id' => 'washing_orders',
                'label' => 'Washing Orders',
                'value' => '78',
                'trend_pct' => '6%',
                'trend_direction' => 'up',
                'trend_text' => 'compared to yesterday',
                'icon' => 'washing-machine',
                'icon_fa' => 'fa-solid fa-soap',
                'icon_color' => '#0284C7', // Sky Blue
                'card_bg' => 'bg-[#F0F9FF]',
                'icon_box_bg' => 'bg-[#0284C7]',
            ],
            [
                'id' => 'ready_for_pickup',
                'label' => 'Ready for Pickup',
                'value' => '45',
                'trend_pct' => '10%',
                'trend_direction' => 'up',
                'trend_text' => 'compared to yesterday',
                'icon' => 'package',
                'icon_fa' => 'fa-solid fa-box',
                'icon_color' => '#10B981', // Green
                'card_bg' => 'bg-[#ECFDF5]',
                'icon_box_bg' => 'bg-[#10B981]',
            ],
            [
                'id' => 'delivered_orders',
                'label' => 'Delivered Orders',
                'value' => '58',
                'trend_pct' => '7%',
                'trend_direction' => 'up',
                'trend_text' => 'compared to yesterday',
                'icon' => 'truck',
                'icon_fa' => 'fa-solid fa-truck',
                'icon_color' => '#F43F5E', // Rose
                'card_bg' => 'bg-[#FFF1F2]',
                'icon_box_bg' => 'bg-[#F43F5E]',
            ],
            [
                'id' => 'todays_revenue',
                'label' => "Today's Revenue",
                'value' => '$ 312.50',
                'trend_pct' => '15%',
                'trend_direction' => 'up',
                'trend_text' => 'compared to yesterday',
                'icon' => 'dollar-sign',
                'icon_fa' => 'fa-solid fa-coins',
                'icon_color' => '#0D9488', // Teal
                'card_bg' => 'bg-[#F0FDFA]',
                'icon_box_bg' => 'bg-[#0D9488]',
            ],
            [
                'id' => 'monthly_revenue',
                'label' => 'Monthly Revenue',
                'value' => '$ 4,860.75',
                'trend_pct' => '12%',
                'trend_direction' => 'up',
                'trend_text' => 'compared to last month',
                'icon' => 'calendar',
                'icon_fa' => 'fa-solid fa-calendar-days',
                'icon_color' => '#8B5CF6', // Violet
                'card_bg' => 'bg-[#F5F3FF]',
                'icon_box_bg' => 'bg-[#8B5CF6]',
            ],
        ];

        if ($role === 'Staff') {
            // Staff customized cards
            $adminCards[0]['label'] = 'Shift Capacity';
            $adminCards[0]['value'] = '94%';
            $adminCards[6]['label'] = 'Units Washed';
            $adminCards[6]['value'] = '64 Items';
            $adminCards[7]['label'] = 'Active Washers';
            $adminCards[7]['value'] = '20 Units';
        } elseif ($role === 'Delivery') {
            // Delivery customized cards
            $adminCards[0]['label'] = 'Assigned Routes';
            $adminCards[0]['value'] = '6 Routes';
            $adminCards[6]['label'] = 'Van Fuel Efficiency';
            $adminCards[6]['value'] = '98.5%';
            $adminCards[7]['label'] = 'Avg Dispatch Time';
            $adminCards[7]['value'] = '14 Mins';
        } elseif ($role === 'Receptionist') {
            // Receptionist customized cards
            $adminCards[6]['label'] = 'Walk-in Cash';
            $adminCards[6]['value'] = '$ 185.00';
            $adminCards[7]['label'] = 'Digital Payments';
            $adminCards[7]['value'] = '$ 127.50';
        }

        return $adminCards;
    }

    /**
     * Order Status Donut Chart data generator.
     */
    private function getOrderStatusData(): array
    {
        $categories = [
            ['name' => 'Pending', 'count' => 32, 'color' => '#F59E0B'],
            ['name' => 'Washing', 'count' => 78, 'color' => '#3B82F6'],
            ['name' => 'Ready for Pickup', 'count' => 45, 'color' => '#10B981'],
            ['name' => 'Delivered', 'count' => 58, 'color' => '#8B5CF6'],
            ['name' => 'Cancelled', 'count' => 32, 'color' => '#EF4444'],
        ];

        $total = array_sum(array_column($categories, 'count'));

        // Calculate dynamic percentages
        foreach ($categories as &$cat) {
            $cat['percentage'] = $total > 0 ? (int) round(($cat['count'] / $total) * 100) : 0;
        }

        return [
            'total' => $total,
            'period' => 'This Week',
            'categories' => $categories,
        ];
    }

    /**
     * Revenue Overview Grouped Bar Chart data generator.
     */
    private function getRevenueOverviewData(): array
    {
        return [
            'daily' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                'dates' => ['Sep 15', 'Sep 16', 'Sep 17', 'Sep 18', 'Sep 19', 'Sep 20'],
                'today_series' => [260, 340, 340, 380, 390, 480],
                'last_week_series' => [220, 280, 300, 350, 330, 420],
            ],
            'weekly' => [
                'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                'dates' => ['Aug 25-31', 'Sep 01-07', 'Sep 08-14', 'Sep 15-21'],
                'today_series' => [1850, 2120, 2340, 2580],
                'last_week_series' => [1650, 1900, 2050, 2280],
            ],
            'monthly' => [
                'labels' => ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                'dates' => ['2026', '2026', '2026', '2026', '2026', '2026'],
                'today_series' => [3800, 4100, 4350, 4500, 4720, 4860],
                'last_week_series' => [3400, 3750, 3900, 4100, 4250, 4400],
            ],
        ];
    }

    /**
     * Display the main Dashboard page.
     */
    public function index(Request $request)
    {
        $activeRole = $this->resolveActiveRole($request);
        $availableRoles = $this->getAvailableRoles();
        $isDemoMode = $this->isDemoSwitcherEnabled();

        $statCards = $this->getStatCards($activeRole);
        $orderStatus = $this->getOrderStatusData();
        $revenueOverview = $this->getRevenueOverviewData();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'activeRole' => $activeRole,
                'statCards' => $statCards,
                'orderStatus' => $orderStatus,
                'revenueOverview' => $revenueOverview,
            ]);
        }

        return view('pages.dashboard', [
            'activeRole' => $activeRole,
            'availableRoles' => $availableRoles,
            'isDemoMode' => $isDemoMode,
            'statCards' => $statCards,
            'orderStatus' => $orderStatus,
            'revenueOverview' => $revenueOverview,
            'user' => Auth::user(),
        ]);
    }

    /**
     * Switch active role and redirect to dashboard.
     */
    public function switchRole(Request $request, string $role)
    {
        $roleName = ucfirst(strtolower($role));
        $isDemo = $this->isDemoSwitcherEnabled();

        if (!isset($this->roles[$roleName])) {
            return redirect()->route('dashboard')->with('error', 'Invalid role selected.');
        }

        if (!$isDemo && Auth::check() && !$this->userHasRole(Auth::user(), $roleName)) {
            abort(403, 'You do not have permission to switch to this role.');
        }

        session(['active_role' => $roleName]);

        return redirect()->route('dashboard', ['role' => $roleName])
            ->with('success', "Switched view to {$roleName} dashboard.");
    }
}
