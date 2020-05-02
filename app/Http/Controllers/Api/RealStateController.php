<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RealState;
use App\Http\Requests\RealStateResquest;

class RealStateController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
        $realState = $this->realState->paginate(10);

        return response()->json($realState, 200);
    }

    public function show($id)
    {
        try{

            $realState = $this->realState->findOrFail($id); //Mass Asignment

            return response()->json([
                'data' => [
                    'realState' => 'dados do Imóvel!',
                    'dataState' =>  $realState
                ]
            ], 200);

        }catch(\Exception $e){
        
            return response()->json(['error' => $e->getMessage()], 401);
        
        }
    } 

    public function store(RealStateResquest $request)
    {   
        $data =  $request->all();

        try{

            $realState = $this->realState->create($data); //Mass Asignment

            if( isset($data['categories']) && count($data['categories'])){
                $realState->categories()->sync($data['categories']);
            }

            return response()->json([
                'data' => [
                    'msq' => 'Imóvel Cadastrado com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
        
            return response()->json(['error' => $e->getMessage()], 401);
        
        }
    }

    public function update($id, RealStateResquest $request)
    {
        $data =  $request->all();

        try{

            $realState = $this->realState->findOrFail($id); //Mass Asignment
            $realState->update($data);

            if( isset($data['categories']) && count($data['categories'])){
                $realState->categories()->sync($data['categories']);
            }

            return response()->json([
                'data' => [
                    'msq' => 'Imóvel Editado com sucesso!'
                ]
            ], 200);

        
        }catch(\Exception $e){
        
            return response()->json(['error' => $e->getMessage()], 401);
        
        }
    }

    public function destroy($id)
    {
        try{

            $realState = $this->realState->findOrFail($id); //Mass Asignment
            $realState->delete();
            
            return response()->json([
                'data' => [
                    'msq' => 'Imóvel Deletado com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
        
            return response()->json(['error' => $e->getMessage()], 401);
        
        }
    }
}
