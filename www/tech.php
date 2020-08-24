<?php
    /**
     * Copyright (c) 2017 Learnosity, MIT License
     *
     * Basic example of embedding a standalone assessment using Items API
     * with `rendering_type: "assess"`.
     */

    // - - - - - - Section 1: server-side configuration - - - - - - //

    // Include server side Learnosity SDK.
    require_once __DIR__ . '/../src/vendor/autoload.php';
    use LearnositySdk\Request\Init as LearnosityInit;
    use LearnositySdk\Utils\Uuid as LearnosityUuid;

    // Items API configuration parameters.
    $request = [
         // "rendering_type":"inline",
        'rendering_type' => 'inline',
        'type'           => 'submit_practice',
        'name'           => 'Items API Quickstart',
        'state'          => 'initial',
        'user_id'        => 'student_00012',    // Unique student identifier

        // Reference of the Activity to retrieve from the Item bank.
        // The Activity defines which Items will be served in this assessment.
        'activity_template_id' => 'LRN_DEFUSE_ACTIVITY_1',

        // Uniquely identifies this specific assessment attempt for save/resume,
        // data retrieval and reporting purposes.
        'session_id'     => LearnosityUuid::generate(),

        // Used in data retrieval and reporting to compare results
        // with other users submitting the same assessment.
        'activity_id'    => 'LRN_DEFUSE_ACTIVITY_1',
        'assess_inline'  => true, 
        'config' => [
            'navigation' =>['show_next' => false,'show_submit'=>false],
        ]
    ]; 

    // Public & private security keys required to access Learnosity APIs and
    // data. These keys grant access to Learnosity's public demos account.
    // Learnosity will provide keys for your own private account.
    $consumerKey = 'ARV3wIzUPWnC5l18';
    $consumerSecret = 'oCsuobS0ZBSEw6zG8yepifKSQ3tqgmaBzbPYp1zl';

    // Parameters used to create security authorization.
    $security = [
        'domain'       => $_SERVER['SERVER_NAME'],
        'consumer_key' => $consumerKey
    ];

    // Use Learnosity SDK to construct Items API configuration parameters,
    // and sign them securely with the $security and $consumerSecret parameters.
    $init = new LearnosityInit(
        'items',
        $security,
        $consumerSecret,
        $request);
    $initOptions = $init->generate(); // JSON blob of signed config params.
?>

<!-- Section 2: Web page content. -->
<!DOCTYPE html>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link href="/css/quiz.css" rel="stylesheet">
    </head>
    <body class="ff">
        
        <!-- Items API will render the assessment app into this div. -->
        <div id="learnosity_assess"></div>
        <div  class="explosive-effect"  style="display:none" ></div>
        <div class="blinking-effect" ></div>
        <div class="alert-response-wrapper" style="display:none">
            <span class=" alert-correct " role="alert" style="">
                 ☺️  CORRECT!
            </span>
            <span class=" alert-wrong " role="alert" style="">
                ☠️ WRONG!
            </span>
        </div>
        <!-- Load the Items API library. -->
        <script src="https://items.learnosity.com/"></script>
        <script src="game.js"></script> 
     
            <div class="game-container text-center w-100 h-100 pl-4 pr-4 pt-2  mx-auto flex-column">
                <div class="title-header  bg-primary f-row d-flex justify-content-between  ">
                    <div class="text-left pt-1">&nbsp;&nbsp;💣 Bomb Defusal Manual</div>
                    <button class="btn btn-secondary enable-sound">ON 🔈 </button> 
                </div>
            
                <div class=" f-row justify-content-between top-stats-box" style="display:flex">
                    <div> 🏆 SCORE <span class="badge badge-warning scores">0</span></div>
                    <div> ⌚ TIME REMAINING <span class="badge badge-danger timer">0:00</span></div>
                </div>
                
                <div class="select-level p-5 pt-5" >
                    <h5> Select level :</h5>
                    <a class="btn btn-lg btn-warning btn-block btn-level-1">Beginner ⭐</a>
                    <a class="btn btn-lg btn-danger btn-block btn-level-2">Expert ⭐⭐</a>
                </div>
                <div class="reports-container mt-2 pt-2" role="alert">
                    <h4 class="alert-heading report-status"></h4>
                    <img src="" class="report-img" />
                    <p>Final scores : <span class="report-scores badge badge-warning ">0</span> </p>
                    <p>No. of attempts : <span class="report-attempted badge badge-warning">0</span> </p>
                    <p>Time finished : <span class="report-time badge badge-warning">0:00</span> </p>
                    <hr>
                    <p class="mb-2 pt-2" style="border-top: 1px dashed gray">
                        <a  type="button" class="btn btn-warning btn-try-again"  data-original-title="try again" aria-label="try again" href="./tech.php" title="Try again!" >  TRY AGAIN</a>
                    </p>
                </div>

                <div class="question-container inner cover">
                    <span class="learnosity-item" data-reference="LRN_DEFUSE_HASH_1"></span>
                    <span class="learnosity-item" data-reference="LRN_DEFUSE_PATTERN_1"></span>
                    <span class="learnosity-item" data-reference="LRN_DEFUSE_SYMBOLS_1"></span>
                    <span class="learnosity-item" data-reference="LRN_DEFUSE_WIRE_1"></span>
                    <span class="learnosity-item" data-reference="LRN_DEFUSE_WORD_1"></span> 
                    <span class="learnosity-item" data-reference="LRN_DEFUSE_HOMONYM_1"></span> 
                    <button  type="button" class="btn btn-lg btn-warning btn-answer"  ><span class="btn-label">SUBMIT</span></button>
                    <hr/>
                   
                </div> 
            
                <div class="preloader w-100 h-100 p-5 mx-auto flex-column ">
                    LOADING ...
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" ></div>
                    </div>
                </div>
            </div>
  
         <!-- AUDIOS -->
      
        <audio   id="explosion-sound">
            <source src="sounds/explosion.mp3" type="audio/mpeg">
              Your browser does not support the audio element.
        </audio>

        <audio id="bg-sound" autoplay loop  >
            <source src="sounds/bg-ost.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>

        <script>  
         
            newGame();
            var itemsApp = LearnosityItems.init(
                <?php echo $initOptions ?>,
                {
                    readyListener() {
                        initGame();
                    },
                    errorListener(err) {
                        console.log('Error', err);
                    }
                }
            ); 
        </script>



    </body>
</html>