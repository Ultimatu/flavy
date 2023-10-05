<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

     /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="API Documentation",
     *      description="Documentation des API de l'application =Flavy, solution pharmacie",
     *
     *      @OA\License(
     *          name="URL Accueil",
     *          url="https://lesinnovateurs.me"
     *      ),
     *     @OA\Server(
     *         description="Environnement local",
     *         url="http://localhost:8000/api/documentation"
     *     ),
     *     @OA\Server(
     *         description="Environnement de production",
     *         url="https://lesinnovateurs.me/api/documentation"
     *     ),
     * @OA\SecurityScheme(
     *    type="http",
     *   description="Authentification par token",
     *   scheme="bearer",
     *
     * )
     * )
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login', 'registerClient']);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Application mobile client et Desktop pharmacie"},
     *     summary="User login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="phone", type="string", format="phone", example="1234567890"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Successful login, returns user and token"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function login(Request $request)
    {

        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);
        $credentials = $request->only(['phone', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Connexion refusée, veuillez vérifier vos informations'], 401);
        }
        auth()->user()->tokens()->delete();

        $token = auth()->user()->createToken('ApiToken')->plainTextToken;
        $user = auth()->user();
        return response()->json([
            'user' => $user,
            'message' => 'Connexion effectuée avec succès',
            'Authorization' => [
                'token' => $token,
                'type' => 'Bearer'
            ]
        ], 200);
    }



    public function register(UserRequest $request)
    {
        //verifier si l'utilisateur existe par mail ou phone
        $user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();

        if ($user) {
            return response()->json([
                'message' => "Cet utilisateur existe déjà",

            ], 400);
        }
        $request = $request->validated();

        $request['password'] = bcrypt($request['password']);
        /*if ($request->hasFile('photo_url')) {
            $file = $request['photo_url'];
            //recuperer le nom du fichier
            $fileName = $file->getClientOriginalName();
            //recuperer l'extension du fichier
            $extension = $file->getClientOriginalExtension();

            //generer un nom unique pour le fichier
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            //deplacer le fichier vers le dossier de stockage

            $file->move('storage/photos', $fileNameToStore);

            //enregistrer le nom du fichier dans la base de donnees
            $nameToFront = 'storage/photos/' . $fileNameToStore;

            $request['photo_url'] = $nameToFront;
        }*/

        $user = User::create($request);


        $tokens = $user->createToken('ApiToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'Authorization' => [
                'token' => $tokens,
                'type' => 'Bearer'
            ],
            'message' => "Enregistré effectuer avec succès"
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register-client",
     *     tags={"Application mobile client"},
     *     summary="User registration",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"fullname", "phone", "password", "sexe"},
     *             type="object",
     *             @OA\Property(property="fullname", type="string", description="User fullname"),
     *             @OA\Property(property="adresse", type="string", description="User adresse"),
     *             @OA\Property(property="ville", type="string", description="User ville"),
     *             @OA\Property(property="phone", type="string", description="User phone number", example="+1234567890"),
     *             @OA\Property(property="email", type="string", format="email", description="User email", example="utilisateur@example.com"),
     *             @OA\Property(property="password", type="string", format="password", description="User password", example="motdepasse123"),
     *             @OA\Property(property="sexe", type="string", description="User gender", example="M"),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Successful registration"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */
    public function registerClient(Request $request): JsonResponse
    {
        $request['role_id'] = 1;

        // Extraire les attributs de la demande
        $attributes = $request->only([
            'fullname',
            'adresse',
            'phone',
            'ville',
            'email',
            'password',
            'sexe',
            'role_id',

        ]);

        $request->validate([
            'fullname' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'ville' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'password' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'sexe' => 'required|string|max:255',
        ]);

        // Vérifier si l'utilisateur existe par e-mail ou numéro de téléphone
        $user = User::where('email', $attributes['email'])
        ->orWhere('phone', $attributes['phone'])
        ->first();

        if ($user) {
            return response()->json([
                'message' => "Cet utilisateur existe déjà",
            ], 400);
        }

        // Hasher le mot de passe
        $attributes['password'] = bcrypt($attributes['password']);

        // Créer l'utilisateur avec les attributs extraits
        $user = User::create($attributes);

        // Générer un jeton d'API
        $tokens = $user->createToken('ApiToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'Authorization' => [
                'token' => $tokens,
                'type' => 'Bearer'
            ],
            'message' => "Enregistrement effectué avec succès"
        ],
            201
        );
    }




    /*
     * @OA\Put(
     *     path="/api/auth/update-user/{id}",
     *     tags={"Application mobile client"},
     *     summary="Update user profile",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"fullname", "phone", "sexe"},
     *             type="object",
     *             @OA\Property(property="fullname", type="string", description="User fullname"),
     *             @OA\Property(property="adresse", type="string", description="User adresse"),
     *             @OA\Property(property="ville", type="string", description="User ville"),
     *             @OA\Property(property="phone", type="string", description="User phone number", example="+1234567890"),
     *             @OA\Property(property="email", type="string", format="email", description="User email", example="utilisateur@example.com"),
     *             @OA\Property(property="password", type="string", format="password", description="User password", example="motdepasse123"),
     *             @OA\Property(property="sexe", type="string", description="User gender", example="male"),
     *             @OA\Property(property="maladie_chronique", type="string", description="User chronic illness", example="none"),
     *             @OA\Property(property="poids", type="string", description="User weight", example="70 kg"),
     *             @OA\Property(property="taille", type="string", description="User height", example="175 cm"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Successful update"),
     *     @OA\Response(response="400", description="Bad request"),
     *     @OA\Response(response="404", description="User not found")
     * )
     *
    public function updateUser(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Vérifiez les autorisations pour mettre à jour l'utilisateur si nécessaire

        $request->validate([
            'fullname' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'sexe' => 'required|string|max:255',
            'maladie_chronique' => 'nullable|string|max:255',
            'poids' => 'nullable|string|max:255',
            'taille' => 'nullable|string|max:255',
            'n_cmu' => 'nullable|string|max:255',
        ]);

        // Mettez à jour les champs de l'utilisateur ici

        $user->update($request->all());

        return response()->json(['message' => 'User updated successfully'], 200);
    }
    */




    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Application mobile client et Desktop pharmacie"},
     *     summary="User logout",
     *    security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="Successfully logged out"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function logout(): JsonResponse
    {
        if (Auth::check()) {
            auth()->user()->tokens()->delete();
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        }
        return response()->json([
            'message' => 'User not logged in',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     tags={"Application mobile client et Desktop pharmacie"},
     *     summary="Refresh authentication token",
     *     @OA\Response(response="200", description="Token refreshed"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */

    public function refresh(): JsonResponse
    {
        return response()->json([
            'user' => Auth::user(),
            'Authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'Bearer ',
            ]
        ]);
    }



}
