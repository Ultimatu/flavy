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
            'phone' => 'nullable|string|max:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_type_assurance' => 'required|exists:type_assurance,id',
            'n_cmu' => 'nullable|string|max:255',
            'n_assurance' => 'nullable|string|max:255',
            'sexe' => 'nullable|string|max:10',
            'maladie_chronique' => 'nullable|string',
            'poids' => 'nullable|string|max:10',
            'taille' => 'nullable|string|max:10',

        ]);

        // Trouvez l'utilisateur par ID
        $user = User::find($id);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/avatars');
            $image->move($destinationPath, $name);
            $user->photo = $name;
        }
        // Mettez à jour les informations personnelles
        $user->update([
            'fullname' => $request->input('fullname'),
            'ville' => $request->input('ville'),
            'adresse' => $request->input('adresse'),
            'phone' => $request->input('phone'),
            'id_type_assurance' => $request->input('id_type_assurance'),
            'n_cmu' => $request->input('n_cmu'),
            'n_assurance' => $request->input('n_assurance'),
            'sexe' => $request->input('sexe'),
            'maladie_chronique' => $request->input('maladie_chronique'),
            'poids' => $request->input('poids'),
            'taille' => $request->input('taille'),
            'photo' => $request->input('photo'),
        ]);

        return response()->json([
            'message' => 'Informations personnelles mises à jour avec succès',
            'user' => $user
        ], 200);
    }


    /**
     * @OA\Put(
     *     path="/api/user/update/{id}",
     *     tags={"Application mobile client"},
     *     summary="Mise à jour des informations de l'utilisateur",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données de mise à jour de l'utilisateur",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="fullname", type="string", description="Nom complet de l'utilisateur"),
     *             @OA\Property(property="adresse", type="string", description="Adresse de l'utilisateur"),
     *             @OA\Property(property="phone", type="string", description="Numéro de téléphone de l'utilisateur"),
     *             @OA\Property(property="ville", type="string", description="Ville de l'utilisateur"),
     *             @OA\Property(property="email", type="string", format="email", description="Adresse e-mail de l'utilisateur"),
     *             @OA\Property(property="id_type_assurance", type="integer", description="ID du type d'assurance de l'utilisateur"),
     *             @OA\Property(property="n_cmu", type="string", description="Numéro de la CMU de l'utilisateur"),
     *             @OA\Property(property="n_assurance", type="string", description="Numéro d'assurance de l'utilisateur"),
     *             @OA\Property(property="sexe", type="string", description="Genre de l'utilisateur"),
     *             @OA\Property(property="maladie_chronique", type="string", description="Maladie chronique de l'utilisateur"),
     *             @OA\Property(property="poids", type="string", description="Poids de l'utilisateur"),
     *             @OA\Property(property="taille", type="string", description="Taille de l'utilisateur"),
     *             @OA\Property(property="image", type="string", format="binary", description="Image de l'utilisateur"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Mise à jour réussie"),
     *     @OA\Response(response="400", description="Requête incorrecte"),
     *     @OA\Response(response="404", description="Utilisateur non trouvé"),
     * )
     */
    public function update(Request $request, int $id)
    {
        // Validez les données de la demande
        $request->validate([
            'fullname' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'id_type_assurance' => 'nullable|integer',
            'n_cmu' => 'nullable|string|max:255',
            'n_assurance' => 'nullable|string|max:255',
            'sexe' => 'required|string|max:255',
            'maladie_chronique' => 'nullable|string|max:500',
            'poids' => 'nullable|string|max:255',
            'taille' => 'nullable|string|max:255',
            'photo' => 'nullable|image',
        ]);
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/avatars');
            $image->move($destinationPath, $name);
            $user->photo = $name;
        }
        $user->update([
            'fullname' => $request->input('fullname'),
            'adresse' => $request->input('adresse'),
            'phone' => $request->input('phone'),
            'ville' => $request->input('ville'),
            'email' => $request->input('email'),
            'id_type_assurance' => $request->input('id_type_assurance'),
            'n_cmu' => $request->input('n_cmu'),
            'n_assurance' => $request->input('n_assurance'),
            'sexe' => $request->input('sexe'),
            'maladie_chronique' => $request->input('maladie_chronique'),
            'poids' => $request->input('poids'),
            'taille' => $request->input('taille'),
        ]);

        $user->save();
        return response()->json(['message' => 'Informations mises à jour avec succès',
        'user' => $user], 200);
    }

    /**
     * @OA\Get(
     *    path="/api/private/user/get-my-datas",
     *   tags={"Application mobile client"},
     *  summary="Récupérer les données de l'utilisateur connecté",
     * description="Récupérer les données de l'utilisateur connecté",
     * operationId="getMyDatas",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     *   response=200,
     *  description="Récupérer les données de l'utilisateur connecté",
     * @OA\JsonContent(
     *     @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     * ),
     * ),
     * @OA\Response(
     *   response=401,
     * description="Non autorisé",
     * ),
     * @OA\Response(
     *  response=404,
     * description="Utilisateur non trouvé",
     * ),
     * )
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     */
    public function getMyDatas()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        return response()->json(['user' => $user], 200);
    }

}
