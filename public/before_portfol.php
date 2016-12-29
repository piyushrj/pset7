<?php 
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
                $cashr=CS50::query("SELECT cash FROM users WHERE id=?",$_SESSION["id"]);
                $cash=$cashr[0];
                
                render("portfolio.php", ["title" => "Portfolio", "positions"=>$positions,"cash"=>$cash]);
?>
    