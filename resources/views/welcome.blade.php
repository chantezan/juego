<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100%;
                margin: 0;
            }

        </style>
    </head>
    <body>
    <div class="">
        <div class="row justify-content-md-center">

        <div class="col-md-2">
            <h2> Usuario </h2>
            <table class="table">
                <thead>
                <th> Mejores Puntajes</th>
                </thead>
                <tbody id="local">
                </tbody>
            </table>
        </div>
        <div class="col-md-7">
            <canvas id="myCanvas" width="1000" height="800" style="border:1px solid #000000;">
            </canvas>
        </div>
            <div class="col-md-1">
                <h2> Mejores Puntajes Globales Etapa 1</h2>
                <table  class="table">
                    <thead>
                    <th>Usuario</th>
                    <th>Puntaje</th>
                    </thead>
                    <tbody id="global1">

                    </tbody >
                </table>
                <hr>
                <br>
                <h2> Mejores Puntajes Globales Etapa 2</h2>
                <table  class="table">
                    <thead>
                    <th>Usuario</th>
                    <th>Puntaje</th>
                    </thead>
                    <tbody id="global2">

                    </tbody >
                </table>
            </div>
        </div>
    </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
      $(document).ready(function(){
        actualizar();

        var USUARIO = prompt("Please enter your name", "Usuario");
        var puntajes = [];
        var TIEMPO_JUEGO = 60;
        var ETAPA = 1;
        var CANTIDAD_JUEGOS = 2;
        var timeoutHandle;
        var size = 100;
        var canvas = document.getElementById('myCanvas');
        var elemLeft = $("#myCanvas").offset().left;
        var elemTop = $("#myCanvas").offset().top;
        var context = canvas.getContext('2d');
        var inicial_x = 100;
        var inicial_y = 250;
        var actual_x = inicial_x;
        var actual_y = inicial_y;
        var first = true;
        var puntaje = 0;
        var tiempo_restante = TIEMPO_JUEGO;
        var lineas = [];
        var lineas_antiguas = [];
        juego1 = [{x:300,y:260,selected:false},{x:400,y:600,selected:false},{x:250,y:600,selected:false},{x:690,y:400,selected:false}];
        juego2 = [{x:400,y:260,selected:false},{x:400,y:500,selected:false},{x:250,y:600,selected:false},{x:690,y:400,selected:false},{x:690,y:600,selected:false}];
        elements = juego1;
        fondo_image = new Image();
        fondo_image.src = '{{ URL::asset('image/fondo.jpg')}}';
        fondo_image.onload = function(){
          reload_image = new Image();
          reload_image.src = '{{ URL::asset('image/reload.png')}}';
          reload_image.onload = function() {
          };
          make_base();
          time(tiempo_restante);
        };
        canvas.addEventListener('click', function(event) {
          var x = event.pageX - elemLeft,
              y = event.pageY - elemTop;
          if (y > 50 && y < 100
              && x > 850 && x < 950) {
            lineas = [];
            actual_x = inicial_x;
            actual_y = inicial_y;
            elements.forEach(function(element) {
              element.selected = false;
            });
            dibujar();
          }
        });

        canvas.addEventListener('click', function(event) {
          var x = event.pageX - elemLeft,
              y = event.pageY - elemTop;
          // Collision detection between clicked offset and element.
          elements.forEach(function(element) {
            if (element.selected == false && y > element.y && y < element.y + size
                && x > element.x && x < element.x + size) {
                element.selected = true;
                actual_x = element.x;
                actual_y = element.y;
                lineas.push([actual_x,actual_y]);
                dibujar();
            }
          });
        }, false);

        function dibujar_linea_antigua() {
          context.beginPath();
          primero = null;
          anterior = null;
          lineas_antiguas.forEach(function(element) {
            if(primero == null) {
              primero = element;
              anterior = primero;
            } else {
              context.moveTo(anterior[0] + size/2, anterior[1] + size/2);
              context.lineTo(element[0] + size/2, element[1] + size/2);
              context.strokeStyle="red";
              context.stroke();
              anterior = element;
            }
          });
          if(primero != null ) {
            context.moveTo(primero[0] + size/2, primero[1] + size/2);
            context.lineTo(anterior[0] + size/2, anterior[1] + size/2);
            context.strokeStyle="red";
            context.stroke();
          }

        }

        function sortNumber(a,b) {
          return a - b;
        }

        function dibujar() {
          primero = null;
          anterior = null;
          puntaje = 0;
          context.drawImage(fondo_image, 0, 0,canvas.width,canvas.height);
          dibujar_linea_antigua();
          context.beginPath();
          primero = null;
          anterior = null;
          lineas.forEach(function(element) {
            if(primero == null) {
              primero = element;
              anterior = primero;
            } else {
              calculo = Math.sqrt(Math.pow(anterior[0] - element[0],2) + Math.pow(anterior[1] - element[1],2));
              context.moveTo(anterior[0] + size/2, anterior[1] + size/2);
              context.lineTo(element[0] + size/2, element[1] + size/2);
              context.strokeStyle="#fff";
              context.stroke();
              anterior = element;
              puntaje = puntaje + calculo;
            }

          });
          if(lineas.length == elements.length) {
            context.moveTo(anterior[0] + size/2, anterior[1] + size/2);
            context.lineTo(primero[0] + size/2, primero[1] + size/2);
            context.strokeStyle="#fff";
            context.stroke();
            lineas_antiguas = lineas.slice();
            puntajes.push(puntaje);
            puntajes.sort(sortNumber);
            $.get("{{action('JuegoController@recibirPuntaje')}}",{ etapa:ETAPA,usuario:USUARIO,puntaje:puntaje }, function(data, status){
              $("#local").empty();
              puntajes.forEach(function(element) {
                $("#local").append("<tr><td>"+element.toFixed(0)+"</td></tr>")
              });
            });
            //alert("juego terminado");
          }
          context.fillStyle = "black";
          //context.fillRect(650,50,size,size);
          context.font = "30px Arial";
          context.fillStyle = "red";
          context.textAlign = "center";
          context.fillText(puntaje.toFixed(0).toString(),700,100);

          elements.forEach(function(element) {
            context.drawImage(base_image, element.x, element.y,size,size);
          });

          dibujar_tiempo();
          dibujar_reload();
          context.drawImage(ini_image, actual_x - 50, actual_y - 50,size,size)
        }

        function dibujar_tiempo() {
          context.fillStyle = "white";
          context.fillRect(80,60,60,60);
          context.font = "20px Arial";
          context.textAlign = "center";
          context.fillStyle = "black";
          context.fillText(tiempo_restante.toFixed(0).toString(),100,100);
        }

        function dibujar_reload() {
          context.drawImage(reload_image, 850, 50,50,50);
        }

        function time(i) {
          timeoutHandle = setTimeout(function(){
            if(i == 0) {

              if(CANTIDAD_JUEGOS == 1) {
                alert("se acabo el juego");
                context.fillStyle = "white";
                context.fillRect(0,0,canvas.width,canvas.height);
                exit();
              } else {
                alert("se acabo el tiempo vamos a la siguiente etapa");
              }
              ETAPA = ETAPA + 1;
              lineas_antiguas = [];
              lineas = [];
              puntajes = [];
              $("#local").empty();
              actual_x = inicial_x;
              actual_y = inicial_y;
              elements.forEach(function(element) {
                element.selected = false;
              });
              i = TIEMPO_JUEGO;
              tiempo_restante = TIEMPO_JUEGO
              elements = juego2;
              if(CANTIDAD_JUEGOS != 1) {
                dibujar();
              }
              CANTIDAD_JUEGOS = CANTIDAD_JUEGOS - 1;
            }
            if(i != 0) {
              dibujar_tiempo();
            }
            tiempo_restante = i - 1;

            time(tiempo_restante) }, 1000);
        }

        function make_base()
        {
          ini_image = new Image();
          ini_image.src = '{{ URL::asset('image/codorito.png')}}';
          ini_image.onload = function(){
            base_image = new Image();
            base_image.src = '{{ URL::asset('image/casita5.png')}}';
            base_image.onload = function(){
              dibujar();
            };
          };
        }

        function actualizar() {
          setInterval(function(){
            $.get("{{action('JuegoController@actualizar')}}",{ etapa:1 }, function(data, status){
                $("#global1").empty();
                data.forEach(function(element) {
                  $("#global1").append("<tr><td>"+element.usuario+"</td><td>"+element.puntaje+"</td></tr>")
                });
            });
          },3000);

          setInterval(function(){
            $.get("{{action('JuegoController@actualizar')}}",{ etapa:2 }, function(data, status){
              $("#global2").empty();
              data.forEach(function(element) {
                $("#global2").append("<tr><td>"+element.usuario+"</td><td>"+element.puntaje+"</td></tr>")
              });
            });
          },3000);
        }
      });

    </script>
</html>
