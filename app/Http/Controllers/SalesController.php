<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortBy = $request->sortBy ? $request->sortBy : 'id';
        $sort = $request->sort ? $request->sort : 'DESC';
        $perPage = $request->perPage ? $request->perPage : 10;

        $data = Sales::select('id','product_id','quantity','created_at')
            ->with('Producto')
            ->orderBy($sortBy, $sort)
            ->paginate($perPage);

        $products = Product::select('id','name')
            ->get();
            
        return view('sales', ['data' => $data, 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info($request->all());
        try {
            DB::beginTransaction();
            
            $request->validate(Sales::$rules);
            
            $producto = Product::select('id','stock')
            ->where('id', $request->product_id)
            ->first();
            if ($producto) {
                if ($producto->stock > 0 && $producto->stock > $request->quantity) {
                    Sales::create($request->all());
                    $producto->update([
                        'stock' => $producto->stock - $request->quantity
                    ]);
                } else {
                    return back()->withErrors(['msg' => 'El producto no tiene stock']);
                }
            }

            DB::commit();

            return back()->with('success', 'La venta ha sido realizada');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
            return back()->withErrors(['msg' => 'Ha habido un error al realizar la venta']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $sale = Sales::select('id')
                ->where('id', $id)
                ->first();

            if ($sale) {
                $sale->delete();
            }

            DB::commit();

            return back()->with('success', 'La venta ha sido eliminada');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['msg' => 'Ha habido un error al eliminar la venta']);
        }
    }
}
