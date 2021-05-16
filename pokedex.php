<?php
require "conexion.php";
require "mostrarPokemon.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="recursos/scss/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="recursos/css/style.css">
    <link rel="stylesheet" href="recursos/css/pokedex.css">
    <title>Pokedex</title>
</head>

<body class="container-fluid p-0  justify-content-lg-center bg-white">
<!-- Inicio Contenedor Principal -->
<div class="contenedorPrincipalNav container-fluid min-vh-100 p-0 m-0 min-vw-100 bg-white d-block">
    <?php
    require "header.php";
    ?>

    <!-- Contenedor Buscador -->

    <div class="contenedorPrincipal  container-fluid d-flex flex-column justify-content-center navbar navbar-expand-sm">

        <p class="fw-bold">Todos los pokemones disponible para que eligas</p>
        <div class=" d-flex justify-content-start col-12 flex-column">
            <button class="navbar-toggler text-dark col-2 justify-content-start mb-2" type="button"
                    data-bs-toggle="collapse" data-bs-target="#ContentFilter" aria-expanded="false"
                    aria-controls="ContentFilter">

                <i class="fas fa-sort-down"></i>

            </button>

            <div class="collapse navbar-collapse w-100" id="ContentFilter">

                <form action="pokedex.php" method="post" class="row w-100 p-2">
                    <div class="col-10 mb-2">
                        <input class="form-control me-2" name="busqueda" type="search"
                               placeholder="Buscar por nombre, tipo o número de Pokemón."
                               aria-label="Search">
                    </div>
                    <div class="col-2 mb-2 p-0">
                        <button class="btn btn-danger col-6 m-0 p-0 w-100 h-100" type="submit">Buscar</button>
                    </div>

                    <!--<div class="form-check m-0 col-4 col-md-3 col-lg-2 col-xl-1">
                        <input class="form-check-input ms-0 me-1" type="checkbox" id="inlineCheckbox1" value="fuego">
                        <label class="form-check-label" for="inlineCheckbox1">Fuego</label>
                    </div>
                    <div class="form-check m-0 col-4 col-md-3 col-lg-2 col-xl-1">
                        <input class="form-check-input ms-0 me-1" type="checkbox" id="inlineCheckbox2" value="agua">
                        <label class="form-check-label" for="inlineCheckbox2">Agua</label>
                    </div>
                    <div class="form-check m-0 col-4 col-md-3 col-lg-2 col-xl-1">
                        <input class="form-check-input ms-0 me-1" type="checkbox" id="inlineCheckbox3" value="hierba">
                        <label class="form-check-label" for="inlineCheckbox3">hierba</label>
                    </div>
                    <div class="form-check m-0 col-5 col-md-3 col-lg-3 col-xl-2">
                        <input class="form-check-input ms-0 me-1" type="checkbox" id="inlineCheckbox4"
                               value="electrico">
                        <label class="form-check-label" for="inlineCheckbox4">electrico</label>
                    </div>-->

                </form>
                <div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final Contenedor buscar -->

    <!-- Contenedor agregar pokemones y lista de pokemones) -->
    <div class="contenedorPrincipal container-fluid ps-5  mb-5 pb-5">

        <?php

        if (isset($_SESSION["nombre"])) { ?>
            <div class="d-grid gap-2 col-6 mx-auto mt-5 ">
                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#crearPokemon">
                    Agregar Pokemon <i class="fas fa-plus"></i></button>
            </div>
            <?php
        }


        ?>
        <!-- Pokemones lista contenedor-->
        <div class="d-flex flex-row flex-wrap justify-content-center">
            <?php
            /*recorre fila por fila para traer todos los datos de cada pokemon */
            while ($fila = mysqli_fetch_array($result)) {

            /*buscamos coincidencia entre el nombre del pokemon y el nombre de la imagen */
            foreach ($ficheros1 as $img) {
                if ($img == $fila['imagen']) {
                    $imgMostrar = $directorio . $img;
                }
            }


            /*buscamos coincidencia entre el tipo de pokemon y el tipo de la imagen */
            foreach ($ficheros2 as $img2) {

                $tipo = $fila['tipo'];
                $extension = explode(".", $img2);
                $nuevaExtension = substr($fila['tipo'], 0, -1);
                $tipoFinal = $nuevaExtension . "." . $extension[1];

                if ($img2 == $tipoFinal) {
                    $imgMostrar2 = $directorio2 . $img2;
                }
            }

            if (!isset($_POST["busqueda"])) {

                ?>

                <!-- Pokemones lista -->

                <?php
                pokemonCarta($fila["id"], $fila["nombre"], $imgMostrar, $imgMostrar2, $fila["descripcion"], $fila["tipo"]);
            }
            if (isset($_POST["busqueda"])) {


                if ($_POST["busqueda"] == $fila["nombre"] || $_POST["busqueda"] == $fila["tipo"] || $_POST["busqueda"] == $fila["id"]) {

                    echo pokemonCarta($fila["id"], $fila["nombre"], $imgMostrar, $imgMostrar2, $fila["descripcion"], $fila["tipo"]);

                }
            }
            ?>
        </div>


        <?php
        if (isset($_SESSION["usuario"])) { ?>
            <div class="d-block">
                <button type="button" class="btn btn-warning mt-4"><i class="fas fa-edit"></i></button>
                <button type="button" class="btn btn-danger mt-4"><i class="fas fa-trash-alt "></i>
                </button>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!--</div>-->
<?php
}
?>


</div>
</div>

<!-- Final contenedor agregar pokemones y lista de pokemones) -->

<!-- Final contenedor principal (El div de arriba) -->

<!-- Modal crear pokemon-->
<div class="modal fade" id="crearPokemon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="agregarPokemon.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar un pokemon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input class="" name="numero" type="number" placeholder="Posicion de la Pokedex">
                    <input class="" name="nombrePokemon" type="text" placeholder="Nombre Pokemon">

                    <div class="mt-3 mb-1">¿Que tipo es?</div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" id="agua" value="agua">
                        <label class="form-check-label" for="inlineCheckbox1">Agua</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" id="hierba" value="planta">
                        <label class="form-check-label" for="inlineCheckbox1">Hierba</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" id="electrico" value="electrico">
                        <label class="form-check-label" for="inlineCheckbox1">Electrico</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipo" id="fuego" value="fuego">
                        <label class="form-check-label" for="inlineCheckbox1">Fuego</label>
                    </div>

                    <br>
                    <br>

                    <div class="mb-3">
                        <label for="validationTextarea" class="form-label">Cuentanos un poco del pokemon:</label>
                        <textarea class="form-control " name="descripcion" id="descripcion"
                                  placeholder="Required example textarea"></textarea>
                        <div class="invalid-feedback">
                            Descripcion
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="validationTextarea" class="form-label">Fotito para el Insta</label>
                        <input type="file" name="file" class="form-control" aria-label="file example" required>
                        <div class="invalid-feedback">Example invalid form file feedback</div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button class="  fw-bolder btn btn-primary" type="submit" value="loguear">Agregar Pokemon
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- FIN Modal crear pokemon-->

<footer class="bg-warning d-block" style="height: 100px;">

</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"
        integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js"
        integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous">
</script>
</body>

</html>