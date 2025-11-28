<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Gym API",
 *      description="API pour la gestion de salle de sport",
 *      @OA\Contact(
 *          email="admin@gym-gestion.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\Server(
 *      url="http://localhost:8000",
 *      description="Serveur de développement"
 * )
 * @OA\SecurityScheme(
 *      securityScheme="sanctum",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 * )
 */

class UsersController extends Controller
{
    /**
     * @OA\Get(
      *     path="/api/users",
     *     tags={"Users"},
     *     summary="Liste des utilisateurs",
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function getUsers(Request $request)
    {
        // echo('pn est ici');
        $users=User::all();

        return response()->json([
            'success' => true,
            'data' => $users
        ],200);
    }

    /**
     * @OA\Get(
      *    path="/api/members",
     *     tags={"Users"},
     *     summary="Liste des membres",
     *   @OA\Response(response=200, description="OK"),
     * )
     */

    public function getMembers(){
        $members=User::all();


        return response()->json([
            'success' => true,
            'data' => $users
        ],200);
    }


    /**
     * @OA\Post(
     *     path="/api/newUser",
     *     summary="Ajout d'un nouvel utilisateur",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"name", "email", "password"},
     *                 @OA\Property(property="name", type="string", maxLength=100, example="Cotonou"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(property="password", type="string",minLength=8, example="C0mplexP@ssw0rd"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Commune created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Utilisateur enregistré avec succès"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    
    public function addUser(Request $request){
       // Valider les données entrantes
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }else{
            // Créer un nouvel utilisateur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json([
                'success' => true,
                'data' => $user
            ], 201);
        }
    }

    /**
     * @OA\Put(
     *   tags={"Users"},
     *   path="/api/user/{id}/update",
     *   summary="Mettre à jour un utilisateur",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="name", type="string", maxLength=255),
     *       @OA\Property(property="email", type="string", format="email", maxLength=255),
     *      )
     *     
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
    public function updateUser(Request $request, $id){
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    /**
     * @OA\Delete(
     *   tags={"Users"},
     *   path="/api/user/{id}/delete",
     *   summary="Supprimer un utilisateur",
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
    public function deleteUser($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);  
        }
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès'
        ], 200);
    }      


}
