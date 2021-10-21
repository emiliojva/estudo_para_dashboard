<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{

    public function __construct(){
      
      $this->middleware('auth');

    }                

    //
    public function show($filename,$extesion)
    {
      $filename = "{$filename}.{$extesion}";
      $pathToFile = "/assets/{$filename}"; 

      if( Storage::disk('local')->exists($pathToFile) ){
        return response()->file(storage_path().'/app'.$pathToFile);
      }
    }
}
