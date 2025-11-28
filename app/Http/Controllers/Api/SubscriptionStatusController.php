<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use App\Models\SubscriptionStatus;
use OpenApi\Annotations as OA;

class SubscriptionStatusController extends Controller
{
    //
    /**
     * @OA\Get(
     *   tags={"Subscription status"},
     *   path="/api/subscription-status/list",
     *   summary="Liste des statuts de souscription",
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Non autorisé"),
     *   @OA\Response(response=404, description="Non trouvé")
     * )
     */

    public function getSubscriptionStatuses(){
        $statuses=SubscriptionStatus::all();

        return response()->json([
            'success' => true,
            'data' => $statuses
        ],200);
    }

    /**
     * @OA\Get(
     *   tags={"Subscription status"},
     *   path="/api/subscription-status/{id}",
     *   summary="Détails d'un statut d'abonnement",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID du statut d'abonnement",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */

    public function getSubscriptionStatusById($id){
        $subscriptionStatus=SubscriptionStatus::find($id);
        if(!$subscriptionStatus){
            return response()->json([
                'success' => false,
                'message'=>'Elément introuvable'
            ],404);
        }
        return response()->json([
            'success' => true,
            'data' => $subscriptionStatus
        ],200);
    }

    /**
     * @OA\Post(
     *   tags={"Subscription status"},
     *   path="/api/subscription-status/new",
     *   summary="Ajout d'un statut d'abonnement",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="subscription_status",
     *           type="string",
     *           maxLength=45,
     *           example="Active"
     *         ),
     *         @OA\Property(
     *           property="active_flag", 
     *           type="integer", 
     *           example=1
     *         ),
     *       )
     *     )
     *   ),
     *   @OA\Response(response=200, description="Enregistrement effectué"),
     *   @OA\Response(response=401, description="Action non autorisée"),
     *   @OA\Response(response=404, description="Non trouvé")
     * )
     */

    public function addSubscriptionStatus(Request $request){
        $validator=Validator::make($request->all(),[
            'subscription_status'=>'required|string|max:45',
            'active_flag'=>'nullable|integer'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],400);
        }

        $status=new SubscriptionStatus();
        $status->subscription_status=$request->subscription_status;
        $status->active_flag=$request->active_flag;
        $status->save();

        return response()->json([
            'success' => true,
            'data' => 'Statut d\'abonnement créé avec succès'
        ],201);
    }

    /**
     * @OA\Patch(
     *   tags={"Subscription status"},
     *   path="/api/subscription-status/status/{id}",
     *   summary="Toggle active flag of a subscription status",
     *   @OA\Parameter(
     *     in="path",
     *     name="id",
     *     required=true,
     *     description="ID du statut d'abonnement",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="Enregistrement effectué"),
     *   @OA\Response(response=401, description="Non autorisé"),
     *   @OA\Response(response=404, description="Non trouvé")
     * )
     */
    public function toggleActiveFlag($id){
        $status=SubscriptionStatus::find($id);
        if(!$status){
            return response()->json([
                'success' => false,
                'message'=>'Elément introuvable'
            ],404);
        }
        $status->active_flag = !$status->active_flag;
        $status->save();

        return response()->json([
            'success' => true,
            'message' => 'Statut d\'abonnement mis à jour avec succès',
            'data' => $status
        ],200);
    }

    /**
     * @OA\Put(
     *   tags={"Subscription status"},
     *   path="/api/subscription-status/update/{id}",
     *   summary="Mettre à jour un statut d'abonnement",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID du statut d'abonnement",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(property="subscription_status", type="string", maxLength=45, example="Inactive"),
     *         @OA\Property(property="active_flag", type="integer", example=0)
     *         )
     *       )
     *     ),
     *   @OA\Response(response=200, description="Mis à jour effectuée avec succès"),
     *   @OA\Response(response=400, description="Demande invalide"),
     *   @OA\Response(response=404, description="Non trouvé")
     * )
     */

    public function updateSubscriptionStatus(Request $request,$id){
        $status=SubscriptionStatus::find($id);
        if(!$status){
            return response()->json([
                'success' => false,
                'message'=>'Elément introuvable'
            ],404);
        }

        $validator=Validator::make($request->all(),[
            'subscription_status'=>'required|string|max:45',
            'active_flag'=>'nullable|integer'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ],400);
        }

        $status->subscription_status=$request->subscription_status;
        $status->active_flag=$request->active_flag;
        $status->save();

        return response()->json([
            'success' => true,
            'message' => 'Statut d\'abonnement mis à jour avec succès',
            'data' => $status
        ],200);
    }

    /**
     * @OA\Delete(
     *   tags={"Subscription status"},
     *   path="/api/subscription-status/delete/{id}",
     *   summary="Suppression d'un statut d'abonnement",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID du statut d'abonnement",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */

    public function deleteSubscriptionStatus($id){
        $status=SubscriptionStatus::find($id);
        if(!$status){
            return response()->json([
                'success' => false,
                'message'=>'Elément introuvable'
            ],404);
        }
        $status->delete();

        return response()->json([
            'success' => true,
            'message' => 'Statut d\'abonnement supprimé avec succès'
        ],200);
    }




}
