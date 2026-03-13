<?php
session_start();
include("config.php");

// ===== LOGIN CHECK =====
if ($_SESSION['dcname'] == '') {
    header("Location: login.php");
    exit;
}

// ===== GET CURRENT DATABASE NAME =====
$result = mysqli_query($con, "SELECT DATABASE()");
$row = mysqli_fetch_row($result);
$dbname = $row[0];

// ===== DB USER & PASS (same as config.php) =====
$db_user = "root";   // change if different
$db_pass = "";       // change if different

// ===== BACKUP FOLDER =====
$backupDir = __DIR__ . "/backup/";

// Create folder if not exists
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// ===== SERVER FILE (OVERWRITE ALWAYS) =====
$serverFile = $backupDir . $dbname . "_backup.sql";

// ===== MYSQLDUMP PATH (XAMPP) =====
$mysqldump = "C:\\xampp\\mysql\\bin\\mysqldump.exe";

// ===== EXPORT COMMAND =====
$command = "\"$mysqldump\" --user=$db_user --password=$db_pass $dbname > \"$serverFile\"";

system($command);

// ===== CHECK FILE EXISTS =====
if (file_exists($serverFile)) {

    // ===== USER DOWNLOAD FILE NAME WITH DATE =====
    $downloadName = $dbname . "_backup_" . date("dmY_Hi") . ".sql";

    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$downloadName");
    header("Content-Length: " . filesize($serverFile));

    readfile($serverFile);
    exit;

} else {
    echo "Backup failed!";
}
?>