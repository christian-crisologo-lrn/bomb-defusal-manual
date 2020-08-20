<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Password Hashes</title>
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="/css/quiz.css" rel="stylesheet">
    
  </head>
  <body class="">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">

      <main role="main" class="inner cover">
        <h2 class="cover-heading">On the Subject of Password Hashes</h1>
        
<?php        
$hashes['xh'] = 'a';
$hashes['rt'] = 'b';
$hashes['cs'] = 'c';
$hashes['f0'] = 'd';
$hashes['z0'] = 'e';
$hashes['1o'] = 'f';
$hashes['88'] = 'g';
$hashes['jt'] = 'h';
$hashes['6w'] = 'i';
$hashes['au'] = 'j';
$hashes['es'] = 'k';
$hashes['gg'] = 'l';
$hashes['76'] = 'm';
$hashes['1k'] = 'n';
$hashes['06'] = 'o';
$hashes['17'] = 'p';
$hashes['pc'] = 'q';
$hashes['cx'] = 'r';
$hashes['is'] = 's';
$hashes['6q'] = 't';
$hashes['w9'] = 'u';
$hashes['6h'] = 'v';
$hashes['8a'] = 'w';
$hashes['4f'] = 'x';
$hashes['nl'] = 'y';
$hashes['bp'] = 'z';
$hashes['ua'] = '0';
$hashes['mj'] = '1';
$hashes['ku'] = '2';
$hashes['b8'] = '3';
$hashes['po'] = '4';
$hashes['on'] = '5';
$hashes['i9'] = '6';
$hashes['zr'] = '7';
$hashes['v2'] = '8';
$hashes['oh'] = '9';


function isValid($str) {
  return !preg_match('/[^a-z0-9]/', $str);
}
?>       
        
        

<?php        
if (isset($_GET['hash'])){
  $hash = strtolower($_GET['hash']);

  if (isValid($hash)) {
    echo '<p class="lead">The password!</p>';
    echo '<input class="form-control" type="text" value="';
    
    $output = str_split($hash, 2);
    
    foreach ($output as $key) {
      echo $hashes[$key];
    }
    
    echo '" readonly>' . "\n";
    
  }
} else {
?>
        <p class="lead">Got a secret password hash you need to crack?</p>
        <form action="">
          <div class="form-group">
            <label for="text">Hash</label>
            <input type="text" class="form-control" name="hash" id="hash">
          </div>
          <button type="submit" class="btn btn-lg btn-secondary">Submit</button>
        </form>
        
<?php
}
?>
      </main>
      
      <footer class="mastfoot mt-auto">
    <div class="inner">
      <p><a href="/manual.php">Back</a></p>
    </div>
  </footer>

    </div>

    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>
