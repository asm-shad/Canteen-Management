<?php

include('header.php');

$all_application = $cls_meassage->eligible_application_information_VIP($username);

?>

<style>
.btn-mini {
padding: 4px 8px !important;
font-size: 12px;
line-height: 1;
}

#canteenTable {
/*table-layout: fixed;
width: 100%;*/
}

#canteenTable th,
#canteenTable td {
white-space: normal;
word-break: break-word;
vertical-align: top;
}


.filter-input {
width: 100% !important;
box-sizing: border-box;
font-size: 11px;
padding: 3px 5px;
height: 26px;
border: 1px solid #ddd;
border-radius: 3px;
}
</style>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">
<div class="panel panel-headline">
<div class="panel-heading">
    <h3 class="panel-title">VIP Canteen Applicants Information (Requested Applicants Only)

    </h3>
    <p class="text-danger small">
        Note: Summary Result comes Based on Point Scale and Terms & Condition
    </p>
    <!--    <p class="panel-subtitle">
    
    <form method="post" action="inbox.php" align="center">  
        <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
    </form> 
    </p> -->
</div>
<div class="panel-body">
    <div class="row">
        <div class="col-md-12">

            <table class="table table-striped table-bordered table-hover text-center" id="canteenTable">
                <thead>
                    <!-- COLUMN HEADERS (WIDTH CONTROLS HERE) -->
                    <tr>
                        <th style="width:60px">Std-Rank</th>
                        <th style="width:80px">Employee ID</th>
                        <th style="width:120px">Name</th>
                        <th style="width:110px">Designation</th>
                        <th style="width:100px">Mobile</th>
                        <th style="width:95px">Joining Date</th>
                        <th style="width:95px">Application Date</th>
                        <th style="width:50px">Grade</th>
                        <th style="width:120px">Employer Factory</th>

                        <th style="width:90px">Section/Department</th>
                        <th style="width:80px">Total Number</th>
                        <th style="width:160px">Action</th>
                    </tr>

                    <!-- FILTER ROW -->
                    <tr style="background:#f9f9f9">
                        <th><input type="hidden" class="filter-input"></th>
                        <th><input type="text" class="filter-input"></th>
                        <th><input type="text" class="filter-input"></th>
                        <th><input type="text" class="filter-input"></th>
                        <th><input type="text" class="filter-input"></th>
                        <th><input type="date" class="filter-input"></th>
                        <th><input type="date" class="filter-input"></th>
                        <th><input type="text" class="filter-input"></th>
                        <th><input type="text" class="filter-input"></th>
                        <th><input type="text" class="filter-input"></th>
                        <th><input type="text" class="filter-input"></th>
                        <th><input type="hidden" class="filter-input"></th>

                    </tr>
                </thead>


                <tbody style="font-size:12px;">
                    <?php $i = 1;
                    while ($data = $all_application->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $data['employee_id']; ?></td>
                            <td><?= $data['name']; ?></td>
                            <td><?= $data['designations']; ?></td>
                            <td><?= $data['mobile']; ?></td>
                            <td><?= $data['joining_date']; ?></td>
                            <td><?= $data['application_date']; ?></td>
                            <td><?= $data['level']; ?></td>
                            <td><?= $data['employer_factory']; ?></td>
                            <td><?= $data['section_or_department']; ?></td>
                            <td><strong><?= round($data['total_point'], 2); ?></strong></td>
                            <td>
                                <div style="display: inline-block;">

                                    <div style="display: flex; gap: 4px; margin-bottom: 3px;">
                                        <button class="btn btn-info btn-mini"
                                            onclick="openPointModal(<?php echo htmlspecialchars(json_encode($data)); ?>)">
                                            View Point
                                        </button>

                                        <button class="btn btn-success btn-mini"
                                            onclick="openAcceptModal(<?php echo $data['id']; ?>, '<?php echo $data['name']; ?>')">
                                            Accept
                                        </button>
                                    </div>
<div style="display: flex; gap: 4px; margin-bottom: 3px;">
<button class="btn btn-danger btn-mini"
    onclick="notAcceptApplication(<?php echo $data['id']; ?>)">
    Not Accept
</button>
<a href="updateApplication.php?id=<?= $data['id'] ?>&return_page=eligibleVIP.php">
    <button class="btn btn-primary btn-mini">
        Update
    </button>
</a>
</div>

                                </div>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- END MAIN CONTENT -->

<!-- Point View Modal -->
<div id="pointViewModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" style="font-size: 24px;">&times;</button>
    <h4 class="modal-title">Point Details</h4>
</div>
<div class="modal-body">
    <table class="table table-bordered " style="font-size: 16px;">
        <tr>
            <td><strong>Day Length Point:</strong></td>
            <td id="dayLengthPoint">-</td>
        </tr>
        <tr>
            <td><strong>Service Length Point:</strong></td>
            <td id="serviceLengthPoint">-</td>
        </tr>
        <tr>
            <td><strong>Level Point:</strong></td>
            <td id="levelPoint">-</td>
        </tr>
        <tr>
            <td><strong>Distance Point:</strong></td>
            <td id="distancePoint">-</td>
        </tr>
        <tr>
            <td><strong>Family Point:</strong></td>
            <td id="familyPoint">-</td>
        </tr>
        <tr>
            <td><strong>Priority:</strong></td>
            <td id="priorityValue">-</td>
        </tr>
        <tr style="background-color: #E0DDDC;">
            <td><strong>Total Point:</strong></td>
            <td><strong id="totalPoint">-</strong></td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<!-- Accept Modal -->
<div id="acceptModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Accept Application</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label><strong>Select Allotted Seat:</strong></label>
        <select id="seatType" class="form-control">
            <option value="">-- Select Seat Type --</option>
            <option value="VIP">VIP</option>
            <option value="General">General</option>
        </select>
    </div>
    <div id="seatWarning" class="alert alert-warning" style="display:none;">
        Please select a seat type.
    </div>
    <div class="form-group">
        <label><strong>Allotted Date:</strong></label>
        <input type="date" id="allottedDate" class="form-control">

    </div>
    <div id="dateWarning" class="alert alert-warning" style="display:none;">
        Please select Allotted Date.
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-success" onclick="confirmAccept()">Accept</button>
</div>
</div>
</div>
</div>

<script>
$(document).ready(function() {

var table = $('#canteenTable').DataTable({
//searching: true,
dom: 'lrtip',
ordering: false,
paging: true,
pageLength: 10,
lengthChange: true
});

// Column-wise filtering
$('#canteenTable thead tr:eq(1) th').each(function(colIndex) {

$('input, select', this).on('keyup change', function() {

    let value = this.value;

    // STATUS COLUMN (index = 9)
    if (colIndex === 12 && value !== '') {
        // Match whole word only (Accepted ≠ Not Accepted)
        table
            .column(colIndex)
            .search('\\b' + value + '\\b', true, false)
            .draw();
    } else {
        table
            .column(colIndex)
            .search(value)
            .draw();
    }
});

});

});




let currentApplicationId = null;
let currentApplicationName = null;

function openPointModal(data) {
// Format numbers to 2 decimal places
document.getElementById('dayLengthPoint').textContent = parseFloat(data.day_length_point).toFixed(2);
document.getElementById('serviceLengthPoint').textContent = parseFloat(data.service_length_point).toFixed(2);
document.getElementById('levelPoint').textContent = parseFloat(data.level_point).toFixed(2);
document.getElementById('distancePoint').textContent = parseFloat(data.distance_point).toFixed(2);
document.getElementById('familyPoint').textContent = parseFloat(data.family_point).toFixed(2);
document.getElementById('priorityValue').textContent = data.priority ? data.priority : 'No';
document.getElementById('totalPoint').textContent = parseFloat(data.total_point).toFixed(2);

$('#pointViewModal').modal('show');
}

function openAcceptModal(appId, appName) {
currentApplicationId = appId;
currentApplicationName = appName;
document.getElementById('seatType').value = '';
document.getElementById('allottedDate').value = '';
document.getElementById('seatWarning').style.display = 'none';
document.getElementById('dateWarning').style.display = 'none';
$('#acceptModal').modal('show');
}

function confirmAccept() {
const seatType = document.getElementById('seatType').value;
const allottedDate = document.getElementById('allottedDate').value;

if (!seatType) {
document.getElementById('seatWarning').style.display = 'block';
return;
}

if (!allottedDate) {
document.getElementById('dateWarning').style.display = 'block';
return;
}

// Send AJAX request to process the acceptance
$.ajax({
type: 'POST',
url: 'process_acceptance.php',
data: {
    application_id: currentApplicationId,
    allotted_seat: seatType,
    allotted_date: allottedDate,
    action: 'accept'
},
success: function(response) {
    try {
        const result = JSON.parse(response);
        if (result.success) {
            alert('Application accepted successfully!');
            location.reload();
        } else {
            alert( result.message);
        }
    } catch (e) {
        alert('Application accepted successfully!');
        location.reload();
    }
},
error: function() {
    alert('Error processing request');
}
});

$('#acceptModal').modal('hide');
}

function notAcceptApplication(appId) {
if (!confirm('Are you sure you want to mark this application as Not Accepted?')) {
return;
}

$.ajax({
type: 'POST',
url: 'process_acceptance.php',
data: {
    application_id: appId,
    action: 'not_accept'
},
success: function(response) {
    // No extra alert
    location.reload(); // or remove row if you prefer
},
error: function() {
    alert('Error processing request');
}
});
}
</script>

<?php include('footer.php'); ?>