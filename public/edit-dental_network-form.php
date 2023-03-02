<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_GET['id'])) {
    $ID = $db->escapeString($_GET['id']);
} else {
    // $ID = "";
    return false;
    exit(0);
}
if (isset($_POST['btnEdit'])) {

		$remarks = $db->escapeString(($_POST['remarks']));
		$status = $db->escapeString(($_POST['status']));
		$error = array();


		if (empty($remarks)) {
            $error['remarks'] = " <span class='label label-danger'>Required!</span>";
        }

     
       

        if (!empty($remarks)) {
			
			$sql_query = "UPDATE dental_networks SET remarks = '$remarks', status = '$status' WHERE id =" . $ID;
			 $db->sql($sql_query);
             $update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}

			// check update result
			if ($update_result == 1) {
				$error['update_network'] = " <section class='content-header'><span class='label label-success'>Dental Network updated Successfully</span></section>";
			} else {
				$error['update_network'] = " <span class='label label-danger'>Failed update</span>";
			}
		}
	} 


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM dental_networks WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "dental_networks.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Dental Network<small><a href='dental_networks.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Dental Networks</a></small></h1>
	<small><?php echo isset($error['update_network']) ? $error['update_network'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-6">
		
			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
					
				</div><!-- /.box-header -->
				<form id="edit_network_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="exampleInputEmail1">Remarks</label><i class="text-danger asterik">*</i><?php echo isset($error['remarks']) ? $error['remarks'] : ''; ?>
									<textarea rows="3" type="text" class="form-control" name="remarks"><?php echo $res[0]['remarks']; ?></textarea>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
						    <div class="form-group col-md-12">
								<label class="control-label">Status</label><i class="text-danger asterik">*</i><br>
								<div id="status" class="btn-group">
									<label class="btn btn-warning" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
										<input type="radio" name="status" value="0" <?= ($res[0]['status'] == 0) ? 'checked' : ''; ?>>Pending
									</label>
									<label class="btn btn-success" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
										<input type="radio" name="status" value="1" <?= ($res[0]['status'] == 1) ? 'checked' : ''; ?>> Verified
									</label>
									<label class="btn btn-danger" data-toggle-class="btn-default" data-toggle-passive-class="btn-default">
										<input type="radio" name="status" value="2" <?= ($res[0]['status'] == 2) ? 'checked' : ''; ?>> Rejected
									</label>
								</div>
							</div>
						</div>
					

					
					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btnEdit">Update</button>
					
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
