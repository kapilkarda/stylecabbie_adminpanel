<?php
    include_once 'db.php';   
    if(isset($_POST['start']) && !empty($_POST['start']) && ($_POST['end']) && !empty($_POST['end'])){ 
    	$start1=$_POST['start'];
    	$start=date('Y-m-d',strtotime($start1));
        $end1=$_POST['end'];
    	$end=date('Y-m-d',strtotime($end1));
    	$sql = mysqli_query($con,"SELECT * FROM task where created_at BETWEEN '$start' AND '$end'");
     	$count=mysqli_num_rows($sql);
	}
?>
<thead>
    <tr>
        <th class="numeric">Title</th>
        <th class="numeric">Description</th>
        <th class="numeric">Placed From</th>
        <th class="numeric">Placed To</th>
        <th class="numeric">Status</th>
        <th class="numeric">Date</th>
        <th class="numeric">Action</th>
    </tr>
</thead>
<tbody>
    <?php 
    while ($row_con=mysqli_fetch_array($sql)) {
    ?>
    <tr id='trrow".$row_con['id']."' >
        <td class="center" class="numeric"><?php echo $row_con['title'];?></td>
        <td class="center" class="numeric"><?php echo $row_con['description'];?></td>
        <td class="center" class="numeric"><?php echo $row_con['place_from'];?></td>
        <td class="center" class="numeric"><?php echo $row_con['place_to'];?></td>
        <td class="center" class="numeric">
            <select class="form-control" name="status" onChange="changeStatus(this.value,<?php echo $row_con['task_id'];?>);">
                <option <?php if($row_con['status']=='0'){ echo "selected"; } ?> value="0"><?php echo 'Pending' ;?></option>
                <option <?php if($row_con['status']=='1'){ echo "selected"; } ?> value="1"><?php echo 'Discussion';?></option>
                <option <?php if($row_con['status']=='2'){ echo "selected"; } ?> value="2"><?php echo 'Accepted' ;?></option>
                <option <?php if($row_con['status']=='3'){ echo "selected"; } ?> value="3"><?php echo 'Cancle By User' ;?></option>
                <option <?php if($row_con['status']=='4'){ echo "selected"; } ?> value="4"><?php echo 'Cancle By admin' ;?></option>
                <option <?php if($row_con['status']=='5'){ echo "selected"; } ?> value="5"><?php echo 'Completed' ;?></option>
            </select>
        </td>
        <td class="center" class="numeric"><?php echo $row_con['created_at'];?></td>
        <td class="center" class="numeric">
            <a class='btn btn-info' title='student' href="view_order.php?task_id=<?php echo $row_con['task_id'];  ?>"><i class='mdi-content-create'>View</i></a>
        </td> 
    </tr>
    <?php } ?>
</tbody>
<script type="text/javascript">
    function changeStatus(status,uid){
        var result= confirm("Are you really want change status?");
        if(result==true){
            $.ajax({
              type:'POST',
              url: "updateStatus.php",
              data: "status="+status+"&uid="+uid,
              success: function(response){
                // console.log(response);
                if (response==1) {
                  // console.log('done');
                location.reload();
                } else{
                  alert('Status not update');
                }
              }
            });
        }
    }
</script>