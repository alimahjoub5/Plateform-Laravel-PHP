<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with(['user', 'project'])
            ->where('Status', 'Approved')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('testimonials.index', compact('testimonials'));
    }
} 