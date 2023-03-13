<?php


include('./includes/variables.php');
include_once('includes/custom-functions.php');
$fn = new custom_functions;

if (isset($_POST['btnLogin'])) {

    // get email and password
    $mobile = $db->escapeString($_POST['mobile']);
    $password = $db->escapeString($_POST['password']);

    // set time for session timeout
    $currentTime = time() + 25200;
    $expired = 3600;

    // create array variable to handle error
    $error = array();

    // check whether $email is empty or not
    if (empty($mobile)) {
        $error['mobile'] = "*Email should be filled.";
    }

    // check whether $password is empty or not
    if (empty($password)) {
        $error['password'] = "*Password should be filled.";
    }

    // if email and password is not empty, check in database
    if (!empty($mobile) && !empty($password)) {
        $sql_query = "SELECT * FROM admins WHERE mobile = '$mobile' AND password = '$password' AND status = 1";
        $db->sql($sql_query);
        $res = $db->getResult();
        $num = $db->numRows($res);
        if($num == 1){
            $_SESSION['id'] = $res[0]['id'];
            $_SESSION['role'] = $res[0]['role'];
            $_SESSION['username'] = $res[0]['name'];
            $_SESSION['mobile'] = $res[0]['mobile'];
            $_SESSION['timeout'] = $currentTime + $expired;
            header("location: home.php");
            
        }
        else{
            $error['failed'] = "<span class='label label-danger'>Invalid Mobile or Password!</span>";
        }
    }
}
?>
<?php echo isset($error['update_user']) ? $error['update_user'] : ''; ?>
<div class="col-md-4 col-md-offset-4 " style="margin-top:100px;">
    <!-- general form elements -->
    <div class='row'>
        <div class="col-md-12 text-center">
            <img src="dist/img/logo.jpeg" height="110">
            <h3>Mediensure -Dashboard</h3>
        </div>
        <div class="box box-info col-md-12">
            <div class="box-header with-border">
                <h3 class="box-title">Admin Login</h3>
                <center>
                    <div class="msg"><?php echo isset($error['failed']) ? $error['failed'] : ''; ?></div>
                </center>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mobile :</label>
                        <input type="number" name="mobile" class="form-control" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password :</label>
                        <input type="password" class="form-control" name="password" value="" required>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="btnLogin" class="btn btn-info pull-left">Login</button>
                    </div>
                </div>
            </form>
        </div><!-- /.box -->
    </div>
</div>
<?php include('footer.php'); ?>