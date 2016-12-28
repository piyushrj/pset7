<?php

    // configuration 
    require("../includes/config.php");

     // if user reached page via GET (as by clicking a link or via redirect)
     if ($_SERVER["REQUEST_METHOD"] == "GET")
     {
         
         $rows=CS50::query("SELECT symbol FROM portfolios WHERE user_id=?",$_SESSION["id"]);
         $symbols=[];
         foreach ($rows as $row)
        {
        
            $symbols[] =$row["symbol"];
        }
    
         
         render("sell_form.php", ["title" => "Sell shares", "symbols"=>$symbols]);
     }
     // else if user reached page via POST (as by submitting a form via POST)
     else if ($_SERVER["REQUEST_METHOD"] == "POST")
     {
         

            $n_shares=CS50::query("SELECT shares FROM portfolios WHERE user_id =? AND symbol=?",$_SESSION["id"],$_POST["symbol"]);
            if(isset($n_shares))
            {
                $stock=lookup($_POST["symbol"]);
                CS50::query("DELETE FROM portfolios WHERE user_id =? AND symbol=?",$_SESSION["id"],$_POST["symbol"]);
                $price =@$n_shares[0]["shares"]*$stock["price"];
                CS50::query("UPDATE users SET cash = cash + $price WHERE id = ?",$_SESSION["id"]);
                CS50::query("INSERT INTO history (uid,action,datetime,symbol,shares,price) VALUES(?,'SELL',CURRENT_TIMESTAMP,?,?,?)",$_SESSION["id"],strtoupper($_POST["symbol"]),@$n_shares[0]["shares"],$stock["price"]);
                require("before_portfol.php");
                   
            }
           
     }
?>