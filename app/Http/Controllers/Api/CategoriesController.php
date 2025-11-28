<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use OpenApi\Annotations as OA;

class CategoriesController extends Controller
{
    //
    /**
     * @OA\Get(
     * path="/api/categories/list",
     * tags={"Categories"},
     * summary="Liste des catégories",
     * @OA\Response(response=200, description="OK"),
     *
     *) 
    */
    public function getCategories(){
        
        $categories=Categories::all();

        return response()->json([
            'success' => true,
            'data' => $categories
        ],200);
    }

    /**
     * @OA\Post(
     *   tags={"Categories"},
     *   path="/api/categories/new",
     *   summary="Ajout de catégorie",
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={ "category_name"},
     *              @OA\Property(property="category_name", type="string", maxLength=45, example="Mathematics"),
     *              @OA\Property(property="active_flag", type="integer", example=1),
     *         )
     *        )
     *      ),
     *   @OA\Response(response=200, description="Enregistrement effectué"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */

    public function addCategory(Request $Request){
        $validator=Validator::make($Request->all(),[
            'category_name'=>'required|string|max:45',
            'active_flag'=>'nullable|integer'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],400);
        }

        $category=new Categories();
        $category->category_name=$Request->category_name;
        $category->active_flag=$Request->active_flag;
        $category->save();

        return response()->json([
            'success' => true,
            'data' => 'Category created successfully'
        ],201);
    }

    /**
     * @OA\Get(
     *   tags={"Categories"},
     *   path="/api/categories/{id}",
     *   summary="Récupérer une catégorie par ID", 
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
 public function getCategoryById($id){
        $category=Categories::find($id);
        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ],404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ],200);
    }



    /**
     * @OA\Patch(
     *   tags={"Categories"},
     *   path="/api/categories/status/{id}",
     *   summary="Modifier le statut d'une catégorie",
     *   @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la catégorie",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *   @OA\Response(response=200, description="Statut modifié avec succès"),
     *   @OA\Response(response=404, description="Catégorie non trouvée")
     * )
     */
    public function toggleCategoryStatus($id){
        $category= Categories::Find($id);
        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'Catégorie introuvable'
            ],404);     
        }
        $category->active_flag = !$category->active_flag;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Statut de la catégorie mis à jour avec succès'
        ],200);
    }

    /**
     * @OA\Put(
     *   tags={"Categories"},
     *   path="/api/categories/update/{id}",
     *   summary="Mettre à jour les informations d'une catégorie",
     *   @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID de la categorie"
     *     ),
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={ "category_name"},
     *              @OA\Property(property="category_name", type="string", maxLength=45, example="Mathematics"),
     *              @OA\Property(property="active_flag", type="integer", example=1),
     *          )
     *          )
     *      ),
     *    @OA\Response(response=201, description="Mis à jour effectuée avec succès"),
     *    @OA\Response(response=400, description="Demande invalide")
     * )
     */

    public function updateCategory(Request $request, $id){
        $validator=Validator::make($request->all(),[
            'category_name'=>'required|string|max:45',
            'active_flag'=>'nullable|integer'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],400);
        }

        $category=Categories::find($id);
        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'Catégorie non trouvée'
            ],404);     
        }

        $category->category_name=$request->category_name;
        $category->active_flag=$request->active_flag;
        $category->save();

        return response()->json([
            'success' => true,
            'data' => 'Categorie mise à jour avec succès'
        ],200);
    }

    /**
     * @OA\Delete(
     *   tags={"Categories"},
     *   path="/api/categories/delete/{id}",
     *   summary="Suppression d'une catégorie",
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
    public function deleteCategory($id){
        $category=Categories::find($id);
        if(!$category){
            return response()->json([
                'success' => false,
                'message' => 'Catégorie non trouvée'
            ],404);     
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'data' => 'Catégorie supprimée avec succès'
        ],200);
    }

    

}