<h3>Adopters List</h3>

<?php
    $adopters_list = $adopter->getAllAdopters();
    $isSearch      = false;

    if (isset($_GET['search']) && isset($_GET['keyword']) && ! empty($_GET['keyword'])) {
        $isSearch      = true;
        $adopters_list = $adopter->searchAdopters($_GET['keyword']);
        echo "<p>Search results for: \"" . htmlspecialchars($_GET['keyword']) . "\"</p>";
    }

    if (! empty($adopters_list)):
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($adopters_list as $a): ?>
    <tr>
        <td><?php echo $a['id'] ?></td>
        <td><?php echo htmlspecialchars($a['name']) ?></td>
        <td><?php echo htmlspecialchars($a['email']) ?></td>
        <td><?php echo htmlspecialchars($a['phone']) ?></td>
        <td><?php echo htmlspecialchars($a['address']) ?></td>
        <td>
            <button onclick="document.getElementById('edit-adopter-<?php echo $a['id'] ?>').style.display='block'">Edit</button>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="action" value="delete_adopter">
                <input type="hidden" name="id" value="<?php echo $a['id'] ?>">
                <button type="submit" onclick="return confirm('Are you sure you want to delete this adopter?')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p><i>No items.</i></p>
<?php endif; ?>

<h3>Add New Adopter</h3>
<form method="POST">
    <input type="hidden" name="action" value="add_adopter">
    <div>
        <label>Name:</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label>Phone:</label>
        <input type="text" name="phone" required>
    </div>
    <div>
        <label>Address:</label>
        <input type="text" name="address" required>
    </div>
    <button type="submit">Add Adopter</button>
</form>

<!-- Edit Adopter Modal Forms -->
<?php foreach ($adopter->getAllAdopters() as $a): ?>
<div id="edit-adopter-<?php echo $a['id'] ?>" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc;">
    <h3>Edit Adopter</h3>
    <form method="POST">
        <input type="hidden" name="action" value="update_adopter">
        <input type="hidden" name="id" value="<?php echo $a['id'] ?>">
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($a['name']) ?>" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($a['email']) ?>" required>
        </div>
        <div>
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($a['phone']) ?>" required>
        </div>
        <div>
            <label>Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($a['address']) ?>" required>
        </div>
        <button type="submit">Update Adopter</button>
        <button type="button" onclick="document.getElementById('edit-adopter-<?php echo $a['id'] ?>').style.display='none'">Cancel</button>
    </form>
</div>
<?php endforeach; ?>
