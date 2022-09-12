<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    use ApiResponser;

    public function store(Request $request, Product $product, User $buyer): JsonResponse
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];
        $this->validate($request, $rules);

        if ($buyer->id === $product->seller->id) {
            return $this->errorResponse('Buyer must different than the seller', 409);
        }
        if (!$buyer->isVerified()) {
            return $this->errorResponse('The buyer must be a verified user', 409);
        }
        if (!$product->seller->isVerified()) {
            return $this->errorResponse('The seller must be a verified user', 409);
        }
        if (!$product->isAvailable()) {
            return $this->errorResponse('The product is not available.', 409);
        }
        if ($product->quantity < $request->quantity) {
            return $this->errorResponse(
                'The product does not have enough units for this transaction.', 409
            );
        }

        return DB::transaction(function () use($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
               'quantity' => $request->quantity,
               'buyer_id' => $buyer->id,
               'product_id' => $product->id
            ]);

            return $this->showOne($transaction, 201);
        });
    }
}
