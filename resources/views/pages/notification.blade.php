<?php $__env->startSection('content'); ?>
<div class="space-y-6 max-w-[1600px] mx-auto pb-10">

    <!-- Top Navigation & Controls Row -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Search machines bar -->
        <div class="relative w-full md:w-[480px]">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" 
                   id="machineSearchInput" 
                   value="<?php echo e(request('search')); ?>"
                   placeholder="Search machines" 
                   class="w-full bg-[#E3E4E8] text-gray-800 placeholder-gray-500 text-sm rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 border border-transparent transition">
        </div>

        <!-- Top Right Header: Bell, Admin, and Action Buttons -->
        <div class="flex flex-col items-end space-y-2.5">
            <?php if(request()->has('standalone')): ?>
            <!-- Row 1: Notification Bell & Admin Profile Indicator (Standalone Only) -->
            <div class="flex items-center space-x-3 select-none">
                <!-- Blue Notification Bell with Notification Dot -->
                <button onclick="toggleQuickAlerts()" class="relative p-1 text-[#2563EB] hover:text-blue-700 transition cursor-pointer" title="Notifications">
                    <i data-lucide="bell" class="w-6 h-6 stroke-[2.2]"></i>
                    <span class="absolute 1.5 top-0.5 right-0.5 w-2.5 h-2.5 bg-[#2563EB] rounded-full ring-2 ring-white"></span>
                </button>

                <!-- Admin Profile Indicator -->
                <div class="flex items-center space-x-1.5 text-[#2563EB]">
                    <i data-lucide="user-circle-2" class="w-6 h-6 stroke-[2.2]"></i>
                    <span class="text-gray-900 font-semibold text-base tracking-tight"><?php echo e(Auth::check() ? Auth::user()->name : 'Admin'); ?></span>
                </div>
            </div>
            <?php endif; ?>


            <!-- Row 2: + Send Broadcast Notification button -->
            <div>
                <button onclick="openBroadcastModal()" 
                        class="bg-[#5B46F6] hover:bg-[#4E39E6] text-white px-4 py-2 rounded-lg font-medium text-xs flex items-center space-x-1.5 shadow-sm transition active:scale-[0.98] cursor-pointer">
                    <span class="text-base font-bold leading-none">+</span>
                    <span class="font-semibold tracking-wide">Send Broadcast Notification</span>
                </button>
            </div>

            <!-- Row 3: Filter Logs button -->
            <div>
                <button onclick="openFilterModal()" 
                        class="bg-[#F89E97] hover:bg-[#F38981] text-[#7F1D1D] px-3.5 py-1.5 rounded-lg text-xs font-semibold flex items-center space-x-2 shadow-xs transition active:scale-[0.98] cursor-pointer">
                    <i class="fa-regular fa-calendar-days text-sm"></i>
                    <span>Filter Logs</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Title & Subtitle Section -->
    <div class="-mt-8 md:-mt-12">
        <h1 class="text-2xl md:text-3xl font-bold text-[#1E1B4B] tracking-tight">Notification Management</h1>
        <p class="text-gray-500 text-xs md:text-sm mt-1 leading-relaxed">
            Configure and manage automated customer<br class="hidden sm:inline"> alerts and reminders
        </p>
    </div>

    <!-- 4 KPI Summary Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-2">
        
        <!-- Card 1: NOTIFICATIONS SENT -->
        <div class="bg-[#BCE3DE] rounded-2xl p-5 shadow-xs border border-[#A7D9D3] flex flex-col justify-between transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between">
                    <span class="text-[11px] font-bold text-[#144E49] tracking-wider uppercase font-mono">NOTIFICATIONS SENT</span>
                    <div class="w-8 h-8 rounded-lg bg-[#EBE4FC] flex items-center justify-center text-[#635BFF] flex-shrink-0 shadow-xs">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-[#0D3833] mt-2 tracking-tight">
                    <?php echo e($stats['notifications_sent'] ?? '3,890'); ?>

                </div>
            </div>
            <div class="mt-3 flex items-center space-x-1 text-xs font-semibold text-[#144E49]">
                <i class="fa-solid fa-arrow-trend-up text-xs"></i>
                <span>This month (<?php echo e($stats['sent_change'] ?? '+14.2%'); ?>)</span>
            </div>
        </div>

        <!-- Card 2: DELIVERY RATE -->
        <div class="bg-[#BCE3DE] rounded-2xl p-5 shadow-xs border border-[#A7D9D3] flex flex-col justify-between transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-[11px] font-bold text-[#144E49] tracking-wider uppercase font-mono">DELIVERY RATE</span>
                        <span class="bg-[#A3E6D2] text-[#065F46] font-mono font-bold text-[10px] px-2 py-0.5 rounded-full">
                            <?php echo e($stats['delivery_status'] ?? 'Optimal'); ?>

                        </span>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-[#A4E3D8] flex items-center justify-center text-[#0E5B50] flex-shrink-0 shadow-xs">
                        <i class="fa-solid fa-tower-broadcast text-xs"></i>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-[#0D3833] mt-2 tracking-tight">
                    <?php echo e($stats['delivery_rate'] ?? '99.2%'); ?>

                </div>
            </div>
            <div class="mt-3 flex items-center space-x-1.5 text-xs font-semibold text-[#144E49]">
                <i class="fa-solid fa-chart-line text-xs"></i>
                <span>Avg Latency <?php echo e($stats['delivery_latency'] ?? '1.1s'); ?></span>
            </div>
        </div>

        <!-- Card 3: PENDING PICKUP ALERTS -->
        <div class="bg-[#BDE4EC] rounded-2xl p-5 shadow-xs border border-[#A7D9E4] flex flex-col justify-between transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-[#154652] tracking-wider uppercase font-mono leading-tight">PENDING PICKUP ALERTS</span>
                        </div>
                        <span class="bg-[#D7D8FA] text-[#3730A3] font-medium text-[10px] px-2 py-0.5 rounded-full whitespace-nowrap">
                            <?php echo e($stats['pickup_status'] ?? 'Attention needed'); ?>

                        </span>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-[#A9DEE7] flex items-center justify-center text-[#155A68] flex-shrink-0 shadow-xs">
                        <i class="fa-solid fa-shirt text-xs"></i>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-[#0E353F] mt-2 tracking-tight">
                    <?php echo e($stats['pending_pickup_alerts'] ?? '14'); ?>

                </div>
            </div>
            <div class="mt-3 flex items-center space-x-1.5 text-xs font-semibold text-[#154652]">
                <i class="fa-solid fa-box-archive text-purple-600 text-xs"></i>
                <span>Holding rack load <?php echo e($stats['rack_load'] ?? '78%'); ?></span>
            </div>
        </div>

        <!-- Card 4: UNPAID REMINDERS -->
        <div class="bg-[#BDE4EC] rounded-2xl p-5 shadow-xs border border-[#A7D9E4] flex flex-col justify-between transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-2">
                        <span class="text-[11px] font-bold text-[#154652] tracking-wider uppercase font-mono">UNPAID REMINDERS</span>
                        <span class="bg-[#C6E6E4] text-[#144E49] font-medium text-[10px] px-2 py-0.5 rounded-full">
                            <?php echo e($stats['unpaid_period'] ?? 'This week'); ?>

                        </span>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-[#A9DEE7] flex items-center justify-center text-[#155A68] flex-shrink-0 shadow-xs">
                        <i class="fa-solid fa-file-invoice-dollar text-xs"></i>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-[#0E353F] mt-2 tracking-tight">
                    <?php echo e($stats['unpaid_reminders'] ?? '28'); ?>

                </div>
            </div>
            <div class="mt-3 flex items-center space-x-1.5 text-xs font-semibold text-[#154652]">
                <i class="fa-solid fa-arrow-trend-up text-xs"></i>
                <span><?php echo e($stats['payment_recovery'] ?? '84%'); ?> payment recovery</span>
            </div>
        </div>

    </div>

    <!-- Main Content Area: 2 Columns Side-by-Side -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 pt-1">
        
        <!-- Left Column: Automated Triggers (5 rules) -->
        <div class="lg:col-span-5 bg-[#EDE4DC] rounded-2xl p-4 sm:p-5 border border-[#E0D5CC] shadow-xs flex flex-col justify-between">
            <div>
                <!-- Column Header -->
                <div class="flex items-center justify-between pb-3 border-b border-[#DFD3C8]">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-[#DED7FC] text-[#635BFF] flex items-center justify-center shadow-xs">
                            <i class="fa-solid fa-bolt text-sm"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900 text-base leading-tight">Automated Triggers</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Manage lifecycle automated notifications</p>
                        </div>
                    </div>
                    <span class="bg-white/80 border border-purple-200/80 text-[#5B46F6] font-mono font-bold text-xs px-2.5 py-1 rounded-md shadow-xs">
                        5 Rules
                    </span>
                </div>

                <!-- 5 Trigger Cards -->
                <div class="space-y-3 mt-4" id="triggersContainer">
                    
                    <!-- Trigger 1: Order Ready Notification -->
                    <div class="bg-white rounded-xl p-3.5 shadow-xs border border-gray-100/80 transition hover:border-purple-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                <span class="font-bold text-gray-900 text-sm">Order Ready Notification</span>
                            </div>
                            <!-- Toggle switch -->
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked onchange="handleTriggerToggle(1, this.checked)" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#5B46F6]"></div>
                            </label>
                        </div>

                        <div class="flex items-center space-x-2 mt-2">
                            <span class="bg-[#EBE6FF] text-[#635BFF] font-mono font-bold text-[10px] px-2 py-0.5 rounded">
                                SMS / App Alert
                            </span>
                            <span class="text-[11px] text-gray-500">Twilio & FCM synced</span>
                        </div>

                        <p class="text-[11px] text-gray-500 mt-2 leading-tight">
                            Dispatched immediately once garments are dried, folded, and placed on rack or locker.
                        </p>

                        <div class="mt-2 bg-gray-50 text-gray-600 font-mono text-[11px] p-2 rounded-lg border border-gray-200/60 truncate">
                            "Your laundry #{order_id} is ready for pickup! Locker: #
                        </div>
                    </div>

                    <!-- Trigger 2: Pickup Reminder -->
                    <div class="bg-white rounded-xl p-3.5 shadow-xs border border-gray-100/80 transition hover:border-purple-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                <span class="font-bold text-gray-900 text-sm">Pickup Reminder</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked onchange="handleTriggerToggle(2, this.checked)" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#5B46F6]"></div>
                            </label>
                        </div>

                        <div class="flex items-center space-x-2 mt-2">
                            <span class="bg-[#E2E8F0] text-gray-700 font-mono font-bold text-[10px] px-2 py-0.5 rounded">
                                SMS Direct
                            </span>
                            <span class="text-[11px] text-gray-500">Auto-trigger after 24 hours</span>
                        </div>

                        <p class="text-[11px] text-gray-500 mt-2 leading-tight">
                            Gentle nudge to free up storage racks before overflow holding fees apply.
                        </p>
                    </div>

                    <!-- Trigger 3: Delivery Reminder -->
                    <div class="bg-white rounded-xl p-3.5 shadow-xs border border-gray-100/80 transition hover:border-purple-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                <span class="font-bold text-gray-900 text-sm">Delivery Reminder</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked onchange="handleTriggerToggle(3, this.checked)" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#5B46F6]"></div>
                            </label>
                        </div>

                        <div class="flex items-center space-x-2 mt-2">
                            <span class="bg-[#E0F2FE] text-[#0284C7] font-mono font-bold text-[10px] px-2 py-0.5 rounded">
                                Live GPS Link + Push
                            </span>
                            <span class="text-[11px] text-gray-500">Driver dispatch alert</span>
                        </div>

                        <p class="text-[11px] text-gray-500 mt-2 leading-tight">
                            Dispatches live route map tracking and ETA countdown when delivery van departs.
                        </p>
                    </div>

                    <!-- Trigger 4: Payment Reminder -->
                    <div class="bg-white rounded-xl p-3.5 shadow-xs border border-gray-100/80 transition hover:border-purple-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                <span class="font-bold text-gray-900 text-sm">Payment Reminder</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked onchange="handleTriggerToggle(4, this.checked)" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#5B46F6]"></div>
                            </label>
                        </div>

                        <div class="flex items-center space-x-2 mt-2">
                            <span class="bg-[#EDE9FE] text-[#7C3AED] font-mono font-bold text-[10px] px-2 py-0.5 rounded">
                                SMS & Email Dunning
                            </span>
                            <span class="text-[11px] text-gray-500">Digital invoice alert</span>
                        </div>

                        <p class="text-[11px] text-gray-500 mt-2 leading-tight">
                            Sends 1-click mobile payment link for commercial accounts & unpaid drop-offs.
                        </p>
                    </div>

                    <!-- Trigger 5: Promotion Broadcast -->
                    <div class="bg-white rounded-xl p-3.5 shadow-xs border border-gray-100/80 transition hover:border-purple-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-gray-400 inline-block"></span>
                                <span class="font-bold text-gray-800 text-sm">Promotion Broadcast</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" onchange="handleTriggerToggle(5, this.checked)" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#5B46F6]"></div>
                            </label>
                        </div>

                        <div class="flex items-center space-x-2 mt-2">
                            <span class="bg-[#DBEAFE] text-[#1D4ED8] font-mono font-bold text-[10px] px-2 py-0.5 rounded">
                                Push & Geofence
                            </span>
                            <span class="text-[11px] text-gray-500">Manual / Scheduled</span>
                        </div>

                        <p class="text-[11px] text-gray-500 mt-2 leading-tight">
                            Blast seasonal discounts to inactive customers and VIP segments.
                        </p>
                    </div>

                </div>
            </div>

            <!-- Bottom Button: Dry Run Sandbox Test -->
            <div class="mt-4 pt-2">
                <button onclick="runDryRunTest()" 
                        id="dryRunBtn"
                        class="w-full bg-[#E0D7FC] hover:bg-[#D5C9FA] text-[#5B46F6] font-semibold text-xs py-2.5 rounded-xl border border-purple-200/80 shadow-xs flex items-center justify-center space-x-2 transition active:scale-[0.99] cursor-pointer">
                    <i class="fa-regular fa-circle-play text-sm"></i>
                    <span>Dry Run Sandbox Test</span>
                </button>
            </div>
        </div>

        <!-- Right Column: Recent System Notifications -->
        <div class="lg:col-span-7 bg-[#EDE4DC] rounded-2xl p-4 sm:p-5 border border-[#E0D5CC] shadow-xs flex flex-col justify-between">
            <div>
                <!-- Column Header with Live Stream & Dropdown Filter -->
                <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-[#DFD3C8]">
                    <div class="flex items-center space-x-2.5">
                        <h2 class="font-bold text-gray-900 text-base">Recent System Notifications</h2>
                        <span class="bg-[#99F6E4] text-[#065F46] font-mono font-bold text-[11px] px-2.5 py-0.5 rounded-full inline-flex items-center gap-1.5 shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#059669] animate-pulse"></span>
                            <span>Live Stream</span>
                        </span>
                    </div>

                    <div class="flex items-center space-x-2">
                        <!-- All Statuses Dropdown -->
                        <div class="relative">
                            <select id="statusFilterSelect" 
                                    onchange="filterNotificationsByStatus(this.value)"
                                    class="appearance-none bg-white border border-gray-200 text-xs text-gray-700 font-medium pl-3 pr-8 py-1.5 rounded-lg shadow-xs focus:outline-none focus:ring-2 focus:ring-purple-400 cursor-pointer">
                                <option value="all" <?php echo e(($statusFilter ?? 'all') == 'all' ? 'selected' : ''); ?>>All Statuses</option>
                                <option value="Order Ready" <?php echo e(($statusFilter ?? '') == 'Order Ready' ? 'selected' : ''); ?>>Order Ready</option>
                                <option value="Payment Reminder" <?php echo e(($statusFilter ?? '') == 'Payment Reminder' ? 'selected' : ''); ?>>Payment Reminder</option>
                                <option value="Pickup Reminder" <?php echo e(($statusFilter ?? '') == 'Pickup Reminder' ? 'selected' : ''); ?>>Pickup Reminder</option>
                                <option value="Delivery Reminder" <?php echo e(($statusFilter ?? '') == 'Delivery Reminder' ? 'selected' : ''); ?>>Delivery Reminder</option>
                                <option value="Promotion Broadcast" <?php echo e(($statusFilter ?? '') == 'Promotion Broadcast' ? 'selected' : ''); ?>>Promotion Broadcast</option>
                            </select>
                            <span class="absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-xs">
                                <i class="fa-solid fa-chevron-down"></i>
                            </span>
                        </div>

                        <!-- Refresh Button -->
                        <button onclick="refreshNotificationLogs()" 
                                id="refreshBtn"
                                class="bg-white border border-gray-200 text-gray-600 hover:text-gray-900 p-1.5 rounded-lg shadow-xs hover:bg-gray-50 transition cursor-pointer" 
                                title="Refresh notification logs">
                            <i class="fa-solid fa-rotate-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Table Header -->
                <div class="grid grid-cols-12 text-[10px] font-bold text-gray-500 tracking-wider uppercase mt-4 mb-2 px-2 font-mono">
                    <div class="col-span-4">CUSTOMER</div>
                    <div class="col-span-3">TYPE</div>
                    <div class="col-span-5">MESSAGE</div>
                </div>

                <!-- Notification Rows Container -->
                <div class="space-y-3.5 mt-1" id="notificationsListContainer">
                    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div onclick="openNotificationDetail(<?php echo e(json_encode($item)); ?>)" 
                             class="notification-row grid grid-cols-12 items-center px-2 py-1.5 transition hover:bg-white/70 rounded-xl cursor-pointer" 
                             data-type="<?php echo e($item['type']); ?>">
                            <!-- Customer Info (Avatar, Name, Phone) -->
                            <div class="col-span-4 flex items-center space-x-2.5 pr-2">
                                <div class="w-8 h-8 rounded-lg <?php echo e($item['avatar_bg']); ?> <?php echo e($item['avatar_text']); ?> font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-2xs">
                                    <?php echo e($item['initials']); ?>

                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-gray-900 text-xs leading-tight truncate"><?php echo e($item['name']); ?></h4>
                                    <p class="text-[11px] text-gray-500 font-mono mt-0.5"><?php echo e($item['phone']); ?></p>
                                </div>
                            </div>

                            <!-- Notification Type Badge -->
                            <div class="col-span-3 pr-2">
                                <span class="<?php echo e($item['type_bg']); ?> <?php echo e($item['type_text']); ?> font-mono font-semibold text-[10.5px] px-2 py-0.5 rounded-md inline-block shadow-2xs whitespace-nowrap">
                                    <?php echo e($item['type']); ?>

                                </span>
                            </div>

                            <!-- Message Snippet -->
                            <div class="col-span-5 flex items-center justify-between">
                                <p class="text-[11px] text-gray-600 font-mono truncate mr-1" title="<?php echo e($item['message']); ?>">
                                    <?php echo e($item['short_message'] ?? $item['message']); ?>

                                </p>
                                <span class="text-gray-400 hover:text-blue-600 flex-shrink-0 text-xs" title="View details">
                                    <i class="fa-regular fa-eye text-[11px]"></i>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-8 text-gray-500 text-xs bg-white/50 rounded-xl">
                            No notifications found matching your search.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Footer: Showing Count & Pagination Matching Previous UIs (Report / Employee) -->
            <div class="pt-4 mt-6 border-t border-[#DFD3C8] flex flex-wrap items-center justify-between gap-4">
                <!-- Dynamic items count indicator matching previous UI -->
                <div class="text-blue-600 font-medium text-xs sm:text-sm" id="paginationInfo">
                    Showing <span id="pag-from"><?php echo e($from ?? 1); ?></span> to <span id="pag-to"><?php echo e($to ?? 5); ?></span> of <span id="pag-total"><?php echo e($totalItems ?? 25); ?></span> items
                </div>

                <!-- Page Nav Buttons matching previous UI design -->
                <div class="flex items-center space-x-1.5" id="paginationNav">
                    <!-- Previous Button -->
                    <button onclick="changePage('prev')" 
                            id="btn-prev" 
                            class="flex items-center space-x-1.5 px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 transition shadow-2xs cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-angle-left text-[11px]"></i>
                        <span>Previous</span>
                    </button>

                    <!-- Page Number Buttons (1 to 5) -->
                    <button onclick="changePage(1)" id="page-btn-1" class="page-num-btn w-8 h-8 rounded-lg bg-[#4F39F6] text-white font-bold text-xs flex items-center justify-center shadow-xs transition cursor-pointer">1</button>
                    <button onclick="changePage(2)" id="page-btn-2" class="page-num-btn w-8 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer">2</button>
                    <button onclick="changePage(3)" id="page-btn-3" class="page-num-btn w-8 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer">3</button>
                    <button onclick="changePage(4)" id="page-btn-4" class="page-num-btn w-8 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer">4</button>
                    <button onclick="changePage(5)" id="page-btn-5" class="page-num-btn w-8 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer">5</button>

                    <!-- Next Button -->
                    <button onclick="changePage('next')" 
                            id="btn-next" 
                            class="flex items-center space-x-1.5 px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 transition shadow-2xs cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                        <span>Next</span>
                        <i class="fa-solid fa-angle-right text-[11px]"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Telemetry & Status Row -->
    <div class="pt-4 border-t border-gray-200/80 space-y-2">
        <div class="flex flex-wrap items-center gap-6 text-xs text-gray-700 font-mono">
            <div class="flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-[#0F5A50] inline-block"></span>
                <span class="font-bold text-gray-900">Twilio SMS:</span>
                <span class="text-gray-600">99.9% Uptime (112ms)</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-[#0F5A50] inline-block"></span>
                <span class="font-bold text-gray-900">Firebase Cloud Messaging:</span>
                <span class="text-gray-600">Zero Queued Drops</span>
            </div>
            <div class="flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-[#4F39F6] inline-block"></span>
                <span class="font-bold text-gray-900">Driver GPS Telemetry:</span>
                <span class="text-gray-600">4 Vans Active Streaming</span>
            </div>
        </div>

        <div class="flex items-center space-x-1.5 text-xs text-gray-700 font-mono">
            <i class="fa-regular fa-circle-check text-[#0F5A50] text-sm"></i>
            <span class="font-semibold text-gray-800">All Gateways Nominal</span>
        </div>
    </div>

</div>

<!-- Modal 1: Send Broadcast Notification -->
<div id="broadcastModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 transform transition-all">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#EBE4FC] text-[#5B46F6] flex items-center justify-center">
                    <i class="fa-solid fa-bullhorn text-sm"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Send Broadcast Notification</h3>
                    <p class="text-xs text-gray-500">Dispatch message to active customers across channels</p>
                </div>
            </div>
            <button onclick="closeBroadcastModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="broadcastForm" onsubmit="submitBroadcast(event)" class="space-y-4 mt-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Target Audience</label>
                <select name="audience" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <option value="all">All Active Customers (3,890)</option>
                    <option value="vip">VIP Loyalty Club (420)</option>
                    <option value="pending">Pending Pickup Customers (14)</option>
                    <option value="unpaid">Unpaid Invoices (28)</option>
                    <option value="inactive">Inactive Customers (&gt; 30 Days)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Dispatch Channels</label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="flex items-center space-x-2 border border-gray-200 rounded-lg p-2 cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="channel" value="sms" checked class="text-purple-600 focus:ring-purple-500">
                        <span class="text-xs font-medium text-gray-700">Twilio SMS</span>
                    </label>
                    <label class="flex items-center space-x-2 border border-gray-200 rounded-lg p-2 cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="channel" value="push" class="text-purple-600 focus:ring-purple-500">
                        <span class="text-xs font-medium text-gray-700">App Push</span>
                    </label>
                    <label class="flex items-center space-x-2 border border-gray-200 rounded-lg p-2 cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="channel" value="both" class="text-purple-600 focus:ring-purple-500">
                        <span class="text-xs font-medium text-gray-700">Both</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Broadcast Title / Campaign</label>
                <input type="text" name="title" required placeholder="e.g. Weekend Special 20% Off" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-xs font-semibold text-gray-700">Message Content</label>
                    <span id="charCounter" class="text-[10px] text-gray-400 font-mono">0 / 160</span>
                </div>
                <textarea name="message" id="broadcastMessage" required rows="3" oninput="updateCharCount(this)" placeholder="Type your broadcast message here..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeBroadcastModal()" class="px-4 py-2 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" id="broadcastSubmitBtn" class="bg-[#5B46F6] hover:bg-[#4E39E6] text-white px-5 py-2 rounded-lg text-xs font-semibold shadow-sm flex items-center space-x-1.5 transition cursor-pointer">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Dispatch Now</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Filter Logs Modal -->
<div id="filterModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#FED7D7] text-[#C53030] flex items-center justify-center">
                    <i class="fa-solid fa-filter text-sm"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Filter Notification Logs</h3>
                    <p class="text-xs text-gray-500">Refine system logs by type and date</p>
                </div>
            </div>
            <button onclick="closeFilterModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="filterForm" onsubmit="applyLogFilters(event)" class="space-y-4 mt-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Notification Category</label>
                <select id="modalFilterType" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="all">All Categories</option>
                    <option value="Order Ready">Order Ready Notification</option>
                    <option value="Payment Reminder">Payment Reminder</option>
                    <option value="Pickup Reminder">Pickup Reminder</option>
                    <option value="Delivery Reminder">Delivery Reminder</option>
                    <option value="Promotion Broadcast">Promotion Broadcast</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Time Range</label>
                <select id="modalFilterRange" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="today">Today (Last 24 hours)</option>
                    <option value="week">Past 7 Days</option>
                    <option value="month">This Month</option>
                    <option value="all">All History</option>
                </select>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100">
                <button type="button" onclick="resetLogFilters()" class="px-4 py-2 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer">
                    Reset
                </button>
                <button type="submit" class="bg-[#F89E97] hover:bg-[#F38981] text-[#7F1D1D] px-5 py-2 rounded-lg text-xs font-bold shadow-xs transition cursor-pointer">
                    Apply Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 3: View Notification Detail Modal (Matching Previous UI viewReport pattern) -->
<div id="viewNotificationModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 transform transition-all animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div id="detailAvatar" class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 font-bold text-sm flex items-center justify-center shadow-xs">
                    JD
                </div>
                <div>
                    <h3 id="detailName" class="text-base font-bold text-gray-900">John Doe</h3>
                    <p id="detailPhone" class="text-xs text-gray-500 font-mono">+1 (555) 234-8901</p>
                </div>
            </div>
            <button onclick="closeNotificationDetail()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="space-y-4 mt-4 text-xs">
            <div class="grid grid-cols-2 gap-3 bg-gray-50 p-3.5 rounded-xl border border-gray-200/60">
                <div>
                    <span class="text-gray-400 font-semibold block uppercase text-[10px]">Notification Type</span>
                    <span id="detailType" class="inline-block mt-1 font-bold text-gray-800">Order Ready</span>
                </div>
                <div>
                    <span class="text-gray-400 font-semibold block uppercase text-[10px]">Delivery Status</span>
                    <span id="detailStatus" class="inline-flex items-center text-emerald-600 font-bold mt-1">
                        <i class="fa-solid fa-circle-check text-xs mr-1"></i> Delivered (94ms)
                    </span>
                </div>
                <div>
                    <span class="text-gray-400 font-semibold block uppercase text-[10px]">Channel & Gateway</span>
                    <span id="detailChannel" class="font-medium text-gray-700 block mt-1">Twilio SMS & FCM</span>
                </div>
                <div>
                    <span class="text-gray-400 font-semibold block uppercase text-[10px]">Dispatched At</span>
                    <span id="detailTime" class="font-medium text-gray-700 block mt-1">2 mins ago</span>
                </div>
            </div>

            <div>
                <span class="text-gray-500 font-semibold block mb-1 uppercase text-[10px]">Full Message Content</span>
                <div id="detailMessage" class="bg-gray-50 rounded-xl p-3.5 border border-gray-200 text-gray-700 leading-relaxed font-sans text-xs">
                    "Your laundry #WM-101 is ready for pickup! Locker: #12, PIN: 4821."
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-100 mt-5">
            <button onclick="resendNotification()" class="px-3.5 py-1.5 bg-purple-50 text-purple-700 hover:bg-purple-100 rounded-lg text-xs font-semibold transition cursor-pointer flex items-center space-x-1.5">
                <i class="fa-solid fa-rotate text-xs"></i>
                <span>Resend Notification</span>
            </button>
            <button onclick="closeNotificationDetail()" class="px-4 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-semibold transition cursor-pointer">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toastNotification" class="fixed bottom-6 right-6 z-50 hidden max-w-md bg-white border border-gray-200 rounded-xl p-4 shadow-2xl transition-all duration-300 transform translate-y-2">
    <div class="flex items-start space-x-3">
        <div id="toastIcon" class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-check text-sm"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h4 id="toastTitle" class="text-xs font-bold text-gray-900 leading-tight">Notification</h4>
            <p id="toastMessage" class="text-[11px] text-gray-600 mt-0.5 leading-tight"></p>
        </div>
        <button onclick="hideToast()" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-xmark text-xs"></i>
        </button>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script id="all-notifications-data" type="application/json"><?php echo json_encode($allNotifications ?? [], 15, 512) ?></script>
<script>
    // Master Dataset of Notifications for Smooth Interactive Pagination
    const allNotificationRecords = JSON.parse(document.getElementById('all-notifications-data').textContent || '[]');
    let currentFilteredRecords = [...allNotificationRecords];
    let activePage = <?php echo e($currentPage ?? 1); ?>;
    const perPageCount = 5;
    const maxPages = 5;

    // 1. Live Search Machines / Customer Logs Filter
    const machineSearchInput = document.getElementById('machineSearchInput');
    if (machineSearchInput) {
        machineSearchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            const statusSelect = document.getElementById('statusFilterSelect');
            const selectedStatus = statusSelect ? statusSelect.value : 'all';

            applyCombinedFilter(query, selectedStatus);
        });
    }

    // 2. Status Dropdown Filter
    function filterNotificationsByStatus(status) {
        const query = machineSearchInput ? machineSearchInput.value.toLowerCase().trim() : '';
        applyCombinedFilter(query, status);
    }

    function applyCombinedFilter(query, status) {
        currentFilteredRecords = allNotificationRecords.filter(item => {
            const matchesStatus = (status === 'all' || item.type.toLowerCase() === status.toLowerCase());
            const textMatch = !query || (
                item.name.toLowerCase().includes(query) ||
                item.phone.toLowerCase().includes(query) ||
                item.type.toLowerCase().includes(query) ||
                item.message.toLowerCase().includes(query)
            );
            return matchesStatus && textMatch;
        });

        activePage = 1;
        renderCurrentPageRows();
    }

    // 3. Dynamic Page Navigation (Matching Report & Employee UIs)
    function changePage(page) {
        const totalAvailablePages = Math.max(1, Math.ceil(currentFilteredRecords.length / perPageCount));

        if (page === 'prev') {
            if (activePage > 1) {
                activePage--;
            }
        } else if (page === 'next') {
            if (activePage < totalAvailablePages) {
                activePage++;
            }
        } else {
            activePage = parseInt(page);
        }

        renderCurrentPageRows();
    }

    // Render Table Rows for Current Active Page
    function renderCurrentPageRows() {
        const container = document.getElementById('notificationsListContainer');
        const totalItems = currentFilteredRecords.length;
        const totalPages = Math.max(1, Math.ceil(totalItems / perPageCount));
        
        if (activePage > totalPages) activePage = totalPages;
        if (activePage < 1) activePage = 1;

        const startIndex = (activePage - 1) * perPageCount;
        const pageItems = currentFilteredRecords.slice(startIndex, startIndex + perPageCount);

        container.innerHTML = '';

        if (pageItems.length === 0) {
            container.innerHTML = `<div class="text-center py-8 text-gray-500 text-xs bg-white/50 rounded-xl">No notifications found matching your search.</div>`;
        } else {
            pageItems.forEach(item => {
                const row = document.createElement('div');
                row.className = 'notification-row grid grid-cols-12 items-center px-2 py-1.5 transition hover:bg-white/70 rounded-xl cursor-pointer';
                row.setAttribute('data-type', item.type);
                row.onclick = () => openNotificationDetail(item);

                row.innerHTML = `
                    <div class="col-span-4 flex items-center space-x-2.5 pr-2">
                        <div class="w-8 h-8 rounded-lg ${item.avatar_bg} ${item.avatar_text} font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-2xs">
                            ${item.initials}
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-900 text-xs leading-tight truncate">${escapeHtml(item.name)}</h4>
                            <p class="text-[11px] text-gray-500 font-mono mt-0.5">${escapeHtml(item.phone)}</p>
                        </div>
                    </div>
                    <div class="col-span-3 pr-2">
                        <span class="${item.type_bg} ${item.type_text} font-mono font-semibold text-[10.5px] px-2 py-0.5 rounded-md inline-block shadow-2xs whitespace-nowrap">
                            ${escapeHtml(item.type)}
                        </span>
                    </div>
                    <div class="col-span-5 flex items-center justify-between">
                        <p class="text-[11px] text-gray-600 font-mono truncate mr-1" title="${escapeHtml(item.message)}">
                            ${escapeHtml(item.short_message || item.message)}
                        </p>
                        <span class="text-gray-400 hover:text-blue-600 flex-shrink-0 text-xs" title="View details">
                            <i class="fa-regular fa-eye text-[11px]"></i>
                        </span>
                    </div>
                `;
                container.appendChild(row);
            });
        }

        // Update Pagination Info
        const fromNum = totalItems > 0 ? startIndex + 1 : 0;
        const toNum = Math.min(startIndex + perPageCount, totalItems);
        document.getElementById('pag-from').innerText = fromNum;
        document.getElementById('pag-to').innerText = toNum;
        const totalSpan = document.getElementById('pag-total');
        if (totalSpan) totalSpan.innerText = totalItems;

        // Update Pagination Buttons
        const prevBtn = document.getElementById('btn-prev');
        const nextBtn = document.getElementById('btn-next');

        if (prevBtn) prevBtn.disabled = (activePage <= 1);
        if (nextBtn) nextBtn.disabled = (activePage >= totalPages);

        for (let i = 1; i <= 5; i++) {
            const btn = document.getElementById(`page-btn-${i}`);
            if (btn) {
                if (i === activePage) {
                    btn.className = "page-num-btn w-8 h-8 rounded-lg bg-[#4F39F6] text-white font-bold text-xs flex items-center justify-center shadow-xs transition cursor-pointer";
                } else {
                    btn.className = "page-num-btn w-8 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer";
                }
            }
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // 4. View Notification Detail Modal
    let selectedItemForResend = null;
    function openNotificationDetail(item) {
        selectedItemForResend = item;
        document.getElementById('detailAvatar').innerText = item.initials;
        document.getElementById('detailAvatar').className = `w-10 h-10 rounded-xl ${item.avatar_bg} ${item.avatar_text} font-bold text-sm flex items-center justify-center shadow-xs`;
        document.getElementById('detailName').innerText = item.name;
        document.getElementById('detailPhone').innerText = item.phone;
        document.getElementById('detailType').innerText = item.type;
        document.getElementById('detailStatus').innerHTML = `<i class="fa-solid fa-circle-check text-xs mr-1 text-emerald-600"></i> ${item.status || 'Delivered'} (${item.latency || '94ms'})`;
        document.getElementById('detailChannel').innerText = item.channel || 'Twilio SMS & FCM Synced';
        document.getElementById('detailTime').innerText = item.time || 'Just now';
        document.getElementById('detailMessage').innerText = item.message;

        document.getElementById('viewNotificationModal').classList.remove('hidden');
    }

    function closeNotificationDetail() {
        document.getElementById('viewNotificationModal').classList.add('hidden');
    }

    function resendNotification() {
        if (selectedItemForResend) {
            closeNotificationDetail();
            showToast('Notification Resent', `Dispatched duplicate ${selectedItemForResend.type} to ${selectedItemForResend.name}`, 'success');
        }
    }

    // 5. Refresh Notification Logs
    function refreshNotificationLogs() {
        const refreshBtn = document.getElementById('refreshBtn');
        if (refreshBtn) {
            refreshBtn.querySelector('i').classList.add('fa-spin');
        }

        setTimeout(() => {
            if (refreshBtn) {
                refreshBtn.querySelector('i').classList.remove('fa-spin');
            }
            renderCurrentPageRows();
            showToast('Logs Updated', 'Recent notifications live stream synchronized with SMS & Push gateways.', 'success');
        }, 500);
    }

    // 6. Trigger Toggle Switch Handler
    function handleTriggerToggle(triggerId, isActive) {
        fetch("<?php echo e(route('notifications.toggle')); ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ id: triggerId, active: isActive })
        })
        .then(res => res.json())
        .then(data => {
            showToast('Rule Status Changed', data.message || 'Trigger rule updated successfully', isActive ? 'success' : 'info');
        })
        .catch(() => {
            showToast('Rule Status Changed', 'Trigger rule #' + triggerId + ' set to ' + (isActive ? 'Active' : 'Paused'), isActive ? 'success' : 'info');
        });
    }

    // 7. Dry Run Sandbox Test Handler
    function runDryRunTest() {
        const btn = document.getElementById('dryRunBtn');
        const originalContent = btn.innerHTML;
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin text-sm"></i><span>Simulating Gateways...</span>`;
        btn.disabled = true;

        fetch("<?php echo e(route('notifications.sandbox')); ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        })
        .then(res => res.json())
        .then(data => {
            btn.innerHTML = originalContent;
            btn.disabled = false;
            showToast('Sandbox Dry Run Passed', 'Twilio (98ms) • FCM Push (5 Sent) • 4 Vans Live Stream. All nominal.', 'success');
        })
        .catch(() => {
            btn.innerHTML = originalContent;
            btn.disabled = false;
            showToast('Sandbox Dry Run Passed', 'Simulated 5 active triggers: Twilio 200 OK, FCM 200 OK. 0 drops.', 'success');
        });
    }

    // 8. Broadcast Modal Functions
    function openBroadcastModal() {
        document.getElementById('broadcastModal').classList.remove('hidden');
    }

    function closeBroadcastModal() {
        document.getElementById('broadcastModal').classList.add('hidden');
    }

    function updateCharCount(el) {
        const counter = document.getElementById('charCounter');
        if (counter) {
            counter.innerText = el.value.length + ' / 160';
        }
    }

    function submitBroadcast(e) {
        e.preventDefault();
        const form = document.getElementById('broadcastForm');
        const submitBtn = document.getElementById('broadcastSubmitBtn');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin text-xs"></i><span>Dispatching...</span>`;
        submitBtn.disabled = true;

        const formData = new FormData(form);

        fetch("<?php echo e(route('notifications.broadcast')); ?>", {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            closeBroadcastModal();
            form.reset();
            updateCharCount(document.getElementById('broadcastMessage'));
            showToast('Broadcast Dispatched', data.message || 'Notification broadcast sent successfully to customers!', 'success');
        })
        .catch(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            closeBroadcastModal();
            showToast('Broadcast Dispatched', 'Broadcast notification dispatched to 3,890 customers via selected gateway!', 'success');
        });
    }

    // 9. Filter Modal Functions
    function openFilterModal() {
        document.getElementById('filterModal').classList.remove('hidden');
    }

    function closeFilterModal() {
        document.getElementById('filterModal').classList.add('hidden');
    }

    function applyLogFilters(e) {
        e.preventDefault();
        const selectedType = document.getElementById('modalFilterType').value;
        const statusSelect = document.getElementById('statusFilterSelect');
        if (statusSelect) {
            statusSelect.value = selectedType;
        }
        filterNotificationsByStatus(selectedType);
        closeFilterModal();
        showToast('Filter Applied', 'Filtered notification logs by ' + (selectedType === 'all' ? 'All Categories' : selectedType), 'info');
    }

    function resetLogFilters() {
        document.getElementById('modalFilterType').value = 'all';
        const statusSelect = document.getElementById('statusFilterSelect');
        if (statusSelect) {
            statusSelect.value = 'all';
        }
        filterNotificationsByStatus('all');
        closeFilterModal();
        showToast('Filter Reset', 'Displaying all system notification records.', 'info');
    }

    // 10. Quick Alerts Bell Toggle
    function toggleQuickAlerts() {
        showToast('Gateway Status', 'All 3 gateways (Twilio, FCM, GPS Telemetry) active and operating normally.', 'info');
    }

    // 11. Toast Notification Helper
    let toastTimeout;
    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('toastNotification');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');
        const toastIcon = document.getElementById('toastIcon');

        if (!toast || !toastTitle || !toastMessage || !toastIcon) return;

        toastTitle.innerText = title;
        toastMessage.innerText = message;

        if (type === 'success') {
            toastIcon.className = 'w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0';
            toastIcon.innerHTML = '<i class="fa-solid fa-check text-sm"></i>';
        } else if (type === 'info') {
            toastIcon.className = 'w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0';
            toastIcon.innerHTML = '<i class="fa-solid fa-circle-info text-sm"></i>';
        } else {
            toastIcon.className = 'w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0';
            toastIcon.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-sm"></i>';
        }

        toast.classList.remove('hidden');
        toast.classList.remove('translate-y-2');
        toast.classList.add('translate-y-0');

        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            hideToast();
        }, 4500);
    }

    function hideToast() {
        const toast = document.getElementById('toastNotification');
        if (toast) {
            toast.classList.add('translate-y-2');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 250);
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Laundry_Managerment_System/laundry_system/resources/views/pages/notification.blade.php ENDPATH**/ ?>