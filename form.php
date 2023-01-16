<?php
    $host = 'localhost';
    $dbname = 'cookie-password';
    $dbuser = 'root';
    $dbpass = '';

    $conn = new PDO("mysql:host=$host;dbname=$dbname",$dbuser, $dbpass);
    if(!$conn) {
        echo "database connection fail";
    }

    if(isset($_POST['submitBtn'])) {
        $password = $_POST['password'];

        $sql = "SELECT * FROM passwords WHERE password='$password'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchObject();

        if($result) {
            if($result->status != true) {
                $updateSql = "UPDATE passwords SET status=true WHERE id=$result->id";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->execute();
                setcookie('as-mobile-pro-password', $password);
                header('location:https://getbootstrap.com');
            }
            if($result->status == true) {
                if(!isset($_COOKIE['as-mobile-pro-password'])) {
                    header('location:form.php');
                    echo 'hey dont do that';
                }
                if($password === $_COOKIE['as-mobile-pro-password']) {
                    header('location:https://getbootstrap.com');
                }
            }
        } else {
            echo "<script>alert('wrong password')</script>";
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>as mobile pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <form method="post">
            <div class="mb-2">
                <input type="text" name="password" placeholder="enter password" class="form-control" required>
            </div>
            <button name="submitBtn" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>