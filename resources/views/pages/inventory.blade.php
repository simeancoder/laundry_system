<?php $__env->startSection('content'); ?>
<div class="space-y-4 max-w-[1550px] mx-auto pb-10">

    <!-- Top Header Row Matching Design Exactly -->
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
        <!-- Top-Left Title and Subtitle -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight leading-tight">Inventory</h1>
            <p class="text-[#2563EB] font-medium text-sm mt-0.5 tracking-wide">All Items</p>
        </div>

        <!-- Top-Right Bell, Admin Profile, and Add Item Button -->
        <div class="flex flex-col items-end space-y-3">
            <?php if(request()->has('standalone')): ?>
            <!-- Row 1: Notification Bell & Admin Profile (Standalone Only) -->
            <div class="flex items-center space-x-3 select-none">
                <!-- Blue Bell Icon -->
                <button type="button" class="text-[#2563EB] hover:text-blue-700 transition cursor-pointer p-1" title="Notifications">
                    <svg class="w-6 h-6 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </button>

                <!-- Blue Circle User Icon & Admin Text -->
                <div class="flex items-center space-x-2 text-[#2563EB]">
                    <svg class="w-7 h-7 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="10" r="3"></circle>
                        <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
                    </svg>
                    <span class="text-gray-900 font-semibold text-base tracking-normal">Admin</span>
                </div>
            </div>
            <?php endif; ?>


            <!-- Row 2: + Add Item Button (Vivid Blue / Purple Pill) -->
            <div>
                <button type="button" 
                        onclick="openAddModal()"
                        class="bg-[#3225D6] hover:bg-[#281DB8] active:scale-[0.98] text-white px-4 py-1.5 rounded-lg text-xs font-semibold flex items-center space-x-1.5 shadow-xs transition cursor-pointer">
                    <span class="text-sm font-bold leading-none">+</span>
                    <span>Add Item</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Filter & Action Controls Bar -->
    <div class="flex flex-wrap items-center gap-3 pt-1">
        <!-- 1. Search Box with Magnifying Glass -->
        <div class="relative w-full sm:w-[280px]">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-700">
                <svg class="w-4 h-4 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <input type="text" 
                   id="itemSearchInput" 
                   value="<?php echo e(request('search', $search ?? '')); ?>"
                   oninput="handleSearch(this.value)"
                   placeholder="Search items..." 
                   class="w-full bg-white text-gray-800 placeholder-gray-500 text-sm rounded-xl pl-9 pr-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition">
        </div>

        <!-- 2. All Categories Dropdown -->
        <div class="relative">
            <select id="categoryFilter" 
                    onchange="handleFilterChange()"
                    class="appearance-none bg-white text-gray-800 text-sm rounded-xl pl-3.5 pr-9 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition cursor-pointer font-normal">
                <option value="all" <?php echo e(($categoryFilter ?? 'all') === 'all' ? 'selected' : ''); ?>>All Categories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat); ?>" <?php echo e(($categoryFilter ?? '') === $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-700">
                <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </span>
        </div>

        <!-- 3. All Status Dropdown -->
        <div class="relative">
            <select id="statusFilter" 
                    onchange="handleFilterChange()"
                    class="appearance-none bg-white text-gray-800 text-sm rounded-xl pl-3.5 pr-9 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition cursor-pointer font-normal">
                <option value="all" <?php echo e(($statusFilter ?? 'all') === 'all' ? 'selected' : ''); ?>>All Status</option>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($st); ?>" <?php echo e(($statusFilter ?? '') === $st ? 'selected' : ''); ?>><?php echo e($st); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-700">
                <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </span>
        </div>

        <!-- 4. Refresh Button -->
        <button type="button" 
                onclick="resetFilters()"
                class="bg-white hover:bg-gray-50 active:bg-gray-100 text-gray-800 text-sm rounded-xl px-4 py-2 border border-gray-300 flex items-center space-x-2 transition cursor-pointer shadow-2xs font-normal">
            <svg class="w-4 h-4 stroke-current text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg>
            <span>Refresh</span>
        </button>
    </div>

    <!-- Data Table Container Matching Design Exactly -->
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="inventoryTable">
                <thead>
                    <tr class="bg-[#F4F6FA] text-gray-900 text-sm border-b border-gray-200">
                        <th class="py-3.5 px-6 font-bold tracking-tight">Items</th>
                        <th class="py-3.5 px-6 font-bold tracking-tight">Categories</th>
                        <th class="py-3.5 px-6 font-bold tracking-tight text-center">Stock</th>
                        <th class="py-3.5 px-6 font-bold tracking-tight text-center">Unit</th>
                        <th class="py-3.5 px-6 font-bold tracking-tight text-center">Status</th>
                        <th class="py-3.5 px-6 font-bold tracking-tight text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="inventoryTableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50/70 transition-colors" data-id="<?php echo e($item['id']); ?>">
                        <!-- Item Name -->
                        <td class="py-4 px-6 text-sm text-gray-900 font-medium whitespace-nowrap">
                            <?php echo e($item['name']); ?>

                        </td>

                        <!-- Category -->
                        <td class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap">
                            <?php echo e($item['category']); ?>

                        </td>

                        <!-- Stock Level -->
                        <td class="py-4 px-6 text-sm text-gray-900 font-medium text-center whitespace-nowrap">
                            <?php echo e($item['stock']); ?>

                        </td>

                        <!-- Unit -->
                        <td class="py-4 px-6 text-sm text-gray-800 text-center whitespace-nowrap">
                            <?php echo e($item['unit']); ?>

                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            <?php if(strtolower($item['status']) === 'in stock'): ?>
                                <span class="inline-block bg-[#E8F8EE] text-[#16A34A] text-xs font-semibold px-3.5 py-1 rounded-full">
                                    In Stock
                                </span>
                            <?php elseif(strtolower($item['status']) === 'low stock'): ?>
                                <span class="inline-block bg-[#FEE2E2] text-[#EF4444] text-xs font-semibold px-3.5 py-1 rounded-full">
                                    Low Stock
                                </span>
                            <?php else: ?>
                                <span class="inline-block bg-gray-100 text-gray-600 text-xs font-semibold px-3.5 py-1 rounded-full">
                                    <?php echo e($item['status']); ?>

                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- Action Buttons (View, Edit, Delete) -->
                        <td class="py-4 px-6 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- View Button (Eye) -->
                                <button type="button" 
                                        onclick="openViewModal(<?php echo e(json_encode($item)); ?>)" 
                                        class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 hover:text-blue-600 transition cursor-pointer shadow-2xs"
                                        title="View Details">
                                    <svg class="w-4 h-4 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>

                                <!-- Edit Button (Pencil) -->
                                <button type="button" 
                                        onclick="openEditModal(<?php echo e(json_encode($item)); ?>)" 
                                        class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 hover:text-emerald-600 transition cursor-pointer shadow-2xs"
                                        title="Edit Item">
                                    <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </button>

                                <!-- Delete Button (Trash) -->
                                <button type="button" 
                                        onclick="openDeleteModal(<?php echo e($item['id']); ?>, '<?php echo e(addslashes($item['name'])); ?>')" 
                                        class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition cursor-pointer shadow-2xs"
                                        title="Delete Item">
                                    <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-base font-semibold text-gray-700">No inventory items found</p>
                                <p class="text-xs text-gray-400 mt-1">Try clearing your search query or reset filters.</p>
                                <button onclick="resetFilters()" class="mt-4 px-4 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">
                                    Reset Filters
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom Pagination Card Matching Design Exactly -->
    <div class="bg-white border border-gray-200 rounded-2xl p-3.5 px-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-2xs" id="paginationWrapper">
        <!-- Left: Showing 1 to 6 of 25 items -->
        <div class="text-[#2563EB] font-medium text-sm" id="paginationInfo">
            Showing <?php echo e($from ?? 1); ?> to <?php echo e($to ?? 6); ?> of <?php echo e($totalFiltered ?? 25); ?> items
        </div>

        <!-- Right: Pagination Controls (< Previous, 1, 2, 3, 4, 5, Next >) -->
        <div class="flex items-center space-x-2" id="paginationButtons">
            <!-- < Previous Button -->
            <button type="button" 
                    id="prevBtn"
                    onclick="changePage(<?php echo e(max(1, ($currentPage ?? 1) - 1)); ?>)"
                    class="bg-white hover:bg-gray-50 active:bg-gray-100 border border-gray-300 text-gray-800 text-xs font-medium px-3 py-1.5 rounded-lg flex items-center space-x-1 transition cursor-pointer shadow-2xs <?php echo e(($currentPage ?? 1) <= 1 ? 'opacity-50 cursor-not-allowed' : ''); ?>"
                    <?php echo e(($currentPage ?? 1) <= 1 ? 'disabled' : ''); ?>>
                <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Previous</span>
            </button>

            <!-- Page Number Buttons (1, 2, 3, 4, 5) -->
            <?php for($p = 1; $p <= max(5, $totalPages ?? 5); $p++): ?>
                <?php if($p <= ($totalPages ?? 5)): ?>
                    <button type="button" 
                            onclick="changePage(<?php echo e($p); ?>)"
                            class="min-w-[32px] h-[32px] text-xs font-semibold rounded-lg flex items-center justify-center transition cursor-pointer shadow-2xs <?php echo e(($currentPage ?? 1) == $p ? 'bg-[#2563EB] text-white' : 'bg-white hover:bg-gray-50 text-gray-800 border border-gray-300'); ?>">
                        <?php echo e($p); ?>

                    </button>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Next > Button -->
            <button type="button" 
                    id="nextBtn"
                    onclick="changePage(<?php echo e(min($totalPages ?? 5, ($currentPage ?? 1) + 1)); ?>)"
                    class="bg-white hover:bg-gray-50 active:bg-gray-100 border border-gray-300 text-gray-800 text-xs font-medium px-3 py-1.5 rounded-lg flex items-center space-x-1 transition cursor-pointer shadow-2xs <?php echo e(($currentPage ?? 1) >= ($totalPages ?? 5) ? 'opacity-50 cursor-not-allowed' : ''); ?>"
                    <?php echo e(($currentPage ?? 1) >= ($totalPages ?? 5) ? 'disabled' : ''); ?>>
                <span>Next</span>
                <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

</div>

<!-- ================= MODALS ================= -->

<!-- 1. ADD ITEM MODAL -->
<div id="addModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Add New Inventory Item</h3>
                <p class="text-xs text-gray-500 mt-0.5">Enter item details and initial stock levels.</p>
            </div>
            <button onclick="closeAddModal()" class="w-8 h-8 text-gray-400 hover:text-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="addItemForm" onsubmit="submitAddItem(event)" class="mt-5 space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Item Name *</label>
                <input type="text" name="name" required placeholder="e.g. Detergent, Packing Bags" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Category *</label>
                    <select name="category" required class="w-full text-sm rounded-xl border border-gray-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="Cleaning">Cleaning</option>
                        <option value="Packing">Packing</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Chemicals">Chemicals</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Unit of Measure *</label>
                    <input type="text" name="unit" required placeholder="e.g. L, Pcs, Kg, Roll" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Stock Quantity *</label>
                    <input type="number" name="stock" min="0" required placeholder="50" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status *</label>
                    <select name="status" required class="w-full text-sm rounded-xl border border-gray-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="In Stock">In Stock</option>
                        <option value="Low Stock">Low Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Minimum Threshold (Alert Level)</label>
                <input type="number" name="min_threshold" min="1" value="15" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Description / Notes</label>
                <textarea name="notes" rows="2" placeholder="Storage instructions, chemical safety, or reordering info" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="bg-[#3225D6] hover:bg-[#281DB8] text-white px-5 py-2 rounded-xl text-sm font-semibold transition shadow-xs">
                    Save Item
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. EDIT ITEM MODAL -->
<div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Edit Inventory Item</h3>
                <p class="text-xs text-gray-500 mt-0.5">Update item attributes and stock count.</p>
            </div>
            <button onclick="closeEditModal()" class="w-8 h-8 text-gray-400 hover:text-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="editItemForm" onsubmit="submitEditItem(event)" class="mt-5 space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" id="editItemId" name="id">

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Item Name *</label>
                <input type="text" id="editItemName" name="name" required class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Category *</label>
                    <select id="editItemCategory" name="category" required class="w-full text-sm rounded-xl border border-gray-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="Cleaning">Cleaning</option>
                        <option value="Packing">Packing</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Chemicals">Chemicals</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Unit of Measure *</label>
                    <input type="text" id="editItemUnit" name="unit" required class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Stock Quantity *</label>
                    <input type="number" id="editItemStock" name="stock" min="0" required class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Status *</label>
                    <select id="editItemStatus" name="status" required class="w-full text-sm rounded-xl border border-gray-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="In Stock">In Stock</option>
                        <option value="Low Stock">Low Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Minimum Threshold (Alert Level)</label>
                <input type="number" id="editItemThreshold" name="min_threshold" min="1" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Description / Notes</label>
                <textarea id="editItemNotes" name="notes" rows="2" class="w-full text-sm rounded-xl border border-gray-300 px-3.5 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="bg-[#2563EB] hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition shadow-xs">
                    Update Item
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. VIEW DETAILS MODAL -->
<div id="viewModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div>
                <span id="viewItemBadge" class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full mb-1"></span>
                <h3 id="viewItemName" class="text-xl font-bold text-gray-900"></h3>
            </div>
            <button onclick="closeViewModal()" class="w-8 h-8 text-gray-400 hover:text-gray-700 rounded-lg flex items-center justify-center hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="mt-4 space-y-3.5">
            <div class="bg-gray-50 rounded-xl p-4 grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Category</span>
                    <span id="viewItemCategory" class="text-gray-900 font-bold mt-0.5 block"></span>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Current Stock</span>
                    <span id="viewItemStock" class="text-gray-900 font-bold mt-0.5 block"></span>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Unit</span>
                    <span id="viewItemUnit" class="text-gray-900 font-bold mt-0.5 block"></span>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Min Threshold</span>
                    <span id="viewItemThreshold" class="text-gray-900 font-bold mt-0.5 block"></span>
                </div>
            </div>

            <div class="px-1 text-sm">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Last Restocked</span>
                <span id="viewItemRestocked" class="text-gray-700 font-medium mt-0.5 block"></span>
            </div>

            <div class="px-1 text-sm">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider block">Notes & Specifications</span>
                <p id="viewItemNotes" class="text-gray-600 mt-1 leading-relaxed text-xs bg-gray-50 p-3 rounded-lg"></p>
            </div>
        </div>

        <div class="flex justify-end pt-5 border-t border-gray-100 mt-4">
            <button type="button" onclick="closeViewModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-xl text-xs font-semibold transition">
                Close
            </button>
        </div>
    </div>
</div>

<!-- 4. DELETE CONFIRMATION MODAL -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200 text-center">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-1">Delete Item?</h3>
        <p class="text-xs text-gray-500 mb-6">Are you sure you want to remove <strong id="deleteItemName" class="text-gray-800"></strong> from the inventory list? This action cannot be undone.</p>
        
        <div class="flex items-center justify-center space-x-3">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 rounded-xl transition">
                Cancel
            </button>
            <button type="button" onclick="confirmDeleteItem()" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl text-xs font-semibold transition shadow-xs">
                Yes, Delete
            </button>
        </div>
    </div>
</div>

<!-- Toast Alert Component -->
<div id="inventoryToast" class="hidden fixed bottom-6 right-6 z-50 bg-gray-900 text-white px-4 py-3 rounded-xl shadow-xl flex items-center space-x-2 text-sm transition-all duration-300 transform translate-y-2 opacity-0">
    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    <span id="toastMessage" class="font-medium"></span>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Global State
    let activePage = <?php echo e($currentPage ?? 1); ?>;
    let deleteTargetId = null;

    // Toast Notification helper
    function showToast(message) {
        const toast = document.getElementById('inventoryToast');
        const text = document.getElementById('toastMessage');
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
        }, 3200);
    }

    // Live Search with Debounce
    let searchTimer = null;
    function handleSearch(query) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            activePage = 1;
            fetchInventoryData();
        }, 250);
    }

    // Filter Change Handler
    function handleFilterChange() {
        activePage = 1;
        fetchInventoryData();
    }

    // Reset Filters & Refresh
    function resetFilters() {
        document.getElementById('itemSearchInput').value = '';
        document.getElementById('categoryFilter').value = 'all';
        document.getElementById('statusFilter').value = 'all';
        activePage = 1;
        fetchInventoryData();
        showToast('Filters reset to default view.');
    }

    // Change Page
    function changePage(page) {
        activePage = page;
        fetchInventoryData();
    }

    // Fetch Inventory Data via AJAX
    function fetchInventoryData() {
        const search = document.getElementById('itemSearchInput').value;
        const category = document.getElementById('categoryFilter').value;
        const status = document.getElementById('statusFilter').value;

        const url = new URL('<?php echo e(route("inventory.index")); ?>', window.location.origin);
        if (search) url.searchParams.set('search', search);
        if (category && category !== 'all') url.searchParams.set('category', category);
        if (status && status !== 'all') url.searchParams.set('status', status);
        url.searchParams.set('page', activePage);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                renderTable(res.data);
                renderPagination(res.pagination);
            }
        })
        .catch(err => {
            console.error('Error loading inventory data:', err);
        });
    }

    // Render Table Rows
    function renderTable(items) {
        const tbody = document.getElementById('inventoryTableBody');
        if (!items || items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-base font-semibold text-gray-700">No inventory items found</p>
                            <p class="text-xs text-gray-400 mt-1">Try clearing your search query or reset filters.</p>
                            <button onclick="resetFilters()" class="mt-4 px-4 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">
                                Reset Filters
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        items.forEach(item => {
            const isStock = item.status.toLowerCase() === 'in stock';
            const isLow = item.status.toLowerCase() === 'low stock';
            const badgeClass = isStock ? 'bg-[#E8F8EE] text-[#16A34A]' : (isLow ? 'bg-[#FEE2E2] text-[#EF4444]' : 'bg-gray-100 text-gray-600');

            const itemJson = JSON.stringify(item).replace(/"/g, '&quot;');

            html += `
                <tr class="hover:bg-gray-50/70 transition-colors" data-id="${item.id}">
                    <td class="py-4 px-6 text-sm text-gray-900 font-medium whitespace-nowrap">${item.name}</td>
                    <td class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap">${item.category}</td>
                    <td class="py-4 px-6 text-sm text-gray-900 font-medium text-center whitespace-nowrap">${item.stock}</td>
                    <td class="py-4 px-6 text-sm text-gray-800 text-center whitespace-nowrap">${item.unit}</td>
                    <td class="py-4 px-6 text-center whitespace-nowrap">
                        <span class="inline-block ${badgeClass} text-xs font-semibold px-3.5 py-1 rounded-full">
                            ${item.status}
                        </span>
                    </td>
                    <td class="py-4 px-6 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <button type="button" onclick="openViewModal(${itemJson})" class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 hover:text-blue-600 transition cursor-pointer shadow-2xs" title="View Details">
                                <svg class="w-4 h-4 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                            <button type="button" onclick="openEditModal(${itemJson})" class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-gray-100 hover:text-emerald-600 transition cursor-pointer shadow-2xs" title="Edit Item">
                                <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </button>
                            <button type="button" onclick="openDeleteModal(${item.id}, '${item.name.replace(/'/g, "\\'")}')" class="w-8 h-8 rounded-lg border border-gray-300 flex items-center justify-center text-gray-800 hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition cursor-pointer shadow-2xs" title="Delete Item">
                                <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
        tbody.innerHTML = html;
    }

    // Render Pagination Controls
    function renderPagination(pagination) {
        document.getElementById('paginationInfo').innerText = `Showing ${pagination.from} to ${pagination.to} of ${pagination.total} items`;

        let btnHtml = '';
        const prevDisabled = pagination.current_page <= 1;
        btnHtml += `
            <button type="button" onclick="changePage(${Math.max(1, pagination.current_page - 1)})" class="bg-white hover:bg-gray-50 active:bg-gray-100 border border-gray-300 text-gray-800 text-xs font-medium px-3 py-1.5 rounded-lg flex items-center space-x-1 transition cursor-pointer shadow-2xs ${prevDisabled ? 'opacity-50 cursor-not-allowed' : ''}" ${prevDisabled ? 'disabled' : ''}>
                <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                <span>Previous</span>
            </button>
        `;

        for (let p = 1; p <= pagination.last_page; p++) {
            const isActive = p === pagination.current_page;
            btnHtml += `
                <button type="button" onclick="changePage(${p})" class="min-w-[32px] h-[32px] text-xs font-semibold rounded-lg flex items-center justify-center transition cursor-pointer shadow-2xs ${isActive ? 'bg-[#2563EB] text-white' : 'bg-white hover:bg-gray-50 text-gray-800 border border-gray-300'}">
                    ${p}
                </button>
            `;
        }

        const nextDisabled = pagination.current_page >= pagination.last_page;
        btnHtml += `
            <button type="button" onclick="changePage(${Math.min(pagination.last_page, pagination.current_page + 1)})" class="bg-white hover:bg-gray-50 active:bg-gray-100 border border-gray-300 text-gray-800 text-xs font-medium px-3 py-1.5 rounded-lg flex items-center space-x-1 transition cursor-pointer shadow-2xs ${nextDisabled ? 'opacity-50 cursor-not-allowed' : ''}" ${nextDisabled ? 'disabled' : ''}>
                <span>Next</span>
                <svg class="w-3.5 h-3.5 stroke-current" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
            </button>
        `;

        document.getElementById('paginationButtons').innerHTML = btnHtml;
    }

    // Modal Control Functions
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('addItemForm').reset();
    }

    function openEditModal(item) {
        document.getElementById('editItemId').value = item.id;
        document.getElementById('editItemName').value = item.name;
        document.getElementById('editItemCategory').value = item.category;
        document.getElementById('editItemStock').value = item.stock;
        document.getElementById('editItemUnit').value = item.unit;
        document.getElementById('editItemStatus').value = item.status;
        document.getElementById('editItemThreshold').value = item.min_threshold || 15;
        document.getElementById('editItemNotes').value = item.notes || '';
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function openViewModal(item) {
        document.getElementById('viewItemName').innerText = item.name;
        document.getElementById('viewItemCategory').innerText = item.category;
        document.getElementById('viewItemStock').innerText = item.stock;
        document.getElementById('viewItemUnit').innerText = item.unit;
        document.getElementById('viewItemThreshold').innerText = item.min_threshold ? `${item.min_threshold} ${item.unit}` : '15 ' + item.unit;
        document.getElementById('viewItemRestocked').innerText = item.last_restocked || 'Recent';
        document.getElementById('viewItemNotes').innerText = item.notes || 'Standard storage in dry climate-controlled supply warehouse.';

        const isStock = item.status.toLowerCase() === 'in stock';
        const badge = document.getElementById('viewItemBadge');
        badge.innerText = item.status;
        badge.className = `inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full mb-1 ${isStock ? 'bg-[#E8F8EE] text-[#16A34A]' : 'bg-[#FEE2E2] text-[#EF4444]'}`;

        document.getElementById('viewModal').classList.remove('hidden');
    }
    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }

    function openDeleteModal(id, name) {
        deleteTargetId = id;
        document.getElementById('deleteItemName').innerText = name;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        deleteTargetId = null;
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Submit Add Item Form
    function submitAddItem(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        fetch('<?php echo e(route("inventory.store")); ?>', {
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
                closeAddModal();
                showToast(data.message || 'Item added successfully!');
                fetchInventoryData();
            }
        })
        .catch(err => {
            console.error('Add failed:', err);
            alert('Failed to add item. Please check the values.');
        });
    }

    // Submit Edit Item Form
    function submitEditItem(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const id = document.getElementById('editItemId').value;

        fetch(`<?php echo e(url('inventory')); ?>/${id}`, {
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
                closeEditModal();
                showToast(data.message || 'Item updated successfully!');
                fetchInventoryData();
            }
        })
        .catch(err => {
            console.error('Update failed:', err);
            alert('Failed to update item.');
        });
    }

    // Confirm Delete
    function confirmDeleteItem() {
        if (!deleteTargetId) return;

        const token = document.querySelector('input[name="_token"]')?.value || '<?php echo e(csrf_token()); ?>';
        const formData = new FormData();
        formData.append('_token', token);
        formData.append('_method', 'DELETE');

        fetch(`<?php echo e(url('inventory')); ?>/${deleteTargetId}`, {
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
                closeDeleteModal();
                showToast(data.message || 'Item deleted successfully!');
                fetchInventoryData();
            }
        })
        .catch(err => {
            console.error('Delete failed:', err);
            alert('Failed to delete item.');
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(request()->has('standalone') ? 'layouts.blank' : 'layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Laundry_Managerment_System/laundry_system/resources/views/pages/inventory.blade.php ENDPATH**/ ?>