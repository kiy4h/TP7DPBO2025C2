<?php
    require_once 'class/Pet.php';
    require_once 'class/Adopter.php';
    require_once 'class/Shelter.php';
    require_once 'class/Adoption.php';

    // initialize classes
    $pet      = new Pet();
    $adopter  = new Adopter();
    $shelter  = new Shelter();
    $adoption = new Adoption();

    // process adoption
    if (isset($_POST['adopt'])) {
        $adoption->adoptPet($_POST['pet_id'], $_POST['adopter_id'], $_POST['notes'] ?? '');
        header("Location: ?page=adoptions");
        exit;
    }

    // process pet search
    $search_results = null;
    if (isset($_GET['search']) && ! empty($_GET['keyword'])) {
        $search_results = $pet->searchPets($_GET['keyword']);
    }

    // process CRUD operations
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            // pet CRUD
            case 'add_pet':
                $pet->addPet($_POST['name'], $_POST['species'], $_POST['breed'], $_POST['age'],
                    $_POST['gender'], $_POST['description'], $_POST['shelter_id']);
                header("Location: ?page=pets");
                exit;
            case 'update_pet':
                $pet->updatePet($_POST['id'], $_POST['name'], $_POST['species'], $_POST['breed'],
                    $_POST['age'], $_POST['gender'], $_POST['description'],
                    $_POST['shelter_id'], $_POST['adoption_status']);
                header("Location: ?page=pets");
                exit;
            case 'delete_pet':
                $pet->deletePet($_POST['id']);
                header("Location: ?page=pets");
                exit;

            // adopter CRUD
            case 'add_adopter':
                $adopter->addAdopter($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address']);
                header("Location: ?page=adopters");
                exit;
            case 'update_adopter':
                $adopter->updateAdopter($_POST['id'], $_POST['name'], $_POST['email'],
                    $_POST['phone'], $_POST['address']);
                header("Location: ?page=adopters");
                exit;
            case 'delete_adopter':
                $adopter->deleteAdopter($_POST['id']);
                header("Location: ?page=adopters");
                exit;

            // shelter CRUD
            case 'add_shelter':
                $shelter->addShelter($_POST['name'], $_POST['address'], $_POST['phone'], $_POST['email']);
                header("Location: ?page=shelters");
                exit;
            case 'update_shelter':
                $shelter->updateShelter($_POST['id'], $_POST['name'], $_POST['address'],
                    $_POST['phone'], $_POST['email']);
                header("Location: ?page=shelters");
                exit;
            case 'delete_shelter':
                $shelter->deleteShelter($_POST['id']);
                header("Location: ?page=shelters");
                exit;

            // adoption CRUD
            case 'delete_adoption':
                $adoption->deleteAdoption($_POST['id']);
                header("Location: ?page=adoptions");
                exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Adoption System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'view/header.php'; ?>
    <main>
        <!-- search form -->
        <div class="search-container">
            <form method="GET" action="">
                <input type="hidden" name="page" value="<?php echo $_GET['page'] ?? 'pets' ?>">
                <input type="text" name="keyword" placeholder="Search items..." value="<?php echo $_GET['keyword'] ?? '' ?>">
                <button type="submit" name="search">Search</button>
            </form>
        </div>

        <nav>
            <a href="?page=pets">Pets 💝</a> |
            <a href="?page=adopters">Adopters 👤</a> |
            <a href="?page=shelters">Shelters 🏘️</a> |
            <a href="?page=adoptions">Adoptions 📃</a>
        </nav>

        <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ($page == 'pets') include 'view/pets.php';
                elseif ($page == 'adopters') include 'view/adopters.php';
                elseif ($page == 'shelters') include 'view/shelters.php';
                elseif ($page == 'adoptions') include 'view/adoptions.php';
            } else {
                include 'view/pets.php';
            }
        ?>
    </main>
    <?php include 'view/footer.php'; ?>
</body>
</html>