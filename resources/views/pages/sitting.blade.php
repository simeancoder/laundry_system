@extends('layouts.navbar')

@section('content')
<div class="space-y-6 max-w-[1400px] mx-auto pb-12">

    <!-- Flash message -->
    <div id="settingsToast" class="hidden p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-sm animate-fade-in">
        <div class="flex items-center space-x-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
            <span class="font-medium" id="settingsToastMsg">Settings updated successfully!</span>
        </div>
        <button onclick="document.getElementById('settingsToast').classList.add('hidden')" class="text-emerald-600 hover:text-emerald-800 text-base leading-none">&times;</button>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">System Settings</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Configure laundry shop preferences, pricing defaults, and machine monitoring parameters.</p>
        </div>
        <div>
            <button onclick="saveAllSettings()" class="bg-[#2042E3] hover:bg-[#1A38C2] text-white px-5 py-2.5 rounded-xl font-semibold text-sm flex items-center space-x-2 shadow-sm transition active:scale-[0.98] cursor-pointer">
                <i class="fa-solid fa-floppy-disk text-sm"></i>
                <span>Save All Settings (OK)</span>
            </button>
        </div>
    </div>

    <!-- Settings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Navigation Tabs -->
        <div class="lg:col-span-4 xl:col-span-3 space-y-2">
            <div class="bg-white rounded-2xl border border-gray-200 p-3 shadow-xs">
                <nav class="space-y-1">
                    <button onclick="showSettingsTab('general', this)" class="settings-nav-btn w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition bg-blue-50 text-blue-700">
                        <i class="fa-solid fa-store w-5 text-center"></i>
                        <span>Shop Profile</span>
                    </button>
                    <button onclick="showSettingsTab('machines', this)" class="settings-nav-btn w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                        <i class="fa-solid fa-washing-machine w-5 text-center"></i>
                        <span>Machine & Operations</span>
                    </button>
                    <button onclick="showSettingsTab('promotions', this)" class="settings-nav-btn w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                        <i class="fa-solid fa-tags w-5 text-center"></i>
                        <span>Pricing & Discounts</span>
                    </button>
                    <button onclick="showSettingsTab('notifications', this)" class="settings-nav-btn w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                        <i class="fa-solid fa-bell w-5 text-center"></i>
                        <span>Notifications & Alerts</span>
                    </button>
                </nav>
            </div>

            <!-- Quick Links Card -->
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-2xl p-5 shadow-sm">
                <h4 class="font-bold text-sm">Laundry 6 Plus System</h4>
                <p class="text-xs text-blue-100 mt-1">Enterprise Laundry Management v2.4</p>
                <div class="mt-4 pt-3 border-t border-white/20 flex items-center justify-between text-xs text-blue-100">
                    <span>Server Status</span>
                    <span class="inline-flex items-center text-emerald-300 font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span> Online
                    </span>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings Content Panels -->
        <div class="lg:col-span-8 xl:col-span-9">

            <!-- Panel 1: General Shop Profile -->
            <div id="panel-general" class="settings-panel bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-900">Shop Profile &amp; Contact</h3>
                    <p class="text-xs text-gray-500">Business identity displayed on receipts, invoices, and customer alerts.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Business / Store Name</label>
                        <input type="text" id="storeName" value="Laundry 6 Plus" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Hotline / Phone Number</label>
                        <input type="text" id="storePhone" value="+855 12 345 678" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Support Email</label>
                        <input type="email" id="storeEmail" value="support@laundry6plus.com" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Operating Hours</label>
                        <input type="text" id="storeHours" value="07:00 AM - 09:00 PM (Daily)" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Store Address</label>
                        <input type="text" id="storeAddress" value="No. 128, Street 51, BKK1, Phnom Penh, Cambodia" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button onclick="saveAllSettings()" class="bg-[#2042E3] hover:bg-[#1A38C2] text-white px-5 py-2 rounded-xl text-xs font-semibold shadow-sm transition cursor-pointer">
                        Save Profile (OK)
                    </button>
                </div>
            </div>

            <!-- Panel 2: Machine & Operations Settings -->
            <div id="panel-machines" class="settings-panel hidden bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-900">Machine &amp; Operations Defaults</h3>
                    <p class="text-xs text-gray-500">Configure machine monitoring thresholds, default cycle durations, and safety limits.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Standard Wash Duration (Minutes)</label>
                        <input type="number" id="washDuration" value="45" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Standard Dry Duration (Minutes)</label>
                        <input type="number" id="dryDuration" value="35" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Max Temp Alert (°C)</label>
                        <input type="number" id="maxTemp" value="75" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Maintenance Reminder Interval (Cycles)</label>
                        <input type="number" id="maintenanceInterval" value="500" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button onclick="saveAllSettings()" class="bg-[#2042E3] hover:bg-[#1A38C2] text-white px-5 py-2 rounded-xl text-xs font-semibold shadow-sm transition cursor-pointer">
                        Save Machine Settings (OK)
                    </button>
                </div>
            </div>

            <!-- Panel 3: Pricing & Discounts Settings -->
            <div id="panel-promotions" class="settings-panel hidden bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-900">Pricing, Currency &amp; Discounts</h3>
                    <p class="text-xs text-gray-500">Currency symbols, standard tax rate, and promotion policy defaults.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Currency Code &amp; Symbol</label>
                        <select id="currencyCode" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="USD" selected>USD ($) - US Dollar</option>
                            <option value="KHR">KHR (៛) - Khmer Riel</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Standard VAT / Tax Rate (%)</label>
                        <input type="number" id="taxRate" value="0.00" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Max Stackable Promotions</label>
                        <input type="number" id="maxPromoStack" value="1" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Auto-Apply New Customer Discount</label>
                        <select id="autoWelcomeDiscount" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="1" selected>Enabled (NEWCLEAN10)</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                </div>

                <div class="p-4 bg-blue-50/60 rounded-xl border border-blue-100 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-xs text-blue-900">Manage Machine Discounts &amp; Promo Codes</h4>
                        <p class="text-[11px] text-blue-700 mt-0.5">Create vouchers, set percentage discounts, or schedule seasonal campaigns.</p>
                    </div>
                    <a href="{{ route('machines.index') }}#discountsPromotionsSection" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition shadow-xs">
                        Open Promo Dashboard &rarr;
                    </a>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button onclick="saveAllSettings()" class="bg-[#2042E3] hover:bg-[#1A38C2] text-white px-5 py-2 rounded-xl text-xs font-semibold shadow-sm transition cursor-pointer">
                        Save Pricing (OK)
                    </button>
                </div>
            </div>

            <!-- Panel 4: Notifications Settings -->
            <div id="panel-notifications" class="settings-panel hidden bg-white rounded-2xl border border-gray-200 p-6 shadow-xs space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="text-lg font-bold text-gray-900">Automated Alerts &amp; Notifications</h3>
                    <p class="text-xs text-gray-500">Configure real-time notifications for order completion, machine repairs, and discounts.</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 border border-gray-100">
                        <div>
                            <p class="font-semibold text-xs text-gray-800">Order Completed SMS / Telegram</p>
                            <p class="text-[11px] text-gray-500">Send automatic pickup notification when laundry status reaches 'Ready for Pickup'.</p>
                        </div>
                        <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                    </div>
                    <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 border border-gray-100">
                        <div>
                            <p class="font-semibold text-xs text-gray-800">Machine Maintenance Warning</p>
                            <p class="text-[11px] text-gray-500">Trigger immediate dashboard alert if motor health falls below 80% or temperature exceeds 70°C.</p>
                        </div>
                        <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                    </div>
                    <div class="flex items-center justify-between p-3.5 rounded-xl bg-gray-50 border border-gray-100">
                        <div>
                            <p class="font-semibold text-xs text-gray-800">Promotional Broadcasts</p>
                            <p class="text-[11px] text-gray-500">Enable promotional banner popups on customer payment receipt screens.</p>
                        </div>
                        <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button onclick="saveAllSettings()" class="bg-[#2042E3] hover:bg-[#1A38C2] text-white px-5 py-2 rounded-xl text-xs font-semibold shadow-sm transition cursor-pointer">
                        Save Notifications (OK)
                    </button>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Modal: Save Confirmation OK -->
<div id="saveSuccessModal" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl animate-in fade-in zoom-in-95 duration-150">
        <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fa-solid fa-check"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900">Settings Saved!</h3>
        <p class="text-xs text-gray-500 mt-1">All your store preferences and machine configurations have been updated successfully.</p>
        <div class="mt-5">
            <button onclick="closeSaveSuccessModal()" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm shadow-sm transition cursor-pointer">
                OK
            </button>
        </div>
    </div>
</div>

<script>
    function showSettingsTab(tabName, btn) {
        document.querySelectorAll('.settings-panel').forEach(p => p.classList.add('hidden'));
        const panel = document.getElementById('panel-' + tabName);
        if (panel) panel.classList.remove('hidden');

        document.querySelectorAll('.settings-nav-btn').forEach(b => {
            b.className = 'settings-nav-btn w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition';
        });
        btn.className = 'settings-nav-btn w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-semibold transition bg-blue-50 text-blue-700';
    }

    function saveAllSettings() {
        const modal = document.getElementById('saveSuccessModal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeSaveSuccessModal() {
        const modal = document.getElementById('saveSuccessModal');
        if (modal) modal.classList.add('hidden');
        const toast = document.getElementById('settingsToast');
        if (toast) {
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3500);
        }
    }
</script>
@endsection
