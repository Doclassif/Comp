<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;

class DBController extends Controller
{
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
}
