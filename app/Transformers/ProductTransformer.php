<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier' => (int)$product->id,
            'title' => (string)$product->name,
            'details' => (string)$product->description,
            'stock' => (int)$product->quantity,
            'situation' => (string)$product->status,
            'seller' => (int)$product->seller_id,
            'picture' => url("img/{$product->image}"),
            'creationDate' => (string)$product->created_at,
            'lastChanged' => (string)$product->updated_at,
            'deleteDate' => isset($product->deleted_at) ? (string) $product->deleted_at : null
        ];
    }

    public static function originalAttribute(?string $index): ?string
    {
        $attributes = [
            'identifier' => 'id',
            'title' => 'name',
            'details' => 'description',
            'stock' => 'quantity',
            'situation' => 'status',
            'seller' => 'seller_id',
            'picture' => 'image',
            'creationDate' => 'created_at',
            'lastChanged' => 'updated_at',
            'deleteDate' => 'deleted_at'
        ];

        return $attributes[$index] ?? null;
    }
}
