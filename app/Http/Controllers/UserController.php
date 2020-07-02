<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $result = DB::table('users')->groupBy('number_personnel')->get();
        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $item = User::create($request->validated());
        return response()->json($item, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {      
        $r=response()->json(User::where('сhief_num', $user->id)->get());     
        return $r;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->validated());

		$user->update();

        return response()->json($user,  Response::HTTP_OK);
        
        // return User::where('id', $user->id)
        // ->update(['number_personnel' => $request->number_personnel,
        // 'number_personnel' => $request->number_personnel,
        // 'first_name' => $request->first_name,
        // 'last_name' => $request->last_name,
        // 'middle_name' => $request->middle_name,
        // 'position' => $request->position,
        // 'date_start_work' => $request->date_start_work,
        // 'payday' => $request->payday,
        // 'сhief_num' => $request->сhief_num,
        // 'email' => $request->email
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
		return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
