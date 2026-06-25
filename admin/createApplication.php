<?php include('header.php'); ?>

<div class="main-content">
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Canteen Access Request Form</h3>
            </div>

            <div class="panel-body">
                <form id="addApplication" method="post" action="add_application.php">

                    <!-- ROW 1 -->
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Employee ID <span class="text-danger">*</span></label>
                            <input class="form-control" name="employee_id" id="employee_id" autocomplete="off" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Designation</label>
                            <input class="form-control" name="designation" id="designation" readonly>
                        </div>
                    </div>

                    <!-- ROW 2 -->
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Mobile</label>
                            <input class="form-control" name="phone" id="phone" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Joining Date</label>
                            <input class="form-control" name="joiningdate" id="joiningdate" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Department</label>
                            <input class="form-control" name="department" id="department" readonly>
                        </div>
                    </div>

                    <!-- ROW 3 -->
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Employer Factory</label>
                            <input class="form-control" name="company_name" id="company_name" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Level</label>
                            <input class="form-control" name="level" id="level" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Application Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="application_date"
                                value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>

                    <!-- ROW 4 -->
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Status</label>
                            <input class="form-control" name="status" value="Requested" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="category" id="category">
                                <option value="">Select</option>
                            </select>
                            <input type="hidden" name="canteen_name" id="canteen_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Priority</label>
                            <select class="form-control" name="priority">
                                <option value="">Select</option>
                                <option>Priority-1</option>
                                <option>Priority-2</option>
                                <option>Priority-3</option>
                            </select>
                        </div>


                    </div>

                    <!-- ROW 5 -->
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Living Status</label>
                            <input class="form-control" name="living_status" value="Regular" readonly>
                            <!-- <select class="form-control" name="living_status">
                                <option value="">Select</option>
                                <option>Regular</option>
                                <option>Resign</option>
                                <option>Lefty</option>
                                <option>Inactive</option>
                                <option>Drop Out</option>
                            </select> -->
                        </div>


                        <div class="form-group col-md-4">
                            <label>Location Distance <span class="text-danger">*</span></label>
                            <select class="form-control" name="location_distance">
                                <option value="">Select</option>
                                <option>More than 1km</option>
                                <option>Less than 1km</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Live with Family <span class="text-danger">*</span></label>
                            <select class="form-control" name="live_with_family">
                                <option value="">Select</option>
                                <option>Yes</option>
                                <option>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Remarks</label>
                            <textarea class="form-control" name="remarks" rows="1"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-6">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const empInput = document.getElementById('employee_id');
    const form = document.getElementById('addApplication');


    // Stop ENTER submit
    form.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });

    // Load categories on page load
    function loadCategories() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_categories.php', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                let res = JSON.parse(xhr.responseText);
                if (res.success) {
                    const categorySelect = document.getElementById('category');
                    // Clear existing options except the first one
                    while (categorySelect.options.length > 1) {
                        categorySelect.remove(1);
                    }
                    // Add new options
                    res.data.forEach(function(category) {
                        const option = document.createElement('option');
                        option.value = category.code;
                        option.textContent = category.code;
                        option.dataset.name = category.name;
                        categorySelect.appendChild(option);
                    });
                }
            }
        };
        xhr.send();
    }

    function fetchEmployee(empId) {
        if (empId === '') return;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetch_employee.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                let res = JSON.parse(xhr.responseText);
                if (res.success) {
                    document.getElementById('name').value = res.data.name;
                    document.getElementById('designation').value = res.data.designation;
                    document.getElementById('phone').value = res.data.phone;
                    document.getElementById('joiningdate').value = res.data.joiningdate;
                    document.getElementById('department').value = res.data.department;
                    document.getElementById('company_name').value = res.data.company_name;
                    document.getElementById('level').value = res.data.level;
                } else {
                    alert('Employee not found');
                }
            }
        };
        xhr.send('employee_id=' + encodeURIComponent(empId));
    }

    empInput.addEventListener('blur', () => fetchEmployee(empInput.value.trim()));
    empInput.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') {
            fetchEmployee(empInput.value.trim());
        }
    });

    // Update hidden canteen_name field when category selection changes
    const categorySelect = document.getElementById('category');
    categorySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const canteenName = selectedOption.dataset.name || '';
        document.getElementById('canteen_name').value = canteenName;
    });

    // Load categories when page loads
    document.addEventListener('DOMContentLoaded', loadCategories);
</script>

<?php include('footer.php'); ?>