<?php

class ApiConsumer{

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
        include "./controller/GetNameController.php";
        include './controller/GetAttributesController.php';

        $getAttribute = new GetAttributesController();
        $getNameClick = new GetNameController();

        $allAttributes = [];

        try {
            $nameCountry = $this->searchBar();

            if($nameCountry == ""){
                $nameCountry = $getNameClick->clickCountries();
            }else{
                $nameCountry = $this->searchBar();
            }

            $nameCountry = str_replace(" ", "%20", $nameCountry);

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

            
            $commonName = $getAttribute->getCommonName($data); //Common Name
            $officialName = $getAttribute->getOfficialName($data); //Official Name
            $region = $getAttribute->getRegion($data);
            $population = $getAttribute->getPopulation($data);
            $capital = $getAttribute->getCapital($data);
            $language = $getAttribute->getLanguage($data);
            $timezone = $getAttribute->getTimezone($data);
            $flag = $getAttribute->getFlag($data);

            $allAttributes = [    
                                $commonName, 
                                $officialName, 
                                $region, 
                                $population, 
                                $capital, 
                                $language, 
                                $timezone, 
                                $flag
                        ];
            
            return $allAttributes;
            
    }
        } catch (Exception $e) {
            // Manejar la excepción y mostrar un mensaje personalizado
            return "Error: No se pudo obtener la información del país.";
        }
            
    }

    function menu(){
        // Obtener la información de la barra de búsqueda
        $searchInfo = $this->getSearchBarInfo();
    
        // Verificar si la información de búsqueda es un array válido
        if (is_array($searchInfo) && count($searchInfo) > 0) {
            // Obtener el nombre común del país desde la información de búsqueda
            $commonName = $searchInfo[0];
            $officialName = $searchInfo[1];
            $region = $searchInfo[2];
            $population = $searchInfo[3];
            $capital = $searchInfo[4];
            $language = $searchInfo[5];
            $timezone = $searchInfo[6];
            $flag = $searchInfo[7];

            switch($region){
                case "Africa":
                    $imagenReg = "./resources/img/africa.png";
                    break;
                case "Americas":
                    $imagenReg = "./resources/img/america.png";
                    break;
                case "Asia":
                    $imagenReg = "./resources/img/asia.png";
                    break;
                case "Europe":
                    $imagenReg = "./resources/img/europe.png";
                    break;
                case "Oceania":
                    $imagenReg = "./resources/img/oceania.png";
                    break;
            
            }
            
            // Mostrar el nombre común en un encabezado h1

            echo "<div class='container-info'>
                    <h1> $commonName </h1>
                    <h2>$officialName</h2>
                    <img src='$flag'>

                    <div>
                        <h2>Data</h2>
                        <h4>Capital: $capital </h4>
                        <h4>Population: $population </h4>
                        <h4>Language: $language</h4>
                        <h4>Timezone: $timezone</h4>
                    </div>

                    <div> 
                        <h2>Region: $region</h2>
                        <img src= '$imagenReg'>

                    </div>

                    <!--hola-->
                </div>";

        } 
    }

    

}

?>
