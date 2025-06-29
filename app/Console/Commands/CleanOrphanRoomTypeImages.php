<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoomTypeImage;
use Illuminate\Support\Facades\Storage;

class CleanOrphanRoomTypeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:orphan-roomtype-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete RoomTypeImage records whose image files are missing from storage.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = 0;
        $images = RoomTypeImage::all();
        foreach ($images as $image) {
            if (!$image->image_path || !Storage::disk('public')->exists($image->image_path)) {
                $image->delete();
                $deleted++;
            }
        }
        $this->info("Deleted $deleted orphan RoomTypeImage records.");
        return 0;
    }
}
