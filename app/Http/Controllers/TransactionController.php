<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('customer')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $customers = Customer::all();
        $services = Service::all();
        return view('transactions.create', compact('customers', 'services'));
    }    

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'transaction_date' => 'required|date',
            'pickup_date' => 'nullable|date',
            'services' => 'required|array',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.weight' => 'required|numeric|min:0.1',
        ]);
    
        // Hitung total harga
        $total = 0;
        foreach ($request->services as $s) {
            $service = Service::find($s['service_id']);
            $total += $service->price_per_kg * $s['weight'];
        }
    
        // Simpan transaksi
        $transaction = Transaction::create([
            'customer_id' => $request->customer_id,
            'transaction_date' => $request->transaction_date,
            'pickup_date' => $request->pickup_date,
            'status' => 'pending',
            'total_price' => $total,
            'payment_status' => 'unpaid'
        ]);
    
        // Simpan detail layanan
        foreach ($request->services as $s) {
            $service = Service::find($s['service_id']);
            $transaction->details()->create([
                'service_id' => $s['service_id'],
                'weight' => $s['weight'],
                'price' => $service->price_per_kg * $s['weight'],
            ]);
        }
    
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }
    
    public function show($id)
    {
        $transaction = Transaction::with('customer', 'details.service')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = Transaction::with('details')->findOrFail($id);
        $customers = Customer::all();
        $services = Service::all();
        return view('transactions.edit', compact('transaction', 'customers', 'services'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'payment_status' => 'required',
        ]);

        $transaction->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->details()->delete();
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
