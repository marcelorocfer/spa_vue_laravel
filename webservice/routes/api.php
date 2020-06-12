<?php

use App\User;
use App\Conteudo;
use App\Comentario;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/cadastro', "UsuarioController@cadastro");
Route::post('/login', "UsuarioController@login");
Route::middleware('auth:api')->put('/perfil', "UsuarioController@perfil");
Route::middleware('auth:api')->post('/conteudo/adicionar', "ConteudoController@adicionar");
Route::middleware('auth:api')->get('/conteudo/lista', "ConteudoController@lista");
Route::middleware('auth:api')->put('/conteudo/curtir/{id}', "ConteudoController@curtir");
Route::middleware('auth:api')->put('/conteudo/curtirpagina/{id}', "ConteudoController@curtirpagina");
Route::middleware('auth:api')->put('/conteudo/comentar/{id}', "ConteudoController@comentar");
Route::middleware('auth:api')->put('/conteudo/comentarpagina/{id}', "ConteudoController@comentarpagina");

Route::middleware('auth:api')->get('/conteudo/pagina/lista/{id}', "ConteudoController@pagina");

Route::middleware('auth:api')->post('/usuario/amigo', "UsuarioController@amigo");
Route::middleware('auth:api')->get('/usuario/listaamigos', "UsuarioController@listaamigos");
Route::middleware('auth:api')->get('/usuario/listaamigospagina/{id}', "UsuarioController@listaamigospagina");

Route::get('/testes', function() {

    /*
     *
    $user = User::find(1);
    $amigos = $user->amigos()->pluck('id');
    $amigos->push($user->id);
    $conteudos = Conteudo::whereIn('user_id', $amigos)->with('user')->orderBy('data', 'DESC')->paginate(5);
    dd($amigos);
    */

    // dd(Conteudo::all());
    /*
    $user = User::find(1);

    $conteudo = Conteudo::find(9);
    $user->comentarios()->create([
        'conteudo_id' => $conteudo->id,
        'texto' => 'Muito bom!',
        'data' => date('Y-m-d H:i:s')
    ]);
    */
//    $user = User::find(1);
//    $user2 = User::find(2);

//    $conteudos = Conteudo::all();
//    foreach ($conteudos as $key => $value) :
//        $value->delete();
//    endforeach;

    // Add Conteúdo:
    /*
        $user->conteudos()->create([
            'titulo'=>'Conteúdo 2',
            'texto'=>'Texto 2',
            'imagem'=>'URL da imagem 2',
            'link'=>'Link 2',
            'data'=>'2019-08-28'
        ]);
        return $user->conteudos;
    */

    // Add Amigo:
    /*
        $user->amigos()->toggle($user2->id);

        return $user->amigos;
    */

    // Add Curtida:
    /*
        $conteudo = Conteudo::find(1);
        $user->curtidas()->toggle($conteudo->id);

        // return $conteudo->curtidas()->count();
        return $conteudo->curtidas;
    */

    // Add Comentários
    /*
        $conteudo = Conteudo::find(1);
        $user->comentarios()->create([
            'conteudo_id'=>$conteudo->id,
            'texto'=>'Muito bom!',
            'data'=>date('Y-m-d')
        ]);
        $user2->comentarios()->create([
            'conteudo_id'=>$conteudo->id,
            'texto'=>'Legal!',
            'data'=>date('Y-m-d')
        ]);
        return $conteudo->comentarios;
    */

});

