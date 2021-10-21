<?php

use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Gerado automaticamente pelo laravel/ui bootstrap --auth
 */
Auth::routes();

Route::get('/', function () {
  return view('welcome');
});















/**
 *  /
 */
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




/**
 * ava.uerj.br/media/nome_do_arquivo.pdf
 */
Route::get('media/{filename}.{extension}', [MediaController::class,'show']);




















/**
 * Armazenando um arquivo pdf por time()
 */
Route::get('test/pdf/write',function(){

  echo "Gravando arquivo pdf no storage...";

  /**
   * Nome do Arquivo PDF por timestamp()
   */
  $filename = '/pdf_'.time().'.pdf';
  $path_storage = storage_path() . $filename;
  
  /**
   * Gerando um arquivo pdf com DomPDF e guardando buffer em $pdf_gen
   */
  $dompdf = App::make('dompdf.wrapper');
  $dompdf->loadHtml("<h1>Test</h1> <p> - PDF gravado com sucesso em {$path_storage} </p>");
  $dompdf->setPaper('A4', 'portrait');
  $pdf_gen = $dompdf->output();
  
  /**
   * gravar no storage
   */
  Storage::disk('local')->put( $filename, $pdf_gen );   // Storage::disk('local')->put('example.txt', 'Contents');
  
  
  /**
   * Exibir stream do pdf como retorno
   */
  return $dompdf->stream();



  /**
   * Basic html to pdf
   */
  /*
  $pdf = App::make('dompdf.wrapper'); // Carregamento da facade por helper make
  $pdf->loadHTML('<h1>Test</h1>');
  return $pdf->stream();
  */
});

/**
 * Retornando usuarios SEM controller/views
 */
Route::get('test/users',function(){
  $users = \App\Models\User::all();
  dd($users->toArray());
});













/**
* basic Routes
*/
Route::get('hello', function(){
  return 'Bem vindo ao sistema Ava';
});

/**
* Params and Optionals Routes {arg?}
*/
Route::get('ola/{name}/{sobrenome?}', function($name,$lastname = null){
  return "Hello {$name} {$lastname}";
});

/**
* Autheticated Routes
*/
Route::middleware('auth')->get('auth',function(){
  return 'Estou logado';
});

/**
* Group Routes
*/
Route::middleware('auth')->group(function(){
  route::get('auth',function(){
    return 'rota 1';
  });

  route::get('auth-2',function(){
    return 'rota 2';
  });

});