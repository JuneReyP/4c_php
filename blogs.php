<?php
include 'conn.php';

include 'header.php';
if(!isset($_SESSION['logged_in'])){
    header("location: index.php");
}
//data insert
if (isset($_POST['post'])) {
    $userId = $_SESSION['user_id'];
    $title = $_POST['post_title'];
    $content = $_POST['content'];

    //insert data to DB table
    $insert = $conn->prepare("INSERT INTO postings(post_title, user_id, description) VALUES(?, ?, ?)");
    $insert->execute(array(
        //binding to our table
        $title,
        $userId,
        $content
    ));

    echo "<script>alert('Postings Inserted!')</script>";
}

//data update
if (isset($_POST['update_data'])) {
    $id = $_POST['id'];
    $title = $_POST['post_title'];
    $content = $_POST['content'];

    //update the data
    $update = $conn->prepare("UPDATE postings set post_title = ?, description = ? WHERE post_id = ?");
    $update->execute([
        $title,
        $content,
        $id
    ]);

    echo "<script>alert('Postings Updated!')</script>";
}

//delete data
if(isset($_GET['delete'])){
    //get the needed data
    $id = $_GET['id'];

    //SQL query
    $delete = $conn->prepare("DELETE FROM postings WHERE post_id = ?");

    //data binding
    $delete->execute([
        $id
    ]);

    echo "<script>alert('Postings Deleted!')</script>";
}

?>
    <div class="container">
        <div class="row">
            <!-- statement for updating and inserting data form start -->
            <?php if (isset($_GET['update'])) { ?>
                <!-- blog update forms start -->
                <div class="col-3 shadow ms-4 mt-3 p-2">
                    <form action="blogs.php" method="POST">
                        <?php
                        $id = $_GET['id'];

                        $getData = $conn->prepare("SELECT * FROM postings WHERE post_id = ?");
                        $getData->execute([
                            $id
                        ]);

                        foreach ($getData as $data) { ?>
                            <input type="hidden" name="id" value="<?= $data['post_id']; ?>">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Post Title</label>
                                <input type="text" name="post_title" value="<?= $data['post_title']; ?>" class="form-control" id="exampleFormControlInput1" placeholder="Posting Title here">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"><?= $data['description']; ?></textarea>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-success" name="update_data">Update</button>
                                <button class="btn btn-danger mt-2"><a href="blogs.php" class="text-decoration-none">Cancel</a></button>
                            </div>
                        <?php } ?>
                    </form>
                </div>

                <!-- blog update forms end -->
            <?php  } else { ?>
                <!-- blog forms start -->

                <div class="col-3 shadow ms-4 mt-3 p-2">
                    <form action="blogs.php" method="POST">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Post Title</label>
                            <input type="text" name="post_title" class="form-control" id="exampleFormControlInput1" placeholder="Posting Title here">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary" name="post">Post</button>
                        </div>
                    </form>
                </div>

                <!-- blog forms end -->
            <?php } ?>
            <!-- statement for updating and inserting data form end -->
            <!-- fetch the data start -->
            <div class="col ms-3 shadow mt-3">
                <table class="table">
                    <tr>
                        <thead>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </thead>
                    </tr>
                    <tbody>
                        <?php
                        $userId = $_SESSION['user_id']; 
                        $rows = $conn->prepare("SELECT * FROM postings WHERE user_id = ?");
                        $rows->execute([$userId]);
                        $count = 1;
                        foreach ($rows as $row) { ?>
                            <tr>
                                <td><?= $count++; ?></td>
                                <td><?= $row['post_title']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td>
                                    <a href="?update&id=<?= $row['post_id']; ?>" class="text-decoration-none">✏</a> | 
                                    <a href="?delete&id=<?= $row['post_id']; ?>" class="text-decoration-none">❌</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- fetch the data end -->

        </div>
    </div>

</body>

</html>