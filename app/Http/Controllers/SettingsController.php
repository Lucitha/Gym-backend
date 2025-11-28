<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;
use App\Models\Settings;

class SettingsController extends Controller
{
    //
    /**
     * @OA\Get(
     *   tags={"Settings"},
     *   path="/api/settings",
     *   summary="Informations sur un paramètre de configuration",
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=404, description="Not Found")
     * )
     */
    public function getSettings(){
        $settings = Settings::first();
        return response()->json([
            'success' => true,
            'data' => $settings
        ], 200);
    }

    /**
     * @OA\Put(
     *   tags={"Settings"},
     *   path="/api/settings/update",
     *   summary="Mise à jour des informations sur un paramètre de configuration",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *           type="object",
     *           @OA\Property(property="company", type="string"),
     *           @OA\Property(property="logo", type="string"),
     *           @OA\Property(property="horraires", type="string", exemple=["Mon-Fri: 9am - 6pm", "Sat: 10am - 4pm"]),
     *           @OA\Property(property="description", type="string"),
     *           @OA\Property(property="contacts", type="string", exemple=["email@example.com", "123-456-7890"]),  
     *           @OA\Property(property="social_link", type="string", exemple=["facebook.com/yourpage", "twitter.com/yourhandle"])
     *       )
     *   ),
     *   @OA\Response(response=200, description="Mise à jour réussie"),
     *   @OA\Response(response=401, description="Autorisation refusée"),
     * )
     */

    public function updateSettings(Request $request){
        $validator = Validator::make($request->all(), [
            'company' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
            'horraires' => 'nullable|string',
            'description' => 'nullable|string',
            'contacts' => 'nullable|string',
            'social_link' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $settings = Settings::first();
        if (!$settings) {
            return response()->json([
                'success' => false,
                'message' => 'Settings not found'
            ], 404);
        }
        //ajouter le logo dans un repertoire de stockage et enregistrer le chemin
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $request->merge(['logo' => $path]);
        }
        
        $settings->update($request->only([
            'company',
            'logo',
            'horraires',
            'description',
            'contacts',
            'social_link'
        ]));

        return response()->json([
            'success' => true,
            'data' => $settings
        ], 200);
    }
}
