<?php
include_once 'Database.php';
include_once 'process/process.php';
$database = new database();
$db = $database->connect();
$auth = new process($db);

if (isset($_POST['register'])) {
    $auth->email = $_POST['email'];
    $auth->checkEmail();
    $authCheck = $auth->email;
    $error = validate($authCheck);
    if (empty($error)) {
        $auth->email = $_POST['email'];
        $auth->password = $_POST['password'];
        $auth->create();
        echo '<div id="mess" class="alert alert-success" role="alert"><strong>Регистрация успешно завершина!</strong></div>';
    }
}
/**
 * @param $authCheck
 * @return array
 */
function validate($authCheck): array
{
    try {
        $error = [];
        if (empty($_POST['email'])) {
            throw new Exception ('Введите email!');
        }
        if ($_POST['password'] !== $_POST['password2']) {
            throw new Exception ('Пароли не совпадают!');
        }
        if (empty($_POST['password'])) {
            throw new Exception ('Введите пароль!');
        }
        $validatePassword = preg_match("/^(?=.*[a-z])(?=.*\d)[a-zA-Z\d]{8,}$/", $_POST['password']);
        if (!$validatePassword) {
            throw new Exception ('Пароль (8 символов), должен содержать буквы (латинские) и цифры!');
        }
        $validateEmail = preg_match("/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $_POST['email']);
        if (!$validateEmail) {
            throw new Exception ('Email не валиден!');
        }
        if ($_POST['email'] === $authCheck) {
            throw new Exception ('Email уже зарегистрирован!');
        }
    } catch (Exception $e) {
        $error [] = $e->getMessage();
    }
    return $error;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
    <title>Blog Template for Bootstrap</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/blog/">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
            <div class="card flex-md-row mb-6 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <div class="warpper">
                        <input class="radio" id="one" name="group" type="radio">
                        <input class="radio" id="two" name="group" type="radio" checked>
                        <input class="radio" id="three" name="group" type="radio">
                        <div class="tabs">
                            <label class="tab" id="one-tab" for="one">Авторизация</label>
                            <label class="tab" id="two-tab" for="two">Регистрация</label>
                        </div>
                        <div class="panels">
                            <div class="panel" id="one-panel">
                                <form method="post">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="email" class="form-control"
                                               value="<?= isset($_POST['email']) ? $_POST['email'] : null ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Пароль: </label>
                                        <input type="password" class="form-control" name="password" value=""/>
                                    </div>
                                    <label>
                                        <input type="submit" class="btn btn-primary" name="login" value="Войти"/>
                                    </label>
                                </form>
                            </div>
                            <div class="panel" id="two-panel">
                                <?php if (!empty($error)): ?>
                                    <?php foreach ($error as $err): ?>
                                        <div class="alert alert-danger" role="alert"> <?= $err ?>  </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <form method="post" action="">
                                    <label> Email: </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="email"/>
                                    </div>
                                    <div class="form-group">
                                        <label> Пароль:</label>
                                        <input type="password" class="form-control" name="password"/>
                                    </div>
                                    <div class="form-group">
                                        <label> Подтвердить пароль:</label>
                                        <input type="password" class="form-control" name="password2"/>
                                    </div>
                                    <input type="submit" class="btn btn-primary" name="register" value="Register"/>
                                    <br/>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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

