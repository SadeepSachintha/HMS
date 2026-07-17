<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\FoodItem;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * Class WebsiteController
 * 
 * Manages the public-facing hotel landing page, showcasing featured room types and galleries.
 * 
 * @package App\Http\Controllers
 */
class WebsiteController extends Controller
{
    /**
     * Display the public landing page with featured room options.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch up to 6 room types with their gallery images to showcase on the landing page
        $featuredRooms = RoomType::with('images')->limit(6)->get();

        return view('website.home', compact('featuredRooms'));
    }

    /**
     * Display the public food menu.
     * 
     * @return \Illuminate\View\View
     */
    public function menu()
    {
        // Fetch all available food items grouped by category
        $foodItems = FoodItem::where('is_available', true)->get()->groupBy('category');

        return view('website.menu', compact('foodItems'));
    }

    /**
     * Display the public events page.
     * 
     * @return \Illuminate\View\View
     */
    public function events()
    {
        // Fetch active and scheduled events
        $events = Event::with('location_rel')
            ->whereIn('status', ['scheduled', 'in_progress', 'completed'])
            ->orderBy('start_time', 'asc')
            ->get();

        return view('website.events', compact('events'));
    }
}
