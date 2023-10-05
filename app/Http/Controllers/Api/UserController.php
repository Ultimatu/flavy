<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/user/update-assurance/{id}",
     *     tags={"Application mobile client"},
     *     summary="Mise à jour des informations d'assurance",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_type_assurance", "n_assurance"},
     *             type="object",
     *             @OA\Property(property="id_type_assurance", type="integer", description="ID du type d'assurance"),
     *             @OA\Property(property="n_assurance", type="string", description="Numéro d'assurance"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Mise à jour réussie"),
     *     @OA\Response(response="400", description="Requête incorrecte"),
     *     @OA\Response(response="404", description="Utilisateur non trouvé"),
     * )
     */
    public function updateAssurance(Request $request, int $id)
    {
        $request->validate([
            'id_type_assurance' => 'required|exists:type_assurance,id',
            'n_assurance' => 'required|string|max:255',
        ]);

        // Trouvez l'utilisateur par ID
        $user = User::findOrFail($id);

        $user->update([
            'id_type_assurance' => $request->input('id_type_assurance'),
            'n_assurance' => $request->input('n_assurance'),
        ]);

        return response()->json(['message' => 'Informations d\'assurance mises à jour avec succès'], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/user/update-infos/{id}",
     *     tags={"Application mobile client"},
     *     summary="Mise à jour des informations personnelles",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"fullname", "ville", "adresse"},
     *             type="object",
     *             @OA\Property(property="fullname", type="string", description="Nom complet"),
     *             @OA\Property(property="ville", type="string", description="Ville"),
     *             @OA\Property(property="adresse", type="string", description="Adresse"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Mise à jour réussie"),
     *     @OA\Response(response="400", description="Requête incorrecte"),
     *     @OA\Response(response="404", description="Utilisateur non trouvé"),
     * )
     */
    public function updateInfos(Request $request, int $id)
    {
        // Validez les données de la demande
        $request->validate([
            'fullname' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
        ]);

        // Trouvez l'utilisateur par ID
        $user = User::findOrFail($id);

        // Mettez à jour les informations personnelles
        $user->update([
            'fullname' => $request->input('fullname'),
            'ville' => $request->input('ville'),
            'adresse' => $request->input('adresse'),
        ]);

        return response()->json(['message' => 'Informations personnelles mises à jour avec succès'], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/user/update-antecedant/{id}",
     *     tags={"Application mobile client"},
     *     summary="Mise à jour des antécédents médicaux",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"maladie_chronique"},
     *             type="object",
     *             @OA\Property(property="maladie_chronique", type="string", description="Maladie chronique"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Mise à jour réussie"),
     *     @OA\Response(response="400", description="Requête incorrecte"),
     *     @OA\Response(response="404", description="Utilisateur non trouvé"),
     * )
     */
    public function updateAntecedant(Request $request, $id)
    {
        // Validez les données de la demande
        $request->validate([
            'maladie_chronique' => 'nullable|string|max:500',
        ]);

        // Trouvez l'utilisateur par ID
        $user = User::findOrFail($id);

        // Mettez à jour les antécédents médicaux
        $user->update([
            'maladie_chronique' => $request->input('maladie_chronique'),
        ]);

        return response()->json(['message' => 'Antécédents médicaux mis à jour avec succès'], 200);
    }
}
