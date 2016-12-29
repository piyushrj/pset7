

<?php

    // configuration 
    require("../includes/config.php");

     // if user reached page via GET (as by clicking a link or via redirect)
     if ($_SERVER["REQUEST_METHOD"] == "GET")
     {
         // else render form
         render("changepass_form.php", ["title" => "Change Password"]);
     }
     // else if user reached page via POST (as by submitting a form via POST)
     else if ($_SERVER["REQUEST_METHOD"] == "POST")
     {
        $rows = CS50::query("SELECT hash FROM users WHERE id = ?", $_SESSION["id"]);
        $row = $rows[0];

        if (empty($_POST["cpassword"]))
        {
            apologize("You must provide your password.");
        }
        else if (empty($_POST["npassword1"])||empty($_POST["npassword2"]))
        {
            apologize("You must provide your new password in both the above fields.");
        }
        else if(!password_verify($_POST["cpassword"], $row["hash"]))// compare hash of user's input against hash that's in database
        {
            apologize("Original Password did not match.");
        }
        else if($_POST["npassword1"]!=$_POST["npassword2"])
        {
            apologize("New Passwords did not match.");
        }
        else
        {
            CS50::query("UPDATE users SET hash=? WHERE id=?",password_hash($_POST["npassword1"], PASSWORD_DEFAULT),$_SESSION["id"]);
            // redirect to portfolio
            redirect("/");
        }
     }
 ?>


