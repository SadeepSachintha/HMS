<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display the landing page of the website.
     */
    public function index()
    {
        // Fetch up to 6 room types to showcase on the landing page
        $featuredRooms = RoomType::with('images')->limit(6)->get();

        return view('website.home', compact('featuredRooms'));
    }
}
