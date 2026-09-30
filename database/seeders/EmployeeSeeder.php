<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            [
                'employee_id' => 'EMP001',
                'name' => 'Heng Simean',
                'email' => 'simeanmmo@gamil.com',
                'role' => 'Receptionist',
                'phone' => '01456789',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP002',
                'name' => 'Hoem Chen',
                'email' => 'hoemchen2002@gamil.com',
                'role' => 'Manager',
                'phone' => '014848014',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP003',
                'name' => 'Kat Ky',
                'email' => 'katky001@gamil.com',
                'role' => 'Presser',
                'phone' => '014966901',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP004',
                'name' => 'Phy Yong Jea',
                'email' => 'yongjea002@gamil.com',
                'role' => 'Laundry Staff',
                'phone' => '014587980',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP005',
                'name' => 'Soum Rern',
                'email' => 'soumrern003@gamil.com',
                'role' => 'Delivery Staff',
                'phone' => '014122330',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            [
                'employee_id' => 'EMP006',
                'name' => 'Rern Chamroung',
                'email' => 'chamroung004@gamil.com',
                'role' => 'Laundry Staff',
                'phone' => '06998890',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=120&h=120&q=80',
            ],
        ];

        foreach ($employees as $data) {
            Employee::updateOrCreate(
                ['employee_id' => $data['employee_id']],
                $data
            );
        }
    }
}
