<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <title id="title">Toko</title>
    <link rel="icon" href="img/logo.jpg" type="image/x-icon">
    <style>
        .jumbotron {
            padding: 2rem 1rem;
        }

        #cont {
            min-height: 570px;
        }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php require 'partials/_nav.php' ?>

    <div>&nbsp;
        <a href="index.php" class="active text-dark">
            <i class="fas fa-qrcode"></i>
            <span>All Toko</span>
        </a>
    </div>

    <?php
    $id = $_GET['catid'];
    $countsql = "SELECT SUM(`itemQuantity`) FROM `viewcart` WHERE `userId`=$userId AND `cartTokoId`=$id";
    $countresult = mysqli_query($conn, $countsql);
    $countrow = mysqli_fetch_assoc($countresult);
    $count = $countrow['SUM(`itemQuantity`)'];
    if (!$count) {
        $count = 0;
    }
    echo '<a href="viewCart.php?catid=' . $id . '"><button type="button" class="btn btn-secondary mx-2" title="MyCart">
          <svg xmlns="img/cart.svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
          </svg>  
          <i class="bi bi-cart">Cart(' . $count . ')</i>
        </button></a>';  ?>

    <?php
    $sql = "SELECT * FROM `toko` WHERE tokoId = $id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $catname = $row['tokoName'];
        $catdesc = $row['tokoDesc'];
    }
    ?>

    <!-- menu container starts here -->
    <div class="container my-3" id="cont">
        <div class="col-lg-4 text-center bg-light my-3" style="margin:auto;border-top: 2px groove black;border-bottom: 2px groove black;">
            <h2 class="text-center"><span id="catTitle">Items</span></h2>
        </div>
        <div class="row">
            <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `menu` WHERE menuTokoId = $id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $menuId = $row['menuId'];
                $menuName = $row['menuName'];
                $menuPrice = $row['menuPrice'];
                $menuDesc = $row['menuDesc'];

                echo '<div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="card" style="width: 18rem;">
                            <img src="img/menu-' . $menuId . '.jpg" class="card-img-top" alt="image for this menu" width="249px" height="270px">
                            <div class="card-body">
                                <h5 class="card-title">' . $menuName . '</h5>
                                <h6 style="color: #ff0000">Rp. ' . $menuPrice . '/-</h6>
                                <p class="card-text">' . substr($menuDesc, 0, 29) . '...</p>   
                                <div class="row justify-content-center">';
                if ($loggedin) {
                    $id = $_GET['catid'];
                    $quaSql = "SELECT `itemQuantity` FROM `viewcart` WHERE menuId = '$menuId' AND `userId`='$userId'";
                    $quaresult = mysqli_query($conn, $quaSql);
                    $quaExistRows = mysqli_num_rows($quaresult);
                    if ($quaExistRows == 0) {
                        echo '<form action="partials/_manageCart.php" method="POST">
                                              <input type="hidden" name="itemId" value="' . $menuId . '">
                                              <input type="hidden" name="cartTokoId" value="' . $id . '">
                                              <button type="submit" name="addToCart" class="btn btn-primary mx-2">Add to Cart</button>';
                    } else {
                        echo '<a href="viewCart.php?catid=' . $id . '"><button class="btn btn-primary mx-2">Go to Cart</button></a>';
                    }
                } else {
                    echo '<button class="btn btn-primary mx-2" data-toggle="modal" data-target="#loginModal">Add to Cart</button>';
                }
                echo '</form>                            
                               
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            if ($noResult) {
                echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <p class="display-4">Sorry In this Toko No items available.</p>
                        <p class="lead"> We will update Soon.</p>
                    </div>
                </div> ';
            }
            ?>
        </div>
    </div>


    <?php require 'partials/_footer.php' ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>
    <script>
        document.getElementById("title").innerHTML = "<?php echo $catname; ?>";
        document.getElementById("catTitle").innerHTML = "<?php echo $catname; ?>";
    </script>
</body>

</html>