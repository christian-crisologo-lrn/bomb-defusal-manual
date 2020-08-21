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
        'rendering_type' => 'assess',
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
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <h1>Standalone Assessment Example</h1>

        <!-- Items API will render the assessment app into this div. -->
        <div id="learnosity_assess"></div>

        <!-- Load the Items API library. -->
        <script src="https://items.learnosity.com/"></script>

        <!-- Initiate Items API assessment rendering, using the JSON blob of signed params. -->
        <script>
            var itemsApp = LearnosityItems.init(
                <?php echo $initOptions ?>,
                {
                    readyListener() {
                        // window.initGame();

                        itemsApp.on('item:setAttemptedResponse', function (itemId) {
                            // window.checkAnswer(itemId);
                            console.log('#CC setAttemptedResponse ',itemId);
                        });

                        itemsApp.on('item:changed', function (itemId) {
                            // window.checkAnswer(itemId);
                            console.log('#CC changed ',itemId);
                        });

                        itemsApp.on('item:changing', function (itemIndex) {
                            console.log('#CC item changing ',itemIndex);
                        });


                        $.each(itemsApp.questions(), function (index, question) {
                              
                                question.on('validated', function () {
                                    console.log('#CC validated ',question);
                                    
                                });
                                question.on('changed', function () {
                                    console.log('#CC validated ',question);
                                    
                                });
                        });
                    },
                    errorListener(err) {
                        console.log('Error', err);
                    }
                }
            );

         
        </script>
    </body>
</html>