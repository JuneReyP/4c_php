<?php
    include 'header.php';
    include 'conn.php';

    if(isset($_SESSION['logged_in'])){
        header("location: blogs.php");
    }

    if(isset($_POST['login'])){
        $email = trim($_POST['email']);
        $pass = $_POST['password'];

        $rows = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $rows->execute([$email]);

        foreach($rows as $row){
            if(password_verify($pass, $row['password'])){
                
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $row['u_id'];

                header("location: blogs.php");
            }else{
                $msg = "Email or password incorrect!";
            }
        }
    }
 ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
        <?php if (isset($msg)) {
                echo '
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong>' . $msg . '</strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
         ';
            } ?>
        <form method="POST" action="login.php" class="shadow p-4 mt-4">
                <div class="row mb-3">
                    <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" name="email" class="form-control" id="inputEmail" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword1" class="col-sm-4 col-form-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputPassword1" name="password" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-4">
                        <button name="login" class="btn btn-primary">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 </body>
 </html>