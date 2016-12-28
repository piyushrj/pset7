<?php

    // configuration 
    require("../includes/config.php");

     // if user reached page via GET (as by clicking a link or via redirect)
     if ($_SERVER["REQUEST_METHOD"] == "GET")
     {
         $rows=CS50::query("SELECT action,datetime,symbol,shares,price FROM history WHERE uid=?",$_SESSION["id"]);
         
         $records = [];
         foreach ($rows as $row)
        {
                   
            if (isset($rows))
            {
                $records[] = [
                "action" => $row["action"],
                "datetime" => $row["datetime"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"],
                "price" => $row["price"]
                ];
            }
        }
    
        render("records.php", ["title" => "History", "records"=>$records]);
        
     }
?>