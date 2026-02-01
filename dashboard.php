<?php
include "config/auth.php";
include "config/db.php";

$sql = "SELECT f.id, f.name, f.price, c.name AS category
        FROM food_items f
        JOIN categories c ON f.category_id = c.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Food Dashboard</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>

<h2>Food Menu</h2>
<input type="text" id="search" placeholder="Search food...">
<?php
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='8'>
            <tr>
                <th>Food</th>
                <th>Category</th>
                <th>Price (TZS)</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['category']}</td>
                <td>" . number_format($row['price'], 0) . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No products found";
}
?>
<script>
document.getElementById('search').addEventListener('keyup', function() {
    var filter = this.value.toLowerCase();
    var rows = document.querySelectorAll('table tr');

    rows.forEach(function(row, index) {
        if (index === 0) return; // skip header row
        var foodName = row.cells[0].textContent.toLowerCase();
        row.style.display = foodName.includes(filter) ? '' : 'none';
    });
});
</script>
</body>
</html>