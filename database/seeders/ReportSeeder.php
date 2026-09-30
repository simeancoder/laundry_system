<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reports = [
            // Delivery Category (Default active in screenshot)
            [
                'name' => 'Weekly Delivery Route Efficiency',
                'category' => 'delivery',
                'type' => 'Logistics',
                'date' => '25/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '25/Sep/26 10:30 AM',
                'description' => 'Analysis of route coverage, dispatch delays, driver assignments and vehicle fuel efficiency.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Express Same-Day Delivery Audit',
                'category' => 'delivery',
                'type' => 'Performance',
                'date' => '24/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '24/Sep/26 04:15 PM',
                'description' => 'Review of premium express order deliveries, customer handoff signatures, and satisfaction scores.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Driver Performance & Drop-off Logs',
                'category' => 'delivery',
                'type' => 'Dispatch',
                'date' => '22/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '22/Sep/26 09:00 AM',
                'description' => 'Log of pickups and deliveries handled by delivery drivers Soum Rern and team.',
                'status' => 'Completed',
            ],

            // Customer Category
            [
                'name' => 'Monthly Customer Retention & Growth',
                'category' => 'customer',
                'type' => 'Growth',
                'date' => '23/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '23/Sep/26 11:00 AM',
                'description' => 'Evaluation of regular versus new client visits, loyalty points redemption and referral rates.',
                'status' => 'Completed',
            ],
            [
                'name' => 'VIP Accounts & Corporate Orders',
                'category' => 'customer',
                'type' => 'Corporate',
                'date' => '20/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '20/Sep/26 02:45 PM',
                'description' => 'Audit of hotel, gym, and restaurant B2B bulk contracts and monthly settlement status.',
                'status' => 'Completed',
            ],

            // Laundry Order Category
            [
                'name' => 'Wash & Fold Daily Order Pipeline',
                'category' => 'laundry_order',
                'type' => 'Operational',
                'date' => '25/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '25/Sep/26 08:30 AM',
                'description' => 'Volume of clothes received, sorted, in wash, drying, ironed, and ready for pickup.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Dry Cleaning Volume & Stain Treatment Log',
                'category' => 'laundry_order',
                'type' => 'Quality',
                'date' => '21/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '21/Sep/26 01:20 PM',
                'description' => 'Delicate fabric care reports, solvent usage, and customer special-request tracking.',
                'status' => 'Completed',
            ],

            // Daily Sale Category
            [
                'name' => 'Daily Sales & Cash Drawer Reconciliation',
                'category' => 'daily_sale',
                'type' => 'Financial',
                'date' => '25/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '25/Sep/26 07:00 PM',
                'description' => 'Breakdown of counter cash payments, QR KHQR transfers, and credit card settlements.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Peak Hours Sales Distribution',
                'category' => 'daily_sale',
                'type' => 'Analytics',
                'date' => '24/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '24/Sep/26 08:15 PM',
                'description' => 'Hourly revenue peaks identifying busiest customer drop-off windows.',
                'status' => 'Completed',
            ],

            // Monthly Sale Category
            [
                'name' => 'Monthly Revenue & Margin Analysis',
                'category' => 'monthly_sale',
                'type' => 'Financial',
                'date' => '01/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '01/Sep/26 09:30 AM',
                'description' => 'Comprehensive monthly income, cost of goods sold, profit margins and year-over-year growth.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Q3 Revenue Forecast vs Actuals',
                'category' => 'monthly_sale',
                'type' => 'Executive',
                'date' => '15/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '15/Sep/26 10:00 AM',
                'description' => 'Quarterly progress toward annual revenue targets across standard and express services.',
                'status' => 'Completed',
            ],

            // Payment Category
            [
                'name' => 'Payment Gateway & Electronic Settlements',
                'category' => 'payment',
                'type' => 'Audit',
                'date' => '24/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '24/Sep/26 03:00 PM',
                'description' => 'ABA PAY, Wing, and card transaction settlement audits and fee summaries.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Outstanding Customer Balances & Invoices',
                'category' => 'payment',
                'type' => 'Receivables',
                'date' => '22/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '22/Sep/26 11:30 AM',
                'description' => 'Unpaid invoices and pending pay-on-pickup laundry packages.',
                'status' => 'Completed',
            ],

            // Employee Category
            [
                'name' => 'Staff Attendance & Shift Hours Report',
                'category' => 'employee',
                'type' => 'HR',
                'date' => '25/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '25/Sep/26 09:45 AM',
                'description' => 'Bi-weekly attendance log, overtime calculations, and leave records for laundry staff.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Operator Productivity & Turnaround Time',
                'category' => 'employee',
                'type' => 'Productivity',
                'date' => '21/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '21/Sep/26 05:00 PM',
                'description' => 'Garments processed per operator per hour in wash, iron, and packaging zones.',
                'status' => 'Completed',
            ],

            // Inventory Category
            [
                'name' => 'Detergent & Chemical Supplies Stock Audit',
                'category' => 'inventory',
                'type' => 'Inventory',
                'date' => '23/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '23/Sep/26 04:30 PM',
                'description' => 'Current inventory levels for liquid detergent, fabric softener, bleach, and packaging bags.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Supplier Reorder Recommendations',
                'category' => 'inventory',
                'type' => 'Procurement',
                'date' => '19/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '19/Sep/26 01:15 PM',
                'description' => 'Items reaching minimum safety thresholds and purchase orders prepared for approval.',
                'status' => 'Completed',
            ],

            // Machine Usage Category
            [
                'name' => 'Washing Machine Runtime & Health Monitoring',
                'category' => 'machin_usage',
                'type' => 'Machinery',
                'date' => '24/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '24/Sep/26 02:00 PM',
                'description' => 'Total cycle counts, motor temperature, vibration diagnostics, and filter maintenance.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Commercial Dryers Energy Consumption Report',
                'category' => 'machin_usage',
                'type' => 'Utilities',
                'date' => '20/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '20/Sep/26 10:45 AM',
                'description' => 'Kilowatt-hour usage and gas consumption tracking across industrial drying units.',
                'status' => 'Completed',
            ],

            // Service Category
            [
                'name' => 'Service Demand & Package Popularity Trends',
                'category' => 'service',
                'type' => 'Marketing',
                'date' => '23/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '23/Sep/26 03:30 PM',
                'description' => 'Order distribution across Wash & Fold, Ironing, Dry Cleaning, and Express packages.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Seasonal Fabric & Bedding Cleaning Demand',
                'category' => 'service',
                'type' => 'Trends',
                'date' => '18/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '18/Sep/26 11:15 AM',
                'description' => 'Volume changes in comforter, blanket, curtain, and heavy winter coat servicing.',
                'status' => 'Completed',
            ],

            // Additional Delivery & General Reports to ensure rich pagination
            [
                'name' => 'Zone B Weekend Pickup Schedule Review',
                'category' => 'delivery',
                'type' => 'Logistics',
                'date' => '17/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '17/Sep/26 04:00 PM',
                'description' => 'Weekend volume analysis and proposed courier shifts for Zone B residential towers.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Delayed Orders Root-Cause Analysis',
                'category' => 'delivery',
                'type' => 'Quality',
                'date' => '16/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '16/Sep/26 09:15 AM',
                'description' => 'Incident analysis of weather delays, traffic bottlenecks, and customer reschedule requests.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Monthly Customer Feedback & Satisfaction Index',
                'category' => 'customer',
                'type' => 'Survey',
                'date' => '15/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '15/Sep/26 02:00 PM',
                'description' => 'Compilation of 5-star ratings, fragrance preferences, and packing neatness reviews.',
                'status' => 'Completed',
            ],
            [
                'name' => 'Store Operations Summary & KPI Dashboard',
                'category' => 'daily_sale',
                'type' => 'Executive',
                'date' => '14/Sep/26',
                'generated_by' => 'Admin',
                'generated_on' => '14/Sep/26 06:30 PM',
                'description' => 'Executive high-level snapshot of orders, turnarounds, revenue, and active fleet status.',
                'status' => 'Completed',
            ],
        ];

        foreach ($reports as $data) {
            Report::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
