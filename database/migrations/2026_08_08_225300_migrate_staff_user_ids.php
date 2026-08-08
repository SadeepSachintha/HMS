<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable activity logging during migration to prevent logging database migrations as staff updates
        if (config('logging.channels.daily')) {
            // Optional: avoid logs activity trait logging during migration
        }

        // Fetch all staff records
        $staffMembers = Staff::all();

        foreach ($staffMembers as $staff) {
            // Find if there is a User with the staff member's email
            $user = User::where('email', $staff->email)->first();

            if (!$user) {
                // Create a User record for the staff member
                $user = User::create([
                    'name' => $staff->name,
                    'email' => $staff->email,
                    'role' => 'staff',
                    'password' => Hash::make('password'),
                    'status' => true,
                ]);
            } else {
                // Ensure their role is staff if not already set as admin/manager
                if (!in_array($user->role, ['admin', 'manager', 'staff'])) {
                    $user->update(['role' => 'staff']);
                }
            }

            // Update staff's user_id to point to their own User record
            $staff->user_id = $user->id;
            $staff->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Data migration cannot be safely reversed as original creator IDs are not backed up.
    }
};
