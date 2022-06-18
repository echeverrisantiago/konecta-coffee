<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
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

        $data = Product::select('id','name','reference','price','weight','category','stock','created_at')
            ->orderBy($sortBy, $sort)
            ->paginate($perPage);
            
        return view('products', ['data' => $data]);
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
        try {
            DB::beginTransaction();

            $request->validate(Product::$rules);

            Product::create($request->all());

            DB::commit();

            return back()->with('success', 'El producto ha sido creado');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['msg' => 'Ha habido un error al guardar el producto']);
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
        try {
            DB::beginTransaction();

            $request->validate(Product::$rules);

            $product = Product::select('id')
                ->where('id', $id)
                ->first();

            if ($product) {
                $product->update($request->all());
            }

            DB::commit();

            return back()->with('success', 'El producto ha sido actualizado');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['msg' => 'Ha habido un error al guardar el producto']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();

            $product = Product::select('id')
                ->where('id', $id)
                ->first();

            if ($product) {
                $sales = Sales::select('id')
                    ->where('product_id', $id)
                    ->get();

                if ($sales) {
                    foreach ($sales as $sale) {
                        $sale->delete();
                    }
                }
                
                $product->delete();
            }

            DB::commit();

            return back()->with('success', 'El producto ha sido eliminado');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();

            return back()->withErrors(['msg' => 'Ha habido un error al eliminar el producto']);
        }
    }
}
