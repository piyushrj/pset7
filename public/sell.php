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
                $rows=CS50::query("SELECT portfolios.symbol, portfolios.shares, users.cash FROM portfolios, users WHERE users.id=? AND portfolios.user_id=users.id",$_SESSION["id"]);
                $rows=CS50::query("SELECT portfolios.symbol, portfolios.shares, users.cash FROM portfolios, users WHERE users.id=? AND portfolios.user_id=users.id",$_SESSION["id"]);
                $positions = [];
                foreach ($rows as $row)
                {
                    $stock = lookup($row["symbol"]);
                    if ($stock !== false)
                    {
                        $positions[] = [
                        "name" => $stock["name"],
                        "price" => $stock["price"],
                        "shares" => $row["shares"],
                        "symbol" => $row["symbol"],
                        "cash" => $row["cash"]
                        ];
                    }
                }
    
                render("portfolio.php", ["title" => "Portfolio", "positions"=>$positions]);
                   
            }
           
     }
?>