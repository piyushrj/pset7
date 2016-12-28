<?php

    // configuration 
    require("../includes/config.php");

     // if user reached page via GET (as by clicking a link or via redirect)
     if ($_SERVER["REQUEST_METHOD"] == "GET")
     {
         // else render form
         render("buy_form.php", ["title" => "Buy"]);
     }
     // else if user reached page via POST (as by submitting a form via POST)
     else if ($_SERVER["REQUEST_METHOD"] == "POST")
     {
         $stock=lookup($_POST["symbol"]);
         if($stock==false)
         {
             apologize("Symbol not found");
         }
         else if(preg_match("/^\d+$/", $_POST["shares"]))
         {
             $stock=lookup($_POST["symbol"]);
             $price =$_POST["shares"]*$stock["price"];
             $price=number_format($price,2,'.','');
             $cash=CS50::query("SELECT cash FROM users WHERE id=?",$_SESSION["id"]);
             if(@$cash[0]["cash"]>$price)
             {
                 CS50::query("INSERT INTO portfolios (user_id,symbol,shares) VALUES(?,?,?) ON DUPLICATE KEY UPDATE shares=shares+?",$_SESSION["id"],$_POST["symbol"],$_POST["shares"],$_POST["shares"]);
                 CS50::query("UPDATE users SET cash = cash - $price WHERE id = ?",$_SESSION["id"]);
                 require("before_portfol.php");
                
             }
             else
             {
                 apologize("You don't have enough money to buy that.");
             }
         }
         else
         {
             apologize("Enter the shares as whole numbers");
         }
     }
?>