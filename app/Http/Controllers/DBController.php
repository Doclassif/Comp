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
        $user = User::where('number_personnel', $number_personnel);
        $oldImg = $user->first();     
        $oldImgStr = substr($oldImg->image_url, 16);
        Storage::delete('public/images/' . $oldImgStr);
        $newImg = Storage::put('public/images/', $request->file);
        $newImgStr = substr($newImg, 15);
        $user->update(['image_url' => '/storage/images/' . $newImgStr]);
        return $newImgStr;
    }
}
