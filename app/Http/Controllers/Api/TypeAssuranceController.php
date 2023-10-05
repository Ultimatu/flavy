<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Free\TypeAssurance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class TypeAssuranceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/type-assurances",
     *     tags={"Application mobile client"},
     *     summary="Liste de tous les types d'assurance",
     *     @OA\Response(response="200", description="Liste des types d'assurance")
     * )
     */
    public function getAll(): JsonResponse
    {
        $typesAssurance = TypeAssurance::all();
        return response()->json($typesAssurance, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/type-assurances",
     *     tags={"ADMIN"},
     *     summary="Créer un nouveau type d'assurance",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"libelle", "description"},
     *             type="object",
     *             @OA\Property(property="libelle", type="string", description="Nom du type d'assurance"),
     *             @OA\Property(property="description", type="string", description="Description du type d'assurance"),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Type d'assurance créé avec succès"),
     *     @OA\Response(response="400", description="Requête incorrecte")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'libelle' => 'required|string|max:500',
            'description' => 'required|string|max:500',
        ]);

        $typeAssurance = TypeAssurance::create([
            'libelle' => $request->input('libelle'),
            'description' => $request->input('description'),
        ]);

        return response()->json($typeAssurance, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/type-assurance/{id}",
     *     tags={"ADMIN"},
     *     summary="Mettre à jour un type d'assurance existant",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du type d'assurance à mettre à jour",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom"},
     *             type="object",
     *             @OA\Property(property="nom", type="string", description="Nom du type d'assurance"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Mise à jour réussie"),
     *     @OA\Response(response="400", description="Requête incorrecte"),
     *     @OA\Response(response="404", description="Type d'assurance non trouvé")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'libelle' => 'required|string|max:500',
            'description' => 'required|string|max:500',
        ]);

        $typeAssurance = TypeAssurance::find($id);

        if (!$typeAssurance) {
            return response()->json(['message' => 'Type d\'assurance non trouvé'], 404);
        }

        $typeAssurance->update([
            'libelle' => $request->input('libelle'),
            'description' => $request->input('description'),
        ]);

        return response()->json(['message' => 'Type d\'assurance mis à jour avec succès'], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/type-assurance/{id}",
     *     tags={"ADMIN"},
     *     summary="Supprimer un type d'assurance",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du type d'assurance à supprimer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Type d'assurance supprimé avec succès"),
     *     @OA\Response(response="404", description="Type d'assurance non trouvé")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $typeAssurance = TypeAssurance::find($id);

        if (!$typeAssurance) {
            return response()->json(['message' => 'Type d\'assurance non trouvé'], 404);
        }

        $typeAssurance->delete();

        return response()->json(null, 204);
    }
}
