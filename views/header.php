<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TWITTER CLONE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    </head>
  <body>
    <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Twitter</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Your timeline</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Your tweets</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-disabled="true">Public profiles</a>
            </li>
          </ul>
          <?php
             if (empty($_SESSION['userloggedin'])): ?>
              <button data-bs-toggle="modal" data-bs-target="#loginSignup" class="btn btn-outline-success" type="button">Login/Signup</button>
          <?php else: ?>
              <h6 style="color:white; margin-right:20px; margin-top:3px;">User: <?=getUserEmail()?></h6>
          
          
            <form id="logoutForm" action="action.php" method="post">
              <input type="hidden" id="csrf" name="csrf" value="<?=$_SESSION['csrf']?>">
              <input type="hidden" value="logout" name="action">
              <button id="logout" data-bs-toggle="modal" data-bs-target="#loginSignup" class="btn btn-outline-success" type="button">Logout</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>
