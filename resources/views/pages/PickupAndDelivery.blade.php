<?php $__env->startSection('content'); ?>
<div class="space-y-6 max-w-[1580px] mx-auto pb-12">

    <?php if(request()->has('standalone')): ?>
    <!-- Top Navigation Header Bar (Standalone Mode Only) -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Top Left: Title & Greeting -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight leading-tight">Pickup & Delivery</h1>
            <p class="text-gray-500 text-sm mt-0.5 font-medium">Welcome back, Admin!</p>
        </div>

        <!-- Top Right: Search Service & Admin Profile -->
        <div class="flex items-center space-x-4">
            <!-- Search Service Bar -->
            <div class="relative w-full md:w-[320px]">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                    <svg class="w-4 h-4 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input type="text" 
                       id="serviceSearchInput" 
                       value="<?php echo e(request('search', $search ?? '')); ?>"
                       oninput="handleTaskSearch(this.value)"
                       placeholder="Search Service" 
                       class="w-full bg-[#E5E7EB] text-gray-800 placeholder-gray-500 text-sm rounded-xl pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/30 border border-transparent transition">
            </div>

            <!-- Blue Notification Bell Icon with Dot -->
            <button type="button" class="relative text-[#2563EB] hover:text-blue-700 transition cursor-pointer p-1" title="Notifications">
                <svg class="w-6 h-6 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-[#2563EB] rounded-full ring-2 ring-white"></span>
            </button>

            <!-- Admin Profile Indicator with Dropdown Caret -->
            <div class="flex items-center space-x-2 select-none cursor-pointer">
                <div class="text-[#2563EB]">
                    <svg class="w-7 h-7 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="10" r="3"></circle>
                        <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
                    </svg>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="text-gray-900 font-semibold text-sm tracking-tight">Admin</span>
                    <svg class="w-3.5 h-3.5 text-gray-600 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Section Header: Title, Subtitle, and Schedule New Task Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-1">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Pickup & Delivery</h2>
            <p class="text-gray-500 text-sm mt-0.5">Manage schedules, staff assignments, and delivery logistics.</p>
        </div>

        <!-- Schedule New Task Button with Rocket Icon -->
        <button type="button" 
                onclick="openScheduleModal()"
                class="bg-[#2042E3] hover:bg-[#1A38C2] active:scale-[0.98] text-white px-5 py-2.5 rounded-xl font-semibold text-sm flex items-center space-x-2.5 shadow-md transition cursor-pointer self-start sm:self-auto">
            <!-- Rocket Icon -->
            <svg class="w-4 h-4 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"></path>
                <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"></path>
                <path d="M9 12H4s.55-3.03 2-4.5c1.62-1.63 5-2 5-2"></path>
                <path d="M12 15v5s3.03-.55 4.5-2c1.63-1.62 2-5 2-5"></path>
            </svg>
            <span>Schedule New Task</span>
        </button>
    </div>

    <!-- 1. KPI Statistics Cards Row (4 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Today's Pickups -->
        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-[#EFF6FF] text-[#2563EB] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">TODAY'S PICKUPS</p>
                <h3 class="text-3xl font-black text-gray-900 leading-tight mt-0.5"><?php echo e($kpi['today_pickups'] ?? 24); ?></h3>
            </div>
        </div>

        <!-- Card 2: Today's Deliveries -->
        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-[#ECFDF5] text-[#10B981] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">TODAY'S DELIVERIES</p>
                <h3 class="text-3xl font-black text-gray-900 leading-tight mt-0.5"><?php echo e($kpi['today_deliveries'] ?? 18); ?></h3>
            </div>
        </div>

        <!-- Card 3: On The Road -->
        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-[#FFFBEB] text-[#F59E0B] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                    <rect x="1" y="3" width="15" height="13"></rect>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">ON THE ROAD</p>
                <h3 class="text-3xl font-black text-gray-900 leading-tight mt-0.5"><?php echo e($kpi['on_the_road'] ?? 6); ?></h3>
            </div>
        </div>

        <!-- Card 4: Pending Assignment -->
        <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-2xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-[#FEF2F2] text-[#EF4444] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">PENDING ASSIGNMENT</p>
                <h3 class="text-3xl font-black text-[#EF4444] leading-tight mt-0.5"><?php echo e($kpi['pending_assignment'] ?? 4); ?></h3>
            </div>
        </div>
    </div>

    <!-- 2. Main Middle Grid: Live Fleet Logistics (Left) & Active Fleet (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- LEFT COLUMN: Live Fleet Logistics (Span 8) -->
        <div class="lg:col-span-8 bg-white border border-gray-200/80 rounded-2xl p-6 shadow-2xs flex flex-col justify-between">
            <!-- Header Row with Map / List Toggle -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Live Fleet Logistics</h3>
                
                <!-- Map View / List View Toggle -->
                <div class="bg-gray-100 p-1 rounded-xl flex items-center space-x-1 text-xs font-semibold">
                    <button type="button" 
                            id="btnMapView"
                            onclick="setLogisticsView('map')" 
                            class="bg-[#38C6BA] text-white px-3.5 py-1.5 rounded-lg shadow-2xs transition">
                        Map View
                    </button>
                    <button type="button" 
                            id="btnListView"
                            onclick="setLogisticsView('list')" 
                            class="text-gray-500 hover:text-gray-800 px-3.5 py-1.5 rounded-lg transition">
                        List View
                    </button>
                </div>
            </div>

            <!-- Stylized Dynamic Map Visual Container -->
            <div id="mapContainer" class="relative w-full rounded-2xl overflow-hidden min-h-[380px] bg-gradient-to-r from-[#1D4ED8] via-[#2563EB] to-[#60A5FA] p-6 shadow-inner flex flex-col justify-between">
                
                <!-- Subtle Vector Street Map Overlay Background Grid -->
                <div class="absolute inset-0 opacity-15 pointer-events-none bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                <svg class="absolute inset-0 w-full h-full stroke-white/20 fill-none pointer-events-none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M -50,180 Q 200,90 400,220 T 900,160" stroke-width="4" stroke-dasharray="8 6" />
                    <path d="M 150,380 Q 300,240 500,260 T 800,100" stroke-width="2" />
                    <path d="M 380,-20 L 410,400" stroke-width="1.5" />
                    <path d="M 620,-20 L 590,400" stroke-width="1.5" />
                </svg>

                <!-- Map Controls (Top Right: Zoom +/-, Satellite Dropdown) -->
                <div class="absolute top-4 right-4 flex flex-col items-end space-y-2 z-10">
                    <!-- Zoom In / Zoom Out Widget -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 flex flex-col divide-y divide-gray-100 overflow-hidden text-gray-700">
                        <button type="button" onclick="zoomMap('in')" class="w-8 h-8 flex items-center justify-center hover:bg-gray-50 font-bold text-base leading-none transition" title="Zoom In">+</button>
                        <button type="button" onclick="zoomMap('out')" class="w-8 h-8 flex items-center justify-center hover:bg-gray-50 font-bold text-base leading-none transition" title="Zoom Out">–</button>
                    </div>

                    <!-- Satellite Dropdown Button -->
                    <button type="button" class="bg-white rounded-xl shadow-md border border-gray-100 px-3.5 py-1.5 text-xs font-bold text-gray-800 flex items-center space-x-1 hover:bg-gray-50 transition cursor-pointer">
                        <span>SATELLITE</span>
                        <svg class="w-3 h-3 text-gray-600 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Animated Interactive Vehicle Position on Map -->
                <div class="absolute top-1/2 left-[44%] -translate-y-1/2 -translate-x-1/2 z-10 group cursor-pointer" onclick="highlightDelivery()">
                    <!-- Pulse Ring -->
                    <div class="absolute -inset-2 bg-white/40 rounded-full animate-ping"></div>
                    <!-- Van Icon Circle -->
                    <div class="relative w-10 h-10 rounded-full bg-[#2042E3] text-white flex items-center justify-center shadow-2xl border-2 border-white">
                        <svg class="w-5 h-5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <rect x="1" y="3" width="15" height="13"></rect>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                    </div>
                </div>

                <!-- Destination Target Waypoint Pin on Map -->
                <div class="absolute top-[48%] left-[58%] -translate-y-1/2 -translate-x-1/2 z-10 cursor-pointer" title="Destination: Grand Plaza Residences">
                    <div class="w-10 h-10 rounded-full bg-white text-[#0D9488] flex items-center justify-center shadow-xl border-2 border-[#0D9488]">
                        <svg class="w-5 h-5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Floating Active Delivery Overlay Card (Bottom-Left on Map) -->
                <div id="activeDeliveryCard" class="relative mt-auto z-20 bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-xl max-w-[340px] border border-white/40 animate-in fade-in duration-300">
                    <!-- Card Top Header -->
                    <div class="flex items-center justify-between text-gray-400">
                        <span class="text-[10px] font-bold tracking-wider uppercase">ACTIVE DELIVERY #4402</span>
                        <button type="button" onclick="toggleActiveDeliveryCard()" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Destination Title -->
                    <h4 class="text-base font-bold text-gray-900 mt-1 mb-2.5">Grand Plaza Residences</h4>

                    <!-- Progress Bar Track -->
                    <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                        <div class="bg-[#2042E3] h-full rounded-full transition-all duration-500" style="width: 85%;"></div>
                    </div>

                    <!-- Progress Stats (Left: 85% Complete, Right: Arrival: 14:30) -->
                    <div class="flex items-center justify-between text-xs mt-2.5">
                        <span class="text-[#2563EB] font-bold">85% Complete</span>
                        <div class="text-right">
                            <span class="text-gray-900 font-bold block">Arrival: 14:30</span>
                            <span class="text-gray-400 text-[10px] uppercase font-semibold block">(12 MIN)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alternate List View Container (Hidden by Default) -->
            <div id="listContainer" class="hidden w-full rounded-2xl border border-gray-200 overflow-hidden min-h-[380px] p-4 space-y-3">
                <div class="p-3 bg-blue-50/50 rounded-xl border border-blue-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-blue-700 uppercase">ACTIVE DISPATCH #4402</span>
                        <h4 class="text-sm font-bold text-gray-900">Grand Plaza Residences</h4>
                        <p class="text-xs text-gray-500">Driver: Marcus Lawson • Truck #402</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-[#2563EB] text-white text-xs font-bold px-2.5 py-1 rounded-full">In Transit</span>
                        <p class="text-xs text-gray-500 mt-1">ETA: 14:30</p>
                    </div>
                </div>
                <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-emerald-700 uppercase">SCHEDULED PICKUP #4403</span>
                        <h4 class="text-sm font-bold text-gray-900">Hotel Aris</h4>
                        <p class="text-xs text-gray-500">Driver: Sara Thompson • Truck #211</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-emerald-600 text-white text-xs font-bold px-2.5 py-1 rounded-full">En Route</span>
                        <p class="text-xs text-gray-500 mt-1">ETA: 15:30</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Active Fleet (Span 4) -->
        <div class="lg:col-span-4 bg-white border border-gray-200/80 rounded-2xl p-6 shadow-2xs flex flex-col justify-between">
            <div>
                <!-- Header: Active Fleet & View All Link -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Active Fleet</h3>
                    <button type="button" onclick="openAllFleetModal()" class="text-[#2563EB] hover:text-blue-700 text-xs font-bold tracking-wide transition cursor-pointer">
                        View All
                    </button>
                </div>

                <!-- Driver List -->
                <div class="space-y-4">
                    <?php $__currentLoopData = array_slice($fleet, 0, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-100 rounded-2xl p-4 hover:border-gray-300 hover:shadow-xs transition flex items-center justify-between cursor-pointer" onclick="viewDriverDetails(<?php echo e(json_encode($driver)); ?>)">
                        <!-- Driver Details & Avatar -->
                        <div class="flex items-start space-x-3.5">
                            <!-- Avatar with Online Green Dot -->
                            <div class="relative flex-shrink-0">
                                <img src="<?php echo e($driver['avatar']); ?>" alt="<?php echo e($driver['name']); ?>" class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-2xs">
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-[#10B981] rounded-full ring-2 ring-white"></span>
                            </div>

                            <div>
                                <!-- Driver Name & Status Pill -->
                                <div class="flex items-center space-x-2">
                                    <h4 class="text-sm font-bold text-gray-900 leading-tight"><?php echo e($driver['name']); ?></h4>
                                    <span class="bg-[#DCFCE7] text-[#15803D] text-[10px] font-black px-2 py-0.5 rounded tracking-wide uppercase">
                                        <?php echo e($driver['status']); ?>

                                    </span>
                                </div>
                                <!-- Vehicle -->
                                <p class="text-xs text-gray-400 mt-1 font-normal"><?php echo e($driver['vehicle']); ?></p>
                                <!-- Active Drops -->
                                <p class="text-xs font-semibold text-[#2563EB] mt-1.5 flex items-center space-x-1">
                                    <span class="inline-block w-1.5 h-1.5 bg-[#2563EB] rounded-full"></span>
                                    <span><?php echo e($driver['active_drops']); ?> Active Drops</span>
                                </p>
                            </div>
                        </div>

                        <!-- Chevron Arrow -->
                        <div class="text-gray-300 pl-2">
                            <svg class="w-5 h-5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Quick Driver Status Summary Pill at bottom -->
            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <span>Fleet Availability: <strong class="text-gray-800">4 / 4 Units</strong></span>
                <span class="text-emerald-600 font-bold flex items-center space-x-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                    <span>100% Operational</span>
                </span>
            </div>
        </div>

    </div>

    <!-- 3. Bottom Grid: Upcoming Tasks (Left Span 8) & Fleet Insights (Right Span 4) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- LEFT COLUMN: Upcoming Tasks Table (Span 8) -->
        <div class="lg:col-span-8 bg-white border border-gray-200/80 rounded-2xl p-6 shadow-2xs">
            <!-- Header Row with Filter & Download Action Buttons -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Upcoming Tasks</h3>

                <div class="flex items-center space-x-2">
                    <!-- Filter Button -->
                    <button type="button" 
                            onclick="toggleTaskFilterModal()"
                            class="w-9 h-9 rounded-xl border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 flex items-center justify-center transition cursor-pointer shadow-2xs"
                            title="Filter Tasks">
                        <svg class="w-4 h-4 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                    </button>

                    <!-- Export / Download Button -->
                    <a href="<?php echo e(route('pickup-and-delivery.export')); ?>" 
                       class="w-9 h-9 rounded-xl border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 flex items-center justify-center transition cursor-pointer shadow-2xs"
                       title="Export Tasks CSV">
                        <svg class="w-4 h-4 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Tasks Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="tasksTable">
                    <thead>
                        <tr class="text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="py-3 px-3">DATE & TIME</th>
                            <th class="py-3 px-3">CUSTOMER</th>
                            <th class="py-3 px-3">TASK TYPE</th>
                            <th class="py-3 px-3">ADDRESS</th>
                            <th class="py-3 px-3">STAFF</th>
                            <th class="py-3 px-3 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm" id="tasksTableBody">
                        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50/60 transition">
                            <!-- Date & Time -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <span class="font-bold text-gray-900 block"><?php echo e($task['date']); ?>,</span>
                                <span class="text-gray-500 text-xs block"><?php echo e($task['time']); ?></span>
                            </td>

                            <!-- Customer -->
                            <td class="py-3.5 px-3 whitespace-nowrap font-bold text-gray-900">
                                <?php echo e($task['customer']); ?>

                            </td>

                            <!-- Task Type Badge (PICKUP vs DELIVERY) -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <?php if(strtoupper($task['task_type']) === 'PICKUP'): ?>
                                    <span class="inline-block bg-[#DBEAFE] text-[#2563EB] text-[10px] font-bold px-2.5 py-0.5 rounded tracking-wide uppercase">
                                        PICKUP
                                    </span>
                                <?php else: ?>
                                    <span class="inline-block bg-[#CCFBF1] text-[#0D9488] text-[10px] font-bold px-2.5 py-0.5 rounded tracking-wide uppercase">
                                        DELIVERY
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Address -->
                            <td class="py-3.5 px-3 whitespace-nowrap text-gray-700 text-xs sm:text-sm">
                                <?php echo e($task['address']); ?>

                            </td>

                            <!-- Staff -->
                            <td class="py-3.5 px-3 whitespace-nowrap">
                                <?php if(!empty($task['is_unassigned'])): ?>
                                    <button type="button" 
                                            onclick="openAssignModal(<?php echo e($task['id']); ?>, '<?php echo e(addslashes($task['customer'])); ?>')" 
                                            class="text-[#EF4444] font-bold italic text-sm hover:underline cursor-pointer" 
                                            title="Click to Assign Driver">
                                        Unassigned
                                    </button>
                                <?php else: ?>
                                    <div class="flex items-center space-x-2">
                                        <img src="<?php echo e($task['staff_avatar'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100'); ?>" alt="<?php echo e($task['staff_name']); ?>" class="w-6 h-6 rounded-full object-cover">
                                        <span class="font-medium text-gray-800 text-sm"><?php echo e($task['staff_name']); ?></span>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-3.5 px-3 whitespace-nowrap text-center">
                                <?php if(strtolower($task['status']) === 'in transit'): ?>
                                    <span class="inline-block bg-[#FEF3C7] text-[#D97706] text-xs font-semibold px-3 py-1 rounded-full">
                                        In Transit
                                    </span>
                                <?php elseif(strtolower($task['status']) === 'scheduled'): ?>
                                    <span class="inline-block bg-[#F1F5F9] text-[#475569] text-xs font-semibold px-3 py-1 rounded-full">
                                        Scheduled
                                    </span>
                                <?php elseif(strtolower($task['status']) === 'pending'): ?>
                                    <span class="inline-block bg-[#FEE2E2] text-[#DC2626] text-xs font-semibold px-3 py-1 rounded-full">
                                        Pending
                                    </span>
                                <?php else: ?>
                                    <span class="inline-block bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1 rounded-full">
                                        <?php echo e($task['status']); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 text-sm">
                                No logistics tasks found matching your search.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RIGHT COLUMN: Fleet Insights (Span 4) -->
        <div class="lg:col-span-4 bg-[#1D4ED8] rounded-2xl p-6 shadow-md text-white flex flex-col justify-between relative overflow-hidden">
            <!-- Decorative Vector Bar Graph Watermark at bottom-right -->
            <div class="absolute -bottom-2 right-2 flex items-end space-x-2 opacity-15 pointer-events-none">
                <div class="w-6 h-16 bg-white rounded-t-sm"></div>
                <div class="w-6 h-24 bg-white rounded-t-sm"></div>
                <div class="w-6 h-36 bg-white rounded-t-sm"></div>
            </div>

            <!-- Top Content -->
            <div class="relative z-10">
                <h3 class="text-xl font-bold tracking-tight">Fleet Insights</h3>
                <p class="text-blue-100 text-sm mt-3 leading-relaxed">
                    Your average delivery time is down 12% this week. Efficiency is high!
                </p>
            </div>

            <!-- Bottom Action: Generate Report Button -->
            <div class="relative z-10 mt-8">
                <button type="button" 
                        onclick="generateFleetReport()" 
                        class="bg-white hover:bg-blue-50 text-[#1D4ED8] font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition cursor-pointer">
                    Generate Report
                </button>
            </div>
        </div>

    </div>

</div>

<!-- ================= INTERACTIVE MODALS ================= -->

<!-- 1. SCHEDULE NEW TASK MODAL -->
<div id="scheduleModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Schedule Logistics Task</h3>
                <p class="text-xs text-gray-500 mt-0.5">Create a new on-demand pickup or scheduled delivery order.</p>
            </div>
            <button onclick="closeScheduleModal()" class="w-8 h-8 text-gray-400 hover:text-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="scheduleTaskForm" onsubmit="submitScheduleTask(event)" class="mt-5 space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Customer Name *</label>
                <input type="text" name="customer" required placeholder="e.g. Metro Sports Club, Lincoln Suite" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Task Type *</label>
                    <select name="task_type" required class="w-full text-sm rounded-xl border border-gray-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="PICKUP">PICKUP</option>
                        <option value="DELIVERY">DELIVERY</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Target Time *</label>
                    <input type="time" name="time" value="14:30" required class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Destination Address *</label>
                <input type="text" name="address" required placeholder="e.g. 500 N Michigan Ave, Suite 100" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Assign Driver</label>
                    <select name="staff_id" class="w-full text-sm rounded-xl border border-gray-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="">Leave Unassigned (Pending)</option>
                        <?php $__currentLoopData = $fleet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($driver['id']); ?>"><?php echo e($driver['name']); ?> (<?php echo e($driver['vehicle']); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Cargo Details</label>
                    <input type="text" name="items_count" placeholder="e.g. 3 Bags, 2 Linens" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeScheduleModal()" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="bg-[#2042E3] hover:bg-[#1A38C2] text-white px-5 py-2 rounded-xl text-sm font-semibold transition shadow-xs">
                    Dispatch Task
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. ASSIGN DRIVER MODAL -->
<div id="assignModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <h3 class="text-lg font-bold text-gray-900 mb-1">Assign Fleet Driver</h3>
        <p class="text-xs text-gray-500 mb-4">Select an on-duty driver for <strong id="assignCustomerName" class="text-gray-800"></strong>.</p>

        <form id="assignForm" onsubmit="submitAssignStaff(event)">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="assignTaskId" name="task_id">

            <div class="space-y-2 mb-5">
                <?php $__currentLoopData = $fleet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="border border-gray-200 rounded-xl p-3 flex items-center justify-between cursor-pointer hover:bg-blue-50/40 transition">
                    <div class="flex items-center space-x-3">
                        <input type="radio" name="staff_id" value="<?php echo e($driver['id']); ?>" required class="text-blue-600 focus:ring-blue-500">
                        <img src="<?php echo e($driver['avatar']); ?>" alt="<?php echo e($driver['name']); ?>" class="w-8 h-8 rounded-full object-cover">
                        <div>
                            <span class="text-sm font-bold text-gray-900 block leading-tight"><?php echo e($driver['name']); ?></span>
                            <span class="text-[10px] text-gray-400 block"><?php echo e($driver['vehicle']); ?></span>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full"><?php echo e($driver['active_drops']); ?> drops</span>
                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="flex items-center justify-end space-x-2 border-t border-gray-100 pt-4">
                <button type="button" onclick="closeAssignModal()" class="px-3.5 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg transition">
                    Cancel
                </button>
                <button type="submit" class="bg-[#2042E3] hover:bg-blue-700 text-white px-4 py-1.5 text-xs font-semibold rounded-lg shadow-xs transition">
                    Confirm Assignment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. VIEW DRIVER DETAILS MODAL -->
<div id="driverModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200 text-center">
        <button onclick="closeDriverModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <img id="modalDriverAvatar" src="" alt="Driver" class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-emerald-100 shadow-md">
        <h3 id="modalDriverName" class="text-xl font-bold text-gray-900 mt-3"></h3>
        <p id="modalDriverVehicle" class="text-xs text-gray-500"></p>

        <div class="mt-4 bg-gray-50 rounded-xl p-4 text-left space-y-2 text-xs">
            <div class="flex justify-between">
                <span class="text-gray-400">Phone:</span>
                <span id="modalDriverPhone" class="font-semibold text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Current Area:</span>
                <span id="modalDriverLocation" class="font-semibold text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Active Drops:</span>
                <span id="modalDriverDrops" class="font-semibold text-blue-600"></span>
            </div>
        </div>

        <button type="button" onclick="closeDriverModal()" class="mt-5 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold text-xs py-2 rounded-xl transition">
            Close Driver Details
        </button>
    </div>
</div>

<!-- 4. FLEET INSIGHTS REPORT MODAL -->
<div id="reportModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">Weekly Fleet Performance Report</h3>
            <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="mt-4 space-y-3 text-sm">
            <div class="p-3 bg-blue-50 rounded-xl">
                <span class="text-xs font-bold text-blue-700 uppercase">SPEED & LATENCY</span>
                <p class="text-xl font-black text-gray-900 mt-1">18.4 mins <span class="text-xs text-emerald-600 font-bold">(-12% from last week)</span></p>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl">
                <span class="text-xs font-bold text-emerald-700 uppercase">ON-TIME DELIVERY RATE</span>
                <p class="text-xl font-black text-gray-900 mt-1">98.6%</p>
            </div>
            <div class="p-3 bg-purple-50 rounded-xl">
                <span class="text-xs font-bold text-purple-700 uppercase">FUEL & LOGISTICS COST</span>
                <p class="text-xl font-black text-gray-900 mt-1">$482.50 <span class="text-xs text-purple-600 font-bold">(Within budget)</span></p>
            </div>
        </div>

        <div class="flex justify-end pt-4 border-t border-gray-100 mt-4">
            <button type="button" onclick="closeReportModal()" class="bg-[#2042E3] text-white px-4 py-2 rounded-xl text-xs font-semibold">
                Done
            </button>
        </div>
    </div>
</div>

<!-- Toast Alert -->
<div id="logisticsToast" class="hidden fixed bottom-6 right-6 z-50 bg-gray-900 text-white px-4 py-3 rounded-xl shadow-xl flex items-center space-x-2 text-sm transition-all duration-300 transform translate-y-2 opacity-0">
    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    <span id="toastLogisticsMessage" class="font-medium"></span>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function showLogisticsToast(message) {
        const toast = document.getElementById('logisticsToast');
        const text = document.getElementById('toastLogisticsMessage');
        text.innerText = message;
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.remove('opacity-0', 'translate-y-2');
            toast.classList.add('opacity-100', 'translate-y-0');
        }, 10);

        setTimeout(() => {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3000);
    }

    // Toggle Map vs List View
    function setLogisticsView(mode) {
        const mapDiv = document.getElementById('mapContainer');
        const listDiv = document.getElementById('listContainer');
        const btnMap = document.getElementById('btnMapView');
        const btnList = document.getElementById('btnListView');

        if (mode === 'map') {
            mapDiv.classList.remove('hidden');
            listDiv.classList.add('hidden');
            btnMap.className = "bg-[#38C6BA] text-white px-3.5 py-1.5 rounded-lg shadow-2xs transition";
            btnList.className = "text-gray-500 hover:text-gray-800 px-3.5 py-1.5 rounded-lg transition";
        } else {
            mapDiv.classList.add('hidden');
            listDiv.classList.remove('hidden');
            btnList.className = "bg-[#38C6BA] text-white px-3.5 py-1.5 rounded-lg shadow-2xs transition";
            btnMap.className = "text-gray-500 hover:text-gray-800 px-3.5 py-1.5 rounded-lg transition";
        }
    }

    // Zoom Map Stub
    function zoomMap(dir) {
        showLogisticsToast(`Map Zoom ${dir.toUpperCase()}`);
    }

    // Highlight Delivery
    function highlightDelivery() {
        const card = document.getElementById('activeDeliveryCard');
        card.classList.remove('hidden');
        card.classList.add('ring-4', 'ring-blue-400');
        setTimeout(() => card.classList.remove('ring-4', 'ring-blue-400'), 1200);
    }

    function toggleActiveDeliveryCard() {
        const card = document.getElementById('activeDeliveryCard');
        card.classList.toggle('hidden');
    }

    // Search tasks
    let taskTimer = null;
    function handleTaskSearch(query) {
        clearTimeout(taskTimer);
        taskTimer = setTimeout(() => {
            const rows = document.querySelectorAll('#tasksTableBody tr');
            const q = query.toLowerCase().trim();
            rows.forEach(r => {
                const text = r.innerText.toLowerCase();
                r.style.display = text.includes(q) ? '' : 'none';
            });
        }, 200);
    }

    // Modals
    function openScheduleModal() {
        document.getElementById('scheduleModal').classList.remove('hidden');
    }
    function closeScheduleModal() {
        document.getElementById('scheduleModal').classList.add('hidden');
        document.getElementById('scheduleTaskForm').reset();
    }

    function openAssignModal(taskId, customerName) {
        document.getElementById('assignTaskId').value = taskId;
        document.getElementById('assignCustomerName').innerText = customerName;
        document.getElementById('assignModal').classList.remove('hidden');
    }
    function closeAssignModal() {
        document.getElementById('assignModal').classList.add('hidden');
    }

    function viewDriverDetails(driver) {
        document.getElementById('modalDriverAvatar').src = driver.avatar;
        document.getElementById('modalDriverName').innerText = driver.name;
        document.getElementById('modalDriverVehicle').innerText = driver.vehicle;
        document.getElementById('modalDriverPhone').innerText = driver.phone;
        document.getElementById('modalDriverLocation').innerText = driver.current_location;
        document.getElementById('modalDriverDrops').innerText = `${driver.active_drops} Active Drops`;
        document.getElementById('driverModal').classList.remove('hidden');
    }
    function closeDriverModal() {
        document.getElementById('driverModal').classList.add('hidden');
    }

    function openAllFleetModal() {
        showLogisticsToast('Viewing all 4 fleet units.');
    }

    function generateFleetReport() {
        document.getElementById('reportModal').classList.remove('hidden');
    }
    function closeReportModal() {
        document.getElementById('reportModal').classList.add('hidden');
    }

    function toggleTaskFilterModal() {
        showLogisticsToast('Filtering active tasks.');
    }

    // Submit Schedule Task
    function submitScheduleTask(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        fetch('<?php echo e(route("pickup-and-delivery.schedule")); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeScheduleModal();
                showLogisticsToast(data.message || 'Logistics task scheduled!');
                setTimeout(() => window.location.reload(), 800);
            }
        })
        .catch(err => {
            console.error('Task error:', err);
            alert('Failed to schedule task.');
        });
    }

    // Submit Assign Staff
    function submitAssignStaff(e) {
        e.preventDefault();
        const form = e.target;
        const taskId = document.getElementById('assignTaskId').value;
        const formData = new FormData(form);

        fetch(`<?php echo e(url('pickup-and-delivery/assign')); ?>/${taskId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeAssignModal();
                showLogisticsToast(data.message || 'Driver assigned!');
                setTimeout(() => window.location.reload(), 800);
            }
        })
        .catch(err => {
            console.error('Assign error:', err);
            alert('Failed to assign driver.');
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(request()->has('standalone') ? 'layouts.blank' : 'layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Laundry_Managerment_System/laundry_system/resources/views/pages/PickupAndDelivery.blade.php ENDPATH**/ ?>