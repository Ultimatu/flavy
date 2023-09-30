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
        $this->middleware('auth:sanctum')->except(['login', 'register']);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Application mobile client et Desktop pharmacie"},
     *     summary="User login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
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
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        $credentials = $request->only(['email', 'password']);

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
     *            @OA\JsonContent(ref="#/components/schemas/User"),
     *
     *     ),
     *     @OA\Response(response="201", description="Successful registration"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     * )
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws
     */
    public function registerClient(Request $request): JsonResponse
    {

        $userRequest = new UserRequest();
        $request['role_id'] = 1;
        $request->validate([
            'fullname' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'photo' => 'nullable',
            'ville' => 'nullable|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string',
            'role_id' => 'required|exists:roles,id',
        ]);
        $userRequest->merge($request->all());



        return $this->register($userRequest);
    }



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
