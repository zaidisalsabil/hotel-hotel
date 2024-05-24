<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $durée = $_POST['durée']; 
    $con = mysqli_connect("localhost", "root", "", "hotel");
    if (!$con) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    
    $end_time = date('H:i', strtotime($heure . ' +' . $durée . ' minutes'));

    
    $prev_end_time_sql = "SELECT MAX(ADDTIME(heure, SEC_TO_TIME(durée * 60))) AS prev_end_time FROM `sale de réunion` WHERE `date` = '$date'";
    $prev_end_time_result = mysqli_query($con, $prev_end_time_sql);
    $row = mysqli_fetch_assoc($prev_end_time_result);
    $prev_end_time = $row['prev_end_time'];

    if ($prev_end_time >= $heure) {
        echo "<script>alert('la salle est occupée');</script>";
        
    } else {
        $insert_sql = "INSERT INTO `sale de réunion`(`nom`, `email`, `date`, `heure`, `durée`) VALUES ('$nom','$email','$date','$heure', '$durée')";
        if (mysqli_query($con, $insert_sql)) {
            echo "<script>alert('réservation réussie.');</script>";
        } else {
            echo "خطأ: " . mysqli_error($con);
        }
    }
}
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="bar.css">
    
    
</head>
<body>
<style>
        /* Ajoutez votre propre style CSS ici */
        .room-image {
          height: 300px; /* Définir la hauteur de l'image */
          object-fit: cover; /* Assurez-vous que l'image s'étend pour couvrir tout le cadre */
          margin-bottom: 20px; /* Espacement entre l'image et le texte */
          margin-top: 80px;
          margin-left: 100px;
        }
        .room-description {
          text-align: left; /* Aligner le texte à gauche */
        }
        footer{
            margin-top: 50px;
        }
        button{
            background-color: rgb(168, 166, 162);

        }
      </style>
<!-- nav-->
<nav class="navbar navbar-expand-lg sticky-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="images/logo d'hotel.png" width="90px" height="60px" alt=""></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse container" id="main">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link p-lg-3" aria-current="page" href="indexx.html" data-i18n="Accueuil">Accueuil</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle p-lg-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-i18n="A_propos">A propos</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-i18n="Action">Action</a></li>
                  <li><a class="dropdown-item" href="#" data-i18n="Another_action">Another action</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle p-lg-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-i18n="Services_loisirs">Services & loisirs</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-i18n="Service_action">Service action</a></li>
                  <li><a class="dropdown-item" href="#" data-i18n="Another_service_action">Another service action</a></li>
                  <li><a class="dropdown-item" href="#" data-i18n="Something_else_here">Something else here</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link p-lg-3" href="#" data-i18n="Tarifs">Tarifs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link p-lg-3" href="#" data-i18n="Contact">Contact</a>
              </li>
            </ul>
          </div>
        </div>
        <div>
          <select class="mt-2">
            <option value="fr" selected data-i18n="français">Français</option>
            <option value="en" data-i18n="english">English</option>
          </select>
        </div>
      </nav>

      <div class="container mt-4">
        <div class="row">
          <!-- Affichage de l'image à gauche -->
          <div class="col-md-6 order-md-2">
            <img src="images/reunion.jpeg" class="img-fluid room-image" alt="">
           
          </div>
          <!-- Affichage de la description et du formulaire de réservation à droite -->
          <div class="col-md-6 room-description order-md-1">
            <h2 data-i18n="meeting_room">Luxury Meeting Room</h2>
            <p data-i18n="meeting_room_description">
              The BENI-HAMAD hotel has a meeting room for 45 people. Our staff's experience and expertise guarantee the success of your event.
            </p>
            <!-- Formulaire de réservation -->
            <form action="réunion.php" method="post">
              <div class="form-group">
                  <label for="date" data-i18n="date_label"> Date :</label>
                  <input type="date" class="form-control" id="date" name="date" required>
              </div>
              <div class="form-group">
                  <label for="heure" data-i18n="time_label"> Heure :</label>
                  <input type="time" class="form-control" id="heure" name="heure" required>
              </div>
              <div class="form-group">
                  <label for="durée" data-i18n="duration_label"> Durée :</label>
                  <input type="number" class="form-control" id="durée" name="durée" required>
              </div>

              <div class="form-group">
                  <label for="nom" data-i18n="name_label">Nom :</label>
                  <input type="text" class="form-control" id="nom" name="nom" required>
              </div>
              <div class="form-group">
                  <label for="email" data-i18n="email_label">Email :</label>
                  <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <button type="submit" class="btn btn-primary" data-i18n="reserve_button">Réserver la salle</button>
          </form>
          </div>
        </div>
      </div>

<script src="nav.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.js"></script>
  </body>
  </html>





