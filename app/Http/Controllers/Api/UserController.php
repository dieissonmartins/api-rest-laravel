<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(10);

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->all();

        try{

            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data); //Mass Asignment
            $user->profile()->create(
                [
                    'phone'         => $data['phone'],
                    'mobile_phone'  => $data['mobile_phone']
                ]
            );

            return response()->json([
                'data' => [
                    'msq' => 'Usuário Cadastrado com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
        
            return response()->json(['error' => $e->getMessage()], 401);
        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

            $user = $this->user->findOrFail($id); //Mass Asignment

            return response()->json([
                'data' => $user
            ], 200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data =  $request->all();

        try{
            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);

            $user = $this->user->findOrFail($id); //Mass Asignment
            $user->update($data);

            $user->profile()->update($profile);

            return response()->json([
                'data' => [
                    'msq' => 'Usuário Editado com sucesso!'
                ]
            ], 200);

        
        }catch(\Exception $e){
        
            return response()->json(['error' => $e->getMessage()], 401);
        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            $user = $this->user->findOrFail($id); //Mass Asignment
            $user->delete();
            
            return response()->json([
                'data' => [
                    'msq' => 'Usuário Deletado com sucesso!'
                ]
            ], 200);

        }catch(\Exception $e){
        
            return response()->json(['error' => $e->getMessage()], 401);
        
        }
    }
}
