<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //variable que va a desplegar el mensaje final
        $mensajeFinal = [];
        function letras($letra, $opcion, $contCiclo)
        {
            //investigue como usar variables globales
            global $mensajeFinal;
            $espacios = 0;
            $noCaracter = 0;
            $error = 0;
            //vector con todas las traducciones morse como llave y letra como caracter
            $diccionario=[".-"=>"A",
                        "-..."=>"B",
                        "-.-."=>"C",
                        "-.."=>"D",
                        "."=>"E",
                        "..-."=>"F",
                        "--."=>"G",
                        "...."=>"H",
                        ".."=>"I",
                        ".---"=>"J",
                        "-.-"=>"K",
                        ".-.."=>"L",
                        "--"=>"M",
                        "-."=>"N",
                        "---"=>"O",
                        ".--."=>"P",
                        "--.-"=>"Q",
                        ".-."=>"R",
                        "..."=>"S",
                        "-"=>"T",
                        "..-"=>"U",
                        "...-"=>"V",
                        ".--"=>"W",
                        "-..-"=>"X",
                        "-.--"=>"Y",
                        "--.."=>"Z",
                        ".----" =>"1",
                        "..---"=>"2",
                        "...--"=>"3",
                        "....-"=>"4",
                        "....."=>"5",
                        "-...."=>"6",
                        "--..."=>"7",
                        "---.."=>"8",
                        "----."=>"9",
                        "-----"=>"0"];
            if($opcion == "M") //De morse a Español
            {
                //recorre todo el diccionario buscando coincidencias
                foreach($diccionario as $key => $valor)
                {
                    //detecta el espacio dado por una /
                    if($letra == "/" && $espacios == 0)
                    {
                        $mensajeFinal[$contCiclo] = " / ";
                        $espacios++;
                        $noCaracter = 1;
                        $error = 0;
                    }
                    //manda el caracter a lel arreglo global
                    elseif($key == $letra)
                    {
                        $mensajeFinal[$contCiclo] = $valor;
                        $noCaracter = 1;
                        $error = 0;
                    }
                    //detecta cualquie fallo o caracter no correspondiente
                    elseif(($valor == $letra || $noCaracter == 0) && $error == 0)
                    {
                        $error = 1;
                    }
                }
            }
            else //De español a morse
            {
                //estructura similar a la anterios
                foreach($diccionario as $key => $valor)
                {
                    if($letra == " " && $espacios == 0)
                    {
                        $mensajeFinal[$contCiclo] = " / ";
                        $espacios++;
                    }
                    elseif($valor == $letra)
                    {
                        $mensajeFinal[$contCiclo] = $key." ";
                    }
                    elseif($letra == substr($key,1,1))
                    {
                        $error = 1;
                    }
                }
            }
            return $error;
        }

        //recibe las variables
        $opcion=$_POST["opcion"];
        $mensaje=$_POST["mensaje"];
        $mensajeMayus = strtoupper($mensaje);
        $mostrar = 1;
        //Descompone la cadena original en caracteres
        if($opcion == "E")
        {
            for($i=0; $i < strlen($mensajeMayus); $i++)
            {
                $palabras[$i] = substr($mensajeMayus, $i, 1);
            }
        }
        //Desocompone la cadena oiginal cada espacio
        else
        {
            $palabras = explode(" ", $mensajeMayus);
        }
        //manda la informacion a tratar en la funcion
        for($i=0; $i<= count($palabras)-1; $i++)
        {
            $error = letras($palabras[$i], $opcion, $i);
            //si hay cualquier error se asigna un valor falso para mostrar
            if($error == 1)
            {
                $mostrar = 0;
            }
        }
        //Da el mensaje de error 
        if($mostrar == 0)
        {
            //Da el mensaje dependiendo de la opcion seleccionadad
            if($opcion == "M")
            {
                echo "<h1>ALGO SALIO MAL, ha escrito de forma incorrecta su mensaje, solo permitido caracteres (-, .)</h1>";
            }
            else
            {
                echo "<h1>ALGO SALIO MAL, ha escrito de forma incorrecta su mensaje, solo permitido caracteres (A - B) numeros del(0 al 9)</h1>";
            }
        }
        //Despliega la traduccion si todo sale bien
        else
        {
            echo "<h1>Su texto a traducir es:</h1>";
            echo $mensaje;
            echo "<h1>Su traducción es: </h1>";
            foreach($mensajeFinal as $value)
            {
                echo $value;
            }
        }
    ?>
</body>
</html>