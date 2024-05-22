<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $con = mysqli_connect("localhost", "root", "", "hotel");
    if (!$con) {
        die("Erreur de connexion : ". mysqli_connect_error());
    }

    // التحقق من توافر المدة المحددة
    $check_sql = "SELECT * FROM `sale de réunion` WHERE `date` = '$date' AND `heure` = '$heure'";
    $result = mysqli_query($con, $check_sql);
    if (mysqli_num_rows($result) > 0) {
        echo "المدة المحددة محجوزة بالفعل";
    } else {
        // إذا كانت المدة غير محجوزة، قم بإدراج البيانات
        $insert_sql = "INSERT INTO `sale de réunion`(`nom`, `email`, `date`, `heure`) VALUES ('$nom','$email','$date','$heure')";
        if (mysqli_query($con, $insert_sql)) {
            echo "تمت إضافة البيانات بنجاح";
        } else {
            echo "حدث خطأ أثناء إضافة البيانات : " . mysqli_error($con);
        }
    }
}
?>