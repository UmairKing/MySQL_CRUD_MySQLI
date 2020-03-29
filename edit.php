<?php
define('DB_SERVER', 'localhost');
define('DB_NAME', 'root');
define('DB_PASS', '123456');
$dbName = "CRUD_DB";
$conn = mysqli_connect(DB_SERVER, DB_NAME, DB_PASS, $dbName);
$tableName = "CRUD_TABLE";
if (isset($_POST['issubmit'])) {
    $updateName = $_POST['updatename'];
    $updateEmail = $_POST['updateemail'];
    $updateZipcode = $_POST['updatezipcode'];
    $updateEditId = $_POST['updateEditId'];

    $updateQuery = "UPDATE {$tableName} SET uname = '$updateName', email ='$updateEmail', zipcode='$updateZipcode' WHERE id='$updateEditId';";

    $result = mysqli_query($conn, $updateQuery);
    if ($result) {
        echo "Updated successfully!";
        header("Location: CRUD.php");
    } else {
        echo "Updation unsuccessful..." . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <?php
    if (isset($_POST['edit'])) {
        $editId = $_POST['editId'];
        $editQuery = "SELECT * FROM {$tableName} WHERE id={$editId};";
        $editRes = mysqli_query($conn, $editQuery);
        $row = mysqli_fetch_assoc($editRes);
        $name = $row['uname'];
        $email = $row['email'];
        $zipcode = $row['zipcode'];
        echo "<div class='container'>


        <form action='{$_SERVER['PHP_SELF']}' method='POST'>
            <div class='form-group'>
                <label>Name</label>
                <input type='text' name='updatename' class='form-control' value={$name}>
            </div>
            <div class='form-group'>
                <label>Email address</label>
                <input type='email' name='updateemail' class='form-control' value={$email}>
            </div>
            <div class='form-group'>
                <label>zipcode</label>
                <input type='number' name='updatezipcode' class='form-control' value={$zipcode}>
            </div>
            <input type='hidden' name='updateEditId' class='form-control' value={$editId}>
            <button type='submit' name='issubmit' class='btn btn-primary'>Insert</button>
        </form>
    </div>";
    }
    ?>
</body>

</html>