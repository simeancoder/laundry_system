@extends('layouts.navbar')

@section('content')
<div class="space-y-6">

    <!-- Section: Generate Reports Bar & Export Buttons -->

    <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
        <div class="flex items-center space-x-3">
            <h2 class="text-lg md:text-xl font-bold text-gray-800">Generate Reports</h2>
            <!-- Quick Add / Generate Trigger Button -->
            <button onclick="openGenerateModal()" class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold rounded-lg border border-blue-200 transition flex items-center space-x-1 cursor-pointer" title="Add / Generate New Custom Report">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Add Report</span>
            </button>
        </div>
        
        <div class="flex items-center space-x-3">
            <!-- Print Button -->
            <button onclick="handlePrint()" class="flex items-center space-x-2 bg-[#4320DF] hover:bg-[#391bc4] text-white px-4 py-2 rounded-lg font-medium text-sm shadow-xs transition cursor-pointer">
                <i class="fa-solid fa-print text-sm"></i>
                <span>Print</span>
            </button>

            <!-- PDF Button -->
            <button onclick="handleExportPDF()" class="flex items-center space-x-2 bg-[#E5252A] hover:bg-[#c91e23] text-white px-4 py-2 rounded-lg font-medium text-sm shadow-xs transition cursor-pointer">
                <i class="fa-solid fa-file-pdf text-sm"></i>
                <span>PDF</span>
            </button>

            <!-- Excel Button -->
            <button onclick="handleExportExcel()" class="flex items-center space-x-2 bg-[#107C41] hover:bg-[#0d6837] text-white px-4 py-2 rounded-lg font-medium text-sm shadow-xs transition cursor-pointer">
                <i class="fa-solid fa-file-excel text-sm"></i>
                <span>Excel</span>
            </button>
        </div>
    </div>

    <!-- 10 Report Cards Grid (5 columns on desktop x 2 rows) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4" id="reportCardsContainer">
        
        <!-- Card 1: Customer -->
        <div onclick="selectCard('customer', this)" data-category="customer" class="report-card bg-white rounded-2xl border border-gray-200 p-4 flex items-center space-x-3.5 shadow-xs hover:border-blue-400 hover:shadow-sm transition cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Clean Blue Person Silhouette -->
                <svg class="w-10 h-10 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.67 0 4.8-2.13 4.8-4.8S14.67 2.4 12 2.4 7.2 4.53 7.2 7.2 9.33 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Customer</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View Customer information</p>
            </div>
        </div>

        <!-- Card 2: Loundry Order -->
        <div onclick="selectCard('laundry_order', this)" data-category="laundry_order" class="report-card bg-white rounded-2xl border border-gray-200 p-4 flex items-center space-x-3.5 shadow-xs hover:border-blue-400 hover:shadow-sm transition cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Folded cyan laundry + pink basket + yellow sparkle -->
                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none">
                    <path d="M10 18C10 15.5 13 14 16 14H24C26.5 14 28 15.5 28 18L26 24H12L10 18Z" fill="#38BDF8"/>
                    <path d="M14 22L17 15L23 15L20 22H14Z" fill="#0EA5E9"/>
                    <path d="M28 12L29.5 8L31 12L35 13.5L31 15L29.5 19L28 15L24 13.5L28 12Z" fill="#FACC15"/>
                    <circle cx="23" cy="9" r="1.5" fill="#FDE047"/>
                    <path d="M18 24H36L34 38C34 39.5 32.5 41 31 41H23C21.5 41 20 39.5 20 38L18 24Z" fill="#F43F5E"/>
                    <path d="M22 28H32M23 32H31M24 36H30" stroke="#FFE4E6" stroke-width="1.8" stroke-linecap="round"/>
                    <path d="M16 24C16 22 18 21 21 21H33C36 21 38 22 38 24" stroke="#E11D48" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Loundry Order</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View all loundry order</p>
            </div>
        </div>

        <!-- Card 3: Daily Sale -->
        <div onclick="selectCard('daily_sale', this)" data-category="daily_sale" class="report-card bg-white rounded-2xl border border-gray-200 p-4 flex items-center space-x-3.5 shadow-xs hover:border-blue-400 hover:shadow-sm transition cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Starburst Blue SALE Badge -->
                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none">
                    <path d="M24 4L28.5 8.5L34.5 7.5L37 13.5L43 15.5L42.5 22L46.5 26.5L43 31.5L44 38L37.5 39.5L34.5 45L28.5 43.5L24 47.5L19.5 43.5L13.5 45L10.5 39.5L4 38L5 31.5L1.5 26.5L5.5 22L5 15.5L11 13.5L13.5 7.5L19.5 8.5L24 4Z" fill="#0284C7" stroke="#0369A1" stroke-width="1.5"/>
                    <text x="24" y="27.5" fill="#FFFFFF" font-size="9" font-family="Arial, sans-serif" font-weight="900" text-anchor="middle" letter-spacing="0.5">SALE</text>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Daily Sale</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View daily sale summary</p>
            </div>
        </div>

        <!-- Card 4: Monthly Sale -->
        <div onclick="selectCard('monthly_sale', this)" data-category="monthly_sale" class="report-card bg-white rounded-2xl border border-gray-200 p-4 flex items-center space-x-3.5 shadow-xs hover:border-blue-400 hover:shadow-sm transition cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Shop with Awning and SALE sign -->
                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none">
                    <path d="M8 17L12 9H36L40 17H8Z" fill="#BAE6FD"/>
                    <path d="M8 17C8 19 10 20.5 12 20.5C14 20.5 16 19 16 17C16 19 18 20.5 20 20.5C22 20.5 24 19 24 17C24 19 26 20.5 28 20.5C30 20.5 32 19 32 17C32 19 34 20.5 36 20.5C38 20.5 40 19 40 17" fill="#0284C7" stroke="#0284C7" stroke-width="1.2"/>
                    <path d="M12 9L12 17M20 9L20 17M28 9L28 17M36 9L36 17" stroke="#0284C7" stroke-width="1.2"/>
                    <rect x="10" y="20.5" width="28" height="19.5" fill="#F8FAFC" stroke="#0284C7" stroke-width="1.5"/>
                    <rect x="14" y="24" width="20" height="12" rx="2" fill="#FFFFFF" stroke="#38BDF8" stroke-width="1.2"/>
                    <text x="24" y="32.5" fill="#0284C7" font-size="8" font-family="Arial, sans-serif" font-weight="bold" text-anchor="middle">SALE</text>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Monthly Sale</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View Monthly sale summary</p>
            </div>
        </div>

        <!-- Card 5: Payment -->
        <div onclick="selectCard('payment', this)" data-category="payment" class="report-card bg-white rounded-2xl border border-gray-200 p-4 flex items-center space-x-3.5 shadow-xs hover:border-blue-400 hover:shadow-sm transition cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Purple payment card / banknote with $ and rain dashes -->
                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none">
                    <rect x="8" y="12" width="32" height="20" rx="4" fill="#C7D2FE" stroke="#6366F1" stroke-width="1.5"/>
                    <circle cx="14" cy="22" r="2" fill="#818CF8"/>
                    <circle cx="34" cy="22" r="2" fill="#818CF8"/>
                    <text x="24" y="25" fill="#4F46E5" font-size="11" font-family="Arial, sans-serif" font-weight="bold" text-anchor="middle">$</text>
                    <line x1="14" y1="36" x2="14" y2="40" stroke="#818CF8" stroke-width="2" stroke-linecap="round"/>
                    <line x1="24" y1="36" x2="24" y2="41" stroke="#818CF8" stroke-width="2" stroke-linecap="round"/>
                    <line x1="34" y1="36" x2="34" y2="39" stroke="#818CF8" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Payment</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View all payment and transaction</p>
            </div>
        </div>

        <!-- Card 6: Employee -->
        <div onclick="selectCard('employee', this)" data-category="employee" class="report-card bg-white rounded-2xl border border-gray-200 p-4 flex items-center space-x-3.5 shadow-xs hover:border-blue-400 hover:shadow-sm transition cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Person working on laptop -->
                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none">
                    <circle cx="24" cy="15" r="5" fill="#FBBF24"/>
                    <path d="M17 26C17 22.7 20.1 20 24 20C27.9 20 31 22.7 31 26V28H17V26Z" fill="#38BDF8"/>
                    <rect x="18" y="25" width="12" height="9" rx="1.5" fill="#94A3B8" stroke="#475569" stroke-width="1"/>
                    <circle cx="24" cy="29.5" r="1.2" fill="#FFFFFF"/>
                    <path d="M12 36H36L34 38H14L12 36Z" fill="#CBD5E1" stroke="#64748B" stroke-width="1"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Employee</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View employee information</p>
            </div>
        </div>

        <!-- Card 7: Inventory -->
        <div onclick="selectCard('inventory', this)" data-category="inventory" class="report-card bg-white rounded-2xl border border-gray-200 p-4 flex items-center space-x-3.5 shadow-xs hover:border-blue-400 hover:shadow-sm transition cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Clipboard with checklist & blue circular nodes -->
                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none">
                    <rect x="10" y="11" width="22" height="30" rx="3.5" stroke="#2563EB" stroke-width="2.5" fill="none"/>
                    <path d="M16 11V8C16 6.9 16.9 6 18 6H24C25.1 6 26 6.9 26 8V11" stroke="#2563EB" stroke-width="2" fill="#EFF6FF"/>
                    <line x1="15" y1="18" x2="25" y2="18" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
                    <line x1="15" y1="23" x2="22" y2="23" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
                    <line x1="15" y1="28" x2="20" y2="28" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="34" cy="27" r="4.5" fill="#3B82F6"/>
                    <circle cx="37" cy="37" r="3.5" fill="#60A5FA"/>
                    <circle cx="28" cy="37" r="3.5" fill="#2563EB"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Inventory</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View inventory and stock summary</p>
            </div>
        </div>

        <!-- Card 8: Machin Usage -->
        <div onclick="selectCard('machin_usage', this)" data-category="machin_usage" class="report-card bg-white rounded-2xl border border-gray-200 p-4 flex items-center space-x-3.5 shadow-xs hover:border-blue-400 hover:shadow-sm transition cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Front-loading washing machine -->
                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none">
                    <rect x="10" y="8" width="28" height="32" rx="4" stroke="#334155" stroke-width="2" fill="#F8FAFC"/>
                    <rect x="14" y="12" width="8" height="3.5" rx="1" fill="#94A3B8"/>
                    <circle cx="31" cy="14" r="2.5" fill="#64748B"/>
                    <circle cx="26" cy="14" r="1.5" fill="#94A3B8"/>
                    <circle cx="24" cy="27" r="9" stroke="#334155" stroke-width="2" fill="#38BDF8"/>
                    <circle cx="24" cy="27" r="6" fill="#0284C7"/>
                    <path d="M21 28C21 26 23 25 25 25C26.5 25 28 26.5 28 28" stroke="#E0F2FE" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Machin Usage</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View machin and performance</p>
            </div>
        </div>

        <!-- Card 9: Dilevery (ACTIVE / SELECTED CARD in Screenshot!) -->
        <div onclick="selectCard('delivery', this)" data-category="delivery" class="report-card bg-white rounded-2xl border-2 border-blue-500 p-4 flex items-center space-x-3.5 shadow-sm transition cursor-pointer" id="card-delivery">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Yellow & orange delivery truck with red wheels -->
                <svg class="w-12 h-12" viewBox="0 0 48 48" fill="none">
                    <rect x="10" y="16" width="18" height="15" rx="2" fill="#FACC15" stroke="#EAB308" stroke-width="1"/>
                    <path d="M28 19H34L39 25V31H28V19Z" fill="#F97316"/>
                    <path d="M30 21H33.5L37 25H30V21Z" fill="#E0F2FE"/>
                    <rect x="12" y="30" width="27" height="2" fill="#334155"/>
                    <circle cx="17" cy="33" r="3.5" fill="#1E293B"/>
                    <circle cx="17" cy="33" r="1.5" fill="#EF4444"/>
                    <circle cx="34" cy="33" r="3.5" fill="#1E293B"/>
                    <circle cx="34" cy="33" r="1.5" fill="#EF4444"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Dilevery</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View delivery and perfomance</p>
            </div>
        </div>

        <!-- Card 10: Service -->
        <div onclick="selectCard('service', this)" data-category="service" class="report-card bg-white rounded-2xl border border-gray-200 p-4 flex items-center space-x-3.5 shadow-xs hover:border-blue-400 hover:shadow-sm transition cursor-pointer">
            <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                <!-- Green rounded rectangle with 3 bullet lines -->
                <svg class="w-11 h-11" viewBox="0 0 48 48" fill="none">
                    <rect x="8" y="8" width="32" height="32" rx="10" fill="#22C55E"/>
                    <circle cx="17" cy="18" r="2" fill="#FFFFFF"/>
                    <line x1="22" y1="18" x2="33" y2="18" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="17" cy="24" r="2" fill="#FFFFFF"/>
                    <line x1="22" y1="24" x2="33" y2="24" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="17" cy="30" r="2" fill="#FFFFFF"/>
                    <line x1="22" y1="30" x2="33" y2="30" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-[15px] leading-snug">Service</h3>
                <p class="text-gray-500 text-[11px] leading-tight mt-0.5">View service and trends</p>
            </div>
        </div>

    </div>

    <!-- Section: Recent Reports Header -->
    <div class="pt-4 flex items-center justify-between">
        <h2 class="text-lg md:text-xl font-bold text-gray-800">Recent Reports</h2>
        <div class="text-xs text-gray-500" id="filterStatusBadge">
            <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-1"></span>
            Connected to MySQL Database (<span id="dbRecordCount">{{ $totalItems ?? 25 }}</span> stored)
        </div>
    </div>

    <!-- Recent Reports Table Container -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xs" id="printableTable">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 bg-[#F8FAFC] text-gray-700 font-semibold text-sm">
                        <th class="py-3.5 px-6 font-semibold">Report Name</th>
                        <th class="py-3.5 px-6 font-semibold">Type</th>
                        <th class="py-3.5 px-6 font-semibold">Date</th>
                        <th class="py-3.5 px-6 font-semibold">Generated By</th>
                        <th class="py-3.5 px-6 font-semibold">Generated On</th>
                        <th class="py-3.5 px-6 font-semibold text-right sm:text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700 font-normal" id="reportsTableBody">
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50/70 transition report-row" id="report-row-{{ $report->id }}">
                        <!-- Report Name -->
                        <td class="py-4 px-6 font-normal text-gray-800 report-name-cell">{{ $report->name }}</td>
                        <!-- Type -->
                        <td class="py-4 px-6 text-gray-700 report-type-cell">{{ $report->type }}</td>
                        <!-- Date -->
                        <td class="py-4 px-6 text-gray-700 report-date-cell">{{ $report->date }}</td>
                        <!-- Generated By -->
                        <td class="py-4 px-6 text-gray-700">{{ $report->generated_by }}</td>
                        <!-- Generated On -->
                        <td class="py-4 px-6 text-gray-700">{{ $report->generated_on }}</td>
                        <!-- Action Buttons -->
                        <td class="py-4 px-6 text-right sm:text-center">
                            <div class="flex items-center justify-end sm:justify-center space-x-2">
                                <!-- View / Eye Button -->
                                <button onclick="viewReport({{ $report->id }}, '{{ addslashes($report->name) }}', '{{ addslashes($report->type) }}', '{{ addslashes($report->date) }}', '{{ addslashes($report->generated_by) }}', '{{ addslashes($report->generated_on) }}', '{{ addslashes($report->description ?? '') }}')" class="w-8 h-8 rounded-lg border border-gray-300 bg-white flex items-center justify-center text-gray-800 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-400 transition shadow-2xs cursor-pointer" title="View Report">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </button>
                                <!-- Edit / Pen Button -->
                                <button onclick="editReport({{ $report->id }}, '{{ addslashes($report->name) }}', '{{ addslashes($report->type) }}', '{{ addslashes($report->date) }}', '{{ addslashes($report->description ?? '') }}')" class="w-8 h-8 rounded-lg border border-gray-300 bg-white flex items-center justify-center text-gray-800 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-400 transition shadow-2xs cursor-pointer" title="Edit Report">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>
                                <!-- Delete / Trash Button -->
                                <button onclick="confirmDeleteReport({{ $report->id }}, '{{ addslashes($report->name) }}')" class="w-8 h-8 rounded-lg border border-gray-300 bg-white flex items-center justify-center text-gray-800 hover:bg-red-50 hover:text-red-600 hover:border-red-400 transition shadow-2xs cursor-pointer" title="Delete Report">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400">No reports found in MySQL database.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar matching screenshot design -->
        <div class="p-4 border-t border-gray-200 flex flex-wrap items-center justify-between gap-4 bg-white">
            <!-- Items count indicator matching screenshot -->
            <div class="text-blue-500 font-medium text-sm" id="paginationInfo">
                Showing 1 to {{ count($reports) }} of {{ $totalItems ?? 25 }} items
            </div>

            <!-- Page Nav Buttons -->
            <div class="flex items-center space-x-2" id="paginationNav">
                <!-- Previous Button -->
                <button onclick="changePage('prev')" id="btn-prev" class="flex items-center space-x-1.5 px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition shadow-2xs cursor-pointer">
                    <i class="fa-solid fa-angle-left text-xs"></i>
                    <span>Previous</span>
                </button>

                <!-- Dynamic / Default Number Buttons (1 to 5) -->
                <button onclick="changePage(1)" id="page-1" class="page-num-btn w-9 h-8 rounded-lg bg-blue-600 text-white font-bold text-sm flex items-center justify-center shadow-xs transition cursor-pointer">1</button>
                <button onclick="changePage(2)" id="page-2" class="page-num-btn w-9 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer">2</button>
                <button onclick="changePage(3)" id="page-3" class="page-num-btn w-9 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer">3</button>
                <button onclick="changePage(4)" id="page-4" class="page-num-btn w-9 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer">4</button>
                <button onclick="changePage(5)" id="page-5" class="page-num-btn w-9 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer">5</button>

                <!-- Next Button -->
                <button onclick="changePage('next')" id="btn-next" class="flex items-center space-x-1.5 px-3 py-1.5 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition shadow-2xs cursor-pointer">
                    <span>Next</span>
                    <i class="fa-solid fa-angle-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>

</div>

<!-- View Report Modal -->
<div id="viewModal" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-blue-50/50">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-base" id="viewModalTitle">Report Details</h3>
            </div>
            <button onclick="closeModal('viewModal')" class="text-gray-400 hover:text-gray-600 p-1 cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-6 space-y-4 text-sm">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-gray-400 text-xs uppercase font-bold block">Report Name</span>
                    <span class="font-semibold text-gray-800 text-base" id="viewReportName">-</span>
                </div>
                <div>
                    <span class="text-gray-400 text-xs uppercase font-bold block">Report Type</span>
                    <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 mt-1" id="viewReportType">Status</span>
                </div>
                <div>
                    <span class="text-gray-400 text-xs uppercase font-bold block">Report Date</span>
                    <span class="text-gray-700 font-medium" id="viewReportDate">-</span>
                </div>
                <div>
                    <span class="text-gray-400 text-xs uppercase font-bold block">Generated By</span>
                    <span class="text-gray-700 font-medium" id="viewGeneratedBy">-</span>
                </div>
                <div class="col-span-2">
                    <span class="text-gray-400 text-xs uppercase font-bold block">Generated On</span>
                    <span class="text-gray-700 font-medium" id="viewGeneratedOn">-</span>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <span class="text-xs font-bold text-gray-500 uppercase block mb-1">Executive Summary</span>
                <p class="text-xs text-gray-600 leading-relaxed" id="viewSummary">
                    This analytical report contains aggregated transactional records, operation volume metrics, and status performance benchmarks for the selected operating cycle.
                </p>
            </div>
        </div>
        <div class="px-6 py-3.5 bg-gray-50 border-t border-gray-100 flex items-center justify-end space-x-2">
            <button onclick="handlePrintSingle()" class="px-3.5 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-medium hover:bg-indigo-700 transition flex items-center space-x-1.5 cursor-pointer">
                <i class="fa-solid fa-print"></i>
                <span>Print Copy</span>
            </button>
            <button onclick="closeModal('viewModal')" class="px-4 py-1.5 bg-white border border-gray-300 text-gray-700 rounded-lg text-xs font-medium hover:bg-gray-100 transition cursor-pointer">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Edit Report Modal -->
<div id="editModal" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-amber-50/50">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-pen text-xs"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-base">Edit Report in MySQL</h3>
            </div>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 p-1 cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="editReportForm" onsubmit="saveReportEdit(event)" class="p-6 space-y-4">
            <input type="hidden" id="editReportId">
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Report Name</label>
                <input type="text" id="editInputName" required class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Report Type</label>
                <input type="text" id="editInputType" required class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Date</label>
                <input type="text" id="editInputDate" required class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Description / Notes</label>
                <textarea id="editInputDescription" rows="2" class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></textarea>
            </div>
            <div class="flex items-center justify-end space-x-2 pt-2 border-t border-gray-100">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition cursor-pointer">Cancel</button>
                <button type="submit" id="btnSaveEdit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition cursor-pointer flex items-center space-x-1.5">
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add / Generate Report Modal -->
<div id="generateModal" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-blue-50/50">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-plus text-xs"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-base">Add / Generate Report</h3>
            </div>
            <button onclick="closeModal('generateModal')" class="text-gray-400 hover:text-gray-600 p-1 cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form id="generateReportForm" onsubmit="saveNewReport(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Report Category</label>
                <select id="newReportCategory" onchange="onCategorySelectChange()" class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                    <option value="daily_sale">Daily Sale</option>
                    <option value="monthly_sale">Monthly Sale</option>
                    <option value="customer">Customer</option>
                    <option value="laundry_order">Loundry Order</option>
                    <option value="payment">Payment</option>
                    <option value="employee">Employee</option>
                    <option value="inventory">Inventory</option>
                    <option value="machin_usage">Machin Usage</option>
                    <option value="delivery" selected>Dilevery</option>
                    <option value="service">Service</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Report Name</label>
                <input type="text" id="newReportName" value="Delivery Performance & Route Report" required class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Report Type</label>
                    <input type="text" id="newReportType" value="Logistics" required class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Date</label>
                    <input type="text" id="newReportDate" value="{{ date('d/M/y') }}" required class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Summary / Description</label>
                <textarea id="newReportDescription" rows="2" class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Operational analysis summary..."></textarea>
            </div>
            <div class="flex items-center justify-end space-x-2 pt-2 border-t border-gray-100">
                <button type="button" onclick="closeModal('generateModal')" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition cursor-pointer">Cancel</button>
                <button type="submit" id="btnSubmitGenerate" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition cursor-pointer flex items-center space-x-1.5">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Generate & Save in MySQL</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Notification Toast -->
<div id="toastNotification" class="fixed bottom-6 right-6 z-50 bg-gray-900 text-white px-4 py-3 rounded-xl shadow-xl flex items-center space-x-3 text-sm hidden transition-all duration-300">
    <i class="fa-solid fa-circle-check text-green-400" id="toastIcon"></i>
    <span id="toastMessage">Action completed successfully.</span>
</div>

@push('scripts')
<script>
    // Global state
    let currentCategory = 'delivery'; // Default active card in screenshot
    let currentPage = {{ $currentPage ?? 1 }};
    const itemsPerPage = 6;
    let totalItems = {{ $totalItems ?? 25 }};

    // Category naming templates for quick generate
    const categoryTemplates = {
        'customer': { name: 'Customer Activity & Growth Report', type: 'Customer' },
        'laundry_order': { name: 'Laundry Order Pipeline & Turnaround', type: 'Orders' },
        'daily_sale': { name: 'Daily Sale Summary Report', type: 'Status' },
        'monthly_sale': { name: 'Monthly Revenue & Margin Analysis', type: 'Financial' },
        'payment': { name: 'Payment Transactions & Reconciliation', type: 'Payment' },
        'employee': { name: 'Employee Attendance & Shift Hours', type: 'HR' },
        'inventory': { name: 'Detergent & Supplies Stock Audit', type: 'Inventory' },
        'machin_usage': { name: 'Washing Machine Runtime & Maintenance', type: 'Machinery' },
        'delivery': { name: 'Delivery Route Logistics & On-Time Rate', type: 'Logistics' },
        'service': { name: 'Service Demand & Dry Cleaning Trends', type: 'Service' }
    };

    // Card selection (highlighting card & filtering table from MySQL backend)
    function selectCard(category, cardElement) {
        document.querySelectorAll('.report-card').forEach(c => {
            c.classList.remove('border-2', 'border-blue-500');
            c.classList.add('border', 'border-gray-200');
        });

        cardElement.classList.remove('border', 'border-gray-200');
        cardElement.classList.add('border-2', 'border-blue-500');

        currentCategory = category;
        currentPage = 1;

        // Fetch filtered data from Laravel backend / MySQL
        fetchReports(category, currentPage);

        const cardTitle = cardElement.querySelector('h3').innerText;
        showToast(`Category selected: ${cardTitle}`);
    }

    // Fetch reports from Laravel backend
    async function fetchReports(category = null, page = 1) {
        try {
            const url = new URL('{{ route("reports.index") }}', window.location.origin);
            url.searchParams.set('page', page);
            if (category && category !== 'all') {
                url.searchParams.set('filter_category', category);
            }

            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Network error loading reports');

            const res = await response.json();
            if (res.success) {
                renderTableRows(res.data);
                updatePaginationUI(res.pagination);
            }
        } catch (err) {
            console.warn('Falling back or updating page:', err);
        }
    }

    // Render table rows dynamically from MySQL data
    function renderTableRows(reports) {
        const tbody = document.getElementById('reportsTableBody');
        tbody.innerHTML = '';

        if (!reports || reports.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="py-8 text-center text-gray-400">No reports found for this selection.</td></tr>`;
            return;
        }

        reports.forEach(r => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50/70 transition report-row';
            tr.id = `report-row-${r.id}`;

            const escapedName = escapeHtml(r.name);
            const escapedType = escapeHtml(r.type);
            const escapedDate = escapeHtml(r.date);
            const escapedBy = escapeHtml(r.generated_by);
            const escapedOn = escapeHtml(r.generated_on);
            const escapedDesc = escapeHtml(r.description || '');

            tr.innerHTML = `
                <td class="py-4 px-6 font-normal text-gray-800 report-name-cell">${escapedName}</td>
                <td class="py-4 px-6 text-gray-700 report-type-cell">${escapedType}</td>
                <td class="py-4 px-6 text-gray-700 report-date-cell">${escapedDate}</td>
                <td class="py-4 px-6 text-gray-700">${escapedBy}</td>
                <td class="py-4 px-6 text-gray-700">${escapedOn}</td>
                <td class="py-4 px-6 text-right sm:text-center">
                    <div class="flex items-center justify-end sm:justify-center space-x-2">
                        <button onclick="viewReport(${r.id}, '${escapedName}', '${escapedType}', '${escapedDate}', '${escapedBy}', '${escapedOn}', '${escapedDesc}')" class="w-8 h-8 rounded-lg border border-gray-300 bg-white flex items-center justify-center text-gray-800 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-400 transition shadow-2xs cursor-pointer" title="View Report">
                            <i class="fa-regular fa-eye text-xs"></i>
                        </button>
                        <button onclick="editReport(${r.id}, '${escapedName}', '${escapedType}', '${escapedDate}', '${escapedDesc}')" class="w-8 h-8 rounded-lg border border-gray-300 bg-white flex items-center justify-center text-gray-800 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-400 transition shadow-2xs cursor-pointer" title="Edit Report">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </button>
                        <button onclick="confirmDeleteReport(${r.id}, '${escapedName}')" class="w-8 h-8 rounded-lg border border-gray-300 bg-white flex items-center justify-center text-gray-800 hover:bg-red-50 hover:text-red-600 hover:border-red-400 transition shadow-2xs cursor-pointer" title="Delete Report">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Update pagination indicator & buttons
    function updatePaginationUI(p) {
        if (!p) return;
        currentPage = p.current_page;
        totalItems = p.total;

        document.getElementById('paginationInfo').innerText = `Showing ${p.from || 0} to ${p.to || 0} of ${p.total} items`;
        document.getElementById('dbRecordCount').innerText = p.total;

        // Update active page buttons
        for (let i = 1; i <= 5; i++) {
            const btn = document.getElementById(`page-${i}`);
            if (btn) {
                if (i === currentPage) {
                    btn.className = "page-num-btn w-9 h-8 rounded-lg bg-blue-600 text-white font-bold text-sm flex items-center justify-center shadow-xs transition cursor-pointer";
                } else {
                    btn.className = "page-num-btn w-9 h-8 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 flex items-center justify-center transition shadow-2xs cursor-pointer";
                }
            }
        }
    }

    // Page navigation
    function changePage(page) {
        let target = currentPage;
        if (page === 'prev') {
            if (currentPage > 1) target = currentPage - 1;
        } else if (page === 'next') {
            if (currentPage < 5) target = currentPage + 1;
        } else {
            target = parseInt(page);
        }

        currentPage = target;
        fetchReports(currentCategory, currentPage);
    }

    // 1. VIEW REPORT FUNCTION
    function viewReport(id, name, type, date, by, on, desc) {
        document.getElementById('viewReportName').innerText = name;
        document.getElementById('viewReportType').innerText = type;
        document.getElementById('viewReportDate').innerText = date;
        document.getElementById('viewGeneratedBy').innerText = by;
        document.getElementById('viewGeneratedOn').innerText = on;
        document.getElementById('viewSummary').innerText = desc || `Analytical status and performance report generated from operational database logs for ${date}.`;
        document.getElementById('viewModal').classList.remove('hidden');
    }

    // 2. ADD / GENERATE REPORT FUNCTION
    function openGenerateModal(category = null) {
        if (category) {
            document.getElementById('newReportCategory').value = category;
        }
        onCategorySelectChange();
        document.getElementById('generateModal').classList.remove('hidden');
    }

    function onCategorySelectChange() {
        const cat = document.getElementById('newReportCategory').value;
        const template = categoryTemplates[cat] || { name: 'Standard Operation Report', type: 'Status' };
        document.getElementById('newReportName').value = template.name;
        document.getElementById('newReportType').value = template.type;
    }

    async function saveNewReport(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmitGenerate');
        btn.disabled = true;
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Saving...</span>`;

        const name = document.getElementById('newReportName').value;
        const category = document.getElementById('newReportCategory').value;
        const type = document.getElementById('newReportType').value;
        const date = document.getElementById('newReportDate').value;
        const description = document.getElementById('newReportDescription').value;

        try {
            const response = await fetch('{{ route("reports.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, category, type, date, description })
            });

            const res = await response.json();
            if (res.success) {
                closeModal('generateModal');
                showToast('Report generated & saved permanently in MySQL!');
                fetchReports(currentCategory, 1);
            } else {
                alert(res.message || 'Error generating report');
            }
        } catch (err) {
            console.error('Error:', err);
            alert('Failed to save to database. Please check connection.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = `<i class="fa-solid fa-floppy-disk text-xs"></i> <span>Generate & Save in MySQL</span>`;
        }
    }

    // 3. EDIT REPORT FUNCTION
    function editReport(id, name, type, date, desc) {
        document.getElementById('editReportId').value = id;
        document.getElementById('editInputName').value = name;
        document.getElementById('editInputType').value = type;
        document.getElementById('editInputDate').value = date;
        document.getElementById('editInputDescription').value = desc || '';
        document.getElementById('editModal').classList.remove('hidden');
    }

    async function saveReportEdit(e) {
        e.preventDefault();
        const id = document.getElementById('editReportId').value;
        const name = document.getElementById('editInputName').value;
        const type = document.getElementById('editInputType').value;
        const date = document.getElementById('editInputDate').value;
        const description = document.getElementById('editInputDescription').value;

        const btn = document.getElementById('btnSaveEdit');
        btn.disabled = true;
        btn.innerText = 'Saving...';

        try {
            const updateUrl = `{{ url('reports') }}/${id}`;
            const response = await fetch(updateUrl, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, type, date, description })
            });

            const res = await response.json();
            if (res.success) {
                closeModal('editModal');
                showToast('Report updated permanently in MySQL database!');

                // Instantly update current row in DOM
                const row = document.getElementById(`report-row-${id}`);
                if (row) {
                    row.querySelector('.report-name-cell').innerText = name;
                    row.querySelector('.report-type-cell').innerText = type;
                    row.querySelector('.report-date-cell').innerText = date;
                }
            } else {
                alert(res.message || 'Error updating report');
            }
        } catch (err) {
            console.error('Update error:', err);
            alert('Error updating report in database.');
        } finally {
            btn.disabled = false;
            btn.innerText = 'Save Changes';
        }
    }

    // 4. DELETE REPORT FUNCTION
    async function confirmDeleteReport(id, name) {
        if (!confirm(`Are you sure you want to permanently delete "${name}" from MySQL database?`)) {
            return;
        }

        try {
            const deleteUrl = `{{ url('reports') }}/${id}`;
            const response = await fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const res = await response.json();
            if (res.success) {
                showToast('Report deleted permanently from MySQL database!');
                // Remove row with smooth fade
                const row = document.getElementById(`report-row-${id}`);
                if (row) {
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 250);
                }
                fetchReports(currentCategory, currentPage);
            } else {
                alert(res.message || 'Error deleting report');
            }
        } catch (err) {
            console.error('Delete error:', err);
            alert('Error deleting record from MySQL.');
        }
    }

    // 5. PRINT REPORT FUNCTION
    function handlePrint() {
        const printUrl = `{{ route('reports.print') }}?category=${currentCategory}`;
        const printWindow = window.open(printUrl, '_blank');
        if (!printWindow) {
            window.print();
        }
    }

    function handlePrintSingle() {
        window.print();
    }

    // 6. EXPORT REPORT TO PDF
    function handleExportPDF() {
        showToast('Exporting Report to PDF...');
        const pdfUrl = `{{ route('reports.export', 'pdf') }}?category=${currentCategory}`;
        window.open(pdfUrl, '_blank');
    }

    // 7. EXPORT REPORT TO EXCEL
    function handleExportExcel() {
        showToast('Exporting Report to Excel...');
        const excelUrl = `{{ route('reports.export', 'excel') }}?category=${currentCategory}`;
        window.location.href = excelUrl;
    }

    // Modal Helpers
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function showToast(msg) {
        const toast = document.getElementById('toastNotification');
        const text = document.getElementById('toastMessage');
        text.innerText = msg;
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3200);
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text.replace(/'/g, "\\'").replace(/"/g, "&quot;");
    }

    document.addEventListener("DOMContentLoaded", function () {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>

<style>
    @media print {
        aside, header, #reportCardsContainer, .flex.items-center.space-x-3 button, #paginationInfo, .flex.items-center.space-x-2, #toastNotification, #filterStatusBadge {
            display: none !important;
        }
        main {
            padding: 0 !important;
        }
        #printableTable {
            border: none !important;
            box-shadow: none !important;
        }
        th:last-child, td:last-child {
            display: none !important;
        }
    }
</style>
@endpush
@endsection
