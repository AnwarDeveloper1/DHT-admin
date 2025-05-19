<?php
session_start();
include '../database/config.php';

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Generate CSRF token if not exists
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// Handle GET requests (for delete operation)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    handleDeleteAppointment($conn);
}

// Handle POST form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!hash_equals($_SESSION['token'], $_POST['token'] ?? '')) {
        die("CSRF token validation failed");
    }

    if (isset($_POST['addAppointment'])) {
        handleAddAppointment($conn);
    } elseif (isset($_POST['updateAppointment'])) {
        handleUpdateAppointment($conn);
    }
}

// Fetch all appointments with patient and doctor details
$appointments = $conn->query("
    SELECT 
        a.A_id, 
        a.time_slot,
        a.status,
        d.doctor_id,
        d.d_name AS doctor_name,
        p.patient_id,
        p.P_name AS patient_name
    FROM 
        appointment a
    JOIN 
        doctor d ON a.d_id = d.doctor_id
    JOIN
        patient p ON a.p_id = p.patient_id
    ORDER BY 
        a.time_slot DESC
");

// Check for edit mode
$edit = false;
$editData = null;
if (isset($_GET['edit'])) {
    $edit = true;
    $editId = (int)$_GET['edit'];
    $stmt = $conn->prepare("
        SELECT * FROM appointment 
        WHERE A_id = ?
    ");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}

function handleAddAppointment($conn) {
    validateAppointmentData();
    
    $patient_id = (int)$_POST['patient_id'];
    $doctor_id = (int)$_POST['doctor_id'];
    $time_slot = $_POST['time_slot'];
    $status = $_POST['status'] ?? 'Scheduled';

    try {
        $stmt = $conn->prepare("
            INSERT INTO appointment 
            (p_id, d_id, time_slot, status) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("iiss", $patient_id, $doctor_id, $time_slot, $status);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to create appointment: " . $stmt->error);
        }

        $_SESSION['success'] = "Appointment scheduled successfully";
        header("Location: appointment.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: appointment.php");
        exit();
    }
}

function handleUpdateAppointment($conn) {
    validateAppointmentData();
    
    $appointment_id = (int)$_POST['appointment_id'];
    $patient_id = (int)$_POST['patient_id'];
    $doctor_id = (int)$_POST['doctor_id'];
    $time_slot = $_POST['time_slot'];
    $status = $_POST['status'] ?? 'Scheduled';

    try {
        $stmt = $conn->prepare("
            UPDATE appointment 
            SET p_id = ?, d_id = ?, time_slot = ?, status = ?
            WHERE A_id = ?
        ");
        $stmt->bind_param("iissi", $patient_id, $doctor_id, $time_slot, $status, $appointment_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to update appointment: " . $stmt->error);
        }

        $_SESSION['success'] = "Appointment updated successfully";
        header("Location: appointment.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: appointment.php");
        exit();
    }
}

function handleDeleteAppointment($conn) {
    if (!isset($_GET['delete']) || !is_numeric($_GET['delete'])) {
        $_SESSION['error'] = "Invalid appointment ID";
        header("Location: appointment.php");
        exit();
    }

    $appointment_id = (int)$_GET['delete'];
    
    try {
        // First verify the appointment exists
        $check = $conn->prepare("SELECT A_id FROM appointment WHERE A_id = ?");
        $check->bind_param("i", $appointment_id);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows === 0) {
            $_SESSION['error'] = "Appointment not found";
        } else {
            // Now delete the appointment
            $stmt = $conn->prepare("DELETE FROM appointment WHERE A_id = ?");
            $stmt->bind_param("i", $appointment_id);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Appointment deleted successfully";
            } else {
                throw new Exception("Failed to delete appointment: " . $stmt->error);
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
    
    header("Location: appointment.php");
    exit();
}

function validateAppointmentData() {
    $required = ['patient_id', 'doctor_id', 'time_slot'];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $_SESSION['error'] = "Please fill all required fields";
            header("Location: appointment.php");
            exit();
        }
    }
    
    if (!strtotime($_POST['time_slot'])) {
        $_SESSION['error'] = "Invalid time slot format";
        header("Location: appointment.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }
        .status-scheduled { background-color: #fff3cd; }
        .status-completed { background-color: #d1e7dd; }
        .status-cancelled { background-color: #f8d7da; }
    </style>
</head>
<body>
    <div class="container py-4">
        <h2 class="mb-4 text-center text-primary">Appointment Management</h2>

        <!-- Display success/error messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Add/Edit Appointment Form -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <?= $edit ? 'Edit Appointment' : 'Schedule New Appointment' ?>
            </div>
            <div class="card-body">
                <form method="POST" action="appointment.php">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                    
                    <?php if ($edit): ?>
                        <input type="hidden" name="appointment_id" value="<?= $editData['A_id'] ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="patient_id" class="form-label">Patient</label>
                            <select name="patient_id" id="patient_id" class="form-select" required>
                                <option value="">Select Patient</option>
                                <?php
                                $patients = $conn->query("SELECT patient_id, P_name FROM patient");
                                while ($row = $patients->fetch_assoc()):
                                    $selected = ($edit && $editData['p_id'] == $row['patient_id']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $row['patient_id'] ?>" <?= $selected ?>>
                                        <?= htmlspecialchars($row['P_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="doctor_id" class="form-label">Doctor</label>
                            <select name="doctor_id" id="doctor_id" class="form-select" required>
                                <option value="">Select Doctor</option>
                                <?php
                                $doctors = $conn->query("SELECT doctor_id, d_name FROM doctor");
                                while ($row = $doctors->fetch_assoc()):
                                    $selected = ($edit && $editData['d_id'] == $row['doctor_id']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $row['doctor_id'] ?>" <?= $selected ?>>
                                        <?= htmlspecialchars($row['d_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="time_slot" class="form-label">Date & Time</label>
                            <input type="datetime-local" name="time_slot" id="time_slot" 
                                   class="form-control" required
                                   value="<?= $edit ? date('Y-m-d\TH:i', strtotime($editData['time_slot'])) : '' ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="Scheduled" <?= $edit && $editData['status'] == 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
                                <option value="Completed" <?= $edit && $editData['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="Cancelled" <?= $edit && $editData['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <?php if ($edit): ?>
                                <button type="submit" name="updateAppointment" class="btn btn-warning">Update Appointment</button>
                                <a href="appointment.php" class="btn btn-secondary">Cancel</a>
                            <?php else: ?>
                                <button type="submit" name="addAppointment" class="btn btn-success">Schedule Appointment</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">Appointments List</div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $appointments->fetch_assoc()): 
                            $statusClass = 'status-' . strtolower($row['status']);
                        ?>
                            <tr class="<?= $statusClass ?>">
                                <td><?= $row['A_id'] ?></td>
                                <td><?= htmlspecialchars($row['patient_name']) ?></td>
                                <td><?= htmlspecialchars($row['doctor_name']) ?></td>
                                <td><?= date('M j, Y g:i A', strtotime($row['time_slot'])) ?></td>
                                <td><?= $row['status'] ?></td>
                                <td>
                                    <a href="appointment.php?edit=<?= $row['A_id'] ?>" 
                                       class="btn btn-sm btn-primary">Edit</a>
                                    <a href="appointment.php?delete=<?= $row['A_id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>