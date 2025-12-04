<?php
require 'db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("UPDATE service_requests 
                        SET status = 'rejected' 
                        WHERE request_id = ?");

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: dashboard_admin.php");
?>
