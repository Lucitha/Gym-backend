<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Room;
use App\Models\User;



class RoomsController extends Controller
{

    //liste des salles
    /**
     * @OA\Get(
      *     path="/api/rooms/list",
     *     tags={"Rooms"},
     *     summary="Liste des salles",
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function getRooms(Request $request)
    {
        // echo('pn est ici');
        $rooms=Room::all();

        return response()->json([
            'success' => true,
            'data' => $rooms
        ],200);
    }

    //ajout d'une salle
    /**
     * @OA\Post(
      *     path="/api/rooms/new",
     *     tags={"Rooms"},
     *     summary="Ajouter une nouvelle salle",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"name", "location", "capacity"},
     *                 @OA\Property(property="room_name", type="string", maxLength=255, example="Salle A"),
     *                 @OA\Property(property="active_flag", type="integer", example=1),
     *                 @OA\Property(property="capacity", type="integer", example=50),
     *                 @OA\Property(property="length", type="number", format="float", example=20.5),
     *                 @OA\Property(property="width", type="number", format="float", example=15.0),
     *                 @OA\Property(property="height", type="number", format="float", example=10.0),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Création avec succès"),
     *     @OA\Response(response=400, description="Demande invalide")
     * )
     */
    public function addRoom(Request $request){
        // Valider les données entrantes
        $validator = Validator::make($request->all(), [
            'room_name' => 'required|string|max:255',
            'active_flag' => 'nullable|integer',
            'capacity' => 'nullable|integer',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',  
            'height' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }
        // Créer une nouvelle salle
        $room = new Room();    
        $room->room_name = $request->input('room_name');
        $room->active_flag = $request->input('active_flag');
        $room->capacity = $request->input('capacity');
        $room->length = $request->input('length');
        $room->width = $request->input('width');
        $room->height = $request->input('height');
        $room->save();

        return response()->json([
            'success' => true,
            'data' => $room
        ], 201);
    }

    //Désactiver une salle
    /**
     * @OA\Patch(
      *     path="/api/rooms/status/{id}",
     *     tags={"Rooms"},
     *     summary="Activer/Désactiver une salle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID de la salle"
     *     ),
     *     @OA\Response(response=200, description="Réussite"),
     *     @OA\Response(response=404, description="Introuvable")
     * )
     */

    public function toggleRoomStatus($id){
        $room = Room::find($id);
        if(!$room){
            return response()->json([
                'success' => false,
                'message' => 'Salle introuvable'
            ], 404);
        }
        $room->active_flag = !$room->active_flag;
        $room->save();

        return response()->json([
            'success' => true,
            'data' => $room
        ], 200);
    }

    //modifier une salle
    /**
     * @OA\Put(
     *   path="/api/rooms/update/{id}",
     *   tags={"Rooms"},
     *   summary="Mettre les informations relatives à une salle",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer"),
     *     description="ID de la salle"
     *     ),
     *     @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(property="room_name", type="string", maxLength=
     *           255, example="Salle A"),
     *           @OA\Property(property="active_flag", type="integer", example=1),
     *           @OA\Property(property="capacity", type="integer", example=50),
     *           @OA\Property(property="length", type="number", format="float", example=20.5),
     *           @OA\Property(property="width", type="number", format="float", example=15.0),
     *           @OA\Property(property="height", type="number", format="float", example=10.0),
     *         )
     *       )
     *     ),
     *     @OA\Response(response=200, description="Mise à jour réussie"),
     *     @OA\Response(response=404, description="Salle introuvable")
     * )
     */

    public function updateRoom(Request $request, $id){
        $room = Room::find($id);
        if(!$room){
            return response()->json([
                'success' => false,
                'message' => 'Salle introuvable'
            ], 404);
        }

        // Valider les données entrantes
        $validator = Validator::make($request->all(), [
            'room_name' => 'sometimes|required|string|max:255',
            'active_flag' => 'sometimes|nullable|integer',
            'capacity' => 'sometimes|nullable|integer',
            'length' => 'sometimes|nullable|numeric',
            'width' => 'sometimes|nullable|numeric',  
            'height' => 'sometimes|nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        // Mettre à jour les informations de la salle
        $room->fill($request->only([
            'room_name', 'active_flag', 'capacity', 'length', 'width', 'height'
        ]));
        $room->save();

        return response()->json([
            'success' => true,
            'data' => $room
        ], 200);
    }

    //supprimer une salle
    /**
     * @OA\Delete(
     *   tags={"Rooms"},
     *   path="/api/rooms/delete/{id}",
     *   summary="Suppression d'une salle",
     *   @OA\Response(response=200, description="Suppression effectué avec succès"),
     *   @OA\Response(response=401, description="Vous n'êtes pas autorisé à réaliser cette action"),
     *   @OA\Response(response=404, description="Salle introuvable")
     * )
     */

    public function deleteRoom($id){
        $room = Room::find($id);
        if(!$room){
            return response()->json([
                'success' => false,
                'message' => 'Salle introuvable'
            ], 404);
        }
        
        $room->delete();
        return response()->json([
            'success' => true,
            'message' => 'Suppression effectué avec succès'
        ], 200);
    }
}