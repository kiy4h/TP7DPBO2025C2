<h3>Adoptions List</h3>

<?php
    $adoptions_list = $adoption->getAllAdoptions();
    if (isset($_GET['search']) && isset($_GET['keyword']) && ! empty($_GET['keyword'])) {
        $adoptions_list = $adoption->searchAdoptions($_GET['keyword']);
        echo "<p>Search results for: \"" . htmlspecialchars($_GET['keyword']) . "\"</p>";
    }

    if (! empty($adoptions_list)):
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Pet</th>
        <th>Adopter</th>
        <th>Adoption Date</th>
        <th>Notes</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($adoptions_list as $a): ?>
    <tr>
        <td><?php echo $a['id'] ?></td>
        <td><?php echo htmlspecialchars($a['pet_name']) ?></td>
        <td><?php echo htmlspecialchars($a['adopter_name']) ?></td>
        <td><?php echo $a['adoption_date'] ?></td>
        <td><?php echo htmlspecialchars($a['notes'] ?? '') ?></td>
        <td>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="action" value="delete_adoption">
                <input type="hidden" name="id" value="<?php echo $a['id'] ?>">
                <button type="submit" onclick="return confirm('Are you sure you want to delete this adoption record? The pet will be marked as available again.')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p><i>No items.</i></p>
<?php endif; ?>

<h3>Create New Adoption</h3>
<form method="POST">
    <input type="hidden" name="adopt" value="1">
    <div>
        <label>Pet:</label>
        <select name="pet_id" required>
            <?php foreach ($pet->getAvailablePets() as $p): ?>
                <option value="<?php echo $p['id'] ?>"><?php echo htmlspecialchars($p['name']) ?> (<?php echo htmlspecialchars($p['species']) ?> -<?php echo htmlspecialchars($p['breed']) ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label>Adopter:</label>
        <select name="adopter_id" required>
            <?php foreach ($adopter->getAllAdopters() as $a): ?>
                <option value="<?php echo $a['id'] ?>"><?php echo htmlspecialchars($a['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label>Notes:</label>
        <textarea name="notes"></textarea>
    </div>
    <button type="submit">Create Adoption</button>
</form>