<?php

include 'config.php';

$message = array(); 

if(isset($_POST['add_product'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image_name = $_FILES['product_image']['name']; 
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image_name;

    if(empty($product_name) || empty($product_price) || empty($product_image_name)) { 
        $message[] = 'Please fill up all fields'; 
    } else {
        
        $check_query = "SELECT COUNT(*) FROM products WHERE name = ";
        $stmt_check = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt_check, "s", $product_name);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $count);
        mysqli_stmt_fetch($stmt_check);
        mysqli_stmt_close($stmt_check);

        if ($count > 0) {
            $message[] = 'Product already exists';
        } else {
            $insert = "INSERT INTO products(name, price, image) VALUES(, , ,)";
            $stmt = mysqli_prepare($conn, $insert);

            mysqli_stmt_bind_param($stmt, "sss", $product_name, $product_price, $product_image_name);

            $upload = mysqli_stmt_execute($stmt);

            if($upload) {
                move_uploaded_file($product_image_tmp_name, $product_image_folder);
                $message[] = 'New product added successfully';
            } else {
                $message[] = 'Could not add the product';
            }

            mysqli_stmt_close($stmt);
        }
    }
}

foreach($message as $msg) {
    echo $msg . "<br>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>
    <link rel="stylesheet" href="style.css">

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<div class="container">
    <div class="admin-product-font-container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <h3>Add a new product</h3>
            <input type="text" placeholder="Enter product name" name="product_name" class="box">
            <input type="number" placeholder="Enter product price" name="product_price" class="box">
            <input type="file" accept="image/png, image/jpeg, image/jpeg" name="product_image" class="box">
            <input type="submit" class="btn" name="add_product" value="Add Product">
        </form>
    </div>
</div>
    
</body>
</html>

    
<?php

    $select = mysqli_query($conn, "SELECT * FROM products");

?>

<div class="product-dispay">
    <table class="product-display-table">

    <thead>
        <tr>
            <td>product image</td>
            <td>product name</td>
            <td>product price</td>
            <td>action</td>
        </tr>
    </thead>

    </table>



</div>

</div>
    
</body>
</html>
