<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Academicien;
use App\Http\Resources\AcademicienResource;

class AcademicienController extends Controller
{
     /**
     * Afficher une liste de la ressource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Academicien::latest()->get();
        return response()->json([AcademicienResource::collection($data), 'Academiciens récupérés.']);
    }
    

    /**
     * Stocker une ressource nouvellement créée 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'matricule' => 'required|string|max:10',
            'name' => 'required|string|max:35',
            'firstname' => 'required|string|max:35'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $academicien = Academicien::create([
            'matricule' => $request->matricule,
            'name' => $request->name,
            'firstname' => $request->firstname
         ]);
        
        return response()->json(['Academicien créé avec succès.', new AcademicienResource($academicien)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $academicien = Academicien::find($id);
        if (is_null($academicien)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new AcademicienResource($academicien)]);
    }

     /**
     * Mettre à jour la ressource spécifiée
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Academicien $academicien)
    {
        $validator = Validator::make($request->all(),[
            'matricule' => 'required|string|max:10',
            'name' => 'required|string|max:35',
            'firstname' => 'required|string|max:35'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $academicien->matricule = $request->matricule;
        $academicien->name = $request->name;
        $academicien->firstname = $request->firstname;
        $academicien->save();
        
        return response()->json(['Academicien mis à jour avec succès', new AcademicienResource($academicien)]);
    }

    /**
     * Supprimer la ressource spécifiée
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Academicien $academicien)
    {
        $academicien->delete();

        return response()->json('Academicien supprimé avec succès');
    }

}
