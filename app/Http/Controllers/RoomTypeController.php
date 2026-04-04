<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\RoomTypeImage;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->middleware('auth');
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = RoomType::withCount('rooms');

        // Sorting functionality
        $sortBy = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort column
        $allowedSortColumns = ['id', 'name', 'price_per_night', 'capacity', 'created_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }

        // Validate sort order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        $roomTypes = $query->paginate(10);

        // Preserve sort parameters in pagination
        if ($request->has('sort')) {
            $roomTypes->appends(['sort' => $request->sort]);
        }
        if ($request->has('order')) {
            $roomTypes->appends(['order' => $request->order]);
        }

        return view('room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('room-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|in:queen,single,double,bathroom,private_bathroom,toiletries,ac,coffee,wifi,hair_dryer,tv,fridge,desk',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $roomType = RoomType::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($index >= 5) break; // Maximum 5 images

                $path = $this->imageService->optimizeAndStore($image, 'room-types');
                $roomType->images()->create([
                    'image_path' => $path,
                    'display_order' => $index
                ]);
            }
        }

        return redirect()->route('room-types.index')
            ->with('success', 'Room type created successfully.');
    }

    public function show(RoomType $roomType)
    {
        $roomType->load(['rooms', 'images']);
        return view('room-types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        $roomType->load('images');
        return view('room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|in:queen,single,double,bathroom,private_bathroom,toiletries,ac,coffee,wifi,hair_dryer,tv,fridge,desk',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_captions.*' => 'nullable|string|max:255',
            'image_orders.*' => 'nullable|integer|min:0'
        ]);

        $roomType->update($validated);

        // Update existing image captions and orders
        if ($request->has('image_captions')) {
            foreach ($request->image_captions as $id => $caption) {
                $image = $roomType->images()->find($id);
                if ($image) {
                    $image->update([
                        'caption' => $caption,
                        'display_order' => $request->image_orders[$id] ?? 0
                    ]);
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $currentCount = $roomType->images()->count();
            foreach ($request->file('images') as $index => $image) {
                if ($currentCount + $index >= 5) break; // Maximum 5 images total

                $path = $this->imageService->optimizeAndStore($image, 'room-types');
                $roomType->images()->create([
                    'image_path' => $path,
                    'display_order' => $currentCount + $index
                ]);
            }
        }

        return redirect()->route('room-types.show', $roomType)
            ->with('success', 'Room type updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        // Images will be automatically deleted through the model's boot method
        $roomType->delete();

        return redirect()->route('room-types.index')
            ->with('success', 'Room type deleted successfully.');
    }

    public function deleteImage($id)
    {
        $image = RoomTypeImage::findOrFail($id);
        $image->delete(); // Will trigger the deleting event in the model
        return response()->json(['success' => true]);
    }
}
