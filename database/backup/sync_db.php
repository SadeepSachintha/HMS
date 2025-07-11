<?php
$host = 'localhost';
$user = 'root';
$pass = '';

$sourceDb = 'hms_0708';
$targetDb = 'hotel_management';

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all tables from source DB
$tablesResult = $conn->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '$sourceDb'");

while ($tableRow = $tablesResult->fetch_assoc()) {
    $table = $tableRow['table_name'];

    // Get column names from the source table
    $columnsResult = $conn->query("SELECT COLUMN_NAME FROM information_schema.columns WHERE table_schema = '$sourceDb' AND table_name = '$table'");
    $columns = [];
    while ($colRow = $columnsResult->fetch_assoc()) {
        $columns[] = "`" . $colRow['COLUMN_NAME'] . "`";
    }

    $columnList = implode(", ", $columns);
    $updateList = implode(", ", array_map(function ($col) {
        return "$col = VALUES($col)";
    }, $columns));

    $sql = "
        INSERT INTO `$targetDb`.`$table` ($columnList)
        SELECT $columnList FROM `$sourceDb`.`$table`
        ON DUPLICATE KEY UPDATE $updateList;
    ";

    echo "Running for table: $table\n";

    if ($conn->query($sql) === TRUE) {
        echo "✔ Table '$table' synced successfully.\n";
    } else {
        echo "✖ Error syncing '$table': " . $conn->error . "\n";
    }
}

$conn->close();
?>

