<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price_per_kg' => 'required|numeric',
        ]);

        Service::create($request->all());
        return redirect()->route('services.index')->with('success', 'Service berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price_per_kg' => 'required|numeric',
        ]);

        $service->update($request->all());
        return redirect()->route('services.index')->with('success', 'Service berhasil diupdate!');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service berhasil dihapus!');
    }
}
