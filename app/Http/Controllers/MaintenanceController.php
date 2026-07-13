<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceRequest;
use App\Models\Maintenance;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MaintenanceController extends Controller
{
    public function index(): View
    {
        $query = Maintenance::with(['product:id,name,sku', 'user:id,name']);

        if ($q = request('q')) {
            $query->where(fn ($w) => $w->where('ticket_no', 'like', "%$q%")
                ->orWhere('title', 'like', "%$q%")
                ->orWhereHas('product', fn ($p) => $p->where('name', 'like', "%$q%")));
        }

        if ($status = request('status')) $query->where('status', $status);
        if ($priority = request('priority')) $query->where('priority', $priority);

        $maintenances = $query->latest('id')->paginate(10)->withQueryString();

        return view('maintenances.index', [
            'pageTitle' => 'Maintenance',
            'pageSubtitle' => 'Manajemen tiket maintenance & servis aset',
            'maintenances' => $maintenances,
        ]);
    }

    public function create(): View
    {
        return view('maintenances.create', [
            'pageTitle' => 'Buat Tiket Maintenance',
            'pageSubtitle' => 'Registrasi tiket servis baru',
            'products' => Product::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(MaintenanceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['ticket_no'] = $this->generateTicket();

        Maintenance::create($data);

        return redirect()->route('maintenances.index')->with('status', 'Tiket maintenance berhasil dibuat.');
    }

    public function edit(Maintenance $maintenance): View
    {
        return view('maintenances.edit', [
            'pageTitle' => 'Edit Maintenance',
            'pageSubtitle' => $maintenance->ticket_no,
            'maintenance' => $maintenance,
            'products' => Product::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function update(MaintenanceRequest $request, Maintenance $maintenance): RedirectResponse
    {
        $data = $request->validated();
        // Auto-fill completed_at when status = completed & tidak diisi
        if ($data['status'] === 'completed' && empty($data['completed_at'])) {
            $data['completed_at'] = now()->toDateString();
        }
        $maintenance->update($data);

        return redirect()->route('maintenances.index')->with('status', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Maintenance $maintenance): RedirectResponse
    {
        $maintenance->delete();
        return redirect()->route('maintenances.index')->with('status', 'Tiket dihapus.');
    }

    private function generateTicket(): string
    {
        $prefix = 'MNT-' . now()->format('ymd');
        $last = Maintenance::where('ticket_no', 'like', "$prefix%")->count() + 1;
        return $prefix . str_pad((string) $last, 3, '0', STR_PAD_LEFT);
    }
}
