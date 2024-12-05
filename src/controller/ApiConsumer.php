<?php

class ApiConsumer{

    function searchBar(){
        
        //Confirmar que exista
        if(isset($_POST["submit"]) && isset($_POST["search"])){
            //Obtener el valor del input de busqueda
            $texto = $_POST["search"];
        } else {
            $texto = "";
        }
        return $texto;
    }

    function getSearchBarInfo(){
        include "./controller/GetNameController.php";
        include './controller/GetAttributesController.php';

        $getAttribute = new GetAttributesController();
        $getNameClick = new GetNameController();

        $allAttributes = [];

        //SI se utiliza el buscador
        try {
            $nameCountry = $this->searchBar();

            if($nameCountry == ""){
                $nameCountry = $getNameClick->clickCountries();
            }else{
                $nameCountry = $this->searchBar();
            }

            $nameCountry = str_replace(" ", "%20", $nameCountry);

        if($nameCountry != "") {
            
            //API
            $url = "https://restcountries.com/v3.1/name/$nameCountry"; // URL de la API que deseas consumir


            ini_set('http_errors', 0);

            $context = stream_context_create([
                'http' => [
                    'ignore_errors' => true // Ignorar errores de HTTP
                ]
            ]);

            // Realizar la solicitud a la API
            try{
                $response = file_get_contents($url, false, $context);
            }catch(Exception $e){
                echo "<p class='text-center text-2xl p-4 m-1 text-brown-super-hard font-semibold'>Doesn't exist. Try with the official name or the english name.</p>";
            }
            
                    
            // Verificar si se obtuvo una respuesta válida
            if ($response === false) {
                throw new Exception('Error al obtener la respuesta de la API');
            }

            // Procesar la respuesta
            $data = json_decode($response, true);

            if(isset($data["status"]) && $data["status"] === 404 || isset($data["message"]) && $data["message"] === "Page Not Found"){
                echo "<p class='text-center text-2xl p-4 m-1 text-brown-super-hard font-semibold'>Doesn't exist. Try with the official name or the english name.</p>";

            }else{
            $commonName = $getAttribute->getCommonName($data);
            $officialName = $getAttribute->getOfficialName($data);
            $region = $getAttribute->getRegion($data);
            $population = $getAttribute->getPopulation($data);
            $capital = $getAttribute->getCapital($data);
            $language = $getAttribute->getLanguage($data);
            $timezone = $getAttribute->getTimezone($data);
            $flag = $getAttribute->getFlag($data);

            //Recorrer todos los idiomas
            $idiomas = [];
            foreach($language as $lang){
                $idiomas[] =  $lang;
            }

            $idiomasString = implode(", ", $idiomas); //Array -> String

            //Toda la información dentro de un array
            $allAttributes = [    
                                $commonName, 
                                $officialName, 
                                $region, 
                                $population, 
                                $capital, 
                                $idiomasString, 
                                $timezone, 
                                $flag
                        ];
            }
            
            return $allAttributes;
            
    }
        } catch (Exception $e) {
            // Error
            return "Error: No se pudo obtener la información del país.";
        }
            
    }

    function menu(){
        // Obtener la información de la barra de búsqueda
        $searchInfo = $this->getSearchBarInfo();
    
        // Verificar si la información de búsqueda es un array válido
        if (is_array($searchInfo) && count($searchInfo) > 0) {

            $commonName = $searchInfo[0];
            $officialName = $searchInfo[1];
            $region = $searchInfo[2];
            $population = $searchInfo[3];
            $capital = $searchInfo[4];
            $language = $searchInfo[5];
            $timezone = $searchInfo[6];
            $flag = $searchInfo[7];

            //Seleccionar imagen dependiendo de la region
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

            //Lo que se verá en la página

            echo "<div class='container-info flex flex-col justify-center items-center p-8 text-brown-super-hard'>

                    <div class='text-center p-1'>
                        <h1 class='text-5xl p-1 font-extrabold'> $commonName </h1>
                        <h2 class='text-[1rem] p-1 font-thin'>$officialName</h2>
                        <img src='$flag' class='p-1'>
                    </div>

                    <div class='flex flex-col justify-center items-center p-1'>
                        <strong class='text-2xl text-brown-hard'>Capital</strong> <p class='text-xl font-semibold p-1'> $capital </p>
                        <strong id='population' class='text-2xl text-brown-hard'>Population</strong> <p class='text-xl font-semibold p-1'> $population </p>
                        <strong class='text-2xl text-brown-hard'>Languages</strong> <p class='text-xl font-semibold text-center p-1'> $language </p>
                        <strong class='text-2xl text-brown-hard'>Timezone</strong> <p class='text-xl font-semibold p-1'> $timezone</p>
                    </div>

                    <div class='flex flex-col justify-center items-center p-1' id='regionn'> 
                        <strong class='text-3xl'>Region</strong> <p class='text-brown-hard text-xl font-semibold p-1'>$region</p>
                        <img id='imagenReg' src= '$imagenReg' class=''>
                    </div>

                </div>";
        } 
    }
}

?>
