<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Affiche la liste des services.
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Affiche le formulaire de création d'un service.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Enregistre un nouveau service.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ServiceName' => 'required|string|max:255',
            'Description' => 'required|string',
            'Price' => 'required|numeric',
            'Category' => 'required|in:Development,Design,Consulting,Other',
            'IsAvailable' => 'boolean',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service créé avec succès.');
    }

    /**
     * Affiche les détails d'un service.
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.show', compact('service'));
    }

    /**
     * Affiche le formulaire de modification d'un service.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Met à jour un service.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ServiceName' => 'required|string|max:255',
            'Description' => 'required|string',
            'Price' => 'required|numeric',
            'Category' => 'required|in:Development,Design,Consulting,Other',
            'IsAvailable' => 'boolean',
        ]);

        $service = Service::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service mis à jour avec succès.');
    }

    /**
     * Supprime un service.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service supprimé avec succès.');
    }
}