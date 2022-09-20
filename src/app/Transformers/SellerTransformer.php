<?php

namespace App\Transformers;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identifier' => (int)$seller->id,
            'name' => (string)$seller->name,
            'email' => (string)$seller->email,
            'isVerified' => (int)$seller->verified,
            'creationDate' => (string)$seller->created_at,
            'lastChange' => (string)$seller->updated_at,
            'deleteDate' => isset($seller->deleted_at) ? (string) $seller->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('seller.show', $seller->id),
                ],
                [
                    'rel' => 'seller.buyer',
                    'href' => route('seller.buyer.index', $seller->id),
                ],
                [
                    'rel' => 'seller.product',
                    'href' => route('seller.product.index', $seller->id),
                ],
                [
                    'rel' => 'seller.category',
                    'href' => route('seller.category.index', $seller->id),
                ],
                [
                    'rel' => 'seller.transaction',
                    'href' => route('seller.transaction.index', $seller->id),
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
            'creationDate' => 'create_at',
            'lastChange' => 'updated_at',
            'deleteDate' => 'deleted_at'
        ];

        return $attributes[$index] ?? null;
    }

    public static function transformedAttribute(?string $index): ?string
    {
        $attributes = [
            'id' => 'identifier',
            'name' => 'name',
            'email' => 'email',
            'verified' => 'isVerified',
            'create_at' => 'creationDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deleteDate'
        ];

        return $attributes[$index] ?? null;
    }
}
