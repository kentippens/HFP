<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show(LandingPage $page)
    {
        // Check if landing page is active
        if (!$page->is_active) {
            abort(404);
        }

        return view('landing.show', compact('page'));
    }

    public function submit(Request $request, $slug)
    {
        // Basic validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // For now, just return back with success message
        // In real app, you'd save to database with source tracking
        return back()->with('success', 'Thank you for your submission! We will contact you soon.');
    }
}
