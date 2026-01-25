<?php
require '../db.php';
require 'admin-auth.php';

// Fetch pending taskers
$query = "SELECT id, fullname, skills, category, experience_years, id_proof_path, professional_cert_path 
          FROM taskers 
          WHERE registration_status = 'pending'";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Taskers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .reject-box {
            display: none;
            margin-top: 10px;
        }
    </style>
    <script>
        function toggleRejectBox(taskerId) {
            const box = document.getElementById('reject-box-' + taskerId);
            if (box.style.display === 'block') {
                box.style.display = 'none';
            } else {
                box.style.display = 'block';
            }
        }
    </script>
</head>
<body class="p-4">

<h2>Pending Tasker Applications</h2>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Skills</th>
            <th>Category</th>
            <th>Experience</th>
            <th>ID Proof</th>
            <th>Certificate</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['fullname']) ?></td>
            <td><?= htmlspecialchars($row['skills']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td><?= (int)$row['experience_years'] ?> yrs</td>

            <td>
                <a href="../<?= htmlspecialchars($row['id_proof_path']) ?>" target="_blank">View</a>
            </td>

            <td>
                <?php if ($row['professional_cert_path']) { ?>
                    <a href="../<?= htmlspecialchars($row['professional_cert_path']) ?>" target="_blank">View</a>
                <?php } else { ?>
                    N/A
                <?php } ?>
            </td>

            <td>
                <a href="approve-tasker.php?id=<?= $row['id'] ?>&action=approve" class="btn btn-success btn-sm">Approve</a>
                
                <button type="button"
                        class="btn btn-danger btn-sm"
                        onclick="toggleRejectBox(<?= $row['id'] ?>)">
                    Reject
                </button>

                <!-- Reject box -->
                <div id="reject-box-<?= $row['id'] ?>" class="reject-box">
                    <form action="reject-tasker.php" method="POST" onsubmit="return confirm('Are you sure you want to reject?');">
                        <input type="hidden" name="tasker_id" value="<?= $row['id'] ?>">
                        <div class="mb-2">
                            <textarea name="reject_reason" class="form-control" rows="3" placeholder="Write rejection reason..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm">Confirm Reject</button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleRejectBox(<?= $row['id'] ?>)">Cancel</button>
                    </form>
                </div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>
