<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\User;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch the admin user created in UserSeeder
        $user = User::where('email', 'admin@gmail.com')->first();
        if (!$user) {
            throw new \Exception('User admin@gmail.com not found. Please run UserSeeder first.');
        }

        $staffData = [
            [
                'user_id' => $user->id,
                'name' => 'John Smith',
                'email' => 'john.smith@hotel.com',
                'phone' => '+1-555-0101',
                'nic' => '901248529V',
                'position' => 'Front Desk Manager',
                'department' => 'Front Office',
                'address' => '123 Main St, City, State 12345',
                'emergency_contact' => 'Jane Smith (Wife) - +1-555-0102',
                'hire_date' => '2023-01-15',
                'salary' => 45000.00,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@hotel.com',
                'phone' => '+1-555-0103',
                'nic' => '199214739502',
                'position' => 'Housekeeping Supervisor',
                'department' => 'Housekeeping',
                'address' => '456 Oak Ave, City, State 12345',
                'emergency_contact' => 'Mike Johnson (Husband) - +1-555-0104',
                'hire_date' => '2023-02-20',
                'salary' => 38000.00,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'name' => 'Michael Brown',
                'email' => 'michael.brown@hotel.com',
                'phone' => '+1-555-0105',
                'nic' => '936528145V',
                'position' => 'Chef',
                'department' => 'Food & Beverage',
                'address' => '789 Pine Rd, City, State 12345',
                'emergency_contact' => 'Lisa Brown (Sister) - +1-555-0106',
                'hire_date' => '2023-03-10',
                'salary' => 52000.00,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'name' => 'Emily Davis',
                'email' => 'emily.davis@hotel.com',
                'phone' => '+1-555-0107',
                'nic' => '199573859604',
                'position' => 'Maintenance Technician',
                'department' => 'Maintenance',
                'address' => '321 Elm St, City, State 12345',
                'emergency_contact' => 'Robert Davis (Father) - +1-555-0108',
                'hire_date' => '2023-04-05',
                'salary' => 35000.00,
                'status' => 'on_leave',
            ],
            [
                'user_id' => $user->id,
                'name' => 'David Wilson',
                'email' => 'david.wilson@hotel.com',
                'phone' => '+1-555-0109',
                'nic' => '967382951V',
                'position' => 'Security Guard',
                'department' => 'Security',
                'address' => '654 Maple Dr, City, State 12345',
                'emergency_contact' => 'Mary Wilson (Mother) - +1-555-0110',
                'hire_date' => '2023-05-12',
                'salary' => 32000.00,
                'status' => 'active',
            ],
        ];

        foreach ($staffData as $data) {
            Staff::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}
