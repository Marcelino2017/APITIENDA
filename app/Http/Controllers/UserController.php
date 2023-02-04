<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = User::all();

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name'  => 'required|string|max:150',
            'last_name'   => 'required|string|max:150',
            'email'       => 'nullable|email|max:255|unique:users,email',
            'phone'       => 'required',
            'address' => 'required',
            'identification_number' => 'required',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->phone      = $request->phone;
        $user->address      = $request->address;
        $user->password   = bcrypt($request->password);
        $user->identification_number = $request->identification_number;
        $user->save();

        return response()->json($user, 201);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return  response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name'  => 'required|string|max:150',
            'last_name'   => 'required|string|max:150',
            'phone'       => 'required',
            'address'     => 'required',
            'identification_number' => 'required',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->identification_number = $request->identification_number;
        $user->save();

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            $array = array(
                'status' => 201,
                'dalete' => "Se elimino el usuario extitosamente"
            );
        } catch (\Exception $e) {
            $array = array(
                'status' => 404,
                'dalete' => $e
            );
        }

        return response()->json($array);
    }
}
