<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;
use App\Models\Inventory;
use App\Models\InventoryLogs;


class InventoryController extends Controller
{
    /**
     * @OA\Get(
     *   tags={"Inventory"},
     *   path="/api/inventory/list",
     *   summary="Liste des équippements",
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Action non autorisée"),
     * )
     */

    public function getInventory(){
        $inventory = Inventory::all();
        return response()->json([
            'success' => true,
            'data' => $inventory
        ], 200);
    }

    /**mi
     * @OA\Post(
     *   tags={"Inventory"},
     *   path="/api/inventory/new",
     *   summary="Ajout d'un nouvel équippement",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="name", type="string", maxLength=45),
     *           @OA\Property(property="active_flag", type="boolean"),
     *           @OA\Property(property="brand", type="string", maxLength=45),
     *           @OA\Property(property="model", type="string", maxLength=45),
     *           @OA\Property(property="quantity", type="integer", minimum=1),
     *           @OA\Property(property="description", type="string", maxLength=45),
     *           @OA\Property(property="category_id", type="integer")
     *       )
     *   ),
     *   @OA\Response(response=200, description="Enregistrement réussi"),
     *   @OA\Response(response=401, description="Action non autorisée"),
     * )
     */

    public function addInventory(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:45',
            'active_flag' => 'nullable|boolean',
            'brand' => 'nullable|string|max:45',
            'model' => 'nullable|string|max:45',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:45',
            'category_id' => 'required|integer|exists:categories,category_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }
        $savedInventory=[];
        for ($i = 0; $i < $request->input('quantity'); $i++) {
            $inventory = new Inventory();
            $inventory->name = $request->input('name');
            $inventory->active_flag = $request->input('active_flag', 1);
            $inventory->brand = $request->input('brand');
            $inventory->model = $request->input('model');
            $inventory->code =  uniqid('INV-');
            $inventory->description = $request->input('description');
            $inventory->category_id = $request->input('category_id');
            if($inventory->save()){
                $inventoryLog = new InventoryLogs();
                $inventoryLog->inventory_id = $inventory->inventory_id;
                $inventoryLog->action_date = now();
                $inventoryLog->description = 'Enregistrement';
                $inventoryLog->creation_date = now();
                if($inventoryLog->save()){
                    $savedInventory['inventory'][] = $inventory->inventory_id;
                    $savedInventory['logs'][] = $inventoryLog->inventory_log_id;
                }
                
            }
        }
        $saved = count($savedInventory['inventory']);
        $savedLogs = count($savedInventory['logs']);
        if($saved == $savedLogs && $saved=$request->quantity){
            return response()->json([
               'success' => true,
               'saved' => $saved
           ], 200);
            
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Some inventory items were not logged properly',
                'saved_inventory' => $saved,
                'saved_logs' => $savedLogs
            ], 500);
        }


       
    }

    /**
     * @OA\Patch(
     *   tags={"Settings"},
     *   path="/api/settings/status/{id}",
     *   summary="Activation/Désactivation un équippement",
     *   @OA\Parameter(ref="#/components/parameters/id"),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */



}
