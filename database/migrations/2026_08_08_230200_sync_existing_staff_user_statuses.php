<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Staff;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $staffMembers = Staff::all();

        foreach ($staffMembers as $staff) {
            $user = $staff->user;
            if ($user) {
                // Sync user status: false if staff is inactive, true otherwise
                $user->update([
                    'status' => ($staff->status !== 'inactive')
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
