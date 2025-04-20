<h3>Pets List</h3>

<?php
    $pets_list = $pet->getAllPets();
    $isSearch  = false;

    if (isset($_GET['search']) && isset($_GET['keyword']) && ! empty($_GET['keyword'])) {
        $isSearch  = true;
        $pets_list = $pet->searchPets($_GET['keyword']);
        echo "<p>Search results for: \"" . htmlspecialchars($_GET['keyword']) . "\"</p>";
    }

    if (! empty($pets_list)):
?>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Species</th>
        <th>Breed</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Status</th>
        <th>Shelter</th>
        <th>Actions</th>
    </tr>
    <?php
        $pets_to_display = isset($search_results) ? $search_results : $pet->getAllPets();
        foreach ($pets_to_display as $p):
    ?>
    <tr>
        <td><?php echo $p['id'] ?></td>
        <td><?php echo htmlspecialchars($p['name']) ?></td>
        <td><?php echo htmlspecialchars($p['species']) ?></td>
        <td><?php echo htmlspecialchars($p['breed']) ?></td>
        <td><?php echo $p['age'] ?></td>
        <td><?php echo $p['gender'] ?></td>
        <td><?php echo $p['adoption_status'] ?></td>
        <td><?php echo htmlspecialchars($p['shelter_name']) ?></td>
        <td>
            <button onclick="document.getElementById('edit-pet-<?php echo $p['id'] ?>').style.display='block'">Edit</button>
            <form method="POST" style="display: inline;">
                <input type="hidden" name="action" value="delete_pet">
                <input type="hidden" name="id" value="<?php echo $p['id'] ?>">
                <button type="submit" onclick="return confirm('Are you sure you want to delete this pet?')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p><i>No items.</i></p>
<?php endif; ?>


<h3>Add New Pet</h3>
<form method="POST">
    <input type="hidden" name="action" value="add_pet">
    <div>
        <label>Name:</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Species:</label>
        <input type="text" name="species" required>
    </div>
    <div>
        <label>Breed:</label>
        <input type="text" name="breed">
    </div>
    <div>
        <label>Age:</label>
        <input type="number" name="age" required min="0">
    </div>
    <div>
        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>
    <div>
        <label>Description:</label>
        <textarea name="description"></textarea>
    </div>
    <div>
        <label>Shelter:</label>
        <select name="shelter_id" required>
            <?php foreach ($shelter->getAllShelters() as $s): ?>
                <option value="<?php echo $s['id'] ?>"><?php echo htmlspecialchars($s['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit">Add Pet</button>
</form>

<!-- Edit Pet Modal Forms -->
<?php foreach ($pet->getAllPets() as $p): ?>
<div id="edit-pet-<?php echo $p['id'] ?>" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc;">
    <h3>Edit Pet</h3>
    <form method="POST">
        <input type="hidden" name="action" value="update_pet">
        <input type="hidden" name="id" value="<?php echo $p['id'] ?>">
        <div>
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($p['name']) ?>" required>
        </div>
        <div>
            <label>Species:</label>
            <input type="text" name="species" value="<?php echo htmlspecialchars($p['species']) ?>" required>
        </div>
        <div>
            <label>Breed:</label>
            <input type="text" name="breed" value="<?php echo htmlspecialchars($p['breed']) ?>">
        </div>
        <div>
            <label>Age:</label>
            <input type="number" name="age" value="<?php echo $p['age'] ?>" required min="0">
        </div>
        <div>
            <label>Gender:</label>
            <select name="gender" required>
                <option value="Male"                                     <?php echo $p['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female"                                       <?php echo $p['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description"><?php echo htmlspecialchars($p['description'] ?? '') ?></textarea>
        </div>
        <div>
            <label>Shelter:</label>
            <select name="shelter_id" required>
                <?php foreach ($shelter->getAllShelters() as $s): ?>
                    <option value="<?php echo $s['id'] ?>"<?php echo $p['shelter_id'] == $s['id'] ? 'selected' : '' ?>><?php echo htmlspecialchars($s['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Status:</label>
            <select name="adoption_status" required>
                <option value="Available"                                          <?php echo $p['adoption_status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                <option value="Pending"                                        <?php echo $p['adoption_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Adopted"                                        <?php echo $p['adoption_status'] == 'Adopted' ? 'selected' : '' ?>>Adopted</option>
            </select>
        </div>
        <button type="submit">Update Pet</button>
        <button type="button" onclick="document.getElementById('edit-pet-<?php echo $p['id'] ?>').style.display='none'">Cancel</button>
    </form>
</div>
<?php endforeach; ?>