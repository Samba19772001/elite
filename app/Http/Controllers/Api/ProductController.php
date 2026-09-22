<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Liste des produits publiés.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::where('status', 'published')
            ->with([
                'images',
                'category',
                'vendor',
            ]);

        // Recherche par nom
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filtre par catégorie
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filtre par ville
        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        // Prix minimum
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        // Prix maximum
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Produits mis en avant
        if ($request->filled('featured')) {
            $query->where('is_featured', filter_var(
                $request->input('featured'),
                FILTER_VALIDATE_BOOLEAN
            ));
        }

        $products = $query
            ->latest()
            ->paginate(12);

        return response()->json([
            'message' => 'Produits récupérés avec succès.',
            'products' => $products,
        ]);
    }

    /**
     * Afficher un produit.
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::where('status', 'published')
            ->with([
                'images',
                'category',
                'vendor',
            ])
            ->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produit introuvable.',
            ], 404);
        }

        return response()->json([
            'message' => 'Produit récupéré avec succès.',
            'product' => $product,
        ]);
    }
}