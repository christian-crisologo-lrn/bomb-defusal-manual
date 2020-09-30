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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link href="/css/quiz.css" rel="stylesheet">
    </head>
    <body>
        

        <!-- Items API will render the assessment app into this div. -->
        <div id="learnosity_assess"></div>

        <!-- Load the Items API library. -->
        <script src="https://items-cn-au.learnosity.com/"></script>
        <script src="game.js"></script>

        <!-- <div class="reports-container cover-container  w-100 h-100 p-3 mx-auto flex-column">
            <p> REPORT POINTS : <span id="report-points">0000</span> </p>
            <p> REPORT ATTEMPTED : <span id="report-questions-attempted">0000</span> </p>
            <p> REPORT WRONG ANSWER : <span id="report-wrong-answers"></span></p>
        </div> -->

        <div class="cover-container  w-100 h-100 p-3 mx-auto flex-column">
            <h1 class="center">Bomb defusal</h1>
            <div class="question-container inner cover">
                <span class="learnosity-item" data-reference="LRN_DEFUSE_HASH_1"></span>
                <span class="learnosity-item" data-reference="LRN_DEFUSE_PATTERN_1"></span>
                <span class="learnosity-item" data-reference="LRN_DEFUSE_SYMBOLS_1"></span>
                <span class="learnosity-item" data-reference="LRN_DEFUSE_WIRE_1"></span>
                <span class="learnosity-item" data-reference="LRN_DEFUSE_WORD_1"></span> 
                <span class="learnosity-item" data-reference="LRN_DEFUSE_HOMONYM_1"></span> 

                <h4> SCORES <span class="badge badge-warning scores">0</span></h4>
                <p> TIME REMAINING <span class="badge badge-danger timer">0:00</span></p>
                <div class="alert alert-warning answer-alert" role="alert"></div>
                <button  type="button" class="btn btn-primary btn-answer"  data-original-title="Next" aria-label="Next Item 2"><span class="btn-label">CHECK ANSWER</span></button>

            </div>
            <div class="preloader w-100 h-100 p-5 mx-auto flex-column ">
                LOADING ...
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" ></div>
                </div>
            </div>
            
        </div>
        <script> 
            newGame();
            var itemsApp = LearnosityItems.init(
                <?php echo $initOptions ?>,
                {
                    readyListener() {
                        gameStart();
                    },
                    errorListener(err) {
                        console.log('Error', err);
                    }
                }
            ); 
        </script>

    </body>
</html>
