<?php

function log_action($conn, $user_id, $action_type, $description,$usertype) {
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action_type, description,user_type) VALUES (?, ?, ?,?)");
    $stmt->bind_param("isss", $user_id, $action_type, $description,$usertype);
    $stmt->execute();
}
?>
