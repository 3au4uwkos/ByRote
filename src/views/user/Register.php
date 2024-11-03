<?php 
    require_once(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "LinkParser.php");
    $css = LinkParser::getLink("css");
    $js = LinkParser::getLink("js");
    $main = LinkParser::getLink("main");
    $login = LinkParser::getLink("login");
    $regImg = LinkParser::getLink("regImg");
    $regBack = LinkParser::getLink("regBack");
    $home = LinkParser::getLink("home");
    $favicon16 = LinkParser::getLink("favicon16");
    $favicon32 = LinkParser::getLink("favicon32");
    $faviconApple = LinkParser::getLink("faviconApple");
    $manifest = LinkParser::getLink("manifest");
    
     session_destroy();
      session_start();

    $error_message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
    {
      require_once(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR . "DBManager.php");

    $fullname = trim($_POST['login']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST["password_repeat"]);

    $res = DBManager::createUser($fullname,$password,$confirm_password);

    if($res === TRUE)
    {
      header("Location: " . $home);
      exit();
    } else
    {
      $error_message = $res;
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="apple-touch-icon" sizes="180x180" href='<?php echo $faviconApple ?>'>
  <link rel="icon" type="image/png" sizes="32x32" href='<?php echo $favicon32 ?>'>
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicon16 ?>">
  <link rel="manifest" href="<?php echo $manifest?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="<?php echo $css ?>" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="<?php echo $js ?>" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body background="<?php echo $regBack?>">
<section class="vh-100">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                <?php echo $error_message; ?>
                <form class="mx-1 mx-md-4" name="form" method="post" action="">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <input type="text" id="login" name="login" class="form-control" required/>
                      <label class="form-label" for="login">Your Login</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <input type="password" id="password" name="password" class="form-control" required />
                      <label class="form-label" for="password">Password</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <input type="password" id="password_repeat" name="password_repeat" class="form-control" required />
                      <label class="form-label" for="password_repeat">Repeat your password</label>
                    </div>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Submit"/>
                  </div>

                  <p>Already have an account? <a href="<?php echo $login?>">Log in here</a>.</p>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                <div class="container mx-auto me-auto">
                    <img src="<?php echo $regImg?>"
                        class="img-fluid rounded mx-auto me-auto" alt="Sample image">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>