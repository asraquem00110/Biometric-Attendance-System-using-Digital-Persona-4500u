<style>

</style>
<?php
include('auth.php');
require_once('include/include-head.php');
require_once('include/include-main.php');
require_once('proc/config.php');
$AccessAreas = array();
$sql = "SELECT * FROM tbl_arealist ORDER BY AreaName";
$res = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($res)>0){
	while($row=mysql_fetch_assoc($res)){
		$AccessAreas[]=$row;
	}
}
$users = array();
$sql = "SELECT * FROM tb_user ORDER BY full_name";
$res = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($res)>0){
	while($row=mysql_fetch_assoc($res)){
		$users[]=$row;
	}
}
$countarea = $countuser = 1;
?>

  <div class="col col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading"><strong style="font-size: 14pt;"><span class="glyphicon glyphicon-cog"></span> SETTINGS</strong></div>
        <div class="panel-body">
        		<div class="col col-md-4">
        				<div class="panel panel-primary">
        						<div class="panel-heading"><b>AREA</b></div>
        						<div class="panel-body">
        							<table class="table table-bordered" id="areaTable">
        								<thead>
        									<tr>
        									<th>#</th>
        									<th>Area</th>
        									<th>Type</th>
        									<th style="width:2%"></th>
        									<th style="width:2%"></th>
        									</tr>
        								</thead>
        								<tbody>
        									<?php foreach($AccessAreas as $area):?>
											<tr>
											<td><?php echo $countarea++;?></td>
											<td><?php echo $area['AreaName'];?></td>
											<td><?php echo $area['AreaType'];?></td>
											<td align="center"><button class="btn btn-xs btn-default editArea" data-id="<?php echo $area["ID"];?>" data-area="<?php echo $area["AreaName"];?>" data-type="<?php echo $area["AreaType"];?>"><span class="glyphicon glyphicon-edit"></span></button></td>			
											<td align="center"><button class="btn btn-xs btn-danger removeArea" data-id="<?php echo $area["ID"];?>"><span class="glyphicon glyphicon-remove"></span></button></td>
											</tr>
        									<?php endforeach?>
        								</tbody>
        							</table>
        							<div style="margin: 0pt 10pt 0pt 10pt;">
        							<form class="form-horizontal">
        								<div class="form-group">
        									<!-- <label></label> -->
        									<input type="text" id="areaname" class="form-control" placeholder="Area">
        								</div>
        								<div class="form-group">
        									<!-- <label></label> -->
        									<input type="text" id="typename" class="form-control" placeholder="Type">
        								</div>

        								<div class="form-group">
        									<!-- <label></label> -->
        									<button type="button" id="addarea" class="btn btn-primary form-control"><span class="glyphicon glyphicon-plus"></span> ADD</button>
        								</div>

        							</form>
        						</div>
        						</div>
        				</div>
        		</div>
        		<div class="col col-md-8">
        				<div class="panel panel-primary">
        						<div class="panel-heading"><b>USER</b><button id="showadduserModal" class="btn btn-xs pull-right btn-primary"><span class="glyphicon glyphicon-plus"></span> NEW</button></div>
        						<div class="panel-body">
        								<table class="table table-bordered" id="userTable">
        								<thead>
        									<tr>
        									<th>#</th>
        									<th>Username</th>
        									<th>Fullname</th>
        									<th>Email Address</th>
        									<th>UserLevel</th>
        									<th style="width:2%"></th>
        									<th style="width:2%"></th>
        									</tr>
        								</thead>
        								<tbody>
        									<?php foreach($users as $user):?>
											<tr>
											<td><?php echo $countuser++;?></td>
											<td><?php echo $user['user_name'];?></td>
											<td><?php echo $user['full_name'];?></td>
											<td><?php echo $user['email_add'];?></td>
											<td><?php echo $user['userlevel'];?></td>
											<td align="center"><button class="btn btn-xs btn-default edituser" data-id="<?php echo $user['IDno'];?>" data-fullname="<?php echo $user['full_name'];?>" data-username="<?php echo $user['user_name'];?>" data-level="<?php echo $user['userlevel'];?>" data-email="<?php echo $user['email_add'];?>" data-password="<?php echo $user['pass_word'];?>"><span class="glyphicon glyphicon-edit"></span></button></td>			
											<td align="center"><button class="btn btn-xs btn-danger removeuser" data-id="<?php echo $user['IDno'];?>"><span class="glyphicon glyphicon-remove"></span></button></td>
											</tr>
        									<?php endforeach?>
        								</tbody>
        							</table>
        						</div>
        				</div>

        		</div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" role="dialog" id="DeleteAreaModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<span class="hidden" id="delareaid"></span>
				<strong>ARE YOU SURE YOU WANT TO DELETE THIS AREA?</strong>


			</div>
			<div class="modal-footer">
				<button class="btn btn-default pull-left" id="hidemodal"><span class="glyphicon glyphicon-remove"></span> CLOSE</button>
				<button class="btn btn-danger pull-right" id="delarea"><span class="glyphicon glyphicon-remove"></span> REMOVE</button>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" role="dialog" id="EditAreaModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<span class="hidden" id="areaid"></span>
				<div style="margin: 0pt 10pt 0pt 10pt;">
					<form class="form-horizontal">
						<div class="form-group">
							<!-- <label></label> -->
							<input type="text" name="" class="form-control" id="editarea">
						</div>
						<div class="form-group">
							<!-- <label></label> -->
							<input type="text" name="" class="form-control" id="edittype">
						</div>
					</form>
        		</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default pull-left" id="hidemodal"><span class="glyphicon glyphicon-remove"></span> CLOSE</button>
				<button class="btn btn-primary pull-right" id="updatearea"><span class="glyphicon glyphicon-check"></span> UPDATE</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" role="dialog" id="addUserModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<div style="margin: 0pt 10pt 0pt 10pt">
					<form class="form-horizontal">
						<div class="form-group">
							<label>FULLNAME</label>
							<input type="text" name="" id="fullname" class="form-control">
						</div>
						<div class="form-group">
							<label>USERNAME</label>
							<input type="text" name="" id="username" class="form-control">
						</div>
						<div class="form-group">
							<label>EMAIL ADDRESS</label>
							<input type="email" name="" id="email" class="form-control">
						</div>
						<div class="form-group">
							<label>USER LEVEL</label>
							<select class="form-control" id="level">
								<option>Admin</option>
								<option>User</option>
							</select>
						</div>

						<div class="form-group">
							<label>PASSWORD</label>
							<input type="password" name="" id="password" class="form-control">
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default pull-left" id="hidemodal"><span class="glyphicon glyphicon-remove"></span> CLOSE</button>
				<button class="btn btn-primary pull-right" id="adduser"><span class="glyphicon glyphicon-check"></span> ADD</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" role="dialog" id="DeleteUserModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<span class="hidden" id="deluserid"></span>
				<strong>ARE YOU SURE YOU WANT TO DELETE THIS USER?</strong>


			</div>
			<div class="modal-footer">
				<button class="btn btn-default pull-left" id="hidemodal"><span class="glyphicon glyphicon-remove"></span> CLOSE</button>
				<button class="btn btn-danger pull-right" id="deluser"><span class="glyphicon glyphicon-remove"></span> REMOVE</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" role="dialog" id="editUserModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"></div>
			<div class="modal-body">
				<div style="margin: 0pt 10pt 0pt 10pt">
					<span class="hidden" id="userid"></span>
					<form class="form-horizontal">
						<div class="form-group">
							<label>FULLNAME</label>
							<input type="text" name="" id="editfullname" class="form-control">
						</div>
						<div class="form-group">
							<label>USERNAME</label>
							<input type="text" name="" id="editusername" class="form-control">
						</div>
						<div class="form-group">
							<label>EMAIL ADDRESS</label>
							<input type="email" name="" id="editemail" class="form-control">
						</div>
						<div class="form-group">
							<label>USER LEVEL</label>
							<select class="form-control" id="editlevel">
								<option>Admin</option>
								<option>User</option>
							</select>
						</div>

						<div class="form-group">
							<label>PASSWORD</label>
							<input type="password" name="" id="editpassword" class="form-control">
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default pull-left" id="hidemodal"><span class="glyphicon glyphicon-remove"></span> CLOSE</button>
				<button class="btn btn-primary pull-right" id="updateuser"><span class="glyphicon glyphicon-check"></span> UPDATE</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	$('#userTable').dataTable();

	$(document).on('click','.editArea',function(){
		var idno = $(this).data('id');
		var area = $(this).data('area');
		var type = $(this).data('type');
		$('#editarea').val(area);
		$('#edittype').val(type);
		$('#areaid').text(idno);
		$('#EditAreaModal').modal('show');
	})

	$(document).on('click','.removeArea',function(){
		var idno = $(this).data('id');
		$('#delareaid').text(idno);
		$('#DeleteAreaModal').modal('show');
	})

	document.getElementById('delarea').onclick = function(){
		var idno = $('#delareaid').text();
		$.ajax({
			url: 'function/areasetting.php',
			type: 'POST',
			data: '&id='+idno+'&remove=1',
			success:function(x){
				window.location.href = window.location.href;
			}
		})
	}

	$(document).on('click','#hidemodal',function(){
		$('#EditAreaModal').modal('hide');
		$('#addUserModal').modal('hide');
		$('#DeleteAreaModal').modal('hide');
		$("#DeleteUserModal").modal('hide');
		$('#editUserModal').modal('hide');
	})

	document.getElementById('updatearea').onclick = function(){
		var idno = $('#areaid').text();
		var area = document.getElementById('editarea').value;
		var type = document.getElementById('edittype').value;
		$.ajax({
			url: 'function/areasetting.php',
			type: 'POST',
			data: '&id='+idno+'&area='+area+'&type='+type+'&update=1',
			success:function(x){
				window.location.href = window.location.href;
			}
		})
	}

	document.getElementById('addarea').onclick = function(){
	
		var area = document.getElementById('areaname').value;
		var type = document.getElementById('typename').value;
		$.ajax({
			url: 'function/areasetting.php',
			type: 'POST',
			data: '&area='+area+'&type='+type+'&add=1',
			success:function(x){
				window.location.href = window.location.href;
			}
		})
	}

	$(document).on('click','#showadduserModal',function(){
		$('#addUserModal').modal('show');
	})

	document.getElementById('adduser').onclick = function(){
		var fullname = $('#fullname').val();
		var username = $('#username').val();
		var level = $('#level').val();
		var email = $('#email').val();
		var password = $('#password').val();
	
		$.ajax({
			url: 'function/usersetting.php',
			type: 'POST',
			data: '&fullname='+fullname+'&username='+username+'&level='+level+'&email='+email+'&password='+password+'&add=1',
			success:function(x){
				window.location.href = window.location.href;
			}
		})
	}

	$(document).on('click','.removeuser',function(){
		$("#deluserid").text($(this).data('id'));
		$("#DeleteUserModal").modal('show');
	})

	document.getElementById('deluser').onclick = function(){
		var idno = $('#deluserid').text();
		$.ajax({
			url: 'function/usersetting.php',
			type: 'POST',
			data: '&id='+idno+'&remove=1',
			success:function(x){
				window.location.href = window.location.href;
			}
		})
	}

	$(document).on('click','.edituser',function(){
		$('#userid').text($(this).data('id'));
		$('#editfullname').val($(this).data('fullname'));
		$('#editusername').val($(this).data('username'));
		$('#editlevel').val($(this).data('level'));
		$('#editemail').val($(this).data('email'));
		$("#editpassword").val($(this).data('password'));
		$('#editUserModal').modal('show');
	})

		document.getElementById('updateuser').onclick = function(){
		var idno = $('#userid').text();
		var fullname = $('#editfullname').val();
		var username = $('#editusername').val();
		var level = $('#editlevel').val();
		var email = $('#editemail').val();
		var password = $('#editpassword').val();

		$.ajax({
			url: 'function/usersetting.php',
			type: 'POST',
			data: '&id='+idno+'&fullname='+fullname+'&username='+username+'&level='+level+'&email='+email+'&password='+password+'&update=1',
			success:function(x){
				window.location.href = window.location.href;
			}
		})
	}


</script>
