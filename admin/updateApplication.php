<?php
include('header.php');
require_once('cls_dbconfig.php');

$db = new cls_dbconfig();

$id = $_GET['id'];

$data = $db->connection()->query("
    SELECT *
    FROM canteen_application
    WHERE id='$id'
")->fetch_assoc();
?>

<div class="main-content">
    <div class="container-fluid">

        <div class="panel panel-headline">

            <div class="panel-heading">
                <h3 class="panel-title">
                    Update Canteen Application
                </h3>
            </div>

            <div class="panel-body">

                <form id="updateApplication">

                    <input type="hidden" name="id"
                        value="<?= $data['id'] ?>">

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label>Employee ID</label>

                            <input type="text"
                                class="form-control"
                                name="employee_id"
                                value="<?= $data['employee_id'] ?>"
                                readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Name</label>

                            <input type="text"
                                class="form-control"
                                name="name"
                                value="<?= $data['name'] ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Designation</label>

                            <input type="text"
                                class="form-control"
                                name="designation"
                                value="<?= $data['designations'] ?>">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label>Mobile</label>

                            <input type="text"
                                class="form-control"
                                name="phone"
                                value="<?= $data['mobile'] ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Joining Date</label>

                            <input type="date"
                                class="form-control"
                                name="joiningdate"
                                value="<?= $data['joining_date'] ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Department</label>

                            <input type="text"
                                class="form-control"
                                name="department"
                                value="<?= $data['section_or_department'] ?>">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label>Employer Factory</label>

                            <input type="text"
                                class="form-control"
                                name="company_name"
                                value="<?= $data['employer_factory'] ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Level</label>

                            <input type="text"
                                class="form-control"
                                name="level"
                                value="<?= $data['level'] ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Application Date</label>

                            <input type="date"
                                class="form-control"
                                name="application_date"
                                value="<?= $data['application_date'] ?>">
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label>Category</label>

                            <input type="text"
                                class="form-control"
                                name="category"
                                value="<?= $data['category'] ?>" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Priority</label>

                            <select class="form-control"
                                name="priority">

                                <option value="" <?= empty($data['priority']) ? 'selected' : '' ?>>
                                    Select Priority
                                </option>

                                <option value="Priority-1" <?= $data['priority'] == 'Priority-1' ? 'selected' : '' ?>>
                                    Priority-1
                                </option>

                                <option value="Priority-2" <?= $data['priority'] == 'Priority-2' ? 'selected' : '' ?>>
                                    Priority-2
                                </option>

                                <option value="Priority-3" <?= $data['priority'] == 'Priority-3' ? 'selected' : '' ?>>
                                    Priority-3
                                </option>

                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Location Distance</label>

                            <select class="form-control"
                                name="location_distance">

                                <option <?= $data['location_distance'] == 'More than 1km' ? 'selected' : '' ?>>
                                    More than 1km
                                </option>

                                <option <?= $data['location_distance'] == 'Less than 1km' ? 'selected' : '' ?>>
                                    Less than 1km
                                </option>

                            </select>
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-md-4">
                            <label>Live With Family</label>

                            <select class="form-control"
                                name="live_with_family">

                                <option <?= $data['live_with_family'] == 'Yes' ? 'selected' : '' ?>>
                                    Yes
                                </option>

                                <option <?= $data['live_with_family'] == 'No' ? 'selected' : '' ?>>
                                    No
                                </option>

                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label>Remarks</label>

                            <textarea class="form-control" name="remarks" rows="1"><?= $data['remarks'] ?></textarea>

                        </div>
                       

                    </div>

                    
                    <input type="hidden" name="return_page" value="<?= $_GET['return_page'] ?>">

                    <button type="submit"
                        class="btn btn-primary">
                        Update
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>


<script>
    $('#updateApplication').submit(function(e) {

        e.preventDefault();

        $.ajax({

            type: 'POST',

            url: 'update_application.php',

            data: new FormData(this),

            contentType: false,

            processData: false,

            success: function(res) {

                res = res.trim();

                if (res == 'success') {

                    alert('Application updated successfully');
                    let return_page = $('input[name="return_page"]').val();
                    window.location = return_page;

                } else {

                    alert(res);

                }
            }
        });

    });
</script>

<?php include('footer.php'); ?>