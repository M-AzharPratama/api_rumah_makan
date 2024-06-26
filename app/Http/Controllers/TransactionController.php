<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Helpers\ApiFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            $data = Transaction::with('product')->get();
            return ApiFormatter::sendResponse(200, true, 'Success', $data);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, false, 'Bad Request', $err->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'order_date' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return ApiFormatter::sendResponse(422, false, 'Validation Error', $validator->errors());
        }

        try {
            $transaction = Transaction::create([
                'product_id' => $request->input('product_id'),
                'order_date' => $request->input('order_date'),
                'quantity' => $request->input('quantity'),
            ]);
            return ApiFormatter::sendResponse(201, true, 'Transaction Created Successfully!', $transaction);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(500, false, 'Internal Server Error', $err->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $transaction = Transaction::with('product')->findOrFail($id);
            return ApiFormatter::sendResponse(200, true, "Transaction with ID $id found", $transaction);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(404, false, "Transaction with ID $id not found", $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'order_date' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return ApiFormatter::sendResponse(422, false, 'Validation Error', $validator->errors());
        }

        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->update($request->only(['product_id', 'order_date', 'quantity']));
            return ApiFormatter::sendResponse(200, true, "Transaction with ID $id updated successfully", $transaction);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(500, false, 'Internal Server Error', $err->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();
            return ApiFormatter::sendResponse(200, true, "Transaction with ID $id deleted successfully", ['id' => $id]);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(500, false, 'Internal Server Error', $err->getMessage());
        }
    }
}
