<?php
include("includes/menu.inc.php");
$count = count($rows);
?>
<!-- index_menu.php: Menu -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="assets/styles_menu.css">
    <link rel="stylesheet" href="assets/styles_nav.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
</head>
<body>
    <?php include("templates/nav.php"); ?>
    <h1> Menu </h1>
    
    <?php for($i=0; $i < $count; $i += 3) { ?>
        <div class="row">
            <?php $end = $i + 3; ?>
            <!--- Col 1 --->
            <?php for($j=$i; $j < $count; $j++) { ?>
                <?php if ($j >= $count) { break; } ?>
                <div class="col">
                    <div class="card">
                        
                        <div class="pizza-name">
                            <h3 class="h3">Pizza Name</h3>
                            <p class="name"> <?php echo $rows[$j]['title']; ?> </p>
                        </div>

                        <div class="pizza-ing">
                            <h3 class="h3">Ingredients</h3>
                            <ul class="ing">
                                <?php $array = explode("," , $rows[$j]['ingredients']); ?>
                                <li> <i class="fas fa-carrot"></i> <?php echo ucfirst($array[0]); ?> </li>
                                <li> <i class="fas fa-cheese"></i> <?php echo ucfirst($array[1]); ?> </li>
                                <li> <i class="fas fa-pepper-hot"></i> <?php echo ucfirst($array[2]); ?> </li>
                            </ul>
                        </div>

                        <div class="view-more">
                            <a class="btn" href="details.php?id=<?php echo $rows[$j]['id']; ?>"> More Details </a>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>
