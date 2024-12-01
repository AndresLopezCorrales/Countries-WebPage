<?php

    class GetAttributesController{

        //[0] - Primer valor encontrado en el JSON

        //get Common Name 
        function getCommonName($data){
            if(isset($data[0]['name']['common'])) {
                $commonName = $data[0]['name']['common'];
                return $commonName;
            } else {
                return "";
            }
        }

        //get Official Name
        function getOfficialName($data){
            if(isset($data[0]["name"]["official"])){
                $officialName = $data[0]["name"]["official"];
                return $officialName;
            }else {
                return "";
            }
        }

        //Get Region / Continent
        function getRegion($data){
            if(isset($data[0]["region"])){
                $region = $data[0]["region"];
                return $region;
            }else {
                return "";
            }
        }

        //get Population
        function getPopulation($data){
            if(isset($data[0]["population"])){
                $population = $data[0]["population"];
                return $population;
            }else {
                return "";
            }
        }

        //get Capital
        function getCapital($data){
            if(isset($data[0]["capital"][0])){
                $capital = $data[0]["capital"][0];
                return $capital;
            }else {
                return "";
            }
        }

        //get Language
        function getLanguage($data) {
            if (isset($data[0]['languages'])) {
                $languages = $data[0]['languages'];
        
                // Iterar sobre las entradas del arreglo de idiomas
                foreach ($languages as $key => $value) {
                    return $value; // Devolver el primer valor encontrado
                }
            }else {
                return "";
            }
        }

        //get Timezone
        function getTimezone($data){
            if(isset($data[0]["timezones"][0])){
                $timezone = $data[0]["timezones"][0];
                return $timezone;
            }else {
                return "";
            }
        }

        //get Flag - Formato PNG
        function getFlag($data){

            if(isset($data[0]['flags']['png'])) {
                $image = $data[0]['flags']['png'];
                return $image;
            }else {
                return "";
            }

        }

    }
?>