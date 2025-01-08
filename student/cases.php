<?php
session_start();
require_once '../Cases.class.php';

// Assuming the logged-in student's ID is stored in the session
$student_id = $_SESSION['account']['user_id'];

$cases = new Cases();
$student_cases = $cases->getByStudent($student_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Cases</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4">Your Cases</h1>
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" onkeyup="searchTable()" placeholder="Search for cases..">
        </div>
        <table id="casesTable" class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Case ID</th>
                    <th>Counselor ID</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($student_cases as $case): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($case['case_id']); ?></td>
                        <td><?php echo htmlspecialchars($case['counselor_id']); ?></td>
                        <td><?php echo htmlspecialchars($case['case_description']); ?></td>
                        <td><?php echo htmlspecialchars($case['case_status']); ?></td>
                        <td><?php echo htmlspecialchars($case['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($case['last_updated']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("casesTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>