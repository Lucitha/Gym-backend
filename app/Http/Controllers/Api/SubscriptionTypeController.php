<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use OpenApi\Annotations as OA;

class SubscriptionTypeController extends Controller
{
    //liste des types d'abonnement
    /**
     * @OA\Get(
     * path="/api/subscription-types/list",
     * tags={"Subscription Types"},
     * summary="Liste des types d'abonnement",
     * @OA\Response(response=200, description="OK"),
     * 
     *) 
    */
     public function getSubscriptionTypes(){
        $subscriptionTypes=SubscriptionType::all();
        return response()->json([
            'success' => true,
            'data' => $subscriptionTypes
        ],200);
    }

    /**
     * @OA\Get(
     *   tags={"Subscription Types"},
     *   path="/api/subscription-types/{id}",
     *   summary="Détails d'un type d'abonnement",
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

    public function getSubscriptionTypesById($id){
        $subscriptionType=SubscriptionType::find($id);
        if(!$subscriptionType){
            return response()->json([
                'success' => false,
                'message' => 'Type d\'abonnement introuvable'
            ],404);
        }
        return response()->json([
            'success' => true,
            'data' => $subscriptionType
        ],200);
    }

    /**
     * @OA\Post(
     *   tags={"Subscription Types"},
     *   path="/api/subscription-types/new",
     *   summary="Ajout de type d'abonnement",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         required={ "name", "description", "amount", "duration_type_id"},
     *         @OA\Property(property="name", type="string", maxLength=45
     *         , example="Premium"),
     *         @OA\Property(property="description", type="string", maxLength=45
     *         , example="Abonnement premium"),
     *         @OA\Property(property="amount", type="string", maxLength=45
     *         , example="49.99"),
     *         @OA\Property(property="duration_type_id", type="integer", example=
     *         1),
     *         @OA\Property(property="active_flag", type="integer", example=1
     *         ),
     *         )
     *          )
     *        ),
     *   @OA\Response(response=200, description="Enregistrement effectué"),
     *   @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function addSubscriptionType(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:45',
            'description'=>'required|string|max:45',
            'amount'=>'nullable|numeric|max:45',
            'duration_type_id'=>'required|integer|exists:duration_types,duration_type_id',
            'active_flag'=>'nullable|integer'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],400);
        }

        $subscriptionType=new SubscriptionType();
        $subscriptionType->name=$request->name;
        $subscriptionType->description=$request->description;
        $subscriptionType->amount=$request->amount;
        $subscriptionType->duration_type_id=$request->duration_type_id;
        $subscriptionType->active_flag=$request->active_flag;
        $subscriptionType->creation_date=date('Y-m-d');
        $subscriptionType->save();

        return response()->json([
            'success' => true,
            'message' => 'Type de souscription créé avec succès',
            'data' => $subscriptionType
        ],201);
    }

    /**
     * @OA\Patch(
     *   tags={"Subscription Types"},
     *   path="/api/subscription-types/status/{id}",
     *   summary="Modifier le statut actif/inactif d'un type d'abonnement",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID du type d'abonnement",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Modification effectuée"),
     *   @OA\Response(response=401, description="Action non autorisée"),
     *   @OA\Response(response=404, description="Non trouvé")
     * )
     */

    public function toggleStatus($id){
        $subscriptionType=SubscriptionType::find($id);
        if(!$subscriptionType){
            return response()->json([
                'success' => false,
                'message' => 'Type d\'abonnement introuvable'
            ],404);
        }

        $subscriptionType->active_flag = !$subscriptionType->active_flag;
        $subscriptionType->save();

        return response()->json([
            'success' => true,
            'message' => 'Statut du type d\'abonnement mis à jour avec succès',
            'data' => $subscriptionType
        ],200);
    } 

    /**
     * @OA\Put(
     *   tags={"Subscription Types"},
     *   path="/api/subscription-types/update/{id}",
     *   summary="Mettre à jour les informations d'un type d'abonnement",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID du type d'abonnement",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *          @OA\Property(property="name", type="string", maxLength=45, example="Premium"),
     *          @OA\Property(property="description", type="string", maxLength=45, example="Abonnement premium"),
     *          @OA\Property(property="amount", type="string", maxLength=45, example="49.99"),
     *          @OA\Property(property="duration_type_id", type="integer", example=1),
     *          @OA\Property(property="active_flag", type="integer", example=1),
     *      )
     *     )
     *   ),
     *   @OA\Response(response=200, description="Mise à jour effectuée avec succès"),
     *   @OA\Response(response=401, description="Action non autorisée"),
     *   @OA\Response(response=404, description="Non trouvé")
     * )
     */

    public function update (Request $request,$id){
        $subscriptionType=SubscriptionType::find($id);
        if(!$subscriptionType){
            return response()->json([
                'success' => false,
                'message' => 'Type d\'abonnement introuvable'
            ],404);
        }

        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:45',
            'description'=>'required|string|max:45',
            'amount'=>'nullable|numeric|max:45',
            'duration_type_id'=>'required|integer|exists:duration_types,duration_type_id',
            'active_flag'=>'nullable|integer'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],400);
        }

        $subscriptionType->name=$request->name;
        $subscriptionType->description=$request->description;
        $subscriptionType->amount=$request->amount;
        $subscriptionType->duration_type_id=$request->duration_type_id;
        $subscriptionType->active_flag=$request->active_flag;
        $subscriptionType->save();

        return response()->json([
            'success' => true,
            'message' => 'Type d\'abonnement mis à jour avec succès',
            'data' => $subscriptionType
        ],200);
    }
   
    /**
     * @OA\Delete(
     *   tags={"Subscription Types"},
     *   path="/api/subscription-types/delete/{id}",
     *   summary="Suppression d'un type d'abonnement",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID du type d'abonnement",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */

    public function deleteSubscriptionType($id){
        $subscriptionType=SubscriptionType::find($id);
        if(!$subscriptionType){
            return response()->json([
                'success' => false,
                'message' => 'Type d\'abonnement introuvable'
            ],404);     
        }

        $subscriptionType->delete();

        return response()->json([
            'success' => true,
            'data' => 'Type d\'abonnement supprimé avec succès'
        ],200);
    }





}
