<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LocationController extends Controller
{
    public function index(): View
    {
        $query = Location::query()->withCount('products');

        if ($q = request('q')) {
            $query->where(fn ($w) => $w->where('code', 'like', "%$q%")
                ->orWhere('name', 'like', "%$q%")
                ->orWhere('pic_name', 'like', "%$q%"));
        }

        $locations = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('locations.index', [
            'pageTitle' => 'Lokasi Gudang',
            'pageSubtitle' => 'Kelola lokasi & gudang penyimpanan',
            'locations' => $locations,
        ]);
    }

    public function create(): View
    {
        return view('locations.create', [
            'pageTitle' => 'Tambah Lokasi',
            'pageSubtitle' => 'Registrasi lokasi baru',
        ]);
    }

    public function store(LocationRequest $request): RedirectResponse
    {
        Location::create($request->validated());
        return redirect()->route('locations.index')->with('status', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location): View
    {
        return view('locations.edit', [
            'pageTitle' => 'Edit Lokasi',
            'pageSubtitle' => $location->name,
            'location' => $location,
        ]);
    }

    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated());
        return redirect()->route('locations.index')->with('status', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        if ($location->products()->exists()) {
            return redirect()->route('locations.index')
                ->with('status', 'Lokasi tidak dapat dihapus karena masih menyimpan barang.');
        }
        $location->delete();
        return redirect()->route('locations.index')->with('status', 'Lokasi berhasil dihapus.');
    }
}
