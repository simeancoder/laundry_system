<?php $__env->startSection('content'); ?>
<div class="space-y-6 max-w-[1600px] mx-auto pb-10">

    <!-- Top Row: Search Machines and Add New Machine Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <!-- Search machines bar -->
        <div class="relative w-full sm:w-[420px]">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-500">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" 
                   id="machineSearchInput" 
                   value="<?php echo e(request('search', $search ?? '')); ?>"
                   oninput="handleSearch(this.value)"
                   placeholder="Search machines" 
                   class="w-full bg-[#E5E7EB] text-gray-800 placeholder-gray-500 text-sm rounded-lg pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 border border-transparent transition shadow-2xs">
        </div>

        <!-- + Add New Machine Button -->
        <div>
            <button onclick="openAddMachineModal()" 
                    class="bg-[#5B46F6] hover:bg-[#4D38EA] text-white px-5 py-2.5 rounded-xl font-medium text-sm flex items-center space-x-2 shadow-sm transition active:scale-[0.98] cursor-pointer">
                <span class="text-lg font-bold leading-none">+</span>
                <span class="font-semibold">Add New Machine</span>
            </button>
        </div>
    </div>

    <!-- Header Row: Title, Subtitle, Export Report and Advanced Filters -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pt-1">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-[#1E1B4B] tracking-tight">Machine Management</h1>
            <p class="text-gray-500 text-xs md:text-sm mt-1">Manage status, health monitoring, and maintenance logs for all units</p>
            
            <!-- Quick Sub-Navigation: Machine Units & Discounts/Promotions -->
            <div class="flex items-center space-x-2 mt-3">
                <a href="#machineInventorySection" class="px-3 py-1.5 rounded-lg text-xs font-bold transition bg-[#5B46F6] text-white shadow-xs flex items-center space-x-1.5">
                    <i class="fa-solid fa-server text-[11px]"></i>
                    <span>Machine Units (<?php echo e(count($allMachines ?? [])); ?>)</span>
                </a>
                <a href="#discountsPromotionsSection" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 flex items-center space-x-1.5">
                    <i class="fa-solid fa-badge-percent text-indigo-600 text-[11px]"></i>
                    <span>Discounts &amp; Promotions</span>
                    <span class="ml-1 px-1.5 py-0.5 bg-emerald-500 text-white text-[9px] font-black rounded-full uppercase leading-none">Live</span>
                </a>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <!-- Export Report Dropdown Menu (Excel & PDF) -->
            <div class="relative inline-block text-left" id="exportReportDropdownWrapper">
                <button type="button" 
                        onclick="toggleExportMenu(event)" 
                        id="btnExportReport"
                        class="bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-medium text-sm px-4 py-2 rounded-lg transition shadow-2xs flex items-center space-x-1.5 cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500/20 active:scale-[0.98]">
                    <span>Export Report</span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-gray-500 ml-1 transition-transform duration-200" id="exportChevronIcon"></i>
                </button>

                <!-- Dropdown Menu: Excel & PDF -->
                <div id="exportDropdownMenu" 
                     class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-200 py-1.5 z-50 animate-in fade-in zoom-in duration-150">
                    <div class="px-3.5 py-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                        Choose Export Format
                    </div>
                    
                    <!-- Option 1: Excel -->
                    <a href="<?php echo e(route('machines.export', 'excel')); ?>" 
                       onclick="closeExportMenu()"
                       class="flex items-center space-x-3 px-3.5 py-2.5 hover:bg-emerald-50 text-gray-700 hover:text-emerald-800 transition group cursor-pointer">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-200 transition">
                            <i class="fa-solid fa-file-excel text-base"></i>
                        </div>
                        <div>
                            <div class="font-bold text-xs text-gray-900 group-hover:text-emerald-800">Excel</div>
                            <div class="text-[10px] text-gray-500">Download Spreadsheet (.csv / .xlsx)</div>
                        </div>
                    </a>

                    <!-- Option 2: PDF -->
                    <a href="<?php echo e(route('machines.export', 'pdf')); ?>" 
                       target="_blank"
                       onclick="closeExportMenu()"
                       class="flex items-center space-x-3 px-3.5 py-2.5 hover:bg-rose-50 text-gray-700 hover:text-rose-800 transition group cursor-pointer border-t border-gray-50">
                        <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-200 transition">
                            <i class="fa-solid fa-file-pdf text-base"></i>
                        </div>
                        <div>
                            <div class="font-bold text-xs text-gray-900 group-hover:text-rose-800">PDF</div>
                            <div class="text-[10px] text-gray-500">Printable Document (.pdf)</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Advanced Filters Button -->
            <button onclick="openAdvancedFiltersModal()" 
                    class="bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-medium text-sm px-4 py-2 rounded-lg transition shadow-2xs flex items-center space-x-1.5 cursor-pointer">
                <span>Advanced Filters</span>
            </button>
        </div>
    </div>

    <!-- 4 KPI Summary Cards Grid matching Screenshot Exactly -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Total Units -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs flex flex-col justify-between transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between">
                    <!-- Washing machine front-load icon -->
                    <div class="w-8 h-8 rounded-lg border border-gray-400 flex items-center justify-center p-1 text-gray-800">
                        <svg class="w-6 h-6 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="3"></rect>
                            <circle cx="12" cy="13" r="5"></circle>
                            <circle cx="12" cy="13" r="2"></circle>
                            <path d="M6 7h.01M9 7h.01"></path>
                        </svg>
                    </div>
                    <span class="text-emerald-600 font-semibold text-xs sm:text-sm tracking-tight">+2 this month</span>
                </div>
                <span class="text-gray-600 text-xs sm:text-sm font-medium mt-3 block">Total Units</span>
            </div>
            <div class="text-4xl font-black text-[#1E2560] leading-none mt-1.5">
                <?php echo e($stats['total_units'] ?? 24); ?>

            </div>
        </div>

        <!-- Card 2: Active Cycles -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs flex flex-col justify-between transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between">
                    <!-- Washing machine front-load icon -->
                    <div class="w-8 h-8 rounded-lg border border-gray-400 flex items-center justify-center p-1 text-gray-800">
                        <svg class="w-6 h-6 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="3"></rect>
                            <circle cx="12" cy="13" r="5"></circle>
                            <circle cx="12" cy="13" r="2"></circle>
                            <path d="M6 7h.01M9 7h.01"></path>
                        </svg>
                    </div>
                    <span class="text-emerald-600 font-semibold text-xs sm:text-sm tracking-tight">83%</span>
                </div>
                <span class="text-gray-600 text-xs sm:text-sm font-medium mt-3 block">Active Cycles</span>
            </div>
            <div class="text-4xl font-black text-[#15803D] leading-none mt-1.5">
                <?php echo e($stats['active_cycles'] ?? 20); ?>

            </div>
        </div>

        <!-- Card 3: Maintenance Alerts -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs flex flex-col justify-between transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between">
                    <!-- Warning triangle icon with exclamation mark -->
                    <div class="w-8 h-8 flex items-center justify-center text-gray-800">
                        <svg class="w-7 h-7 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    </div>
                    <!-- Critical in green text matching screenshot -->
                    <span class="text-emerald-600 font-semibold text-xs sm:text-sm tracking-tight">Critical</span>
                </div>
                <span class="text-gray-600 text-xs sm:text-sm font-medium mt-3 block">Maintenance Alerts</span>
            </div>
            <div class="text-4xl font-black text-[#DC2626] leading-none mt-1.5">
                <?php echo e($stats['maintenance_alerts'] ?? 2); ?>

            </div>
        </div>

        <!-- Card 4: Upcoming Service -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs flex flex-col justify-between transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between">
                    <div></div>
                    <span class="text-emerald-600 font-semibold text-xs sm:text-sm tracking-tight">This week</span>
                </div>
                <span class="text-gray-600 text-xs sm:text-sm font-medium mt-3 block">Upcoming Service</span>
            </div>
            <div class="text-4xl font-black text-[#1E2560] leading-none mt-1.5">
                <?php echo e($stats['upcoming_service'] ?? 24); ?>

            </div>
        </div>

    </div>

    <!-- Main Section: 2 Columns Side-by-Side (Search & Filter + Machine Inventory) -->
    <div id="machineInventorySection" class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

        <!-- Left Column: Search & Filter Card -->
        <div class="lg:col-span-4 xl:col-span-3 bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <h2 class="font-bold text-gray-900 text-base mb-4">Search & Filter</h2>

            <!-- MACHINE TYPE -->
            <div class="mb-5">
                <label class="block text-[11px] font-bold text-gray-600 tracking-wider uppercase mb-1.5">MACHINE TYPE</label>
                <div class="relative">
                    <select id="filterTypeSelect" onchange="applyFilters()"
                            class="w-full appearance-none bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 cursor-pointer">
                        <option value="all" <?php echo e(($typeFilter ?? 'all') == 'all' ? 'selected' : ''); ?>>All Types</option>
                        <option value="Washer" <?php echo e(($typeFilter ?? '') == 'Washer' ? 'selected' : ''); ?>>Washer</option>
                        <option value="Dryer" <?php echo e(($typeFilter ?? '') == 'Dryer' ? 'selected' : ''); ?>>Dryer</option>
                        <option value="Presser" <?php echo e(($typeFilter ?? '') == 'Presser' ? 'selected' : ''); ?>>Presser</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                </div>
            </div>

            <!-- STATUS Options List -->
            <div class="mb-5">
                <label class="block text-[11px] font-bold text-gray-600 tracking-wider uppercase mb-2">STATUS</label>
                <div class="space-y-1 pl-3" id="statusOptionsContainer">
                    <button type="button" 
                            onclick="toggleStatusFilter('Running', this)" 
                            class="status-option-btn w-full text-left py-1 text-sm text-gray-700 hover:text-indigo-600 font-normal transition flex items-center justify-between cursor-pointer <?php echo e(($statusFilter ?? '') == 'Running' ? 'font-bold text-indigo-600' : ''); ?>"
                            data-status="Running">
                        <span>Running</span>
                        <span class="status-check text-xs text-indigo-600 <?php echo e(($statusFilter ?? '') == 'Running' ? '' : 'hidden'); ?>">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </button>
                    <button type="button" 
                            onclick="toggleStatusFilter('Idle', this)" 
                            class="status-option-btn w-full text-left py-1 text-sm text-gray-700 hover:text-indigo-600 font-normal transition flex items-center justify-between cursor-pointer <?php echo e(($statusFilter ?? '') == 'Idle' ? 'font-bold text-indigo-600' : ''); ?>"
                            data-status="Idle">
                        <span>Idle</span>
                        <span class="status-check text-xs text-indigo-600 <?php echo e(($statusFilter ?? '') == 'Idle' ? '' : 'hidden'); ?>">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </button>
                    <button type="button" 
                            onclick="toggleStatusFilter('Alert', this)" 
                            class="status-option-btn w-full text-left py-1 text-sm text-gray-700 hover:text-indigo-600 font-normal transition flex items-center justify-between cursor-pointer <?php echo e(($statusFilter ?? '') == 'Alert' ? 'font-bold text-indigo-600' : ''); ?>"
                            data-status="Alert">
                        <span>Alert</span>
                        <span class="status-check text-xs text-indigo-600 <?php echo e(($statusFilter ?? '') == 'Alert' ? '' : 'hidden'); ?>">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </button>
                    <button type="button" 
                            onclick="toggleStatusFilter('Repairing', this)" 
                            class="status-option-btn w-full text-left py-1 text-sm text-gray-700 hover:text-indigo-600 font-normal transition flex items-center justify-between cursor-pointer <?php echo e(($statusFilter ?? '') == 'Repairing' ? 'font-bold text-indigo-600' : ''); ?>"
                            data-status="Repairing">
                        <span>Repairing</span>
                        <span class="status-check text-xs text-indigo-600 <?php echo e(($statusFilter ?? '') == 'Repairing' ? '' : 'hidden'); ?>">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </button>
                </div>
            </div>

            <!-- LOCATION -->
            <div class="mb-6">
                <label class="block text-[11px] font-bold text-gray-600 tracking-wider uppercase mb-1.5">LOCATION</label>
                <div class="relative">
                    <select id="filterLocationSelect" onchange="applyFilters()"
                            class="w-full appearance-none bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 cursor-pointer">
                        <option value="all" <?php echo e(($locationFilter ?? 'all') == 'all' ? 'selected' : ''); ?>>All Locations</option>
                        <option value="Main Floor - Zone A" <?php echo e(($locationFilter ?? '') == 'Main Floor - Zone A' ? 'selected' : ''); ?>>Main Floor - Zone A</option>
                        <option value="Main Floor - Zone B" <?php echo e(($locationFilter ?? '') == 'Main Floor - Zone B' ? 'selected' : ''); ?>>Main Floor - Zone B</option>
                        <option value="Express Bay - Zone B" <?php echo e(($locationFilter ?? '') == 'Express Bay - Zone B' ? 'selected' : ''); ?>>Express Bay - Zone B</option>
                        <option value="Commercial Wing" <?php echo e(($locationFilter ?? '') == 'Commercial Wing' ? 'selected' : ''); ?>>Commercial Wing</option>
                        <option value="VIP Section" <?php echo e(($locationFilter ?? '') == 'VIP Section' ? 'selected' : ''); ?>>VIP Section</option>
                        <option value="Maintenance Bay" <?php echo e(($locationFilter ?? '') == 'Maintenance Bay' ? 'selected' : ''); ?>>Maintenance Bay</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                </div>
            </div>

            <!-- Reset Filters Button matching screenshot -->
            <button type="button" 
                    onclick="resetAllFilters()"
                    class="w-full border border-[#147D64] text-[#147D64] hover:bg-emerald-50/50 rounded-lg py-2 text-center font-medium text-sm transition cursor-pointer active:scale-[0.99]">
                Reset Filters
            </button>
        </div>

        <!-- Right Column: Machine Inventory Card -->
        <div class="lg:col-span-8 xl:col-span-9 bg-white rounded-2xl border border-gray-200 p-5 shadow-xs">
            <h2 class="font-bold text-gray-900 text-base mb-4">Machine Inventory</h2>

            <!-- Table Header Bar matching screenshot's gray pill -->
            <div class="bg-[#D6DDD9] rounded-xl px-6 py-3 mb-3 grid grid-cols-12 items-center text-xs font-bold text-gray-800 tracking-wider uppercase">
                <div class="col-span-3">SERIAL ID</div>
                <div class="col-span-3">MODEL</div>
                <div class="col-span-3">INSTALLATION DATE</div>
                <div class="col-span-2">STATUS</div>
                <div class="col-span-1 text-center">ACTION</div>
            </div>

            <!-- Machine Rows / Cards Container -->
            <div id="machineCardsContainer" class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $machines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="machine-row-card bg-white rounded-xl border border-gray-300 p-4 transition hover:border-gray-400 shadow-2xs"
                         id="machine-card-<?php echo e($m['id']); ?>"
                         data-id="<?php echo e($m['id']); ?>"
                         data-serial="<?php echo e($m['serial_id']); ?>"
                         data-type="<?php echo e($m['type']); ?>"
                         data-status="<?php echo e($m['status']); ?>"
                         data-location="<?php echo e($m['location']); ?>">
                        <div class="grid grid-cols-12 items-center gap-2">
                            <!-- Serial ID -->
                            <div class="col-span-3">
                                <span class="font-bold text-base text-gray-900"><?php echo e($m['serial_id']); ?></span>
                            </div>

                            <!-- Model (Formatted as multi-line stacked text matching screenshot) -->
                            <div class="col-span-3">
                                <div class="text-sm font-medium text-gray-800 leading-snug whitespace-pre-line">
                                    <?php echo nl2br(e($m['full_model'] ?? $m['model'])); ?>

                                </div>
                            </div>

                            <!-- Installation Date -->
                            <div class="col-span-3">
                                <span class="text-sm text-gray-700 font-normal"><?php echo e($m['installation_date']); ?></span>
                            </div>

                            <!-- Status -->
                            <div class="col-span-2">
                                <?php
                                    $badgeClass = match($m['status']) {
                                        'Running' => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                                        'Idle' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                        'Alert' => 'bg-amber-100 text-amber-800 border border-amber-200',
                                        'Repairing' => 'bg-rose-100 text-rose-800 border border-rose-200',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                ?>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold <?php echo e($badgeClass); ?>">
                                    <?php echo e($m['status']); ?>

                                </span>
                            </div>

                            <!-- Action: Vertically Stacked Icons (Eye, Edit, Trash) matching screenshot -->
                            <div class="col-span-1 flex flex-col items-center justify-center space-y-2">
                                <!-- View Details -->
                                <button onclick="viewMachineById(<?php echo e($m['id']); ?>)"
                                        class="text-gray-700 hover:text-blue-600 transition p-0.5 cursor-pointer"
                                        title="View Machine Telemetry">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>
                                <!-- Edit Machine -->
                                <button onclick="openEditMachineById(<?php echo e($m['id']); ?>)"
                                        class="text-gray-700 hover:text-amber-600 transition p-0.5 cursor-pointer"
                                        title="Edit Machine">
                                    <i class="fa-regular fa-pen-to-square text-sm"></i>
                                </button>
                                <!-- Delete / Archive -->
                                <button onclick="confirmDeleteMachine(<?php echo e($m['id']); ?>, '<?php echo e($m['serial_id']); ?>')"
                                        class="text-gray-700 hover:text-red-600 transition p-0.5 cursor-pointer"
                                        title="Decommission Machine">
                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-10 text-gray-500 text-sm bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        No machine units found matching your search and filter criteria.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer: Showing Count & Pagination Controls -->
            <div class="mt-5 pt-4 border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
                <div class="text-sm font-medium text-blue-600" id="paginationInfo">
                    Showing <span id="info-from"><?php echo e($from ?? 1); ?></span> to <span id="info-to"><?php echo e($to ?? count($machines)); ?></span> of <span id="info-total"><?php echo e($totalItems ?? 24); ?></span> items
                </div>

                <div class="flex items-center space-x-1.5" id="paginationControls">
                    <!-- Previous Button -->
                    <button onclick="changePage('prev')" id="btnPrevPage"
                            class="flex items-center space-x-1 px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-angle-left text-xs"></i>
                        <span>Previous</span>
                    </button>

                    <!-- Page Numbers -->
                    <button onclick="changePage(1)" id="pageBtn-1" class="page-num-btn w-8 h-8 rounded-lg text-xs font-bold transition cursor-pointer bg-[#5B46F6] text-white shadow-xs">1</button>
                    <button onclick="changePage(2)" id="pageBtn-2" class="page-num-btn w-8 h-8 rounded-lg text-xs font-medium border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition cursor-pointer">2</button>
                    <button onclick="changePage(3)" id="pageBtn-3" class="page-num-btn w-8 h-8 rounded-lg text-xs font-medium border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition cursor-pointer">3</button>
                    <button onclick="changePage(4)" id="pageBtn-4" class="page-num-btn w-8 h-8 rounded-lg text-xs font-medium border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition cursor-pointer">4</button>
                    <button onclick="changePage(5)" id="pageBtn-5" class="page-num-btn w-8 h-8 rounded-lg text-xs font-medium border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition cursor-pointer">5</button>

                    <!-- Next Button -->
                    <button onclick="changePage('next')" id="btnNextPage"
                            class="flex items-center space-x-1 px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 text-xs font-medium hover:bg-gray-50 transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                        <span>Next</span>
                        <i class="fa-solid fa-angle-right text-xs"></i>
                    </button>
                </div>
            </div>

        </div>

    </div>

    <!-- ============================================== -->
    <!-- FUNCTION: DISCOUNT & PROMOTION (Below Machine Dashboard) -->
    <!-- ============================================== -->
    <div id="discountsPromotionsSection" class="mt-10 pt-8 border-t border-gray-200 space-y-6">

        <!-- Top Header Row -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2.5">
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold tracking-wider uppercase bg-indigo-100 text-indigo-700 border border-indigo-200 flex items-center space-x-1">
                        <i class="fa-solid fa-tags text-[10px]"></i>
                        <span>Marketing &amp; Campaigns</span>
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-700 flex items-center space-x-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span id="promoLiveBadge">4 Active Campaigns</span>
                    </span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-[#1E1B4B] tracking-tight mt-1">Discounts &amp; Promotions</h2>
                <p class="text-gray-500 text-xs md:text-sm mt-0.5">Manage machine wash discounts, promo codes, seasonal vouchers, and test discount calculations.</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Toggle Discount Calculator Button -->
                <button type="button" 
                        onclick="toggleDiscountCalculator()" 
                        class="bg-white hover:bg-gray-50 border border-gray-300 text-gray-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition shadow-2xs flex items-center space-x-2 cursor-pointer active:scale-[0.98]">
                    <i class="fa-solid fa-calculator text-indigo-600 text-sm"></i>
                    <span>Test Calculator (OK)</span>
                </button>

                <!-- + Create New Promotion Button -->
                <button type="button" 
                        onclick="openAddPromotionModal()" 
                        class="bg-[#5B46F6] hover:bg-[#4D38EA] text-white px-5 py-2.5 rounded-xl font-semibold text-xs flex items-center space-x-2 shadow-sm transition active:scale-[0.98] cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Create Promotion</span>
                </button>
            </div>
        </div>

        <!-- 4 KPI Summary Cards for Promotions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Card 1: Active Promotions -->
            <div class="bg-gradient-to-br from-indigo-50/70 to-white rounded-2xl border border-indigo-100 p-5 shadow-xs flex flex-col justify-between transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-xs">
                        <i class="fa-solid fa-badge-percent text-lg"></i>
                    </div>
                    <span class="text-emerald-600 font-semibold text-xs tracking-tight flex items-center space-x-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Running Now</span>
                    </span>
                </div>
                <div class="mt-3">
                    <span class="text-gray-500 text-xs font-medium block">Active Promotions</span>
                    <div class="text-3xl font-black text-gray-900 leading-none mt-1" id="kpiActivePromos">
                        <?php echo e($promoStats['active_promotions'] ?? 4); ?>

                    </div>
                </div>
            </div>

            <!-- Card 2: Total Savings Given -->
            <div class="bg-gradient-to-br from-emerald-50/70 to-white rounded-2xl border border-emerald-100 p-5 shadow-xs flex flex-col justify-between transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-xs">
                        <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
                    </div>
                    <span class="text-emerald-600 font-semibold text-xs tracking-tight">+18% this month</span>
                </div>
                <div class="mt-3">
                    <span class="text-gray-500 text-xs font-medium block">Total Discounts Granted</span>
                    <div class="text-3xl font-black text-emerald-700 leading-none mt-1" id="kpiTotalSavings">
                        <?php echo e($promoStats['total_savings'] ?? '$1,280.50'); ?>

                    </div>
                </div>
            </div>

            <!-- Card 3: Total Redemptions -->
            <div class="bg-gradient-to-br from-blue-50/70 to-white rounded-2xl border border-blue-100 p-5 shadow-xs flex flex-col justify-between transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-xs">
                        <i class="fa-solid fa-receipt text-lg"></i>
                    </div>
                    <span class="text-blue-600 font-semibold text-xs tracking-tight">236 All-time</span>
                </div>
                <div class="mt-3">
                    <span class="text-gray-500 text-xs font-medium block">Coupon Redemptions</span>
                    <div class="text-3xl font-black text-gray-900 leading-none mt-1" id="kpiTotalRedemptions">
                        <?php echo e($promoStats['total_redemptions'] ?? 236); ?> Orders
                    </div>
                </div>
            </div>

            <!-- Card 4: Top Promo Code -->
            <div class="bg-gradient-to-br from-purple-50/70 to-white rounded-2xl border border-purple-100 p-5 shadow-xs flex flex-col justify-between transition hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center shadow-xs">
                        <i class="fa-solid fa-crown text-base"></i>
                    </div>
                    <span class="text-purple-600 font-semibold text-xs tracking-tight">58 Used</span>
                </div>
                <div class="mt-3">
                    <span class="text-gray-500 text-xs font-medium block">Top Running Promo</span>
                    <div class="text-2xl font-black text-purple-700 font-mono leading-none mt-1" id="kpiTopPromo">
                        <?php echo e($promoStats['top_code'] ?? 'WASHER20'); ?>

                    </div>
                </div>
            </div>

        </div>

        <!-- Interactive Discount Calculator Box (Expandable / Collapsible) -->
        <div id="discountCalculatorWidget" class="bg-white rounded-2xl border-2 border-indigo-200 p-6 shadow-md transition-all">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class="fa-solid fa-calculator text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">Quick Discount Calculator &amp; Validator</h3>
                        <p class="text-xs text-gray-500">Test promo codes against machine cycles or manual order subtotals and click OK to apply.</p>
                    </div>
                </div>
                <button type="button" onclick="toggleDiscountCalculator()" class="text-xs font-semibold text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5">
                <!-- Select Machine / Service -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Machine / Service Unit</label>
                    <select id="calcMachineSelect" onchange="onCalcMachineChanged(this.value)" class="w-full text-xs bg-gray-50 border border-gray-300 rounded-xl p-2.5 font-medium text-gray-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="8.00" data-type="Washers">WM-101 TuboWash 9000 (Washer) - $8.00</option>
                        <option value="6.50" data-type="Washers">WM-111 EcoWash Lite (Washer) - $6.50</option>
                        <option value="12.00" data-type="Dryers">WM-112 HeatDry Pro (Dryer) - $12.00</option>
                        <option value="10.00" data-type="Washers">WM-102 SpeedClean Super (Washer) - $10.00</option>
                        <option value="15.00" data-type="Dryers">HD-102 AeroDry Industrial (Dryer) - $15.00</option>
                        <option value="14.00" data-type="Pressers">PR-101 SteamPress Pro (Presser) - $14.00</option>
                        <option value="35.00" data-type="Commercial Wing">Commercial Wing Bulk Wash &amp; Fold - $35.00</option>
                        <option value="custom" data-type="Custom">Custom Order Subtotal...</option>
                    </select>
                </div>

                <!-- Order Subtotal ($) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Cycle / Order Amount ($)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold text-sm">$</span>
                        <input type="number" step="0.01" id="calcOrderAmount" value="8.00" oninput="runLiveCalculation()" class="w-full text-xs font-bold text-gray-900 bg-gray-50 border border-gray-300 rounded-xl pl-8 pr-3 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>

                <!-- Select / Enter Promo Code -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Promotion Code</label>
                    <div class="flex items-center space-x-2">
                        <select id="calcPromoSelect" onchange="runLiveCalculation()" class="w-full text-xs font-bold font-mono text-indigo-700 bg-indigo-50/50 border border-indigo-200 rounded-xl p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            <option value="WASHER20">WASHER20 (20% Off Washers)</option>
                            <option value="DRYFREESHIP">DRYFREESHIP ($5.00 Off Dryers)</option>
                            <option value="NEWCLEAN10">NEWCLEAN10 ($3.00 Off All)</option>
                            <option value="VIPBULK25">VIPBULK25 (25% Commercial)</option>
                            <option value="PRESSPRO15">PRESSPRO15 (15% Pressers)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Calculation Output Breakdown & Action -->
            <div class="mt-5 p-4 bg-gray-50 rounded-xl border border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex flex-wrap items-center gap-6 text-xs">
                    <div>
                        <span class="text-gray-400 block font-medium">Original Price:</span>
                        <span class="text-sm font-bold text-gray-700" id="calcDisplayOriginal">$8.00</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block font-medium">Discount Applied:</span>
                        <span class="text-sm font-bold text-emerald-600" id="calcDisplayDiscount">-$1.60 (20%)</span>
                    </div>
                    <div class="pl-3 border-l border-gray-300">
                        <span class="text-gray-500 block font-bold uppercase text-[10px]">Net Payable:</span>
                        <span class="text-xl font-black text-indigo-700" id="calcDisplayFinal">$6.40</span>
                    </div>
                </div>

                <div>
                    <button type="button" 
                            onclick="confirmApplyDiscountFromCalc()"
                            class="bg-[#10B981] hover:bg-[#059669] text-white px-5 py-2.5 rounded-xl font-bold text-xs flex items-center space-x-2 shadow-xs transition active:scale-[0.98] cursor-pointer">
                        <i class="fa-solid fa-check"></i>
                        <span>Apply Discount (OK)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Bar & Promotions List -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-xs space-y-4">
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <!-- Search Promo Code Bar -->
                <div class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" 
                           id="promoSearchInput" 
                           oninput="handlePromoSearch(this.value)" 
                           placeholder="Search coupon or campaign..." 
                           class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-3.5 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                </div>

                <!-- Status Filter Pills -->
                <div class="flex flex-wrap items-center gap-1.5" id="promoStatusPills">
                    <button type="button" onclick="filterPromosByStatus('All', this)" class="promo-pill px-3 py-1.5 rounded-lg text-xs font-bold transition bg-[#5B46F6] text-white shadow-xs">
                        All (<span id="countAllPromos">6</span>)
                    </button>
                    <button type="button" onclick="filterPromosByStatus('Active', this)" class="promo-pill px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:bg-gray-100 transition">
                        Active (<span id="countActivePromos">4</span>)
                    </button>
                    <button type="button" onclick="filterPromosByStatus('Scheduled', this)" class="promo-pill px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:bg-gray-100 transition">
                        Scheduled (<span id="countScheduledPromos">1</span>)
                    </button>
                    <button type="button" onclick="filterPromosByStatus('Expired', this)" class="promo-pill px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 hover:bg-gray-100 transition">
                        Expired (<span id="countExpiredPromos">1</span>)
                    </button>
                </div>
            </div>

            <!-- Table Header Pill -->
            <div class="bg-[#E9EEF5] rounded-xl px-5 py-3 grid grid-cols-12 items-center text-[11px] font-bold text-gray-700 tracking-wider uppercase">
                <div class="col-span-3">PROMO CODE &amp; CAMPAIGN</div>
                <div class="col-span-2">DISCOUNT VALUE</div>
                <div class="col-span-2">APPLIES TO</div>
                <div class="col-span-2">VALIDITY &amp; LIMIT</div>
                <div class="col-span-2">STATUS</div>
                <div class="col-span-1 text-center">ACTION</div>
            </div>

            <!-- Promotion Rows Container -->
            <div id="promotionsCardsContainer" class="space-y-3">
                <!-- Dynamically rendered by JavaScript -->
            </div>

        </div>

    </div>

</div>

<!-- ============================================== -->
<!-- MODAL 1: ADD NEW MACHINE -->
<!-- ============================================== -->
<div id="addMachineModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 transform transition-all animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#EDE9FE] text-[#5B46F6] flex items-center justify-center">
                    <i class="fa-solid fa-plus text-sm"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Add New Machine Unit</h3>
                    <p class="text-xs text-gray-500">Register a new washing machine, dryer, or presser</p>
                </div>
            </div>
            <button onclick="closeAddMachineModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="addMachineForm" onsubmit="submitAddMachine(event)" class="space-y-4 mt-4">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Serial ID</label>
                    <input type="text" name="serial_id" required placeholder="e.g. WM-116" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Machine Type</label>
                    <select name="type" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="Washer">Washer</option>
                        <option value="Dryer">Dryer</option>
                        <option value="Presser">Presser</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Model Name</label>
                <input type="text" name="model" required placeholder="e.g. TuboWash 9000" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Installation Date</label>
                    <input type="text" name="installation_date" value="<?php echo e(date('d M Y')); ?>" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Operating Status</label>
                    <select name="status" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="Running">Running</option>
                        <option value="Idle">Idle</option>
                        <option value="Alert">Alert</option>
                        <option value="Repairing">Repairing</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Floor Location</label>
                <select name="location" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="Main Floor - Zone A">Main Floor - Zone A</option>
                    <option value="Main Floor - Zone B">Main Floor - Zone B</option>
                    <option value="Express Bay - Zone B">Express Bay - Zone B</option>
                    <option value="Commercial Wing">Commercial Wing</option>
                    <option value="VIP Section">VIP Section</option>
                    <option value="Maintenance Bay">Maintenance Bay</option>
                </select>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100 mt-5">
                <button type="button" onclick="closeAddMachineModal()" class="px-4 py-2 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="bg-[#5B46F6] hover:bg-[#4D38EA] text-white px-5 py-2 rounded-lg text-xs font-semibold shadow-sm flex items-center space-x-1.5 transition cursor-pointer">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Register Unit</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL 2: EDIT MACHINE -->
<!-- ============================================== -->
<div id="editMachineModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 transform transition-all animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <i class="fa-solid fa-pen text-sm"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Edit Machine Unit</h3>
                    <p class="text-xs text-gray-500">Update unit parameters and operational state</p>
                </div>
            </div>
            <button onclick="closeEditMachineModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="editMachineForm" onsubmit="submitEditMachine(event)" class="space-y-4 mt-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="edit_id" name="id">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Serial ID</label>
                    <input type="text" id="edit_serial" name="serial_id" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Machine Type</label>
                    <select id="edit_type" name="type" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="Washer">Washer</option>
                        <option value="Dryer">Dryer</option>
                        <option value="Presser">Presser</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Model Name</label>
                <input type="text" id="edit_model" name="model" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Operating Status</label>
                    <select id="edit_status" name="status" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="Running">Running</option>
                        <option value="Idle">Idle</option>
                        <option value="Alert">Alert</option>
                        <option value="Repairing">Repairing</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Floor Location</label>
                    <select id="edit_location" name="location" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        <option value="Main Floor - Zone A">Main Floor - Zone A</option>
                        <option value="Main Floor - Zone B">Main Floor - Zone B</option>
                        <option value="Express Bay - Zone B">Express Bay - Zone B</option>
                        <option value="Commercial Wing">Commercial Wing</option>
                        <option value="VIP Section">VIP Section</option>
                        <option value="Maintenance Bay">Maintenance Bay</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100 mt-5">
                <button type="button" onclick="closeEditMachineModal()" class="px-4 py-2 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-2 rounded-lg text-xs font-semibold shadow-sm flex items-center space-x-1.5 transition cursor-pointer">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL 3: VIEW MACHINE TELEMETRY & DETAILS -->
<!-- ============================================== -->
<div id="viewMachineModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 transform transition-all animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 font-bold flex items-center justify-center shadow-xs border border-blue-100">
                    <i class="fa-solid fa-microchip text-base"></i>
                </div>
                <div>
                    <h3 id="view_serial" class="text-base font-bold text-gray-900">WM-101</h3>
                    <p id="view_model" class="text-xs text-gray-500 font-medium">TuboWash 9000</p>
                </div>
            </div>
            <button onclick="closeViewMachineModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="space-y-4 mt-4 text-xs">
            <div class="grid grid-cols-2 gap-3 bg-gray-50 p-3.5 rounded-xl border border-gray-200/70">
                <div>
                    <span class="text-gray-400 font-semibold block uppercase text-[10px]">Machine Type</span>
                    <span id="view_type" class="inline-block mt-1 font-bold text-gray-800">Washer</span>
                </div>
                <div>
                    <span class="text-gray-400 font-semibold block uppercase text-[10px]">Current Status</span>
                    <span id="view_status" class="inline-flex items-center font-bold mt-1 text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">
                        Running
                    </span>
                </div>
                <div>
                    <span class="text-gray-400 font-semibold block uppercase text-[10px]">Location & Bay</span>
                    <span id="view_location" class="font-medium text-gray-700 block mt-1">Main Floor - Zone A</span>
                </div>
                <div>
                    <span class="text-gray-400 font-semibold block uppercase text-[10px]">Installation Date</span>
                    <span id="view_installation" class="font-medium text-gray-700 block mt-1">15 Jan 2023</span>
                </div>
            </div>

            <!-- Telemetry Metrics Grid -->
            <div>
                <span class="text-gray-500 font-semibold block mb-2 uppercase text-[10px]">Real-Time Health & Diagnostic Telemetry</span>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-200/60 text-center">
                        <span class="text-[10px] text-gray-400 block font-medium">Motor Health</span>
                        <span id="view_health" class="text-base font-bold text-emerald-600 block mt-0.5">98%</span>
                    </div>
                    <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-200/60 text-center">
                        <span class="text-[10px] text-gray-400 block font-medium">Operating Temp</span>
                        <span id="view_temp" class="text-base font-bold text-gray-800 block mt-0.5">60°C</span>
                    </div>
                    <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-200/60 text-center">
                        <span class="text-[10px] text-gray-400 block font-medium">Today's Cycles</span>
                        <span id="view_today_cycles" class="text-base font-bold text-indigo-600 block mt-0.5">8</span>
                    </div>
                    <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-200/60 text-center">
                        <span class="text-[10px] text-gray-400 block font-medium">Total Cycles</span>
                        <span id="view_total_cycles" class="text-base font-bold text-gray-800 block mt-0.5">1,240</span>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50/60 p-3 rounded-xl border border-blue-100 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-wrench text-blue-600"></i>
                    <span class="text-gray-700 text-xs">Last Preventive Maintenance:</span>
                </div>
                <span id="view_serviced" class="font-bold text-gray-900 text-xs">10 Aug 2026</span>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-100 mt-5">
            <button onclick="closeViewMachineModal()" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-xs font-semibold transition cursor-pointer">
                Close
            </button>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL 4: ADVANCED FILTERS -->
<!-- ============================================== -->
<div id="advancedFiltersModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-gray-100">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center">
                    <i class="fa-solid fa-sliders text-sm"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Advanced Machine Filters</h3>
                    <p class="text-xs text-gray-500">Filter units by health diagnostics and service cycles</p>
                </div>
            </div>
            <button onclick="closeAdvancedFiltersModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="advFilterForm" onsubmit="applyAdvancedFilters(event)" class="space-y-4 mt-4 text-xs">
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Motor Health Threshold</label>
                <select id="adv_health" class="w-full bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="all">All Health Conditions</option>
                    <option value="optimal">Optimal (&gt; 95%)</option>
                    <option value="good">Good (85% - 95%)</option>
                    <option value="warning">Attention Needed (&lt; 85%)</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Cycle Volume Range</label>
                <select id="adv_cycles" class="w-full bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="all">All Lifetime Cycles</option>
                    <option value="low">Under 500 cycles</option>
                    <option value="mid">500 - 1,500 cycles</option>
                    <option value="high">Over 1,500 heavy cycles</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Sort Machines By</label>
                <select id="adv_sort" class="w-full bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="id_asc">Serial ID (A to Z)</option>
                    <option value="id_desc">Serial ID (Z to A)</option>
                    <option value="cycles_desc">Highest Cycles First</option>
                    <option value="health_asc">Lowest Motor Health (Alerts)</option>
                </select>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeAdvancedFiltersModal()" class="px-4 py-2 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="bg-[#5B46F6] hover:bg-[#4D38EA] text-white px-5 py-2 rounded-lg text-xs font-bold shadow-xs transition cursor-pointer">
                    Apply Advanced Filters
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================== -->
<!-- TOAST NOTIFICATION CONTAINER -->
<!-- ============================================== -->
<div id="machineToast" class="fixed bottom-6 right-6 z-50 hidden max-w-md bg-white border border-gray-200 rounded-xl p-4 shadow-2xl transition-all duration-300 transform translate-y-2">
    <div class="flex items-start space-x-3">
        <div id="toastIcon" class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
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

<!-- ============================================== -->
<!-- PROMOTION MODAL 1: ADD NEW PROMOTION -->
<!-- ============================================== -->
<div id="addPromotionModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 my-8 transform transition-all animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-plus text-sm"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Create New Promotion</h3>
                    <p class="text-xs text-gray-500">Configure discount code, percentage or fixed value, and validity</p>
                </div>
            </div>
            <button onclick="closeAddPromotionModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="addPromotionForm" onsubmit="submitAddPromotion(event)" class="space-y-4 mt-4">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Promo Code (Uppercase)</label>
                    <input type="text" name="code" id="newPromoCode" required placeholder="e.g. AUTUMN20" class="w-full text-xs font-mono font-bold uppercase bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Target Machine Scope</label>
                    <select name="applies_to" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="All Machines">All Machines</option>
                        <option value="Washers">Washers Only</option>
                        <option value="Dryers">Dryers Only</option>
                        <option value="Presser Units">Presser Units</option>
                        <option value="Commercial Wing">Commercial Wing</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Campaign Title</label>
                <input type="text" name="title" required placeholder="e.g. Autumn Wash & Care Discount" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Discount Type</label>
                    <select name="discount_type" id="newDiscountType" onchange="updateDiscountValuePlaceholder(this.value)" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="percentage">Percentage Off (%)</option>
                        <option value="fixed">Fixed Dollar Off ($)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1" id="newDiscountValueLabel">Discount Value (%)</label>
                    <input type="number" step="0.01" name="discount_value" required placeholder="e.g. 20" class="w-full text-xs font-bold bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Min Order Spend ($)</label>
                    <input type="number" step="0.01" name="min_spend" value="10.00" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Usage Limit (Orders)</label>
                    <input type="number" name="usage_limit" value="100" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="<?php echo e(date('Y-m-d')); ?>" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Expiration Date</label>
                    <input type="date" name="end_date" value="<?php echo e(date('Y-m-d', strtotime('+30 days'))); ?>" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Description &amp; Terms</label>
                <textarea name="description" rows="2" placeholder="e.g. Valid on all front-load washing machines..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeAddPromotionModal()" class="px-4 py-2 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="bg-[#5B46F6] hover:bg-[#4D38EA] text-white px-5 py-2.5 rounded-lg text-xs font-bold shadow-xs transition cursor-pointer flex items-center space-x-1.5">
                    <i class="fa-solid fa-check"></i>
                    <span>Save Promotion (OK)</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================== -->
<!-- PROMOTION MODAL 2: EDIT PROMOTION -->
<!-- ============================================== -->
<div id="editPromotionModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 my-8 transform transition-all animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Edit Promotion</h3>
                    <p class="text-xs text-gray-500">Update campaign details and validity</p>
                </div>
            </div>
            <button onclick="closeEditPromotionModal()" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="editPromotionForm" onsubmit="submitEditPromotion(event)" class="space-y-4 mt-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="editPromoId" name="promo_id">
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Promo Code</label>
                    <input type="text" id="editPromoCode" readonly class="w-full text-xs font-mono font-bold uppercase bg-gray-100 border border-gray-200 rounded-lg p-2.5 text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Target Machine Scope</label>
                    <select id="editPromoApplies" name="applies_to" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="All Machines">All Machines</option>
                        <option value="Washers">Washers Only</option>
                        <option value="Dryers">Dryers Only</option>
                        <option value="Presser Units">Presser Units</option>
                        <option value="Commercial Wing">Commercial Wing</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Campaign Title</label>
                <input type="text" id="editPromoTitle" name="title" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Discount Type</label>
                    <select id="editPromoType" name="discount_type" required class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="percentage">Percentage Off (%)</option>
                        <option value="fixed">Fixed Dollar Off ($)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Discount Value</label>
                    <input type="number" step="0.01" id="editPromoValue" name="discount_value" required class="w-full text-xs font-bold bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Min Order Spend ($)</label>
                    <input type="number" step="0.01" id="editPromoMin" name="min_spend" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Usage Limit</label>
                    <input type="number" id="editPromoLimit" name="usage_limit" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Campaign Status</label>
                    <select id="editPromoStatus" name="status" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="Active">Active</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Paused">Paused</option>
                        <option value="Expired">Expired</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Expiration Date</label>
                    <input type="date" id="editPromoEnd" name="end_date" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Description &amp; Terms</label>
                <textarea id="editPromoDesc" name="description" rows="2" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeEditPromotionModal()" class="px-4 py-2 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-2.5 rounded-lg text-xs font-bold shadow-xs transition cursor-pointer flex items-center space-x-1.5">
                    <i class="fa-solid fa-check"></i>
                    <span>Update Promotion (OK)</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================== -->
<!-- PROMOTION MODAL 3: VIEW VOUCHER DETAILS -->
<!-- ============================================== -->
<div id="viewPromotionModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full overflow-hidden shadow-2xl border border-gray-100 transform transition-all animate-in fade-in zoom-in duration-150">
        
        <!-- Voucher Card Top -->
        <div class="bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 text-white p-6 relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 rounded-full bg-white/10 blur-sm pointer-events-none"></div>
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold tracking-wider uppercase bg-white/20 px-2.5 py-0.5 rounded-full">Laundry 6 Plus Coupon</span>
                <button onclick="closeViewPromotionModal()" class="text-white/70 hover:text-white transition">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div class="mt-4 text-center">
                <div class="text-4xl font-black tracking-tight" id="viewPromoDiscountLarge">20% OFF</div>
                <div class="text-sm font-semibold text-indigo-100 mt-1" id="viewPromoTitle">Washer Wednesday Special</div>
            </div>

            <!-- Coupon Code Badge -->
            <div class="mt-5 bg-white/10 border border-white/20 backdrop-blur-sm rounded-xl p-3 flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-indigo-200 block uppercase font-medium">Coupon Code:</span>
                    <span class="font-mono text-lg font-black tracking-wider text-white" id="viewPromoCode">WASHER20</span>
                </div>
                <button type="button" onclick="copyCurrentViewingPromoCode()" class="bg-white text-indigo-700 hover:bg-indigo-50 px-3 py-1.5 rounded-lg text-xs font-bold shadow-xs transition flex items-center space-x-1 cursor-pointer">
                    <i class="fa-regular fa-copy text-xs"></i>
                    <span>Copy</span>
                </button>
            </div>
        </div>

        <!-- Voucher Details Body -->
        <div class="p-6 space-y-3.5 text-xs text-gray-700">
            <div class="flex items-center justify-between py-1 border-b border-gray-100">
                <span class="text-gray-400 font-medium">Applies To:</span>
                <span class="font-bold text-gray-900" id="viewPromoApplies">Washers Only</span>
            </div>
            <div class="flex items-center justify-between py-1 border-b border-gray-100">
                <span class="text-gray-400 font-medium">Minimum Spend:</span>
                <span class="font-bold text-gray-900" id="viewPromoMinSpend">$10.00</span>
            </div>
            <div class="flex items-center justify-between py-1 border-b border-gray-100">
                <span class="text-gray-400 font-medium">Validity Period:</span>
                <span class="font-medium text-gray-800" id="viewPromoDates">01 Sep 2026 - 31 Dec 2026</span>
            </div>
            <div class="flex items-center justify-between py-1 border-b border-gray-100">
                <span class="text-gray-400 font-medium">Redemptions Used:</span>
                <span class="font-bold text-emerald-600" id="viewPromoRedemptions">58 / 100 used</span>
            </div>
            <div class="pt-1">
                <span class="text-gray-400 font-medium block">Terms &amp; Notes:</span>
                <p class="text-gray-600 mt-1 leading-relaxed bg-gray-50 p-2.5 rounded-lg border border-gray-100" id="viewPromoTerms">
                    Applicable on all front-load washing machines. Cannot be combined with other commercial clearance deals.
                </p>
            </div>
        </div>

        <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
            <button onclick="closeViewPromotionModal()" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-xs transition cursor-pointer">
                OK, Done
            </button>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- PROMOTION MODAL 4: DELETE CONFIRMATION -->
<!-- ============================================== -->
<div id="deletePromotionModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-gray-100 transform transition-all animate-in fade-in zoom-in duration-150">
        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 tracking-tight">Deactivate Promotion</h3>
        <p class="text-xs text-gray-500 mt-2 font-medium">
            Are you sure you want to deactivate promotion code <span id="deletePromoCodeDisplay" class="font-bold text-rose-600 font-mono">WASHER20</span>? Customers won't be able to apply it.
        </p>

        <div class="mt-6 flex items-center space-x-3">
            <button type="button" onclick="closeDeletePromotionModal()" class="flex-1 py-2.5 px-4 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition cursor-pointer">
                Cancel
            </button>
            <button type="button" onclick="confirmDeletePromotionAction()" class="flex-1 py-2.5 px-4 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer">
                OK, Delete
            </button>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- PROMOTION MODAL 5: DISCOUNT APPLIED CELEBRATION -->
<!-- ============================================== -->
<div id="discountAppliedModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-gray-100 transform transition-all animate-in fade-in zoom-in duration-150">
        <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fa-solid fa-check"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 tracking-tight">Discount Applied!</h3>
        <p class="text-xs text-gray-500 mt-1" id="appliedPromoMsg">Promo code applied successfully to machine order.</p>

        <div class="my-4 p-3.5 bg-emerald-50/70 border border-emerald-200 rounded-2xl text-left space-y-1.5 text-xs">
            <div class="flex justify-between">
                <span class="text-gray-500">Promo Code:</span>
                <span class="font-mono font-bold text-indigo-700" id="appliedModalCode">WASHER20</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Savings Granted:</span>
                <span class="font-bold text-emerald-700" id="appliedModalDiscount">-$1.60</span>
            </div>
            <div class="flex justify-between border-t border-emerald-200 pt-1.5 font-bold">
                <span class="text-gray-800">Final Total:</span>
                <span class="text-base text-gray-900" id="appliedModalTotal">$6.40</span>
            </div>
        </div>

        <button onclick="closeDiscountAppliedModal()" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-xs transition cursor-pointer">
            OK
        </button>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script id="all-machines-data" type="application/json"><?php echo json_encode($allMachines ?? [], 15, 512) ?></script>
<script id="all-promotions-data" type="application/json"><?php echo json_encode($promotions ?? [], 15, 512) ?></script>
<script>
    // Master In-Memory Dataset of all 24 machines from Controller
    const allMachinesMaster = JSON.parse(document.getElementById('all-machines-data').textContent || '[]');
    let filteredMachines = [...allMachinesMaster];

    // HTML escape utility
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Lookup machine by ID for modals
    function viewMachineById(id) {
        const m = allMachinesMaster.find(item => item.id == id);
        if (m) viewMachineDetails(m);
    }

    function openEditMachineById(id) {
        const m = allMachinesMaster.find(item => item.id == id);
        if (m) openEditMachineModal(m);
    }

    // State Variables
    let currentSearchTerm = "<?php echo e(request('search', '')); ?>";
    let selectedType = "<?php echo e(request('type', 'all')); ?>";
    let selectedStatus = "<?php echo e(request('status', 'all')); ?>";
    let selectedLocation = "<?php echo e(request('location', 'all')); ?>";
    let currentPage = <?php echo e($currentPage ?? 1); ?>;
    const perPage = 5;

    // Initialize UI on page load
    document.addEventListener("DOMContentLoaded", function() {
        renderFilteredPage();
    });

    // 1. SEARCH FUNCTIONALITY
    function handleSearch(term) {
        currentSearchTerm = term.trim().toLowerCase();
        currentPage = 1;
        applyFilters();
    }

    // 2. TOGGLE STATUS FILTER BUTTON
    function toggleStatusFilter(status, btnElement) {
        if (selectedStatus === status) {
            selectedStatus = 'all';
        } else {
            selectedStatus = status;
        }

        // Update UI buttons
        document.querySelectorAll('.status-option-btn').forEach(btn => {
            const check = btn.querySelector('.status-check');
            if (btn.getAttribute('data-status') === selectedStatus) {
                btn.classList.add('font-bold', 'text-indigo-600');
                btn.classList.remove('font-normal', 'text-gray-700');
                if (check) check.classList.remove('hidden');
            } else {
                btn.classList.remove('font-bold', 'text-indigo-600');
                btn.classList.add('font-normal', 'text-gray-700');
                if (check) check.classList.add('hidden');
            }
        });

        currentPage = 1;
        applyFilters();
    }

    // 3. APPLY FILTERS (Type, Status, Location, Search)
    function applyFilters() {
        const typeSelect = document.getElementById('filterTypeSelect');
        if (typeSelect) selectedType = typeSelect.value;

        const locSelect = document.getElementById('filterLocationSelect');
        if (locSelect) selectedLocation = locSelect.value;

        filteredMachines = allMachinesMaster.filter(m => {
            // Type Match
            const matchesType = (selectedType === 'all' || m.type.toLowerCase() === selectedType.toLowerCase());

            // Status Match
            const matchesStatus = (selectedStatus === 'all' || m.status.toLowerCase() === selectedStatus.toLowerCase());

            // Location Match
            const matchesLocation = (selectedLocation === 'all' || m.location.toLowerCase().includes(selectedLocation.toLowerCase()));

            // Search Match (Serial, Model, Type, Location, Installation Date)
            let matchesSearch = true;
            if (currentSearchTerm) {
                const combined = (m.serial_id + ' ' + m.model + ' ' + m.type + ' ' + m.location + ' ' + m.installation_date).toLowerCase();
                matchesSearch = combined.includes(currentSearchTerm);
            }

            return matchesType && matchesStatus && matchesLocation && matchesSearch;
        });

        currentPage = 1;
        renderFilteredPage();
    }

    // 4. RESET ALL FILTERS
    function resetAllFilters() {
        currentSearchTerm = '';
        selectedType = 'all';
        selectedStatus = 'all';
        selectedLocation = 'all';
        currentPage = 1;

        const searchInput = document.getElementById('machineSearchInput');
        if (searchInput) searchInput.value = '';

        const typeSelect = document.getElementById('filterTypeSelect');
        if (typeSelect) typeSelect.value = 'all';

        const locSelect = document.getElementById('filterLocationSelect');
        if (locSelect) locSelect.value = 'all';

        document.querySelectorAll('.status-option-btn').forEach(btn => {
            btn.classList.remove('font-bold', 'text-indigo-600');
            btn.classList.add('font-normal', 'text-gray-700');
            const check = btn.querySelector('.status-check');
            if (check) check.classList.add('hidden');
        });

        filteredMachines = [...allMachinesMaster];
        renderFilteredPage();
        showToast("Filters Cleared", "Displaying all machine inventory records.", "info");
    }

    // 5. RENDER FILTERED CARDS & PAGINATION
    function renderFilteredPage() {
        const total = filteredMachines.length;
        const totalPages = Math.max(1, Math.ceil(total / perPage));
        if (currentPage > totalPages) currentPage = totalPages;

        const startIndex = (currentPage - 1) * perPage;
        const endIndex = Math.min(startIndex + perPage, total);
        const pagedItems = filteredMachines.slice(startIndex, endIndex);

        const container = document.getElementById('machineCardsContainer');
        container.innerHTML = '';

        if (pagedItems.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12 text-gray-500 text-sm bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <i class="fa-solid fa-box-open text-2xl text-gray-400 mb-2 block"></i>
                    No machine units match your filter criteria.
                </div>
            `;
        } else {
            pagedItems.forEach(m => {
                let badgeClass = 'bg-gray-100 text-gray-700';
                if (m.status === 'Running') badgeClass = 'bg-emerald-100 text-emerald-800 border border-emerald-200';
                else if (m.status === 'Idle') badgeClass = 'bg-blue-100 text-blue-800 border border-blue-200';
                else if (m.status === 'Alert') badgeClass = 'bg-amber-100 text-amber-800 border border-amber-200';
                else if (m.status === 'Repairing') badgeClass = 'bg-rose-100 text-rose-800 border border-rose-200';

                // Display multiline formatted model
                const modelFormatted = (m.full_model || m.model).replace(/\n/g, '<br>');
                const safeJson = JSON.stringify(m).replace(/"/g, '&quot;');

                const cardHtml = `
                    <div class="machine-row-card bg-white rounded-xl border border-gray-300 p-4 transition hover:border-gray-400 shadow-2xs" id="machine-card-${m.id}">
                        <div class="grid grid-cols-12 items-center gap-2">
                            <div class="col-span-3">
                                <span class="font-bold text-base text-gray-900">${escapeHtml(m.serial_id)}</span>
                            </div>
                            <div class="col-span-3">
                                <div class="text-sm font-medium text-gray-800 leading-snug">
                                    ${modelFormatted}
                                </div>
                            </div>
                            <div class="col-span-3">
                                <span class="text-sm text-gray-700 font-normal">${escapeHtml(m.installation_date)}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold ${badgeClass}">
                                    ${escapeHtml(m.status)}
                                </span>
                            </div>
                            <div class="col-span-1 flex flex-col items-center justify-center space-y-2">
                                <button onclick="viewMachineById(${m.id})" class="text-gray-700 hover:text-blue-600 transition p-0.5 cursor-pointer" title="View Machine Telemetry">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>
                                <button onclick="openEditMachineById(${m.id})" class="text-gray-700 hover:text-amber-600 transition p-0.5 cursor-pointer" title="Edit Machine">
                                    <i class="fa-regular fa-pen-to-square text-sm"></i>
                                </button>
                                <button onclick="confirmDeleteMachine(${m.id}, '${escapeHtml(m.serial_id)}')" class="text-gray-700 hover:text-red-600 transition p-0.5 cursor-pointer" title="Decommission Machine">
                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', cardHtml);
            });
        }

        // Update Pagination Info
        document.getElementById('info-from').innerText = total > 0 ? (startIndex + 1) : 0;
        document.getElementById('info-to').innerText = endIndex;
        document.getElementById('info-total').innerText = total;

        // Update Previous / Next Buttons
        const btnPrev = document.getElementById('btnPrevPage');
        const btnNext = document.getElementById('btnNextPage');
        if (btnPrev) btnPrev.disabled = (currentPage <= 1);
        if (btnNext) btnNext.disabled = (currentPage >= totalPages);

        // Update 1..5 page buttons
        for (let i = 1; i <= 5; i++) {
            const btn = document.getElementById(`pageBtn-${i}`);
            if (btn) {
                if (i > totalPages) {
                    btn.classList.add('hidden');
                } else {
                    btn.classList.remove('hidden');
                    if (i === currentPage) {
                        btn.className = "page-num-btn w-8 h-8 rounded-lg text-xs font-bold transition cursor-pointer bg-[#5B46F6] text-white shadow-xs";
                    } else {
                        btn.className = "page-num-btn w-8 h-8 rounded-lg text-xs font-medium border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition cursor-pointer";
                    }
                }
            }
        }
    }

    // 6. PAGE NAVIGATION
    function changePage(page) {
        const totalPages = Math.max(1, Math.ceil(filteredMachines.length / perPage));
        if (page === 'prev') {
            if (currentPage > 1) currentPage--;
        } else if (page === 'next') {
            if (currentPage < totalPages) currentPage++;
        } else {
            currentPage = Math.min(Math.max(1, parseInt(page)), totalPages);
        }
        renderFilteredPage();
    }

    // 7. VIEW MACHINE TELEMETRY MODAL
    function viewMachineDetails(m) {
        document.getElementById('view_serial').innerText = m.serial_id;
        document.getElementById('view_model').innerText = m.model;
        document.getElementById('view_type').innerText = m.type;
        document.getElementById('view_location').innerText = m.location;
        document.getElementById('view_installation').innerText = m.installation_date;
        document.getElementById('view_health').innerText = m.motor_health || '98%';
        document.getElementById('view_temp').innerText = m.temperature || '55°C';
        document.getElementById('view_today_cycles').innerText = m.cycles_today || 6;
        document.getElementById('view_total_cycles').innerText = (m.total_cycles || 1200).toLocaleString();
        document.getElementById('view_serviced').innerText = m.last_serviced || '10 Aug 2026';

        const statusEl = document.getElementById('view_status');
        statusEl.innerText = m.status;
        if (m.status === 'Running') {
            statusEl.className = "inline-flex items-center font-bold mt-1 text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md";
        } else if (m.status === 'Idle') {
            statusEl.className = "inline-flex items-center font-bold mt-1 text-blue-700 bg-blue-100 px-2 py-0.5 rounded-md";
        } else if (m.status === 'Alert') {
            statusEl.className = "inline-flex items-center font-bold mt-1 text-amber-700 bg-amber-100 px-2 py-0.5 rounded-md";
        } else {
            statusEl.className = "inline-flex items-center font-bold mt-1 text-rose-700 bg-rose-100 px-2 py-0.5 rounded-md";
        }

        document.getElementById('viewMachineModal').classList.remove('hidden');
    }
    function closeViewMachineModal() {
        document.getElementById('viewMachineModal').classList.add('hidden');
    }

    // 8. ADD NEW MACHINE MODAL & ACTION
    function openAddMachineModal() {
        document.getElementById('addMachineModal').classList.remove('hidden');
    }
    function closeAddMachineModal() {
        document.getElementById('addMachineModal').classList.add('hidden');
    }

    function submitAddMachine(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        const newMachine = {
            id: allMachinesMaster.length + 1,
            serial_id: formData.get('serial_id'),
            model: formData.get('model'),
            type: formData.get('type'),
            full_model: `${formData.get('model')}\n(${formData.get('type')})`,
            installation_date: formData.get('installation_date'),
            status: formData.get('status'),
            location: formData.get('location'),
            cycles_today: 0,
            total_cycles: 0,
            temperature: 'Ambient',
            motor_health: '100%',
            last_serviced: 'New Installation'
        };

        allMachinesMaster.unshift(newMachine);
        closeAddMachineModal();
        form.reset();
        applyFilters();
        showToast("Machine Registered", `Unit ${newMachine.serial_id} added successfully!`, "success");

        // Background POST to backend route
        fetch("<?php echo e(route('machines.store')); ?>", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        }).catch(err => console.log('Saved to active session:', err));
    }

    // 9. EDIT MACHINE MODAL & ACTION
    function openEditMachineModal(m) {
        document.getElementById('edit_id').value = m.id;
        document.getElementById('edit_serial').value = m.serial_id;
        document.getElementById('edit_model').value = m.model;
        document.getElementById('edit_type').value = m.type;
        document.getElementById('edit_status').value = m.status;
        document.getElementById('edit_location').value = m.location;

        document.getElementById('editMachineModal').classList.remove('hidden');
    }
    function closeEditMachineModal() {
        document.getElementById('editMachineModal').classList.add('hidden');
    }

    function submitEditMachine(e) {
        e.preventDefault();
        const id = parseInt(document.getElementById('edit_id').value);
        const serial = document.getElementById('edit_serial').value;
        const model = document.getElementById('edit_model').value;
        const type = document.getElementById('edit_type').value;
        const status = document.getElementById('edit_status').value;
        const location = document.getElementById('edit_location').value;

        const idx = allMachinesMaster.findIndex(m => m.id === id);
        if (idx !== -1) {
            allMachinesMaster[idx].serial_id = serial;
            allMachinesMaster[idx].model = model;
            allMachinesMaster[idx].type = type;
            allMachinesMaster[idx].full_model = `${model}\n(${type})`;
            allMachinesMaster[idx].status = status;
            allMachinesMaster[idx].location = location;
        }

        closeEditMachineModal();
        renderFilteredPage();
        showToast("Machine Updated", `Unit ${serial} has been successfully updated.`, "success");

        // Background PUT to backend route
        const data = new URLSearchParams();
        data.append('_token', '<?php echo e(csrf_token()); ?>');
        data.append('_method', 'PUT');
        data.append('serial_id', serial);
        data.append('model', model);
        data.append('type', type);
        data.append('status', status);
        data.append('location', location);

        fetch(`/machines/${id}`, {
            method: 'POST',
            body: data,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        }).catch(err => console.log('Updated in active session:', err));
    }

    // 10. DELETE / DECOMMISSION MACHINE
    function confirmDeleteMachine(id, serial) {
        if (confirm(`Are you sure you want to decommission and remove unit ${serial}?`)) {
            const idx = allMachinesMaster.findIndex(m => m.id === id);
            if (idx !== -1) {
                allMachinesMaster.splice(idx, 1);
            }
            applyFilters();
            showToast("Unit Decommissioned", `Unit ${serial} archived from active inventory.`, "warning");

            // Background DELETE to backend route
            fetch(`/machines/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            }).catch(err => console.log('Decommissioned:', err));
        }
    }

    // 11. ADVANCED FILTERS MODAL
    function openAdvancedFiltersModal() {
        document.getElementById('advancedFiltersModal').classList.remove('hidden');
    }
    function closeAdvancedFiltersModal() {
        document.getElementById('advancedFiltersModal').classList.add('hidden');
    }

    function applyAdvancedFilters(e) {
        e.preventDefault();
        const healthFilter = document.getElementById('adv_health').value;
        const cyclesFilter = document.getElementById('adv_cycles').value;
        const sortFilter = document.getElementById('adv_sort').value;

        // Apply health filter
        filteredMachines = allMachinesMaster.filter(m => {
            const healthNum = parseInt(m.motor_health) || 90;
            if (healthFilter === 'optimal' && healthNum <= 95) return false;
            if (healthFilter === 'good' && (healthNum < 85 || healthNum > 95)) return false;
            if (healthFilter === 'warning' && healthNum >= 85) return false;

            const cyclesNum = m.total_cycles || 1000;
            if (cyclesFilter === 'low' && cyclesNum >= 500) return false;
            if (cyclesFilter === 'mid' && (cyclesNum < 500 || cyclesNum > 1500)) return false;
            if (cyclesFilter === 'high' && cyclesNum <= 1500) return false;

            return true;
        });

        // Apply sort
        if (sortFilter === 'id_asc') {
            filteredMachines.sort((a, b) => a.serial_id.localeCompare(b.serial_id));
        } else if (sortFilter === 'id_desc') {
            filteredMachines.sort((a, b) => b.serial_id.localeCompare(a.serial_id));
        } else if (sortFilter === 'cycles_desc') {
            filteredMachines.sort((a, b) => (b.total_cycles || 0) - (a.total_cycles || 0));
        } else if (sortFilter === 'health_asc') {
            filteredMachines.sort((a, b) => (parseInt(a.motor_health) || 100) - (parseInt(b.motor_health) || 100));
        }

        closeAdvancedFiltersModal();
        currentPage = 1;
        renderFilteredPage();
        showToast("Advanced Filters Applied", `Found ${filteredMachines.length} units matching specifications.`, "info");
    }

    // 12. TOAST NOTIFICATION UTILITY
    let toastTimeout;
    function showToast(title, message, type = "success") {
        const toast = document.getElementById('machineToast');
        const titleEl = document.getElementById('toastTitle');
        const msgEl = document.getElementById('toastMessage');
        const iconEl = document.getElementById('toastIcon');

        titleEl.innerText = title;
        msgEl.innerText = message;

        if (type === "success") {
            iconEl.className = "w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0";
            iconEl.innerHTML = '<i class="fa-solid fa-check text-sm"></i>';
        } else if (type === "warning") {
            iconEl.className = "w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center flex-shrink-0";
            iconEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-sm"></i>';
        } else {
            iconEl.className = "w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0";
            iconEl.innerHTML = '<i class="fa-solid fa-circle-info text-sm"></i>';
        }

        toast.classList.remove('hidden');
        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(hideToast, 4000);
    }

    function hideToast() {
        document.getElementById('machineToast').classList.add('hidden');
    }

    // 13. EXPORT REPORT DROPDOWN TOGGLE
    function toggleExportMenu(e) {
        e.stopPropagation();
        const menu = document.getElementById('exportDropdownMenu');
        const chevron = document.getElementById('exportChevronIcon');
        if (!menu) return;
        
        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            if (chevron) chevron.classList.add('rotate-180');
        } else {
            menu.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }
    }

    function closeExportMenu() {
        const menu = document.getElementById('exportDropdownMenu');
        const chevron = document.getElementById('exportChevronIcon');
        if (menu) menu.classList.add('hidden');
        if (chevron) chevron.classList.remove('rotate-180');
    }

    // Close export dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('exportReportDropdownWrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            closeExportMenu();
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Laundry_Managerment_System/laundry_system/resources/views/pages/machine.blade.php ENDPATH**/ ?>