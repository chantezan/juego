<?php

namespace App\Http\Controllers;

use App\Puntaje;
use Illuminate\Http\Request;

class JuegoController extends Controller
{
    public function actualizar(Request $request)
    {

      return Puntaje::where('etapa',$request["etapa"])->orderBy('puntaje','asc')->groupBy('usuario')->take(10)->get();
    }

    public function recibirPuntaje(Request $request){
      $puntaje = new Puntaje();
      $puntaje->usuario = $request['usuario'];
      $puntaje->etapa = $request['etapa'];
      $puntaje->puntaje = $request['puntaje'];
      $puntaje->save();
      return http_response_code(200);
    }
}
