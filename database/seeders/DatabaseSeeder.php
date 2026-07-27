<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Customer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default system settings
        \App\Models\Setting::firstOrCreate(
            ['id' => 1],
            [
                'hotel_name' => 'Hotel Grand Palace',
                'contact_email' => 'info@grandpalace.com',
                'contact_phone' => '+94112345678',
                'check_in_time' => '14:00:00',
                'check_out_time' => '12:00:00',
                'email_notifications' => true,
                'sms_notifications' => false,
                'service_charge_rate' => 10.00,
                'sscl_rate' => 2.50,
                'tdl_rate' => 1.00,
                'vat_rate' => 18.00,
            ]
        );
        // Create room types
        $standard = RoomType::create([
            'name' => 'Standard Room',
            'description' => 'Comfortable room with basic amenities',
            'price_per_night' => 100.00,
            'capacity' => 2
        ]);

        \App\Models\RoomTypeImage::create([
            'room_type_id' => $standard->id,
            'image_path' => 'rooms/standard.png',
            'caption' => 'Comfortable Standard Room',
            'display_order' => 1
        ]);

        $deluxe = RoomType::create([
            'name' => 'Deluxe Room',
            'description' => 'Spacious room with premium amenities',
            'price_per_night' => 200.00,
            'capacity' => 3
        ]);

        \App\Models\RoomTypeImage::create([
            'room_type_id' => $deluxe->id,
            'image_path' => 'rooms/deluxe.png',
            'caption' => 'Spacious Deluxe Room',
            'display_order' => 1
        ]);

        $suite = RoomType::create([
            'name' => 'Suite',
            'description' => 'Luxury suite with separate living area',
            'price_per_night' => 300.00,
            'capacity' => 4
        ]);

        \App\Models\RoomTypeImage::create([
            'room_type_id' => $suite->id,
            'image_path' => 'rooms/suite.png',
            'caption' => 'Luxurious Suite',
            'display_order' => 1
        ]);

        // Create 15 rooms (7 Standard, 5 Deluxe, 3 Suite)
        // Standard rooms (101-107)
        for ($i = 1; $i <= 7; $i++) {
            Room::create([
                'number' => '10' . $i,
                'room_type_id' => $standard->id,
                'floor' => 1,
                'status' => 'available',
                'is_clean' => true,
                'notes' => null
            ]);
        }

        // Deluxe rooms (201-205)
        for ($i = 1; $i <= 5; $i++) {
            Room::create([
                'number' => '20' . $i,
                'room_type_id' => $deluxe->id,
                'floor' => 2,
                'status' => 'available',
                'is_clean' => true,
                'notes' => null
            ]);
        }

        // Suites (301-303)
        for ($i = 1; $i <= 3; $i++) {
            Room::create([
                'number' => '30' . $i,
                'room_type_id' => $suite->id,
                'floor' => 3,
                'status' => 'available',
                'is_clean' => true,
                'notes' => null
            ]);
        }

        // Create sample customers
        Customer::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'nic_passport' => '911042754V',
            'address' => '123 Main St'
        ]);

        Customer::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '+94987654321',
            'nic_passport' => '199260142672',
            'address' => '456 Oak Ave'
        ]);

        // Create sample reservations
        $rooms = Room::all();
        $customers = \App\Models\Customer::all();

        for ($i = 0; $i < 5; $i++) {
            $room = $rooms->random();
            $customer = $customers->random();

            $checkIn = now()->addDays(rand(1, 30));
            $checkOut = $checkIn->copy()->addDays(rand(1, 7));

            $reservation = \App\Models\Reservation::create([
                'customer_id' => $customer->id,
                'room_id' => $room->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'number_of_guests' => rand(1, 4),
                'status' => ['confirmed', 'pending', 'checked_out'][rand(0, 2)]
            ]);

            // Create payment for some reservations
            if (rand(0, 1)) {
                \App\Models\Payment::create([
                    'reservation_id' => $reservation->id,
                    'amount' => $room->roomType->price_per_night * $checkIn->diffInDays($checkOut),
                    'payment_date' => now(),
                    'payment_method' => ['credit_card', 'cash', 'bank_transfer'][rand(0, 2)],
                    'status' => 'completed',
                    'transaction_id' => 'TXN' . rand(1000, 9999),
                    'notes' => 'Sample payment'
                ]);
            }
        }

        // Call other seeders
        $this->call([
            AdminSeeder::class,
            CustomerSeeder::class,
            UserSeeder::class,
            StaffSeeder::class,
        ]);
    }
}
