<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
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
    public function transform(Category $category)
    {
        return [
            'identifier' => (int)$category->id,
            'title' => (string)$category->name,
            'details' => (string)$category->description,
            'creationDate' => (string)$category->created_at,
            'lastChanged' => (string)$category->updated_at,
            'deleteDate' => isset($category->deleted_at) ? (string) $category->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('category.show', $category->id),
                ],
                [
                    'rel' => 'category.buyer',
                    'href' => route('category.buyer.index', $category->id),
                ],
                [
                    'rel' => 'category.product',
                    'href' => route('category.product.index', $category->id),
                ],
                [
                    'rel' => 'category.seller',
                    'href' => route('category.seller.index', $category->id),
                ],
                [
                    'rel' => 'category.transaction',
                    'href' => route('category.transaction.index', $category->id),
                ]
            ]
        ];
    }

    public static function originalAttribute(?string $index): ?string
    {
        $attributes = [
            'identifier' => 'id',
            'title' => 'name',
            'details' => 'description',
            'creationDate' => 'created_at',
            'lastChanged' => 'updated_at',
            'deleteDate' => 'deleted_at'
        ];

        return $attributes[$index] ?? null;
    }
}
