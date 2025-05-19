<?php
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function getDoctors($pdo) {
    $stmt = $pdo->query("SELECT d.*, dept.name as dept_name FROM doctors d 
                         LEFT JOIN departments dept ON d.dept_id = dept.dept_id");
    return $stmt->fetchAll();
}

function getPatients($pdo) {
    $stmt = $pdo->query("SELECT * FROM patients");
    return $stmt->fetchAll();
}

function getDepartments($pdo) {
    $stmt = $pdo->query("SELECT * FROM departments");
    return $stmt->fetchAll();
}

function getAppointments($pdo) {
    $stmt = $pdo->query("SELECT a.*, p.name as patient_name, d.name as doctor_name 
                         FROM appointments a
                         JOIN patients p ON a.patient_id = p.patient_id
                         JOIN doctors d ON a.doctor_id = d.doctor_id");
    return $stmt->fetchAll();
}
?>