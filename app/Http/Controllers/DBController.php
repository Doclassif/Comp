<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;

class DBController extends Controller
{
    public function draganddrop(Request $request)
    {
        $number_personnel = $request[0];
        $сhief_num = $request[1];
        $return = DB::update('update users set сhief_num = ?
        where number_personnel = ?', [$сhief_num, $number_personnel]);
        return $return;
    }
    public function view()
    {
        // $test = 'test';
        //$result = DB::table('users')->where('first_name', 'Руслан')->first();
        //$result = DB::table('users')->where('first_name', 'Руслан')->value('email');
        $result=User::all()->groupBy('number_personnel');
        //$result = DB::table('users')->groupBy('number_personnel')->get();
        return json_encode($result);
    }
    public function fileupd(Request $request)
    {

        $number_personnel = $request->item;
        // $path = $request->file->storeAs('', $number_personnel.'foto.jpg');
        $oldImg = DB::select('select image_url from users where number_personnel = ?', [$number_personnel]);
        $oldImgStr = substr($oldImg[0]->image_url, 16);
        Storage::delete('public/images/' . $oldImgStr);
        $newImg = Storage::put('public/images/', $request->file);
        $newImgStr = substr($newImg, 15);
        $return = DB::update('update users set image_url = ?
        where number_personnel = ?', ['/storage/images/' . $newImgStr, $number_personnel]);
        // Storage::setVisibility('images/'.$number_personnel.'foto.jpg', 'public');
        // $visibility = Storage::getVisibility('images/'.$number_personnel.'foto.jpg');
        return $newImgStr;
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $number_personnel = $request->number_personnel;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $middle_name = $request->middle_name;
        $position = $request->position;
        $date_start_work = $request->date_start_work;
        $payday = $request->payday;
        $сhief_num = $request->chief_num;
        $email = $request->email;
        $return = DB::update('update users set number_personnel = ?, first_name = ?, last_name = ?, middle_name = ?, position = ?, date_start_work = ?, payday = ? where id =  ?', [$number_personnel, $first_name, $last_name, $middle_name, $position, $date_start_work, $payday, $id]);
        return $return;
    }

    public function insert(Request $request)
    {
        $id = $request->id;
        $number_personnel = $request->number_personnel;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $middle_name = $request->middle_name;
        $position = $request->position;
        $date_start_work = $request->date_start_work;
        $payday = $request->payday;
        DB::insert('insert into users (number_personnel, first_name, last_name, middle_name, position, date_start_work, payday = ?) values (?, ?)', [1, 'Dayle']);
        $return = DB::update('update users set number_personnel = ?, first_name = ?, last_name = ?, middle_name = ?, position = ?, date_start_work = ?, payday = ? where id =  ?', [$number_personnel, $first_name, $last_name, $middle_name, $position, $date_start_work, $payday, $id]);
        return $return;
    }
}
