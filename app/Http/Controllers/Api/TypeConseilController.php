<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Free\TypeConseil;
use Illuminate\Http\Request;

class TypeConseilController extends Controller
{



    /**
     * @OA\Get( path="/api/public/typeconseils",
     *  tags={"Application mobile client"},
     * summary="Get all TypeConseils",
     *    @OA\Response(response="200",
     *    description="Get all TypeConseils",
     *   @OA\JsonContent(
     *   type="array",
     *  @OA\Items(ref="#/components/schemas/TypeConseil")
     * )
     * )
     * )
     */

    public function getAll()
    {
        return response()->json(TypeConseil::all(), 200);
    }





    /**
     * @OA\Get( path="/api/public/typeconseils/{id}",
     *  tags={"Application mobile client"},
     * summary="Get TypeConseil by id",
     *    @OA\Parameter(
     *    name="id",
     *    description="TypeConseil id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *    type="integer",
     *    format="int64"
     *    )
     *    ),
     *    @OA\Response(response="200",
     *    description="Get TypeConseil by id",
     *   @OA\JsonContent(ref="#/components/schemas/TypeConseil")
     * )
     * )
     */

    public function get(int $id)
    {
        $typeConseils = TypeConseil::find($id);
        if ($typeConseils){
            return response()->json(TypeConseil::find($id), 200);

        }
        return response()->json(['message'=>'Type de conseil non trouvé'], 404);

    }



    /**
     * @OA\Post(
     *     path="/api/admin/typeconseils",
     *     tags={"API ADMIN"},
     *     summary="Add TypeConseil",
     *     security={{"bearer":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TypeConseil")
     *     ),
     *     @OA\Response(response="201", description="TypeConseil created"),
     *     @OA\Response(response="400", description="Bad request"),
     *     @OA\Response(response="401", description="Unauthorized")
     * )
     */
    public function add(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:type_conseils|string',
            'description' => 'required|string',
        ]);

        $typec = TypeConseil::where('nom', $request->nom)->first();
        if ($typec) {
            return response()->json(['message' => 'Type de conseil existe déja'], 400);
        }
        $typeConseil = TypeConseil::create($request->all());
        return response($typeConseil, 201);
    }



    /**
     * @OA\Put( path="/api/admin/typeconseils/{id}",
     *  tags={"API ADMIN"},
     * summary="Update TypeConseil by id",
     *    @OA\Parameter(
     *    name="id",
     *    description="TypeConseil id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *    type="integer",
     *    format="int64"
     *    )
     *    ),
     *    @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TypeConseil")
     *     ),
     *    @OA\Response(response="200",
     *    description="Update TypeConseil by id",
     *   @OA\JsonContent(ref="#/components/schemas/TypeConseil")
     * )
     * )
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'required|string',
        ]);

        $typeConseil = TypeConseil::find($id);
        if (!$typeConseil) {
            return response()->json(['message' => 'Type de conseil non trouvé'], 404);
        }
        $typeConseil->update($request->all());
        return response($typeConseil, 200);
    }




    /**
     * @OA\Delete( path="/api/admin/typeconseils/{id}",
     *  tags={"API ADMIN"},
     * summary="Delete TypeConseil by id",
     *    @OA\Parameter(
     *    name="id",
     *    description="TypeConseil id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *    type="integer",
     *    format="int64"
     *    )
     *    ),
     *    @OA\Response(response="204",
     *    description="Delete TypeConseil by id",
     *   @OA\JsonContent(ref="#/components/schemas/TypeConseil")
     * )
     * )
     */

    public function delete(int $id)
    {
        $typeConseil = TypeConseil::find($id);
        if (!$typeConseil) {
            return response()->json(['message' => 'Type de conseil non trouvé'], 404);
        }
        $typeConseil->delete();
        return response()->json(['message' => 'Type de conseil supprimé avec succès'], 200);
    }

}
