<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DurationType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use OpenApi\Annotations as OA;

class DurationTypesController extends Controller
{
    //
    /**
     * @OA\Get(
     * path="/api/duration-types/list",
     * tags={"Duration Types"},
     * summary="Liste des types de durée",
     * @OA\Response(response=200, description="OK"),
     *
     *) 
    */
    public function getDurationTypes(){
        $durationTypes=DurationType::all();
        return response()->json([
            'success' => true,
            'data' => $durationTypes
        ],200);
    }

    /**
     * @OA\Get(
     *   tags={"Duration Types"},
     *   path="/api/duration-types/{id}",
     *   summary="Détails d'un type de durée",
     *    @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID du type de durée",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
    public function getDurationTypeById($id){
        $durationType=DurationType::find($id);
        if(!$durationType){
            return response()->json([
                'success' => false,
                'message' => 'Type de durée introuvable'
            ],404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Détails du type de durée récupérés avec succès',
            'data' => $durationType
        ],200);
    }

    //ajout d'un type de durée
    /**
     * @OA\Post(
     *   tags={"Duration Types"},
     *   path="/api/duration-types/new",
     *   summary="Ajouter un type de durée",
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"Duration_type"},
     *              @OA\Property(property="Duration_type", type="string", maxLength=45, example="Hour"),
     *              @OA\Property(property="active_flag", type="integer", example=1),
     *         )
     *        )
     *      ),
     *   @OA\Response(response=200, description="Enregistrement effectué"),
     *   @OA\Response(response=401, description="Action non autorisée"),
     * )
     */

    public function addDurationType(Request $request){
        $validator=Validator::make($request->all(),[
            'Duration_type'=>'required|string|max:45',
            'active_flag'=>'nullable|integer'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $durationType=new DurationType();
        $durationType->Duration_type=$request->Duration_type;
        $durationType->active_flag=$request->active_flag ?? 1;
        $durationType->save();

        return response()->json([
            'success' => true,
            'message' => 'Type de durée enregistré avec succès',
            'data' => $durationType
        ],201);

    }

    /**
     * @OA\Patch(
     *   tags={"Duration Types"},
     *   path="/api/duration-types/status/{id}",
     *   summary="Mettre à jour le statut actif/inactif d'un type de durée",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID du type de durée",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Action non autorisée"),
     *   @OA\Response(response=404, description="Non trouvé")
     * )
     */

    public function toggleStatus($id){
        $durationType=DurationType::find($id);
        if(!$durationType){
            return response()->json([
                'success' => false,
                'message' => 'Type de durée introuvable'
            ],404);
        }
        $durationType->active_flag = !$durationType->active_flag;
        $durationType->save();

        return response()->json([
            'success' => true,
            'data' => $durationType
        ],200);
    }

    /**
     * @OA\Put(
     *   tags={"Duration Types"},
     *   path="/api/duration-types/update/{id}",
     *   summary="Mettre  à jour les informations d'un type de durée",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         required={"Duration_type"},
     *         @OA\Property(property="Duration_type", type="string", maxLength=45, example="Hour"),
     *         @OA\Property(property="active_flag", type="integer", example=1),
     *       )
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID du type de durée",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Mise à jour effectuée avec succès"),
     *   @OA\Response(response=401, description="Action non autorisée"),
     *   @OA\Response(response=404, description="Non trouvé")
     * )
     */
    public function update (Request $request,$id){
        $durationType=DurationType::find($id);
        if(!$durationType){
            return response()->json([
                'success' => false,
                'message' => 'Type de durée introuvable'
            ],404);
        }

        $validator=Validator::make($request->all(),[
            'Duration_type'=>'required|string|max:45',
            'active_flag'=>'nullable|integer'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $durationType->Duration_type=$request->Duration_type;
        if($request->has('active_flag')){
            $durationType->active_flag=$request->active_flag;
        }
        $durationType->save();

        return response()->json([
            'success' => true,
            'message' => 'Type de durée mis à jour avec succès',
            'data' => $durationType
        ],200);
    }

    /**
     * @OA\Delete(
     *   tags={"Duration Types"},
     *   path="/api/duration-types/delete/{id}",
     *   summary="Summary",
     *  @OA\Parameter(
     *     name="id",
     *         in="path",
     *     required=true,
     *     @OA\Schema(type="integer"),
     *     description="ID du type de durée"
     *   ),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */

    public function deleteDurationType($id){
        $durationType=DurationType::find($id);
        if(!$durationType){
            return response()->json([
                'success' => false,
                'message' => 'Type de durée introuvable'
            ],404);
        }

        $durationType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Type de durée supprimé avec succès'
        ],200);
    }

}
