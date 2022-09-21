<?php
    include ('./Grafo.php');
    session_start();
    if (isset($_SESSION["grafo"]) == false) {
        $_SESSION["grafo"] = new Grafo();
    }
?>

<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafo</title>
    <link rel="stylesheet" href="../Grafo/resources/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@500&family=Open+Sans&display=swap" rel="stylesheet">
    <script type="text/javascript" src="../Grafo/node_modules/vis/dist/vis.js"></script>
    <link rel="stylesheet" type="text/css" href="../Grafo/node_modules/vis/dist/vis.css" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header class="titulo">
        <h1>Grafo</h1>
        <h5>Por Camilo Arteta</h5>
        <br/>
    </header>
    <nav>
        <ul>
            <li><a href="#agregar-vertice">Agregar</a></li>
            <li><a href="#eliminar-vertice">Eliminar</a></li>
            <li><a href="#mostrar-vertice">Visualizar</a></li>
            <li><a href="#mostrar-grafo">Visualizar grafo</a></li>
        </ul>
    </nav>
    <main>
        <div id="contenedor-grafo">
        </div>
        <div class="contenedor-principal">
            <div class="contenedor-form">
                <h4 id="agregar-vertice">Agregar Vertice</h4>
                <form action="index.php" method="post">
                    <div class="elemento">
                        <label for="informacion-agregar">ID Vertice</label>
                        <input type="text" id="informacion-agregar" name="informacion-agregar" placeholder="Ingrese la ID" required="true">
                    </div>
                    <br/>
                    <input type="submit" value="Agregar" name="agregar-vertice">
                </form>
                <script type="text/javascript">
                    <?php
                        if (isset($_POST["agregar-vertice"])) {
                            if ($_SESSION["grafo"]->agregarVertice($_POST["informacion-agregar"])) {
                                echo "Swal.fire({
                                    title: 'Agregar Vertice',
                                    text: 'Vertice agregado correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Seguir!'
                                })";
                            } else {
                                echo "Swal.fire({
                                    title: 'Agregar Vertice',
                                    text: 'El vertice ya existe, ingrese otro valor',
                                    icon: 'error',
                                    confirmButtonText: 'Seguir!'
                                })";
                            }
                        }
                    ?>
                </script>
            </div>
            <div class="contenedor-form">
                <h4>Agregar Arista</h4>
                <form action="index.php" method="post">
                    <div class="elemento">
                        <label for="desde-agregar">Desde</label>
                        <input type="text" id="desde-agregar" name="desde-agregar" placeholder="Ingrese un vertice" required="true">
                    </div>
                    <br/>
                    <div class="elemento">
                        <label for="hasta-agregar">Hasta</label>
                        <input type="text" id="hasta-agregar" name="hasta-agregar" placeholder="Ingrese un vertice" required="true">
                    </div>
                    <br/>
                    <div class="elemento">
                        <label for="peso">Peso</label>
                        <input type="text" id="peso" name="peso" placeholder="Ingrese el peso" required="true">
                    </div>
                    <br/>
                    <input type="submit" value="Agregar" name="agregar-arista">
                </form>
                <script type="text/javascript">
                    <?php
                        if(isset($_POST["agregar-arista"])) {
                            if(isset($_POST["desde-agregar"]) && isset($_POST["hasta-agregar"]) && isset($_POST["peso"])) {
                                if ($_SESSION["grafo"]->agregarArista($_POST["desde-agregar"], $_POST["hasta-agregar"], $_POST["peso"])) {
                                    echo "Swal.fire({
                                        title: 'Agregar Arista',
                                        text: 'Arista agregada correctamente',
                                        icon: 'success',
                                        confirmButtonText: 'Seguir!'
                                    })";
                                } else {
                                    echo "Swal.fire({
                                        title: 'Agregar Arista',
                                        text: 'La conexión ya existe, o los vertices no han sido creados... Intente nuevamente',
                                        icon: 'error',
                                        confirmButtonText: 'Seguir!'
                                    })";
                                }
                            }
                        }
                    ?>
                </script>
            </div>
            <div class="contenedor-form">
                <h4 id="eliminar-vertice">Eliminar Vertice</h4>
                <form action="index.php" method="post">
                    <div class="elemento">
                        <label for="informacion-eliminar">ID Vertice</label>
                        <input type="text" id="informacion-eliminar" name="informacion-eliminar" placeholder="Ingrese la ID" required="true">
                    </div>
                    <br/>
                    <input type="submit" value="Eliminar" name="eliminar-vertice">
                </form>
                <script type="text/javascript">
                    <?php
                        if(isset($_POST["eliminar-vertice"])) {
                            if(isset($_POST["informacion-eliminar"])) {
                                if ($_SESSION["grafo"]->eliminarVertice($_POST["informacion-eliminar"])) {
                                    echo "Swal.fire({
                                        title: 'Eliminar Vertice',
                                        text: 'Vertice eliminado correctamente',
                                        icon: 'success',
                                        confirmButtonText: 'Seguir!'
                                    })";
                                } else {
                                    echo "Swal.fire({
                                        title: 'Eliminar Vertice',
                                        text: 'El vertice no ha sido encontrado, no se pudo eliminar',
                                        icon: 'error',
                                        confirmButtonText: 'Seguir!'
                                    })";
                                }
                            }
                        }
                    ?>
                </script>
            </div>
            <div class="contenedor-form">
                <h4>Eliminar Arista</h4>
                <form action="index.php" method="post">
                    <div class="elemento">
                        <label for="desde-eliminar">Desde</label>
                        <input type="text" id="desde-eliminar" name="desde-eliminar" placeholder="Ingrese un vertice" required="true">
                    </div>
                    <br/>
                    <div class="elemento">
                        <label for="hasta-eliminar">Hasta</label>
                        <input type="text" id="hasta-eliminar" name="hasta-eliminar" placeholder="Ingrese un vertice" required="true">
                    </div>
                    <br/>
                    <input type="submit" value="Eliminar" name="eliminar-arista">
                </form>
                <script type="text/javascript">
                    <?php
                    if(isset($_POST["eliminar-arista"])) {
                        if(isset($_POST["desde-eliminar"]) && isset($_POST["hasta-eliminar"])) {
                            if ($_SESSION["grafo"]->eliminarArista($_POST["desde-eliminar"], $_POST["hasta-eliminar"])) {
                                echo "Swal.fire({
                                    title: 'Eliminar Arista',
                                    text: 'Arista Eliminada correctamente',
                                    icon: 'success',
                                    confirmButtonText: 'Seguir!'
                                })";
                            } else {
                                echo "Swal.fire({
                                    title: 'Eliminar Arista',
                                    text: 'La conexión no ha sido encontrada, no se pudo eliminar',
                                    icon: 'error',
                                    confirmButtonText: 'Seguir!'
                                })";
                            }
                        }
                    }
                ?>
                </script>
            </div>
            <div class="contenedor-form">
                <h4 id="mostrar-vertice">Mostrar Vertice</h4>
                <form action="index.php" method="post">
                    <div class="elemento">
                        <label for="informacion-mostrar">ID Vertice</label>
                        <input type="text" id="informacion-mostrar" name="informacion-mostrar" placeholder="Ingrese la ID" required="true">
                    </div>
                    <br/>
                    <input type="submit" value="Mostrar" name="mostrar-vertice">
                </form>
                <div id="contenedor-grafo-mostrar-vertice">
                </div>
                <script type="text/javascript">
                    var nodos = new vis.DataSet([
                    <?php
                        if(isset($_POST["mostrar-vertice"])){
                            $contador = 1;
                            foreach ($_SESSION["grafo"]->getMatriz() as $keyVector => $vector) {
                                if ($contador != count($_SESSION["grafo"]->getMatriz())) {
                                    if ($keyVector == $_POST["informacion-mostrar"]) {
                                       echo "{id: '$keyVector', label: '$keyVector', color: {
                                        background: '#EC7630'
                                       }}, ";
                                    } else {    
                                        echo "{id: '$keyVector', label: '$keyVector'}, ";
                                    }
                                    $contador ++;
                                } else {
                                    if ($keyVector == $_POST["informacion-mostrar"]) {
                                        echo "{id: '$keyVector', label: '$keyVector', color: {
                                        background: '#EC7630'
                                       }}";
                                    } else {    
                                        echo "{id: '$keyVector', label: '$keyVector'}";
                                    }
                                }
                            }
                        }
                    ?>
                    ]);
                    
                    var aristas = new vis.DataSet([
                        <?php
                            if(isset($_POST["mostrar-vertice"])){
                                foreach ($_SESSION["grafo"]->getMatriz() as $keyVector1 => $vector1) {
                                    if ($vector1 != null) {
                                        foreach ($vector1 as $keyVector2 => $indice) {
                                            echo "{from: '$keyVector1', to: '$keyVector2', label: '$indice'}, ";
                                        }
                                    }
                                }
                            }
                        ?>
                    ]);

                    var contenedor = document.getElementById("contenedor-grafo-mostrar-vertice");

                    var datos = {
                        nodes: nodos,
                        edges: aristas
                    };

                    var opciones = {
                        edges: {
                            arrows: {
                                to: {
                                    enabled: true
                                }
                            }
                        }
                    };

                    var grafo = new vis.Network(contenedor, datos, opciones);
                </script>
            </div>
            <div class="contenedor-form">
                <h4>Mostrar Adyacentes Vertice</h4>
                <form action="index.php" method="post">
                    <div class="elemento">
                        <label for="informacion-mostrar-adyacentes">ID Vertice</label>
                        <input type="text" id="informacion-mostrar-adyacentes" name="informacion-mostrar-adyacentes" placeholder="Ingrese la ID" required="true">
                    </div>
                    <br/>
                    <input type="submit" value="Mostrar" name="mostrar-adyacentes-vertice">
                </form>
                <div id="contenedor-grafo-mostrar-adyacentes">
                </div>
                <script type="text/javascript">
                    var nodos = new vis.DataSet([
                    <?php
                        if(isset($_POST["mostrar-adyacentes-vertice"])){
                            $verticesAdyacentes = $_SESSION["grafo"]->getAdyacentes($_POST["informacion-mostrar-adyacentes"]);
                            $verticePrincipal = $_SESSION["grafo"]->getVertice($_POST["informacion-mostrar-adyacentes"]);
                            $contador = 1;
                            if ($verticePrincipal != null) {
                                echo "{id: '{$verticePrincipal->getId()}', label: '{$verticePrincipal->getId()}'}, ";
                                if ($verticesAdyacentes != null) {
                                    foreach($verticesAdyacentes as $keyVector => $vector1) {
                                        echo '{id: "'. $keyVector .'", label: "' . $keyVector . '"}, ';
                                    }
                                }
                            }
                        }
                    ?>
                    ]);
                    
                    var aristas = new vis.DataSet([
                        <?php
                            if(isset($_POST["mostrar-adyacentes-vertice"])) {
                                $verticesAdyacentes = $_SESSION["grafo"]->getAdyacentes($_POST["informacion-mostrar-adyacentes"]);
                                $verticePrincipal = $_SESSION["grafo"]->getVertice($_POST["informacion-mostrar-adyacentes"]);
                                if(isset($_POST["informacion-mostrar-adyacentes"])){
                                    if ($verticePrincipal != null) {
                                        if ($verticesAdyacentes != null) {
                                            foreach ($verticesAdyacentes as $keyVector1 => $vector1) {
                                                if ($vector1 != null) {
                                                    echo '{from: "'. $verticePrincipal->getId() .'", to: "' . $keyVector1 . '", label: "' . $vector1 . '"}, ';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                    ]);

                    var contenedor = document.getElementById("contenedor-grafo-mostrar-adyacentes");

                    var datos = {
                        nodes: nodos,
                        edges: aristas
                    };

                    var opciones = {
                        edges: {
                            arrows: {
                                to: {
                                    enabled: true
                                }
                            }
                        }
                    };

                    var grafo = new vis.Network(contenedor, datos, opciones);
                </script>
            </div>
            <div class="contenedor-form">
                <h4>Mostrar Grado Vertice</h4>
                <form action="index.php" method="post">
                    <div class="elemento">
                        <label for="informacion-mostrar-grado">ID Vertice</label>
                        <input type="text" id="informacion-mostrar-grado" name="informacion-mostrar-grado" placeholder="Ingrese la ID" required="true">
                    </div>
                    <br/>
                    <input type="submit" value="Mostrar" name="mostrar-grado-vertice">
                </form>
                <script type="text/javascript">
                    <?php
                        $bandera;
                        if (isset($_POST["mostrar-grado-vertice"])) {
                            if (isset($_POST["informacion-mostrar-grado"])) {
                                foreach ($_SESSION["grafo"]->getVector() as $idVertice => $vertice) {
                                    if ($idVertice == $_POST["informacion-mostrar-grado"]) {
                                        $respuesta = $_SESSION["grafo"]->grado($_POST["informacion-mostrar-grado"]);
                                        $bandera = true;
                                        break;
                                    } else {
                                        $bandera = false;
                                    }
                                }
                                if ($bandera) {
                                    echo "Swal.fire({
                                        title: 'Mostrar Grado',
                                        text: 'El grado es: $respuesta',
                                        icon: 'info',
                                        confirmButtonText: 'Seguir!'
                                    })";
                                } else {
                                    echo "Swal.fire({
                                        title: 'Mostrar Grado',
                                        text: 'El vertice no existe, intente nuevamente',
                                        icon: 'error',
                                        confirmButtonText: 'Seguir!'
                                    })";
                                }
                            }
                        }
                    ?>
                </script>
            </div>
            <div class="mostrar-grafo">
                <h4 id="mostrar-grafo">Mostrar Grafo</h4>
                <form action="index.php" method="post">
                    <input type="submit" value="Mostrar Grafo" name="mostrar-grafo-btn">
                </form>
                <script type="text/javascript">
                    var nodos = new vis.DataSet([
                    <?php
                        if(isset($_POST["mostrar-grafo-btn"])){
                            $contador = 1;
                            foreach ($_SESSION["grafo"]->getMatriz() as $keyVector => $vector) {
                                if ($contador != count($_SESSION["grafo"]->getMatriz())) {
                                    echo "{id: '$keyVector', label: '$keyVector'}, ";
                                    $contador ++;
                                } else {
                                    echo "{id: '$keyVector', label: '$keyVector'}";
                                }
                            }
                        }
                    ?>
                    ]);
                    
                    var aristas = new vis.DataSet([
                        <?php
                            if(isset($_POST["mostrar-grafo-btn"])){
                                foreach ($_SESSION["grafo"]->getMatriz() as $keyVector1 => $vector1) {
                                    if ($vector1 != null) {
                                        foreach ($vector1 as $keyVector2 => $indice) {
                                            echo "{from: '$keyVector1', to: '$keyVector2', label: '$indice'}, ";
                                        }
                                    }
                                }
                            }
                        ?>
                    ]);

                    var contenedor = document.getElementById("contenedor-grafo");

                    var datos = {
                        nodes: nodos,
                        edges: aristas
                    };

                    var opciones = {
                        edges: {
                            arrows: {
                                to: {
                                    enabled: true
                                }
                            }
                        }
                    };

                    var grafo = new vis.Network(contenedor, datos, opciones);
                </script>
            </div>
        </div>
    </main>
</body>
</html>
