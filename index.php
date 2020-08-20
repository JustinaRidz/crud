<?php

declare(strict_types=1);
include('scrips/loginToDB.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <title>Document</title>
</head>

<body>
    <header>
        <a href="index.php">Darbuotojai</a>
        <a href="index.php?projects">Projektai</a>
    </header>
    <?php
    $sql = "SELECT person_id, person_name, person_lastname FROM crud.people";
    // $columns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'db_name' AND TABLE_NAME = 'tbl_name'";
    # Darbuotojai
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        ob_start(); ?>
        <a href="index.php?new">NEW</a>
        <?php
        echo "
            <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Lastname</th>
                <th>action</th>
            </tr>
        ";
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['person_id'];
            $name = $row['person_name'];
            $lastName = $row['person_lastname'];

            echo "
                 <tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$lastName</td>
                    <td><a href='index.php?del=$id'>delete</a></td>
                </tr>
            ";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    #Projektai
    if (isset($_GET['projects'])) {
    ob_clean();
    $sql = "SELECT project_id, project_name, project_deadline FROM crud.project";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "
            <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Deadline</th>
            </tr>
        ";
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['project_id'];
            $name = $row['project_name'];
            $deadline = $row['project_deadline'];
            echo "
                 <tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$deadline</td>
                </tr>
            ";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
}
if(isset($_GET['new'])) {
 echo "
 <form action='' method='post'>
  <input type='text' id='fname' name='fname'><br>
  <input type='text' id='lname' name='lname'><br><br>
  <input type='submit' value='Submit'>
</form> 
 ";

 $vardas = $_POST['fname'];
 $pavarde = $_POST['lname'];
    
  if(isset($vardas) && isset($pavarde)) {
      if(!empty($vardas) && !empty($pavarde)) {
                $sql = "INSERT INTO crud.people (person_name, person_lastname)
                        VALUES ('$vardas', '$pavarde')";

                if (mysqli_query($conn, $sql)) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                header('Location: index.php');
      } else {
          echo "Irasyk kazka!!!!";
      }
    }
}
    // sql to delete a record
$delete = $_GET['del'];
    if(isset($delete)) {
    $sql = "DELETE FROM crud.people WHERE person_id=$delete";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
        header('Location: index.php');
    }


    mysqli_close($conn);
    ?>
</body>

</html>