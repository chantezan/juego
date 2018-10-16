<?php

use Illuminate\Database\Seeder;

class PuntajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $puntaje = new \App\Puntaje();
        $puntaje->usuario = "fifi";
        $puntaje->puntaje = 100;
      $puntaje->etapa = 2;
        $puntaje->save();

      $puntaje = new \App\Puntaje();
      $puntaje->usuario = "pepe";
      $puntaje->puntaje = 2000;
      $puntaje->etapa = 1;
      $puntaje->save();

      $puntaje = new \App\Puntaje();
      $puntaje->usuario = "rere";
      $puntaje->puntaje = 1500;
      $puntaje->etapa = 1;
      $puntaje->save();

      $puntaje = new \App\Puntaje();
      $puntaje->usuario = "jiji";
      $puntaje->puntaje = 1000;
      $puntaje->etapa = 2;
      $puntaje->save();

      $puntaje = new \App\Puntaje();
      $puntaje->usuario = "riri";
      $puntaje->puntaje = 800;
      $puntaje->etapa = 2;
      $puntaje->save();

      $puntaje = new \App\Puntaje();
      $puntaje->usuario = "bebe";
      $puntaje->puntaje = 1700;
      $puntaje->etapa = 2;
      $puntaje->save();

      $puntaje = new \App\Puntaje();
      $puntaje->usuario = "gepe";
      $puntaje->puntaje = 96;
      $puntaje->etapa = 1;
      $puntaje->save();
    }
}
