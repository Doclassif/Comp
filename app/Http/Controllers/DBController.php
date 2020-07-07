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
        $oldImg = User::where('number_personnel', $number_personnel)->get();     
        $oldImgStr = substr($oldImg[0]->image_url, 16);
        Storage::delete('public/images/' . $oldImgStr);
        $newImg = Storage::put('public/images/', $request->file);
        $newImgStr = substr($newImg, 15);
        User::where('number_personnel', $number_personnel)
          ->update(['image_url' => '/storage/images/' . $newImgStr]);
        return $newImgStr;
    }
}
