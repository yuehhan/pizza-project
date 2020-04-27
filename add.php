<?php 
    // since we referenced this file in our GET request form, we need some
    // PHP here to check if there is data has been sent
    //$_GET is a global array in PHP, it is an associative array
    // if(isset($_GET['submit'])){
    //     echo $_GET['email'];
    //     echo $_GET['title'];
    //     echo $_GET['ingredients'];
    // }
    // htmlspecialchars method will prevent XSS attacks: https://www.w3schools.com/php/func_string_htmlspecialchars.asp
    include('config/db_connect.php');
    $email = '';
    $errors = array('email'=>'', 'title'=>'', 'ingredients'=>'');
    if(isset($_POST['submit'])){
        // check email
        if(empty($_POST['email'])){
            $errors['email'] =  'An email is required <br />';
        }else{
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'email must be a valid email address';
            }
        }
        // check title
        if(empty($_POST['title'])){
            $errors['title'] = 'A title is required <br />'; 
        }

        // check ingredient
        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = 'An ingredient is required <br />';
        }

        // check for errors with array_filter: https://www.w3schools.com/php/func_array_filter.asp
        if(array_filter($errors)){
            // echo 'There are errors in the form';
        }else{
            // protect from sql injection
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

            // create sql
            $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";
            // save to db and check
            if(mysqli_query($conn, $sql)){
                // success
                header('Location: index.php');
            }else{
                // error
                echo 'query error ' . mysqli_error($conn); 
            }
            
        }
    }
?>
<!DOCTYPE html>
<html>

<?php include('templates/header.php') ?>

<section class="container grey-text">
    <h4 class="center">Add Pizza</h4>
    <form action="add.php" method="POST" class="white">

        <label>Your Email:</label>
        <input type="text" name="email" value="<?php echo $email; ?>">
        <div class="red-text"><?php echo $errors['email']; ?></div>

        <label>Pizza Title:</label>
        <input type="text" name="title">
        <div class="red-text"><?php echo $errors['title']; ?></div>

        <label>Ingredients (comma separated):</label>
        <input type="text" name="ingredients">
        <div class="red-text"><?php echo $errors['ingredients']; ?></div>

        <div class="center">
            <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include('templates/footer.php') ?>


</html>