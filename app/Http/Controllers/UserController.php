<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use \App\Http\Requests\StoreUserRequest;
use \App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $fields = $request->validated();

        // dd($fields);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => $fields['password'],
            'phone' => $fields['phone'],
            'social_media' => $fields['social_media'],
        ]);

        return response()->json([
            'status' => true,
            'body'   => $user,
            'token'  => $user->createToken('userLogged')->plainTextToken
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userData = User::find($id);

        if(isset($userData)){

            $userData['placesVisited'] = $this->countAllRegistersInTable('posts', $id); 
            $userData['comments']      = $this->countAllRegistersInTable('comments', $id); 

            // dd($userData);
            // $userData['created_at'] = $userData

            return response()->json([
                'status' => true,
                'body' => $userData,
            ], 200); 
        }

        return response()->json([
            'status' => false,
            'message' => 'Usuário não encontrado!'
        ], 404);
    }

    /**
     * Return the count of registers on Table based in ID 
     */ 
    private function countAllRegistersInTable($name, $id){
        $count = DB::table($name)->where('user_id', $id)->count();
        return $count;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}