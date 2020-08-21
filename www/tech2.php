<?php
  
    // Include server side Learnosity SDK.
    require_once __DIR__ . '/../src/vendor/autoload.php';

    use LearnositySdk\Request\Init as LearnosityInit;
    use LearnositySdk\Utils\Uuid as LearnosityUuid;

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

//simple api request object for Items API
$request = [
    'state'=> 'initial',
    'type'           => 'submit_practice',
    'name'           => 'Items API Quickstart',
    'rendering_type'=> 'assess',
    'session_id'=> LearnosityUuid::generate(),
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
    'dynamic_items'=> [
        'try_again'=> [
            'max_attempts'=> 5,
        ]
    ],
    'config'=> [
        'navigation'=> [
            'warning_on_change' => true,
        ],
        'region_overrides'=> [
            'bottom'=> [[
                'type'=> 'try_again_button'
            ]]
        ]
    ]
];

$Init = new LearnosityInit('items', $security, $consumerSecret, $request);
$signedRequest = $Init->generate();

?>

<head><link rel="stylesheet" type="text/css" href="../css/style.css"></head>
    <body>
        <h1>Standalone Assessment Example</h1>

        <!-- Items API will render the assessment app into this div. -->
        <div id="learnosity_assess"></div>

        <!-- Load the Items API library. -->
        <script src="https://items.learnosity.com/"></script>

        <!-- Initiate Items API assessment rendering, using the JSON blob of signed params. -->
        <script>
        var initializationObject = <?php echo $signedRequest; ?>;

        //optional callbacks for ready
      //optional callbacks for ready
      var callbacks = {
            readyListener: function () {
                console.log('#CC listening ');
                itemsApp.assessApp().on('test:save:error', function (e) {
                    console.log('test:save:error');
                    console.log(e);
                });
                itemsApp.assessApp().on('test:submit:error', function (e) {
                    console.log('test:submit:error');
                    console.log(e);
                });

                itemsApp.assessApp().questionsApp().submit = function (settings) {
                    submitNumber++;
                    settings.error({message: 'error'});
                    if (!$('#alert-submit-error').length && submitNumber < 3) {
                        $('#test-save-submit .modal-dialog').append(
                            '<div class="alert alert-info" role="alert" style="margin-top: 20px" id="alert-submit-error">Make sure you <em>Try again</em> twice</div>'
                        );
                    }
                    if (submitNumber >= 3) {
                        $('#alert-submit-error').hide();
                    }
                };
            },
            errorListener: function (err) {
                console.log(err);
            }
        };
        var itemsApp = LearnosityItems.init(initializationObject, callbacks);
    </script>

    </body>

<?php
// include_once 'views/modals/initialisation-preview.php';
// include_once 'includes/footer.php';