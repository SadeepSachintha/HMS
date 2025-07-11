<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class FoodItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = FoodItem::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Sorting functionality
        $sortBy = $request->get('sort', 'id');
        $sortOrder = $request->get('order', 'desc');

        // Validate sort column
        $allowedSortColumns = ['id', 'name', 'category', 'price', 'is_available', 'created_at'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }

        // Validate sort order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        $foodItems = $query->paginate(10);

        // Preserve search and sort parameters in pagination
        if ($request->has('search')) {
            $foodItems->appends(['search' => $request->search]);
        }
        if ($request->has('sort')) {
            $foodItems->appends(['sort' => $request->sort]);
        }
        if ($request->has('order')) {
            $foodItems->appends(['order' => $request->order]);
        }

        return view('food-items.index', compact('foodItems'));
    }

    public function create()
    {
        return view('food-items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:50',
            'is_available' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageService = app(ImageService::class);
            $path = $imageService->optimizeAndStore($request->file('image'), 'food-items');
            $validated['image_path'] = $path;
        }

        FoodItem::create($validated);

        return redirect()->route('food-items.index')
            ->with('success', 'Food item created successfully.');
    }

    public function show(FoodItem $foodItem)
    {
        return view('food-items.show', compact('foodItem'));
    }

    public function edit(FoodItem $foodItem)
    {
        return view('food-items.edit', compact('foodItem'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:50',
            'is_available' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3072',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($foodItem->image_path) {
                Storage::disk('public')->delete($foodItem->image_path);
            }
            $imageService = app(ImageService::class);
            $path = $imageService->optimizeAndStore($request->file('image'), 'food-items');
            $validated['image_path'] = $path;
        }

        $foodItem->update($validated);

        return redirect()->route('food-items.index')
            ->with('success', 'Food item updated successfully.');
    }

    public function destroy(FoodItem $foodItem)
    {
        $foodItem->delete();

        return redirect()->route('food-items.index')
            ->with('success', 'Food item deleted successfully.');
    }
}
