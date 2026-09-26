<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    /**
     * Liste des vendeurs
     */
    public function index()
    {
        $vendors = Vendor::with('user')
            ->latest()
            ->paginate(12);

        return response()->json([
            'status' => true,
            'message' => 'Vendeurs récupérés avec succès',
            'data' => $vendors
        ]);
    }

    /**
     * Afficher un vendeur
     */
    public function show($id)
    {
        $vendor = Vendor::with('user')->find($id);

        if (!$vendor) {
            return response()->json([
                'status' => false,
                'message' => 'Vendeur introuvable'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Vendeur récupéré avec succès',
            'data' => $vendor
        ]);
    }

    /**
     * Créer un vendeur
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'document_type' => 'nullable|string|max:100',
            'document_number' => 'nullable|string|max:255',
            'verification_status' => 'nullable|in:pending,verified,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $vendor = Vendor::create([
            'user_id' => $request->user_id,
            'company_name' => $request->company_name,
            'description' => $request->description,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'verification_status' => $request->verification_status ?? 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Vendeur créé avec succès',
            'data' => $vendor
        ], 201);
    }

    /**
     * Modifier un vendeur
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'status' => false,
                'message' => 'Vendeur introuvable'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'company_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'document_type' => 'nullable|string|max:100',
            'document_number' => 'nullable|string|max:255',
            'verification_status' => 'nullable|in:pending,verified,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors()
            ], 422);
        }

        $vendor->update($request->only([
            'company_name',
            'description',
            'phone',
            'email',
            'address',
            'city',
            'document_type',
            'document_number',
            'verification_status',
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Vendeur modifié avec succès',
            'data' => $vendor
        ]);
    }

    /**
     * Supprimer un vendeur
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);

        if (!$vendor) {
            return response()->json([
                'status' => false,
                'message' => 'Vendeur introuvable'
            ], 404);
        }

        $vendor->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vendeur supprimé avec succès'
        ]);
    }
}