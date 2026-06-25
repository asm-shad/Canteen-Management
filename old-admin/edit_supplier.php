<?php
// Suppress session-related notices
error_reporting(E_ALL & ~E_NOTICE);
// Start session only if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in before accessing session data
if (!isset($_SESSION['user_name'])) {
    // Redirect to login page or show error
    die("Access denied. Please log in.");
}

$username = $_SESSION['user_name'];

require_once('cls_dbconfig.php');
spl_autoload_register(function ($classname) {
    require_once("$classname.class.php");
});

$db = new cls_dbconfig();
$cls_message = new cls_meassage(); // Note: typo in class name 'cls_meassage' should probably be 'cls_message'

// Get supplier ID from URL
if (!isset($_GET['id'])) {
    die("No supplier ID provided.");
}
$id = intval($_GET['id']);

// Fetch existing supplier data
$conn = $db->connection();
// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM supplier WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Supplier not found.");
}
$supplier = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $supplier_code   = htmlspecialchars($_POST['supplier_code'], ENT_QUOTES, 'UTF-8');
    $description     = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $shortDescription = htmlspecialchars($_POST['short_description'], ENT_QUOTES, 'UTF-8');
    $address         = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
    $origin          = htmlspecialchars($_POST['origin'], ENT_QUOTES, 'UTF-8');
    $contact_person  = htmlspecialchars($_POST['contact_person'], ENT_QUOTES, 'UTF-8');
    $contact_no      = htmlspecialchars($_POST['contact_no'], ENT_QUOTES, 'UTF-8');
    $mail            = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');
    $active          = htmlspecialchars($_POST['active'], ENT_QUOTES, 'UTF-8');
    $remarks         = htmlspecialchars($_POST['remarks'], ENT_QUOTES, 'UTF-8');
    $status          = 0;

    // Use a new function update_supplier in cls_message
    echo $cls_message->update_supplier(
        $id,
        $supplier_code,
        $description,
        $shortDescription,
        $address,
        $origin,
        $contact_person,
        $contact_no,
        $mail,
        $active,
        $remarks,
        $status,
        $username
    );

    header("Location: create_supplier.php?success=1");
    exit();
}
include('header.php'); 
?>
<div class="main-content">
    <div class="container-fluid">

        <div class="panel panel-headline">
            <h3 class="panel-title"><a href="create_supplier.php" class="btn btn-defualt btn-sm m-4" style="margin: 10px">Back</a></h3>
            <div class="panel-heading">
                <h3 class="panel-title">Edit Supplier</h3>
            </div>
            <div class="panel-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-3" style="display:none;">
                            <label>Supplier Code</label>
                            <input type="text" class="form-control" name="supplier_code" value="<?php echo htmlspecialchars($supplier['supplier_code']); ?>" readonly>
                        </div>

                        <div class="col-md-3">
                            <label>Supplier Name</label>
                            <input type="text" class="form-control" name="description" value="<?php echo htmlspecialchars($supplier['description']); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label>Short Description</label>
                            <input type="text" class="form-control" name="short_description" value="<?php echo htmlspecialchars($supplier['short_description']); ?>" required>
                        </div>

                        <div class="col-md-3">
                            <label>Origin</label>
                            <input type="text" class="form-control" name="origin" value="<?php echo htmlspecialchars($supplier['origin']); ?>" required>
                        </div>

                        <div class="col-md-3">
                            <label>Contact Person</label>
                            <input type="text" class="form-control" name="contact_person" value="<?php echo htmlspecialchars($supplier['contact_person']); ?>">
                        </div>

                       
                    </div>

                    <div class="row" style="margin-top:10px;">
                         <div class="col-md-3">
                            <label>Contact No</label>
                            <input type="text" class="form-control" name="contact_no" value="<?php echo htmlspecialchars($supplier['contact_no']); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="mail" value="<?php echo htmlspecialchars($supplier['mail']); ?>">
                        </div>

                        <div class="col-md-6">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($supplier['address']); ?>" required>
                        </div>

                        
                    </div>

                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-3">
                            <label>Active</label>
                            <select class="form-control" name="active" required>
                                <option value="Yes" <?php echo $supplier['active'] == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                <option value="No" <?php echo $supplier['active'] == 'No' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                        <div class="col-md-9">
                            <label>Remarks</label>
                            <input type="text" class="form-control" name="remarks" value="<?php echo htmlspecialchars($supplier['remarks']); ?>">
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Update Supplier</button>
                </form>

            </div>
        </div>
    </div>
</div>