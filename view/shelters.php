<h3>Shelters List</h3>

<?php
    $shelters_list = $shelter->getAllShelters();
    if (isset($_GET['search']) && isset($_GET['keyword']) && ! empty($_GET['keyword'])) {
        $shelters_list = $shelter->searchShelters($_GET['keyword']);
        echo "<p>Search results for: \"" . htmlspecialchars($_GET['keyword']) . "\"</p>";
    }
    if (! empty($shelters_list)):
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($shelters_list as $s): ?>
    <tr>
        <td><?php echo $s['id'] ?></td>
        <td><?php echo htmlspecialchars($s['name']) ?></td>
        <td><?php echo htmlspecialchars($s['address']) ?></td>
        <td><?php echo htmlspecialchars($s['phone']) ?></td>
        <td><?php echo htmlspecialchars($s['email']) ?></td>
        <td>
            <button onclick="document.getElementById('edit-shelter-<?php echo $s['id'] ?>').style.display='block'">Edit</button>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="action" value="delete_shelter">
                <input type="hidden" name="id" value="<?php echo $s['id'] ?>">
                <button type="submit" onclick="return confirm('Are you sure you want to delete this shelter?')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p><i>No items.</i></p>
<?php endif; ?>

<h3>Add New Shelter</h3>
<form method="POST">
    <input type="hidden" name="action" value="add_shelter">
    <div>
        <label>Name:</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Address:</label>
        <input type="text" name="address" required>
    </div>
    <div>
        <label>Phone:</label>
        <input type="text" name="phone" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <button type="submit">Add Shelter</button>
</form>

<!-- Edit Shelter Modal Forms -->
<?php foreach ($shelter->getAllShelters() as $s): ?>
<div id="edit-shelter-<?php echo $s['id'] ?>" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc;">
    <h3>Edit Shelter</h3>
    <form method="POST">
        <input type="hidden" name="action" value="update_shelter">
        <input type="hidden" name="id" value="<?php echo $s['id'] ?>">
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($s['name']) ?>" required>
        </div>
        <div>
            <label>Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($s['address']) ?>" required>
        </div>
        <div>
            <label>Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($s['phone']) ?>" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($s['email']) ?>" required>
        </div>
        <button type="submit">Update Shelter</button>
        <button type="button" onclick="document.getElementById('edit-shelter-<?php echo $s['id'] ?>').style.display='none'">Cancel</button>
    </form>
</div>
<?php endforeach; ?>