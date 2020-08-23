<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>BOMB DEFUSAL MANUAL V1.0.0</title>

    <!-- Custom styles for this template -->
    <link href="/css/quiz.css" rel="stylesheet"> 
    <link href="/css/bg.css" rel="stylesheet"> 
    
  </head>
  <body class="text-center explode-bg">

    <div class="cover-container w-100 h-100 mx-auto flex-column"  > 

      <main role="main" class="inner cover" >
        <img src="images/cover.png" class="img-fluid cover-img"  style="display:none"   />
        <h1 class="cover-heading ff">Ready to defuse?</h1>
        <div class="player-selections">
          <div class="p-4 tech-b1"> 
              <a href="tech.php" class="tech-btn" ><img src="images/tech.png" href="tech.php" style="width:225px" /></a>
              <a href="tech.php" class="btn btn-lg btn-secondary btn-block tech-btn">Bomb Technican</a>
              <p class="p-2" >Are you the sort of person who is chomping at the bit to press buttons and possibly blow up after following bad adive? Then you should be the</p>
          </div>
          <div class="p-4">
            <a href="manual.php"> <img src="images/manual.png" href="manual.php" style="width:225px" /></a>
            <a href="manual.php" class="btn btn-lg btn-secondary btn-block">Manual</a>
            <p class="p-2" >Or are you the type of person happy to help knowing then when it all goes wrong someone else will die? Then you should just use the </p>
          </div>
         </div>
      </main>

      <div class="pb-5" >
        <audio id="bg-sound" autoplay loop  >
                <source src="sounds/bg-ost.mp3" type="audio/mpeg">
                Your browser does not support the audio element.
        </audio>
        <button class="btn btn-warning enable-sound">Play 🔈 </button>  
    </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script>
    
      $(
        ()=>{
         
          const audioControl =  document.getElementById("bg-sound"); 
          audioControl.volume = 0.5;
          $('.cover-img:hidden').fadeIn(3000);

          $('.enable-sound').on('click',(e)=>{
              e.preventDefault();
              if( !audioControl.paused){
                  audioControl.pause();
                  $('.enable-sound').html('Play 🔈'); 

              }else{
                  console.log('#CC play ');
                  $('.enable-sound').html('Stop 🔇');
                  audioControl.play()
              }
          });
        }
      );
      window.scrollTo(0,0);
     
    </script>
  </body>
</html>
