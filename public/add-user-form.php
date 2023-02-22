<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

?>
<?php
if (isset($_POST['btnAdd'])) {


        $name = $db->escapeString(($_POST['name']));
        $mobile = $db->escapeString(($_POST['mobile']));
        $email = $db->escapeString(($_POST['email']));
		$error = array();


        if (empty($name)) {
            $error['name'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($mobile)) {
            $error['mobile'] = " <span class='label label-danger'>Required!</span>";
        }
        if (empty($email)) {
            $error['email'] = " <span class='label label-danger'>Required!</span>";
        }
     
       

        if (!empty($name) && !empty($mobile) && !empty($email)) {
            $sql = "SELECT * FROM users WHERE mobile = '$mobile'";
            $db->sql($sql);
            $res = $db->getResult();
            if ($res) {
                $error['add_user'] = " <section class='content-header'><span class='label label-danger'>User already exist</span></section>";
            } else {
                    $sql="INSERT INTO `users`(`name`, `mobile`, `email`) VALUES ('$name','$mobile','$email')";
                    $db->sql($sql);
                    $result = $db->getResult();
                    if (!empty($result)) {
                        $result = 0;
                    } else {
                        $result = 1;
                    }

                    if ($result == 1) {
                        $error['add_user'] = " <section class='content-header'><span class='label label-success'>User Added Successfully</span></section>";
                    } else {
                        $error['add_user'] = " <span class='label label-danger'>Failed add slide</span>";
                    }
            }
        }
    }
?>
<section class="content-header">
    <h1>Add New User<small><a href='users.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Users</a></small></h1>

    <?php echo isset($error['add_user']) ? $error['add_user'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr />
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">Add Category</h3> -->

                </div><!-- /.box-header -->
                <!-- form start -->
                <form name="add_user_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Name</label><i class="text-danger asterik">*</i><?php echo isset($error['name']) ? $error['name'] : ''; ?>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Mobile Number</label><i class="text-danger asterik">*</i><?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                                    <input type="number" class="form-control" name="mobile" required>
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> Email</label><i class="text-danger asterik">*</i><?php echo isset($error['email']) ? $error['email'] : ''; ?>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                        <input type="reset" onClick="refreshPage()" class="btn-warning btn" value="Clear" />
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    $('#add_user_form').validate({

        ignore: [],
        debug: false,
        rules: {
            name: "required",
            mobile: "required",
            email: "required",
        }
    });
    $('#btnClear').on('click', function() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    });
</script>

<!--code for page clear-->
<script>
    function refreshPage(){
    window.location.reload();
} 
</script>
<?php $db->disconnect(); ?>