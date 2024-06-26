<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Helpers\ApiFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
{
    try {
        $data = Product::all(); // Mengambil semua produk tanpa relasi
        return ApiFormatter::sendResponse(200, true, 'Success', $data);
    } catch (\Exception $err) {
        return ApiFormatter::sendResponse(400, false, 'Bad Request', $err->getMessage());
    }
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return ApiFormatter::sendResponse(422, false, 'Validation Error', $validator->errors());
        }

        try {
            $product = Product::create([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
            ]);
            return ApiFormatter::sendResponse(201, true, 'Product Created Successfully!', $product);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(500, false, 'Internal Server Error', $err->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return ApiFormatter::sendResponse(200, true, "Product with ID $id found", $product);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(404, false, "Product with ID $id not found", $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $name  = ($request->name) ? $request->name : $product->name;
            $price  = ($request->price) ? $request->price :$product->price;

            $product->update([
                'name' => $name,
                'price' => $price
            ]);

            return ApiFormatter::sendResponse(200, true, "Berhasil Ubah Data Dengan ID $id");   
        } catch (\Throwable $th) {
            return ApiFormatter::sendResponse(404, false, "Proses Gagal! Silakan Coba Lagi!", $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return ApiFormatter::sendResponse(200, true, "Product with ID $id deleted successfully", ['id' => $id]);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(500, false, 'Internal Server Error', $err->getMessage());
        }
    }
}
