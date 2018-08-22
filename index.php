<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="css/navbar-style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <title>CodiFlights</title>
    </head>
    <body>
        <?php
        require "log.php";
        $db = new PDO('mysql:host=localhost;dbname=codi-flights', $identifiant, $password);
        $airports = $db->query('SELECT * FROM airport')->fetchAll();
        $flys= $db->query('SELECT flight.*, arrival.city AS arrival_city , depart.city AS depart_city
            FROM flight
            LEFT JOIN airport AS depart
            ON flight.airport_from = depart.code
            LEFT JOIN airport AS arrival
            ON flight.airport_to = arrival.code
            ORDER BY id ')->fetchAll();
        ?>
        <h1>Codi Flights</h1>

        <form class="" action="index.php" method="get">
            <input type="search" name="searchBar" value="">
            <select class="" name="cityselect">
                <?php foreach ($airports as $cityDepart):?>
                    <option value=""><?php echo $cityDepart["city"] ?></option>
                <?php endforeach ?>
                <input type="submit" name="btnSubmit" value="search">
            </select>
        </form>
        <?php
        if(!empty($_get["search"])){
            $search = $_get["search"];
            $dbSearch = "SELECT * FROM flight WHERE depart_city LIKE '%".$search."%'";

        }

         ?>

            <table>
                    <tr>
                      <td>Code de Vol</td>
                      <td>Ville de départ</td>
                      <td>Date de départ</td>
                      <td>Ville d'arrivé</td>
                      <td>Date d'arrivé</td>
                      <td>Duree du vol </td>
                    </tr>
                    <?php foreach ($flys as $fly):?>
                    <tr>
                      <td><?php echo $fly["code"]?></td>
                      <td><?php echo $fly["depart_city"]." ". $fly["airport_from"] ?></td>
                      <td><?php echo $fly['departure_date']; ?></td>
                      <td><?php echo $fly["arrival_city"]." ". $fly["airport_to"] ?></td>
                      <td><?php echo $fly["arrival_date"] ?></td>
                      <td>
                      <?php
                      $dateDepart = new DateTime($fly["departure_date"]);
                      $dateArrival = new DateTime($fly["arrival_date"]);
                      // print_r(date_diff($dateDepart,$dateArrival));
                      $dureeVol = $dateArrival->diff($dateDepart)->format(" %h hours and %i minuts");
                      echo $dureeVol;
                      ?>
                       </td>
                    </tr>

            <tr>


        <?php endforeach ?>


    </table>

    </body>
</html>
