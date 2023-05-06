<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calificacion del juego</title>
</head>

<body>


    <?php
    //arreglos de variables de entrada
    global $jugabilidad, $visuales, $precio, $pertenencia, $calificacion;
    $jugabilidad = array();
    $visuales = array();
    $precio = array();
    $calificacion = array();
    //variable de salida
    $y = 0;

    //variable que recibiriamos

    $x1 = $_POST['anio-lanzamiento'];
    $x2 = $_POST['num-jugadores'];
    $x3 = $_POST['puntaje'];


    //llamada de funciones para jugabilidad
    $a = -40;
    $b = 0;
    $c = 40;
    $jugabilidad[0] = triangular($a, $b, $c, $x1);
    $a = 35;
    $b = 50;
    $c = 70;
    $d = 85;
    $jugabilidad[1] = trapezoidal($a, $b, $c, $d, $x1);
    $desv = 10;
    $prom = 100;
    $jugabilidad[2] = gaussiana($prom, $desv, $x1);

    //llamada de funciones para visuales
    $a = -40;
    $b = 0;
    $c = 45;
    $visuales[0] = triangular($a, $b, $c, $x2);
    $a = 35;
    $b = 57.5;
    $c = 85;
    $visuales[1] = triangular($a, $b, $c, $x2);
    $desv = 12;
    $prom = 100;
    $visuales[2] = gaussiana($prom, $desv, $x2);

    //llamada de funciones para precios
    $a = -40;
    $b = 0;
    $c = 40;
    $precio[0] = triangular($a, $b, $c, $x3);
    $a = 35;
    $b = 55;
    $c = 65;
    $d = 85;
    $precio[1] = trapezoidal($a, $b, $c, $d, $x3);
    $desv = 12;
    $prom = 100;
    $precio[2] = gaussiana($prom, $desv, $x3);

    
    echo "<div class='container'>";
    echo "<div class='section'>";
    echo "<h2>Jugabilidad</h2>";
    echo  "<p>Cuando jugabilidad es: ".$x1." sus pertenencia en malo es: ". $jugabilidad[0]. "</p>";
    echo  "<p><br>Cuando jugabilidad es: ".$x1." sus pertenencia en normal es: ". $jugabilidad[1]. "</p>";
    echo  "<p><br>Cuando jugabilidad es: ".$x1." sus pertenencia en bueno es: ". $jugabilidad[2]. "</p>";
    echo "</div>";
    echo "<div class='section'>";
    echo "<h2>Visuales</h2>";
    echo  "<p><br><br>Cuando visuales es: ".$x2." sus pertenencia en malo es: ". $visuales[0]. "</p>";
    echo  "<p><br>Cuando visuales es: ".$x2." sus pertenencia en normal es: ". $visuales[1]. "</p>";
    echo  "<p><br>Cuando visuales es: ".$x2." sus pertenencia en bueno es: ". $visuales[2]. "</p>";
    echo "</div>";
    echo "<div class='section'>";
    echo "<h2>Precio</h2>";
    echo  "<p><br><br>Cuando precio es: ".$x3." sus pertenencia en malo es: ". $precio[0]. "</p>";
    echo  "<p><br>Cuando precio es: ".$x3." sus pertenencia en normal es: ". $precio[1]. "</p>";
    echo  "<p><br>Cuando precio es: ".$x3." sus pertenencia en bueno es: ". $precio[2]. "</p>";
    echo "</div>";
    echo "</div>";





    function triangular($a, $b, $c, $x)
    {
        if ($x <= $a) {
            $y = 0;
        } elseif ($a <= $x && $x <= $b) {
            $y = ($x - $a) / ($b - $a);
        } elseif ($b <= $x && $x <= $c) {
            $y = ($c - $x) / ($c - $b);
        } else {
            $y = 0;
        }
        $y = $y * 100;
        //echo "La variable y es igual a ". $y;
        return $y;
    }

    function trapezoidal($a, $b, $c, $d, $x)
    {
        if ($x <= $a || $d <= $x) {
            $y = 0;
        } elseif ($a <= $x && $x <= $b) {
            $y = ($x - $a) / ($b - $a);
        } elseif ($c <= $x && $x <= $d) {
            $y = ($d - $x) / ($d - $c);
        } else {
            $y = 1;
        }
        $y = $y * 100;
        return $y;
    }

    function gaussiana($prom, $desv, $x)
    {
        $y = exp(- (($x - $prom) * ($x - $prom)) / (2 * $desv * $desv));
        $y = $y * 100;
        $y = round($y, 2);
        return $y;
    }


    //limpiar arreglo calificacion
    for($i=0;$i<=100;$i++){
        $calificacion[$i] = 0;
    }

    function regla($a, $b, $c, $d)
    {
        global $calificacion;
        if ($a == 0 || $b == 0 || $c == 0) {
            //el arreglo no aporta 
            echo "El arreglo no aporta";
        } else {
            //ninguno es cero
            $tope = min($a, $b, $c);
            // echo $tope; 
            for ($i = 0; $i <= 100; $i++) {
                switch ($d) {
                    case 1:
                        $pertenencia = trapezoidal(-31, 0, 8, 40, $i);
                        break;
                    case 2:
                        $pertenencia = triangular(35, 55, 75, $i);
                        break;
                    case 3:
                        $pertenencia = gaussiana(12, 1, $i);
                        break;
                    default:
                        break;
                }
                if ($pertenencia > $tope) {
                    $guardar = $tope;
                } else {
                    $guardar = $pertenencia;
                }
                if ($guardar < $calificacion[$i]) {
                } else {
                    $calificacion[$i] = $guardar;
                } 
            }
        }
        for($x=0; $x<=100;$x++){
         echo "<br> calificacion ".$x." = ".$calificacion[$x];
        }       
    }

    regla($jugabilidad[0], $visuales[0], $precio[0], 1);
    regla($jugabilidad[1], $visuales[1], $precio[1], 2);
    regla($jugabilidad[2], $visuales[2], $precio[2], 3);
    regla($jugabilidad[2], $visuales[2], $precio[2], 3);
    regla($jugabilidad[2], $visuales[2], $precio[2], 3);



    ?>





</body>

</html>