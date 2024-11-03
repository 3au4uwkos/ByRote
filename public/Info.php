<?php 
    require_once(".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "LinkParser.php");
    $css = LinkParser::getLink("css");
    $js = LinkParser::getLink("js");
    $info = LinkParser::getLink("info");
    $logo = LinkParser::getLink("logo");
    $login = LinkParser::getLink("login");
    $register = LinkParser::getLInk("register");
    $main = LinkParser::getLink("main");
    $favicon16 = LinkParser::getLink("favicon16");
    $favicon32 = LinkParser::getLink("favicon32");
    $faviconApple = LinkParser::getLink("faviconApple");
    $manifest = LinkParser::getLink("manifest");
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
  <title>ByRote</title>
  <link href="<?php echo $css ?>" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="<?php echo $js ?>" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-light navbar-expand-lg"style="background-color: #feb4d8;">
  <div class="container mx-auto">
  <a class="navbar-brand" href="<?php echo $main ?>">
      <img src = '<?php echo $logo ?>' alt = 'Logo' width="80">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto my-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo $main ?>">Welcome</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $info ?>">About application</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tests
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo $login ?>">My tests</a></li>
            <li><a class="dropdown-item" href="<?php echo $login ?>">Create test</a></li>
            <li><hr class="dropdown-divider"></li>
          </ul>
        </li>
      <ul>
      <div class="btn-group me-auto mx-auto" role="group" aria-label="Basic mixed styles example">
        <a type="button" class="btn btn-info px-auto pe-auto" href="<?php echo $login?>">Sign in</a>
        <a type="button" class="btn btn-success px-auto pe-auto" href="<?php echo $register?>">Sing up</a>
      </div>
      </ul>
    </div>
  </div>
</nav>

    <div class="container">
        <h1>Info page</h1>
        <p class='text-success'>There will be information about ByRote</p>
    </div>
</body>
</html>