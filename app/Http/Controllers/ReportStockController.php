<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\Item;
use App\Models\GoodsIn;
use App\Models\GoodsOut;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;

class ReportStockController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();
        $brands = Brand::all();
        $units = Unit::all();
        return view('admin.master.laporan.stok', compact('categories', 'brands', 'units'));
    }

    public function list(Request $request): JsonResponse
    {
        if ($request->ajax()) {

            // 🔴 KODE LAMA (start_date & end_date TIDAK dipakai di view laporan sekarang)
            /*
            if( empty($request->start_date) && empty($request->end_date)){
                $data = Item::with('goodsOuts','goodsIns');
            }else{
                $data = Item::with('goodsOuts','goodsIns');
                $data -> whereBetween('date_out',[$request->start_date,$request->end_date]);
            }
            */

            // 🟢 QUERY UTAMA (tetap pakai ini)
            $data = Item::with('goodsOuts', 'goodsIns');

            // 🟢 TAMBAHAN FILTER
            if ($request->filled('month')) {
                // Input month format: "YYYY-MM"
                $parts = explode('-', $request->month);
                if (count($parts) == 2) {
                    $year = $parts[0];
                    $month = $parts[1];
                    $data->whereYear('items.tanggal_masuk', $year)
                        ->whereMonth('items.tanggal_masuk', $month);
                }
            }
            if ($request->filled('day')) {
                $data->whereDay('items.tanggal_masuk', $request->day);
            }
            if ($request->filled('category_id')) {
                $data->where('items.category_id', $request->category_id);
            }

            if ($request->filled('unit_id')) {
                $data->where('items.unit_id', $request->unit_id);
            }
            // 🟢 END TAMBAHAN

            return DataTables::of($data->latest())
                /*->addColumn('jumlah_masuk', function ($item) {
                $totalQuantity = $item->goodsIns->sum('quantity');
                return $totalQuantity;
            })
            ->addColumn("jumlah_keluar", function ($item) {
                $totalQuantity = $item->goodsOuts->sum('quantity');
                return $totalQuantity;
            }) */
                ->addColumn("kode_barang", function ($item) {
                    return $item->code;
                })
                ->addColumn("stok_awal", function ($item) {
                    return $item->quantity;
                })
                ->addColumn("nama_barang", function ($item) {
                    return $item->name;
                })

                // 🟢 TAMBAHAN KOLOM TANGGAL MASUK
                ->addColumn("tanggal_masuk", function ($item) {
                    return $item->tanggal_masuk;
                })
                // 🟢 END TAMBAHAN

                ->addColumn("condition", function ($item) {
                    return $item->condition ?? '-';
                })
                ->addColumn("total", function ($item) {
                    $totalQuantityIn = $item->goodsIns->sum('quantity');
                    $totalQuantityOut = $item->goodsOuts->sum('quantity');
                    $result = $item->quantity + $totalQuantityIn - $totalQuantityOut;
                    $result = max(0, $result);
                    if ($result == 0) {
                        return "<span class='text-red font-weight-bold'>" . $result . "</span>";
                    }
                    return  "<span class='text-success font-weight-bold'>" . $result . "</span>";
                })
                ->rawColumns(['total'])
                ->make(true);
        }
        return response()->json([]);
    }

    public function grafik(Request $request): JsonResponse
    {
        if ($request->has('month') && !empty($request->month)) {
            $month = $request->month;
            $currentMonth = preg_split("/[-\s]/", $month)[1];
            $currentYear = preg_split("/[-\s]/", $month)[0];
        } else {
            $currentMonth = date('m');
            $currentYear = date('Y');
        }
        $goodsInThisMonth = GoodsIn::whereMonth('date_received', $currentMonth)
            ->whereYear('date_received', $currentYear)->sum('quantity');
        $goodsOutThisMonth = GoodsOut::whereMonth('date_out', $currentMonth)
            ->whereYear('date_out', $currentYear)->sum('quantity');
        $totalStockThisMonth = max(0, $goodsInThisMonth - $goodsOutThisMonth);
        return response()->json([
            'month' => $currentYear . '-' . $currentMonth,
            'goods_in_this_month' => $goodsInThisMonth,
            'goods_out_this_month' => $goodsOutThisMonth,
            'total_stock_this_month' => $totalStockThisMonth,
        ]);
    }
}
