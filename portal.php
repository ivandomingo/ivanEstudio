<?php
session_start();

if(!isset($_SESSION['username'])) 
{
    header('Location: login.php'); 
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" type="text/javascript"></script>
        <title>Prueba estudio</title>
    </head>
    <script>
        $(document).ready(function() {
            carrito = new Carrito();
            $.ajax({
                dataType: 'json',
                url: 'categorias/categorias.php',
                success: function(data) {
                    html = '<center><h2>Categorias</h2></center><div id="general">';
                    $.each(data, function(index) {
                        html += '<div class="categorias" id="categoria' + index + '"><a href="javascript:articulos(' + data[index].idCategoria + ')">' + data[index].nombreCategoria + '</a></div>';
                    });
                    html += '</div>';
                    html += '';
                    $("#contenidoGeneral").html(html);
                }
            });
        });

        //=========================== Carrito ==============================//

        function Carrito() {
            fecha = new Date();
            this.fechaCreacion = fecha.getFullYear() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getDate();
            this.listaArticulos = [];
        }
        ;

        Carrito.prototype.anyadirArticulo = function(articulo) {
            existe = false;

            if (this.listaArticulos.length == 0) {
                existe = false;
            } else {
                for (i = 0; i < this.listaArticulos.length; i++) {
                    if (this.listaArticulos[i].idArticulo == articulo.idArticulo) {
                        existe = true;
                        this.listaArticulos[i].unidades++;
//                        guardarCarrito();
                    }
                }
            }

            if (existe == false) {
                this.listaArticulos[this.listaArticulos.length] = articulo;
//                guardarCarrito();
            }
        };

        Carrito.prototype.borrarUnidadArticulo = function(idArticulo) {
            for (i = 0; i < this.listaArticulos.length; i++) {
                if (this.listaArticulos[i].idArticulo == idArticulo) {
                    if (this.listaArticulos[i].unidades == 1) {
                        this.listaArticulos.splice(i, 1);
                        guardarCarrito();
                    } else {
                        this.listaArticulos[i].unidades--;
//                        guardarCarrito();
                    }
                }
            }
            pintarCarrito();
        };

        Carrito.prototype.sumarUnidadArticulo = function(idArticulo) {
            for (i = 0; i < this.listaArticulos.length; i++) {
                if (this.listaArticulos[i].idArticulo == idArticulo) {
                    this.listaArticulos[i].unidades++;
//                    guardarCarrito();
                }
            }
            pintarCarrito();
        };

        Carrito.prototype.borrarTodosArticulos = function(idArticulo) {
            for (i = 0; i < this.listaArticulos.length; i++) {
                if (this.listaArticulos[i].idArticulo == idArticulo) {
                    this.listaArticulos.splice(i, 1);
//                    guardarCarrito();
                }
            }
            pintarCarrito();
        };

        Carrito.prototype.verCarrito = function() {
            mensaje = "Fecha de Creacion: " + this.fechaCreacion + "  Nº de articulos: " + this.listaArticulos.length + "\n ARTICULOS: ";
            totalPrecio = 0;
            for (i = 0; i < this.listaArticulos.length; i++) {
                mensaje += "\n ID: " + this.listaArticulos[i].idArticulo + " || Nombre: " + this.listaArticulos[i].nombre + "|| Precio: " + this.listaArticulos[i].precio + "|| Unidades: " + this.listaArticulos[i].unidades;
                totalUnidades = parseFloat(this.listaArticulos[i].precio) * parseInt(this.listaArticulos[i].unidades);
                totalPrecio += totalUnidades;
            }
            mensaje += "\n TOTAL " + totalPrecio + "€";
            alert(mensaje);
        };

        function anyadirACarrito(articulo) {
            carrito.anyadirArticulo(articulo);
        }


        //========================= Articulo ===============================//

        function Articulo(idArticulo, nombre, precio) {
            this.idArticulo = idArticulo;
            this.nombre = nombre;
            this.precio = precio;
            this.unidades = 1;
        }

        function añadir_articulo(idArticulo) {
            id = idArticulo;
            precio = $("#precio").text();
            nombre = $("#nombreArticulo").text();
            articulo = new Articulo(id, nombre, precio);
            anyadirACarrito(articulo);
            pintarCarrito();
        }

        function borrarUnidad(idArticulo) {
            carrito.borrarUnidadArticulo(idArticulo);
        }

        function sumarUnidad(idArticulo) {
            carrito.sumarUnidadArticulo(idArticulo);
        }

        function borrarArticulo(idArticulo) {
            carrito.borrarTodosArticulos(idArticulo);
        }

        //=========================== Funciones ===========================//

        //Cuando clickemos en una categoria, mostrara todos los articulos de la BD asociados
        //a esta categoria, con su nombre y su precio. Si se pincha al nombre nos muestra
        //detalladamente ese articulo.
        function articulos(idCategoria) {
            $.ajax({
                dataType: 'json',
                url: 'articulos/articulos.php',
                type: 'POST',
                data: "idCategoria=" + idCategoria,
                success: function(data) {
                    html = '';
                    $.each(data, function(index) {
                        html += '<div class="articulos" id="articulo' + data[index].idArticulo + '">';
                        html += '<a id="nombreArticulo" href="javascript:unArticulo(' + data[index].idArticulo + ')">' + data[index].nombreArticulo + '</a>';
                        html += '<p id="precio">' + data[index].precioArticulo + '</p>';
                        html += '</div>';
                    });
                    html += '<br /><a href=javascript:categorias()>Volver</a>';
                    html += '</div>';
                    $("#contenidoGeneral").html(html);
                }
            });
        }
        ;

        //Recibimos el id de un articulo para pintarlo detalladamente, pidiendole los datos al servidor
        function unArticulo(idArticulo) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'articulos/articulo.php',
                data: "idArticulo=" + idArticulo,
                success: function(data) {
                    html = '';
                    html += '<h2 id="nombreArticulo">' + data[0].nombreArticulo + '</h2>';
                    html += '<p>' + data[0].descripcionArticulo + '</p>';
                    html += '<br /><p id="precio">' + data[0].precioArticulo + '</p>';
                    html += '<br /><a href="javascript:añadir_articulo(' + idArticulo + ')">Añadir al carrito</a>';
//                  html += '<br /><a href="javascript:verCarrito()">Ver carrito</a>';
                    html += '<br /><a href="javascript:articulos(' + data[0].idCategorias + ')">Volver</a>'
                    $("#contenidoGeneral").html(html);
                }
            });
        }
        ;


        //Esta funcion hace lo mismo que la primera que se ejecuta al cargar la pagina, 
        //pero se usa para volver hacia atrás desde los productos de una categoria
        function categorias() {
            $.ajax({
                dataType: 'json',
                url: 'categorias/categorias.php',
                success: function(data) {
                    html = '<center><h2>Categorias</h2></center><div id="general">';
                    $.each(data, function(index) {
                        html += '<div class="categorias" id="categoria' + index + '"><a href="javascript:articulos(' + data[index].idCategoria + ')">' + data[index].nombreCategoria + '</a></div>';
                    });
                    html += '</div>';
                    html += '';
                    $("#contenidoGeneral").html(html);
                }
            });
        }

        function pintarCarrito() {
            total = 0;
            html = '<table id="carrito_articulos" class="table table-hover">';
            html += '<tr><td>Nombre</td><td>Precio</td><td>Unidades</td><td>Opciones</td></tr>';
            for (i = 0; i < carrito.listaArticulos.length; i++) {
                html += '<tr><td>' + carrito.listaArticulos[i].nombre + '</td>';
                html += '<td>' + carrito.listaArticulos[i].precio + '</td>';
                html += '<td>' + carrito.listaArticulos[i].unidades + '</td>';
                html += '<td><a href="javascript:sumarUnidad(' + carrito.listaArticulos[i].idArticulo + ')">+</a> // ';
                html += '<a href="javascript:borrarUnidad(' + carrito.listaArticulos[i].idArticulo + ')">-</a> // ';
                html += '<a href="javascript:borrarArticulo(' + carrito.listaArticulos[i].idArticulo + ')">X</a></td></tr>';
                total = total + (carrito.listaArticulos[i].precio * carrito.listaArticulos[i].unidades);
            }
            html += '</table>';
            html += '<p>Total: ' + total + '&euro;</p>';
            html += '<a href=javascript:comprar() class="btn btn-info">Comprar</a>';
            $("#carrito").html(html);
        }

        //Se inserta el carrito en la BD de la tienda

        function comprar() {
            json = JSON.stringify(carrito);
            $.ajax({
                dataType: 'json',
                url: 'carrito/carrito.php',
                type: 'POST',
                data: "carrito=" + json,
                success: function() {
                    alert("Su compra se ha procesado correctamente");
                }
            });
        }
        
//        function guardarCarrito(){
//            json = JSON.stringify(carrito);
//            $.ajax({
//                dataType: 'json',
//                url: 'carrito/guardarCarrito.php',
//                type: 'POST',
//                data: "carrito="+json,
//                success: function(){
//                }
//        });
//        
//        function verCarrito(){
//            carrito.verCarrito();
//        }
    </script>
    <body>
        <div id="content">
            <a  id="logout" href="login/logout.php" class="btn btn-danger">Logout</a>
            <div id="contenidoGeneral"></div>
            <div id="carrito">
            </div>
        </div>
    </body>
</html>
