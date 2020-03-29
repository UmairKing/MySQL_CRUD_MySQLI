<!-- 
    
    Goal: 
    Create Dd, Create table 
    Insert, Read, Update, Delete

    Plan/Divide:
    Create database on a button click
    Delete database on a buton click
    Create table on a button click
    Delete table on a buton click
    Insert on form submit
    Read Automatically (Can be refreshed on button click)
    Update on button click
    Delete on button click

    id, name, email and zipcode will be stored


 -->

<?php
define('DB_SERVER', 'localhost');
define('DB_NAME', 'root');
define('DB_PASS', '123456');
$conn = mysqli_connect(DB_SERVER, DB_NAME, DB_PASS);
$dbName = "CRUD_DB";
$tableName = "CRUD_TABLE";


if (isset($_POST['createdb'])) {
    $dbCreate = "CREATE DATABASE IF NOT EXISTS {$dbName};";
    $dbCreateRes = mysqli_query($conn, $dbCreate);
    if ($dbCreateRes) {
        echo "DB Created";
    } else {
        echo "DB Failed: " . mysqli_error($conn);
    }
}
if (isset($_POST['deletedb'])) {
    $dbDrop = "DROP DATABASE IF EXISTS {$dbName};";
    $dbDropRes = mysqli_query($conn, $dbDrop);
    if ($dbDropRes) {
        echo "DB Deleted Successfully!";
    } else {
        echo "DB Deletion Failed: " . mysqli_error($conn);
    }
}
if (isset($_POST['createtable'])) {
    $conn = mysqli_connect(DB_SERVER, DB_NAME, DB_PASS, $dbName);
    $tableCreate = "CREATE TABLE IF NOT EXISTS {$tableName} (id INT NOT NULL AUTO_INCREMENT, uname VARCHAR (255), email VARCHAR (255), zipcode INT (15), PRIMARY KEY (id) );";
    $tableCreateRes = mysqli_query($conn, $tableCreate);
    if ($tableCreateRes) {
        echo "Table Created Successfully!";
    } else {
        echo "Table Creation Failed: " . mysqli_error($conn);
    }
}
if (isset($_POST['deletetable'])) {
    $conn = mysqli_connect(DB_SERVER, DB_NAME, DB_PASS, $dbName);
    $tableDrop = "DROP TABLE IF EXISTS {$tableName};";
    $tableDropRes = mysqli_query($conn, $tableDrop);
    if ($tableDropRes) {
        echo "Table Deleted Successfully!";
    } else {
        echo "Table Deletion Failed: " . mysqli_error($conn);
    }
}

if (isset($_POST['isubmit'])) {
    $conn = mysqli_connect(DB_SERVER, DB_NAME, DB_PASS, $dbName);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $zipcode = $_POST['zipcode'];

    $insertQuery = "INSERT INTO {$tableName} (uname, email, zipcode ) VALUES ('$name','$email','$zipcode');";
    $insertRes = mysqli_query($conn, $insertQuery);
    if ($insertRes) {
        echo "Inserted successfully";
    } else {
        echo "Insertion Failed!" . mysqli_error($conn);
    }
}

if (isset($_POST['delete'])) {
    $conn = mysqli_connect(DB_SERVER, DB_NAME, DB_PASS, $dbName);
    $delId = $_POST['delId'];
    $delQuery = "DELETE FROM {$tableName} WHERE id = {$delId};";
    if (mysqli_query($conn, $delQuery)) {
        echo "Record deleted Successfully!";
    } else {
        echo "Record deletion failed" . mysqli_error($conn);
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
    <div class="container text-center">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
            <input type="hidden" name="createdb" value="Create DB">
            <button type="submit" class="btn btn-primary">Create Database</button>
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
            <input type="hidden" name="createtable" value="Create Table">
            <button type="submit" class="btn btn-primary">Create Table</button>
        </form>
    </div>

    <div class="container text-center mt-3">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
            <input type="hidden" name="deletedb" value="Delete DB">
            <button type="submit" class="btn btn-danger">Delete Database</button>
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-inline">
            <input type="hidden" name="deletetable" value="Delete Table">
            <button type="submit" class="btn btn-danger">Delete Table</button>
        </form>
    </div>

    <div class="container">


        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>zipcode</label>
                <input type="number" name="zipcode" class="form-control">
            </div>
            <button type="submit" name="isubmit" class="btn btn-primary">Insert</button>
        </form>
    </div>



    <div class="container mt-5">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Zipcode</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = mysqli_connect(DB_SERVER, DB_NAME, DB_PASS, $dbName);
                $selectQuery = "SELECT * FROM {$tableName};";
                $selectRes = mysqli_query($conn, $selectQuery);
                $rowscheck = mysqli_num_rows($selectRes);
                if ($rowscheck > 0) {
                    while ($row = mysqli_fetch_assoc($selectRes)) {
                        echo "<tr>
                    <th>{$row['id']}</th>
                    <td>{$row['uname']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['zipcode']}</td>
                    <td>
                    <form action='edit.php' method='POST' class='d-inline'>
                    <input type='hidden' name='editId' value={$row['id']}>
                    <button type='submit' name='edit' class='btn btn-primary'>Edit</button>
                    </form>
                    <form action='{$_SERVER['PHP_SELF']}' method='POST' class='d-inline'>
                    <input type='hidden' name='delId' value={$row['id']}>
                    <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                    </form>
                    </td>
                    </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>