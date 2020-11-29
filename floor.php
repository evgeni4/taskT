<?php
include_once 'database.php';
include_once 'process/floor.php';
$database = new Database();
$db = $database->connect();
$floor = new floor($db);

if (isset($_POST['addFloor'])) {
    $floor->name = $_POST['name'];
    $floor->createFloor();
    echo '<div id="mess" class="alert alert-success" role="alert"><strong>Floor added!</strong></div>';
    header("Refresh:1");
 }
$floor_arr = $floor->allFloor();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blog Template for Bootstrap</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            <a class="p-2 text-muted" href="index.php">home</a>
            <a class="p-2 text-muted" href="floor.php">floor</a>
            <a class="p-2 text-muted" href="cabinet.php">cabinet</a>
            <a class="p-2 text-muted" href="worker.php">worker</a>
            <a class="p-2 text-muted" href="auth.php">dashboard</a>
        </nav>
    </div>
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <form method="post">
                        <label> floor: </label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="name"/>
                        </div>
                        <input type="submit" class="btn btn-primary" name="addFloor" value="add"/> <br/>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <th>ID#</th>
                <th>Floor</th>
                </thead>
                <tbody>
                <?php foreach($floor_arr as $floor):?>
                <tr>
                    <td><?=$floor['id'];?></td>
                    <td><?=$floor['name'];?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    setTimeout(function () {
        $("#mess").fadeOut();
    }, 2000)
</script>
</body>
</html>

