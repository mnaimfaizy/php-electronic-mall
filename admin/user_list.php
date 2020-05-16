<?php include_once("includes/header.php"); ?>
<?php
	global $database;
?>
<script>
	function conf(id) {
		var value = window.confirm("Are you sure! You want to delete selected Item?");
		if(value == true) {
			window.location = "delete.php?user_id="+id;
		} else { 
			// Do something else
		}
	}
	
	function update_user_group(id) {
		var group = $("#user_group_"+id).val();
		//alert(status);
		$("#Loading").removeClass('hidden');
		$("#Loading").addClass('show');
		$("#Loading").fadeIn("fast"); // show when submitting
		$.post('ajax/update_user_group.php', {user_id: id, group: group}, function(data) {
				//$('div#update ul.searchresults').html(data);
				//alert(data);
				$("#Loading").fadeOut(4000); // hide when data's ready
				//$("#Loading").removeClass('show');
				//$('#Loading').addClass('hidden');
				
		});		
		return false;
	}
</script>
<?php include_once("includes/top_navigation.php"); ?>

	<!-- BEGIN CONTAINER -->	
	<div class="page-container row-fluid">
		
    <?php include_once("includes/sidebar_menu.php"); ?>
        
		<!-- BEGIN PAGE -->
		<div class="page-content">
			
            <!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
                	<!-- BEGIN span12 -->
					<div class="span12">
						<!-- BEGIN STYLE CUSTOMIZER -->
						<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
							<!-- BEGIN color-mode -->
                            <div class="color-mode">
								<p>THEME COLOR</p>
								<ul class="inline">
									<li class="color-black current color-default" data-style="default"></li>
									<li class="color-blue" data-style="blue"></li>
									<li class="color-brown" data-style="brown"></li>
									<li class="color-purple" data-style="purple"></li>
									<li class="color-white color-light" data-style="light"></li>
								</ul>
								<label class="hidden-phone">
								<input type="checkbox" class="header" checked value="" />
								<span class="color-mode-label">Fixed Header</span>
								</label>							
							</div>
                            <!-- END color-mode -->
						</div>
						<!-- END BEGIN STYLE CUSTOMIZER --> 
                        
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Users List &nbsp;				<small> Here You can view information about Users.</small>
						</h3>
						<ul class="breadcrumb">
							<?php $breadcrumb = breadcrumb();
                                echo $breadcrumb; 
                            ?>
                        </ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
                    <!-- END span12 -->
				</div>
				<!-- END PAGE HEADER-->
            
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Register Users Information</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="span2 hidden" id="Loading">
                                    <img src="images/ajax-loader.gif" />
                                </div>
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#">Print</a></li>
											<li><a href="#">Save as PDF</a></li>
											<li><a href="#">Export to Excel</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="user_table">
									<thead>
										<tr>
											<th>No</th>
											<th>Username</th>
                                            <th>Name</th>
                                            <th>User Group</th>
                                            <th>Profile Photo</th>
                                            <th>Status</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$sql = "SELECT * FROM user ORDER BY id DESC"; 
											$result = $database->query($sql);
											while($customer = $database->fetch_array($result)) {
										?>
                                        <tr class="">
											<td><?php echo $no++; ?></td>
											<td><?php echo $customer['username'];?></td>
                                            <td><?php echo $customer['name'];?></td>
                                            <td>
											<select name="user_group" id="user_group_<?php echo $customer['id']; ?>">
											<?php $group_id = $customer['group_id'];
												$query = $database->query("SELECT * FROM user_group");
											while($row = $database->fetch_array($query)) { ?>
                                            <option value="<?php echo $row['id']; ?>"
                                            <?php if($row['id'] == $group_id) { echo 'selected="selected"'; } ?>> 
											<?php echo $row['group_name']; ?> </option>
                                            <?php } ?>
                                            </select>   
                                            <button class="btn green" id="<?php echo $customer['id']; ?>" onClick="update_user_group(this.id)"> UPDATE </button> 
                                            </td>
                                            <td class="text-center"><img src="images/users/<?php echo $customer['photo'];?>" width="50" height="50" alt="<?php echo $customer['name']; ?>" /></td>
                                            <td><span style="background-color: #8E0002; color: #FFFFFF; padding:4px 10px;">
											<?php echo $customer['status'];?> </span></td>
											<td>
                                            <button type="button" class="btn btn-danger btn-small" onClick="conf(this.id)" id="<?php echo $customer['id']; ?>"> <i class="icon-trash"></i> </button></td>
										</tr>
                                        <?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
            	<!-- END PAGE CONTENT -->
            
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

<?php include_once("includes/footer.php"); ?>