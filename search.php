<?php
include('config/db_connect.php');

// Essential Variables
$search = "";
$selected_rows = [];
$count = 0;
$found = "";
$recent = "";

// Get Request
if (isset($_GET['val'])) {
    $search = $_GET['val'];

    // Fetch all rows from DB
    $stmt = $conn->prepare("SELECT * FROM pizza WHERE LOWER(title) LIKE ?");
    $stmt->bind_param("s", $searchParam);
    $searchParam = '%' . $search . '%';
    $stmt->execute();
    $result = $stmt->get_result();
    $selected_rows = $result->fetch_all(MYSQLI_ASSOC);
}

$count = count($selected_rows);
$found = ($count > 0) ? "True" : "False";

// Search is submitted
if (isset($_POST['search'])) {
    // Make sure the input field is not empty
    if (!empty($_POST['search-q-valid'])) {
        // Non-empty ---> search in DB
        // Normalize the string (lowercase or uppercase)
        $search = htmlspecialchars(strtolower($_POST['search-q']));
        // Store a cookie of that search value in the user's machine
        setcookie("search_val", $search, time() + 86400);
        // Fetch all rows from DB
        $stmt = $conn->prepare("SELECT * FROM pizza WHERE LOWER(title) LIKE ?");
        $stmt->bind_param("s", $searchParam);
        $searchParam = '%' . $search . '%';
        $stmt->execute();
        $result = $stmt->get_result();
        $selected_rows = $result->fetch_all(MYSQLI_ASSOC);
    }

    $count = count($selected_rows);
    $found = ($count > 0) ? "True" : "False";
}

$recent = $_COOKIE['search_val'] ?? ""; // Null coalescing operator
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="assets/styles_menu.css">
<link rel="stylesheet" href="assets/styles_nav.css">
<link rel="stylesheet" href="assets/styles_search.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">

<body>
<?php include('templates/nav.php') ?>

<h1> Search a Pizza </h1>

<h1> Recent: <a href="search.php?val=<?php echo $recent ?>"> <?php echo $recent ?> </a> </h1>

<form id="validate" class="" action="search.php?val=<?php echo $recent ?>" method="POST">
    <input class="" name="search-q" value="" placeholder="Enter some keywords..">
    <div class="danger"> <p></p></div>
    <input type="hidden" name="search-q-valid" value="">
    <input type="submit" name="search" value="Search">
</form>

<?php if ($found === "True") { ?>

    <!-- Card System -->
    <?php for ($i = 0; $i < $count; $i += 3) { ?>
        <div class="row">
            <?php $end = $i + 3; ?>
            <!-- Col 1 -->
            <?php for ($j = $i; $j < $count; $j++) { ?>
                <?php if ($j >= $count) {
                    break;
                } ?>
                <div class="col">
                    <div class="card">
                        <div class="pizza-name">
                            <h3 class="h3">Pizza Name</h3>
                            <p class="name"> <?php echo $selected_rows[$j]['title']; ?> </p>
                        </div>
                        <div class="pizza-ing">
                            <h3 class="h3">Ingredients</h3>
                            <ul class="ing">
                                <?php $array = explode(",", $selected_rows[$j]['ingredients']); ?>
                                <li> <i class="fas fa-carrot"></i> <?php echo ucfirst($array[0]); ?> </li>
                                <li> <i class="fas fa-cheese"></i> <?php echo ucfirst($array[1]); ?> </li>
                                <li> <i class="fas fa-pepper-hot"></i> <?php echo ucfirst($array[2]); ?> </li>
                            </ul>
                        </div>
                        <div class="view-more">
                            <a class="btn" href="details.php?id=<?php echo $selected_rows[$j]['id']; ?>"> More Details </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

<?php } else if ($found === "False") { ?>
    <h2>No Results Found</h2>
<?php } ?>

<script type="text/javascript" src="js/formValidationSearch.js"> </script>
</body>
</html>
