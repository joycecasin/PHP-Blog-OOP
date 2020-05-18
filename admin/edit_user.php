<?php include("includes/header.php");
// Enkel personen die zijn ingelogd mogen deze pagina zien
if (!$session->is_signed_in()) {
    redirect('login.php');
}
if (empty($_GET['id'])) {
    redirect('users.php');
}

$user = User::find_by_id($_GET['id']);
if (isset($_POST['update'])) {
    if ($user) {
        $user->username = $_POST['username'];
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];
        //$user->set_file($_FILES['file']);
        //$user->save_user_and_image();

        if (empty($_FILES['user_image'])) {
            $user->save();

        } else {
            $user->set_file($_FILES['user_image']);
            $user->save_user_and_image();
            $user->save();
            redirect('edit_user.php?id={$user->id}');

        }

    }
    redirect('users.php');
}


?>


<?php include("includes/sidebar.php"); ?>

<?php include("includes/content-top.php"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>Welkom op de edit user pagina</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control"
                                   value="<?php echo $user->username; ?>">
                        </div>
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="<?php echo $user->first_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="<?php echo $user->last_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password"
                                   value="<?php echo $user->password; ?>">
                        </div>
                        <div class="form-group">
                            <img src="<?php echo $user->image_path_and_placeholder(); ?>" alt="" class="img-fluid"
                                 width="40" height="40">
                            <label for="file">User image</label>
                            <input type="file" class="form-control" name="user_image">
                        </div>
                        <input type="submit" name="update" value="Update User" class="btn btn-primary">
                        <a href="delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger">Delete User?</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?php //include ("includes/content.php"); ?>

<?php include("includes/footer.php"); ?>


