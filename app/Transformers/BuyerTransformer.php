<?php

namespace App\Transformers;

use App\Models\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int)$buyer->id,
            'name' => (string)$buyer->name,
            'email' => (string)$buyer->email,
            'isVerified' => (int)$buyer->verified,
            'creationDate' => (string)$buyer->created_at,
            'lastChanged' => (string)$buyer->updated_at,
            'deleteDate' => isset($buyer->deleted_at) ? (string) $buyer->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyer.show', $buyer->id),
                ],
                [
                    'rel' => 'buyer.seller',
                    'href' => route('buyer.seller.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.product',
                    'href' => route('buyer.product.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.category',
                    'href' => route('buyer.category.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.transaction',
                    'href' => route('buyer.transaction.index', $buyer->id),
                ]
            ]
        ];
    }

    public static function originalAttribute(?string $index): ?string
    {
        $attributes = [
            'identifier' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'creationDate' => 'created_at',
            'lastChanged' => 'updated_at',
            'deleteDate' => 'deleted_at'
        ];

        return $attributes[$index] ?? null;
    }
}
