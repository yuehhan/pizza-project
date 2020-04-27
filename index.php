<?php 
    // MySQLi or PDO to connect to database 
    include('config/db_connect.php');
    // write query for all pizzas
    $sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';
    // make query and get results
    $result = mysqli_query($conn, $sql);
    // fetch the resulting rows as an array, associative array
    $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // good practice to free results from memory
    mysqli_free_result($result);
    // close connection
    mysqli_close($conn);

    

?>
<!DOCTYPE html>
<html>
<head><title>PHP Sandbox</title> </head>

    <?php include('templates/header.php'); ?>

    <h4 class="title">My Favorite Pizzas</h4>

    <div class="container">
        <div class="row">
            <?php foreach($pizzas as $pizza): ?>

                <div class="col s6 md3">
                    <div class="card z-depth-0">
                        <img src="src/img/pizza.png" class="pizza" alt="pizza">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                            <ul>
                                <?php foreach(explode(',', $pizza['ingredients']) as $ing): ?>
                                    <li><?php echo htmlspecialchars($ing); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="card-action" right-align>
                        <a href="details.php?id=<?php echo $pizza['id']?>" class="info">more info</a>
                        </div>
                    </div>
                </div>    

            <?php endforeach; ?>
            
        </div>
    </div>

    <?php include('templates/footer.php'); ?>


</html>