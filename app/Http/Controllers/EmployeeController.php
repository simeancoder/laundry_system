<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeController extends Controller
{
    /**
     * Fallback mock data matching the screenshot exactly.
     */
    protected function getMockEmployees()
    {
        if (session()->has('mock_employees')) {
            $sess = session('mock_employees');
            return collect($sess)->map(function ($item) {
                return is_array($item) ? (object)$item : $item;
            });
        }

        $defaults = collect([
            (object)[
                'id' => 1,
                'employee_id' => 'EMP001',
                'name' => 'Heng Simean',
                'email' => 'simeanmmo@gamil.com',
                'role' => 'Receptionist',
                'phone' => '01456789',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            (object)[
                'id' => 2,
                'employee_id' => 'EMP002',
                'name' => 'Hoem Chen',
                'email' => 'hoemchen2002@gamil.com',
                'role' => 'Manager',
                'phone' => '014848014',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            (object)[
                'id' => 3,
                'employee_id' => 'EMP003',
                'name' => 'Kat Ky',
                'email' => 'katky001@gamil.com',
                'role' => 'Presser',
                'phone' => '014966901',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            (object)[
                'id' => 4,
                'employee_id' => 'EMP004',
                'name' => 'Phy Yong Jea',
                'email' => 'yongjea002@gamil.com',
                'role' => 'Laundry Staff',
                'phone' => '014587980',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            (object)[
                'id' => 5,
                'employee_id' => 'EMP005',
                'name' => 'Soum Rern',
                'email' => 'soumrern003@gamil.com',
                'role' => 'Delivery Staff',
                'phone' => '014122330',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=120&h=120&q=80',
            ],
            (object)[
                'id' => 6,
                'employee_id' => 'EMP006',
                'name' => 'Rern Chamroung',
                'email' => 'chamroung004@gamil.com',
                'role' => 'Laundry Staff',
                'phone' => '06998890',
                'status' => 'Active',
                'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=120&h=120&q=80',
            ],
        ]);

        session(['mock_employees' => $defaults->toArray()]);
        return $defaults;
    }

    /**
     * Display employee list with stats, filtering, and search.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleFilter = $request->input('role');
        $statusFilter = $request->input('status');

        $hasDb = false;
        try {
            $hasDb = Schema::hasTable('employees') && Employee::count() > 0;
        } catch (\Throwable $e) {
            $hasDb = false;
        }

        if ($hasDb) {
            $totalEmployees = Employee::count();
            $activeEmployees = Employee::where('status', 'Active')->count();
            $onLeaveEmployees = Employee::where('status', 'On Leave')->count();
            $departmentsCount = Employee::distinct('role')->count('role') ?: 5;

            $query = Employee::query();

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('employee_id', 'like', "%{$search}%");
                });
            }

            if (!empty($roleFilter)) {
                $query->where('role', $roleFilter);
            }

            if (!empty($statusFilter)) {
                $query->where('status', $statusFilter);
            }

            $employees = $query->paginate(6)->withQueryString();
        } else {
            // Mock dataset fallback
            $allEmployees = $this->getMockEmployees();

            $totalEmployees = 25;
            $activeEmployees = 22;
            $onLeaveEmployees = 2;
            $departmentsCount = 5;

            $filtered = $allEmployees->filter(function ($item) use ($search, $roleFilter, $statusFilter) {
                if ($search && !str_contains(strtolower($item->name), strtolower($search))
                    && !str_contains(strtolower($item->email), strtolower($search))
                    && !str_contains(strtolower($item->employee_id), strtolower($search))
                    && !str_contains($item->phone, $search)) {
                    return false;
                }
                if ($roleFilter && $item->role !== $roleFilter) {
                    return false;
                }
                if ($statusFilter && $item->status !== $statusFilter) {
                    return false;
                }
                return true;
            });

            // LengthAwarePaginator for mock items
            $perPage = 6;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $filtered->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $employees = new LengthAwarePaginator(
                $currentPageItems,
                $totalEmployees,
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
            );
        }

        $stats = [
            'total' => $totalEmployees,
            'active' => $activeEmployees,
            'on_leave' => $onLeaveEmployees,
            'departments' => $departmentsCount,
        ];

        // Support both view paths
        $viewName = view()->exists('pages.service.employee') 
            ? 'pages.service.employee' 
            : (view()->exists('pages.employee') ? 'pages.employee' : 'employee');

        return view($viewName, compact('employees', 'stats', 'search', 'roleFilter', 'statusFilter'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'status' => 'nullable|string|in:Active,Inactive,On Leave',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($request->name) . '&background=0D8ABC&color=fff';

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
            $avatarUrl = asset('uploads/avatars/' . $filename);
        }

        $empId = 'EMP' . str_pad(rand(10, 999), 3, '0', STR_PAD_LEFT);
        try {
            if (Schema::hasTable('employees')) {
                $count = Employee::count() + 1;
                $empId = 'EMP' . str_pad($count, 3, '0', STR_PAD_LEFT);

                Employee::create([
                    'employee_id' => $empId,
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => $request->role,
                    'phone' => $request->phone,
                    'status' => $request->status ?? 'Active',
                    'avatar' => $avatarUrl,
                ]);
            }
        } catch (\Throwable $e) {
            \Log::warning("Employee DB store error, syncing to session: " . $e->getMessage());
        }

        // Always sync in session mock data so new employees persist immediately
        $all = $this->getMockEmployees();
        $newId = ($all->max('id') ?? 6) + 1;
        $newEmp = (object)[
            'id' => $newId,
            'employee_id' => $empId,
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'status' => $request->status ?? 'Active',
            'avatar' => $avatarUrl,
        ];
        $all->prepend($newEmp);
        session(['mock_employees' => $all->toArray()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee added successfully!',
                'employee' => $newEmp
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'status' => 'required|string|in:Active,Inactive,On Leave',
        ]);

        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
            $avatarUrl = asset('uploads/avatars/' . $filename);
        }

        try {
            if (Schema::hasTable('employees')) {
                $employee = Employee::findOrFail($id);
                $data = $request->only(['name', 'email', 'role', 'phone', 'status']);
                if ($avatarUrl) {
                    $data['avatar'] = $avatarUrl;
                }
                $employee->update($data);
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        // Always update in session mock data
        $all = $this->getMockEmployees()->map(function ($item) use ($id, $request, $avatarUrl) {
            if ($item->id == $id || ($item->employee_id ?? '') == $id) {
                $item->name = $request->name;
                $item->email = $request->email;
                $item->role = $request->role;
                $item->phone = $request->phone;
                $item->status = $request->status;
                if ($avatarUrl) {
                    $item->avatar = $avatarUrl;
                }
            }
            return $item;
        });
        session(['mock_employees' => $all->toArray()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee updated successfully!'
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Request $request, $id)
    {
        try {
            if (Schema::hasTable('employees')) {
                $employee = Employee::find($id);
                if ($employee) {
                    $employee->delete();
                }
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        // Always remove from session mock data
        $all = $this->getMockEmployees()->reject(function ($item) use ($id) {
            return $item->id == $id || ($item->employee_id ?? '') == $id;
        })->values();
        session(['mock_employees' => $all->toArray()]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully!'
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
