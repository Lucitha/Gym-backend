<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use App\Models\CourseTypes;
use OpenApi\Annotations as OA;

class CourseTypesController extends Controller
{
    //liste des types de cours
    /**
     * @OA\Get(
     *     path="/api/course-type/list",
     *     tags={"Course Types"},
     *     summary="Liste des types de cours",
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function getCourseTypes()
    {
        $courseTypes=CourseTypes::all();

        return response()->json([
            'success' => true,
            'data' => $courseTypes
        ],200);
    }

    //ajout d'un type de cours
    /**
     * @OA\Post(
     *    path="/api/course-type/new",
     *    tags={"Course Types"},
     *    summary="Ajouter un nouveau type de cours",
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={ "course_type_name"},
     *              @OA\Property(property="course_type_name", type="string", maxLength=45, example="Mathematics"),
     *              @OA\Property(property="active_flag", type="integer", example=1),
     *          )
     *          )
     *      ),
     *    @OA\Response(response=201, description="Création avec succès"),
     *    @OA\Response(response=400, description="Demande invalide")
     * )
     */

    public function addCourseType(Request $Request){
        $validator=Validator::make($Request->all(),[
            'course_type_name'=>'required|string|max:45',
            'active_flag'=>'nullable|integer'
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'errors'=>$validator->errors()
            ],400);
        }
        $typeExist=CourseTypes::where('course_type_name',$Request->course_type_name)->first();
        if($typeExist){
            return response()->json([
                'success'=>false,
                'message'=>'Ce type de cours existe déjà'
            ],409);
        }
        $courseTypes=new CourseTypes();
        $courseTypes->course_type_name=$Request->course_type_name;
        $courseTypes->active_flag=$Request->active_flag;
        $courseTypes->save();
        if($courseTypes){
            return response()->json([
                'success'=>true,
                'message'=>'Type de cours ajouté avec succès'
            ],201);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Échec de l\'ajout du type de cours'
            ],500);
        }
    }

    //activer/désactiver un type de cours
    /**
     * @OA\Patch(
     *   tags={"Course Types"},
     *   path="/api/course-type/status/{id}",
     *   summary="Modifier le statut d'un type de cours",
     *   @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID "
     *     ),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */

    public function toggleStatus($id){
        // dd('hi,je suis là');
        $type= CourseTypes::Find($id);
        if(!$type){
            return response()->json([
                'success'=>false,
                'message'=>'Le type de cours indexé est introuvable' 
            ],404);
        }
        $type->active_flag=!$type->active_flag;
        
        if($type->save()){
            return response()->json([
                'success'=>true,
                'message'=>'Type de cours enregistré avec succès',
                'data'=>$type
            ],200);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Echec d\'enregistrement',
            ],500);
        }
    }
    //mettre à jour les informations du type de cour  
    /**
     * @OA\Put(
     *    path="/api/course-type/update/{id}",
     *    tags={"Course Types"},
     *    summary="Mettre à jours un type de cours",
     *    @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID de la salle"
     *     ),
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={ "course_type_name"},
     *              @OA\Property(property="course_type_name", type="string", maxLength=45, example="Mathematics"),
     *              @OA\Property(property="active_flag", type="integer", example=1),
     *          )
     *          )
     *      ),
     *    @OA\Response(response=201, description="Mis à jour effectuée avec succès"),
     *    @OA\Response(response=400, description="Demande invalide")
     * )
     */

    public function update(Request $Request,$id){
        $type = CourseTypes::Find($id);
        if(!$type){
            return response()->json([
                'success'=>false,
                'message'=>'Le type sélectionné est introuvable'
            ],404);
        }
        $type->course_type_name=$Request->course_type_name;
        if($type->save()){
            return response()->json([
                'success'=>true,
                'message'=>'Mis à jour effectuée avec succès'
            ],200);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'Echec d\'enregistrement'
            ],500);
        }
    }

    

}
