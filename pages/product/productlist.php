<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['series'])) {
        $selected_series = $_POST['series'];
        echo "You selected: " . htmlspecialchars($selected_series);
    } else {
        echo "No series selected.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['series' == 'Arc'])) {
        echo "<img src='" . htmlspecialchars($imageSrc) . "' width='300' alt='Product Image'>";
    }
}
?>
