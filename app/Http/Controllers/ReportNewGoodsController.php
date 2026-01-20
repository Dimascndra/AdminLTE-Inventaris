<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\Item;              
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class ReportNewGoodsController extends Controller
{
    /**
     * Halaman utama laporan barang baru.
     */
    public function index(): View
    {
        return view('admin.master.laporan.Barangbaru');
    }

    /**
     * Menyediakan data untuk DataTables dengan filter 7 hari terakhir.
     */
    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            
            // 1. Tentukan batas waktu: 7 hari yang lalu, dimulai dari awal hari.
            $sevenDaysAgo = Carbon::now()->subDays(7)->startOfDay();

            // 2. Query Item: Ambil data item yang dibuat (created_at) dalam 7 hari terakhir
            $data = Item::where('created_at', '>=', $sevenDaysAgo)
                        ->get();

            // 3. Proses data menggunakan Yajra DataTables
            return DataTables::of($data)
                ->addIndexColumn()
                
                // Menggunakan kolom 'name' dan 'code' dari tabel items
                ->addColumn('item_name', fn($row) => $row->name ?? '-') 
                ->addColumn('code', fn($row) => $row->code ?? '-')
                
                // Menggunakan kolom 'quantity' (stok saat ini)
                ->addColumn('quantity', fn($row) => $row->quantity ?? 0) 
                
                // Menggunakan created_at
                ->addColumn('date', fn($row) => Carbon::parse($row->created_at)->format('d-m-Y'))
                
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }
}