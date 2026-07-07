<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
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
}
