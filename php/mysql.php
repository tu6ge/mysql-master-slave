<?php

$mysqli = new mysqli('mysql-m', 'root', 'admin');

$sql = "show master status";    
$result = $mysqli->query($sql);    
    
if ($result)     
{    
    if ($result->num_rows>0)    
    {    
        while ($rows = $result->fetch_assoc()) {    
            print_r($rows);    
        }//end while()    
    }
}
