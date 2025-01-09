<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portfolios = Portfolio::all();
        return view('portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('portfolios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ProjectID' => 'required|exists:projects,ProjectID',
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'ImageURL' => 'nullable|string|max:500',
            'LiveLink' => 'nullable|string|max:500',
            'Category' => 'required|in:Web Development,Mobile App,Design,Other',
            'Tags' => 'nullable|json',
        ]);

        Portfolio::create($request->all());

        return redirect()->route('portfolios.index')->with('success', 'Portfolio created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        return view('portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'ProjectID' => 'required|exists:projects,ProjectID',
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'ImageURL' => 'nullable|string|max:500',
            'LiveLink' => 'nullable|string|max:500',
            'Category' => 'required|in:Web Development,Mobile App,Design,Other',
            'Tags' => 'nullable|json',
        ]);

        $portfolio->update($request->all());

        return redirect()->route('portfolios.index')->with('success', 'Portfolio updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('success', 'Portfolio deleted successfully.');
    }

    public function public()
    {
        $portfolios = Portfolio::all();
        return view('portfolios.public', compact('portfolios'));
    }
}