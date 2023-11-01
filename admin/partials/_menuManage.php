<?php
include '_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['createItem'])) {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $tokoId = $_POST["tokoId"];
        $price = $_POST["price"];

        $sql = "INSERT INTO `menu` (`menuName`, `menuPrice`, `menuDesc`, `menuTokoId`, `menuPubDate`) VALUES ('$name', '$price', '$description', '$tokoId', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $menuId = $conn->insert_id;
        if ($result) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {

                $newName = 'menu-' . $menuId;
                $newfilename = $newName . ".jpg";

                $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/e-commerce/img/';
                $uploadfile = $uploaddir . $newfilename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
                    echo "<script>alert('success');
                            window.location=document.referrer;
                        </script>";
                } else {
                    echo "<script>alert('failed');
                            window.location=document.referrer;
                        </script>";
                }
            } else {
                echo '<script>alert("Please select an image file to upload.");
                        window.location=document.referrer;
                    </script>';
            }
        } else {
            echo "<script>alert('failed');
                    window.location=document.referrer;
                </script>";
        }
    }
    if (isset($_POST['removeItem'])) {
        $menuId = $_POST["menuId"];
        $sql = "DELETE FROM `menu` WHERE `menuId`='$menuId'";
        $result = mysqli_query($conn, $sql);
        $filename = $_SERVER['DOCUMENT_ROOT'] . "/e-commerce/img/menu-" . $menuId . ".jpg";
        if ($result) {
            if (file_exists($filename)) {
                unlink($filename);
            }
            echo "<script>alert('Removed');
                window.location=document.referrer;
            </script>";
        } else {
            echo "<script>alert('failed');
            window.location=document.referrer;
            </script>";
        }
    }
    if (isset($_POST['updateItem'])) {
        $menuId = $_POST["menuId"];
        $menuName = $_POST["name"];
        $menuDesc = $_POST["desc"];
        $menuPrice = $_POST["price"];
        $menuTokoId = $_POST["catId"];

        $sql = "UPDATE `menu` SET `menuName`='$menuName', `menuPrice`='$menuPrice', `menuDesc`='$menuDesc', `menuTokoId`='$menuTokoId' WHERE `menuId`='$menuId'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script>alert('update');
                window.location=document.referrer;
                </script>";
        } else {
            echo "<script>alert('failed');
                window.location=document.referrer;
                </script>";
        }
    }
    if (isset($_POST['updateItemPhoto'])) {
        $menuId = $_POST["menuId"];
        $check = getimagesize($_FILES["itemimage"]["tmp_name"]);
        if ($check !== false) {
            $newName = 'menu-' . $menuId;
            $newfilename = $newName . ".jpg";

            $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/e-commerce/img/';
            $uploadfile = $uploaddir . $newfilename;

            if (move_uploaded_file($_FILES['itemimage']['tmp_name'], $uploadfile)) {
                echo "<script>alert('success');
                        window.location=document.referrer;
                    </script>";
            } else {
                echo "<script>alert('failed');
                        window.location=document.referrer;
                    </script>";
            }
        } else {
            echo '<script>alert("Please select an image file to upload.");
            window.location=document.referrer;
                </script>';
        }
    }
}
