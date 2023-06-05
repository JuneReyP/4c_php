<?php
include 'header.php';
include 'conn.php';

if(isset($_SESSION['logged_in'])){
    header("location: blogs.php");
}

if (isset($_POST['signUp'])) {
    $fName = $_POST['firstName'];
    $lName = $_POST['lastName'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if ($password1 == $password2) {
        $hash = password_hash($password1, PASSWORD_DEFAULT);
        $register = $conn->prepare("INSERT INTO users(f_name, l_name, email, password) VALUES(?, ?, ?, ?)");
        $register->execute([
            $fName,
            $lName,
            $email,
            $hash
        ]);
        $successMsg = "Registration Successful!";
    } else {
        $msg = "Password do not match!";
    }
}

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-5">
            <?php
            if (isset($msg)) {
                echo '
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>' . $msg . '</strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
         ';
            } elseif (isset($successMsg)) { ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong><?= $successMsg; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php } ?>
            <form method="POST" action="register.php" class="shadow p-4 mt-4">
                <div class="row mb-3">
                    <label for="firstName" class="col-sm-4 col-form-label">First Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php if(isset($fName)){ echo $fName; } ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="LastName" class="col-sm-4 col-form-label">Last Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="astName" name="lastName" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" name="email" class="form-control" id="inputEmail" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword1" class="col-sm-4 col-form-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputPassword1" name="password1" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword2" class="col-sm-4 col-form-label">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputPassword2" name="password2" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <button name="signUp" class="btn btn-primary">Sign up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

</html>