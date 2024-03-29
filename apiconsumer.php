<?php

class apiconsumer{

    function searchBar(){
        if(isset($_POST["submit"]) && isset($_POST["search"])){
            $texto = $_POST["search"];
        } else {
            $texto = ""; // Valor predeterminado si no se encuentra el valor en $_POST["search"]
        }
        return $texto;
    }

    // Get common name of the country
    function getSearchBarInfo(){
        try {

        $nameCountry = $this->searchBar();

        if($nameCountry != "") {
            
            $url = "https://restcountries.com/v3.1/name/$nameCountry"; // URL de la API que deseas consumir

            ini_set('http_errors', 0);

            // Crear un contexto de flujo para configurar opciones adicionales
            $context = stream_context_create([
                'http' => [
                    'ignore_errors' => true // Ignorar errores de HTTP
                ]
            ]);

            // Realizar la solicitud a la API con el contexto de flujo
            $response = file_get_contents($url, false, $context);
                    
            // Verificar si se obtuvo una respuesta válida
            if ($response === false) {
            // Manejar el error
                throw new Exception('Error al obtener la respuesta de la API');
            }

            // Procesar la respuesta (puede ser JSON, XML, etc.)
            $data = json_decode($response, true); // Decodificar la respuesta JSON a un array asociativo

            if(isset($data[0]['name']['common'])) {
                $commonName = $data[0]['name']['common'];
                return $commonName;
            } else {
                $commonName = "No existe";
                return $commonName;
            }
    }
        } catch (Exception $e) {
            // Manejar la excepción y mostrar un mensaje personalizado
            return "Error: No se pudo obtener la información del país.";
        }
            
    }

    function menu(){
        echo "<h1>" . $this->getSearchBarInfo() . "</h1>";
    }

}

?>
