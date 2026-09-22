<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Liste des catégories actives.
     */
    public function index(): JsonResponse
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'slug',
                'description',
                'image',
            ]);

        return response()->json([
            'message' => 'Catégories récupérées avec succès.',
            'categories' => $categories,
        ]);
    }

    /**
     * Afficher une catégorie.
     */
    public function show(int $id): JsonResponse
    {
        $category = Category::where('status', true)
            ->with([
                'products' => function ($query) {
                    $query->where('status', 'published')
                        ->with(['images', 'vendor']);
                }
            ])
            ->find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Catégorie introuvable.',
            ], 404);
        }

        return response()->json([
            'message' => 'Catégorie récupérée avec succès.',
            'category' => $category,
        ]);
    }
}