<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Free\Conseils;
use Illuminate\Http\Request;

class ConseilController extends Controller
{


    /**
     * @OA\Get( path="/api/public/conseils",
     *  tags={"API PUBLIC"},
     * summary="Get all Conseils",
     *    @OA\Response(response="200",
     *    description="Get all Conseils",
     *   @OA\JsonContent(
     *   type="array",
     *  @OA\Items(ref="#/components/schemas/Conseils")
     * )
     * )
     * )
     */

    public function getAll()
    {
        return response()->json(Conseils::all(), 200);
    }


    /**
     * @OA\Get( path="/api/public/conseils/{id}",
     *  tags={"API PUBLIC"},
     * summary="Get Conseils by id",
     *    @OA\Parameter(
     *    name="id",
     *    description="Conseils id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *    type="integer",
     *    format="int64"
     *    )
     *    ),
     *    @OA\Response(response="200",
     *    description="Get Conseils by id",
     *   @OA\JsonContent(ref="#/components/schemas/Conseils")
     * )
     * )
     */
    public function get(int $id)
    {

        $conseil = Conseils::find($id);
        if ($conseil){
            return response()->json($conseil, 200);

        }
        return response()->json(['message'=>"Conseil non trouvé"], 404);
    }



    /**
     * @OA\Post( path="/api/admin/conseils",
     *  tags={"API ADMIN"},
     * summary="Add Conseils",
     *    @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/Conseils"),
     *    ),
     *    @OA\Response(response="201",
     *    description="Add Conseils",
     *   @OA\JsonContent(ref="#/components/schemas/Conseils")
     * )
     * )
     */

    public function add(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'image' => 'nullable',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('conseils', $filename);
            $request->input('image', $filename);
        }

        $conseil = Conseils::create($request->all());
        return response()->json($conseil, 201);
    }




    /**
     * @OA\Put( path="/api/admin/conseils/{id}",
     *  tags={"API ADMIN"},
     * summary="Update Conseils by id",
     *    @OA\Parameter(
     *    name="id",
     *    description="Conseils id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *    type="integer",
     *    format="int64"
     *    )
     *    ),
     *    @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/Conseils"),
     *    ),
     *    @OA\Response(response="200",
     *    description="Update Conseils by id",
     *   @OA\JsonContent(ref="#/components/schemas/Conseils")
     * )
     * )
     */
    public function update(Request $request, $id)
    {
        $conseil = Conseils::find($id);
        if (is_null($conseil)) {
            return response()->json(['message' => 'Conseil non trouvé'], 404);
        }
        $conseil->update($request->all());
        return response()->json($conseil, 200);
    }



    /**
     * @OA\Delete( path="/api/admin/conseils/{id}",
     *  tags={"API ADMIN"},
     * summary="Delete Conseils by id",
     *    @OA\Parameter(
     *    name="id",
     *    description="Conseils id",
     *    required=true,
     *    in="path",
     *    @OA\Schema(
     *    type="integer",
     *    format="int64"
     *    )
     *    ),
     *    @OA\Response(response="204",
     *    description="Delete Conseils by id",
     *   @OA\JsonContent(ref="#/components/schemas/Conseils")
     * )
     * )
     */
    public function delete(int $id)
    {
        $conseil = Conseils::find($id);
        if (is_null($conseil)) {
            return response()->json(['message' => 'Conseil non trouvé'], 404);
        }
        $conseil->delete();
        return response()->json(null, 204);
    }



}
