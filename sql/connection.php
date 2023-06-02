<?php

    function connection(){
        // supply data
        $server_name = "localhost";
        $server_username = "root";
        $server_password = "";
        $db_name = "simple_games";
    
        // connecting to database
        mysqli_report(MYSQLI_REPORT_OFF);
        $mysql = new mysqli($server_name, $server_username, $server_password, $db_name);
    
        // error handling
        if($mysql->connect_error){
            die("error in connecting to database ". $mysql->connect_error);
        }else{
            return $mysql;
        }     
    }

?>