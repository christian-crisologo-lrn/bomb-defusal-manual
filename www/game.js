 
const MAX_TIME = 240;
let currentQuestionIndex = -1; 
let isGameOver = false;
let timeRemaining = 0;
let gameLevel = 1;

const newGame = () => {
    $('.question-container').hide(); 
    $('.answer-alert').hide();
    $('.btn-answer').hide();
    $('.reports-container').hide();
} 

function secondsToMinute(d) { 
    const m = Math.floor(d % 3600 / 60);
    const s = Math.floor(d % 3600 % 60); 
    return   ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
}

const  timer = (seconds, cb) => {
    if(isGameOver) return false;
    //
    let _timeRemaining = seconds;
    cb(seconds);
    setTimeout(function() {
      if (_timeRemaining > 0) {
        timer(_timeRemaining - 1, cb); 
      }
    }, 1000);
  }

const updateScores= () => {
    const nextScore = Object.values(itemsApp.getScores()).reduce(
      (accumulator, current) => accumulator + (current.score || 0),
      0
    );
    $('.scores').html(nextScore.toString().padStart(2, '0'));
  }

const nextQuestion = () => {
    currentQuestionIndex++;
    $('.question-container').show();
    $('.learnosity-item').hide();
    $('.btn-answer').show();
    $('.answer-alert').hide();
    $(`.question-container div:nth-child(${currentQuestionIndex+1})`).show();
}

const submit = () =>{
    var submitSettings = {
        success: function (response_ids) {
            // Receives a list of the submitted session responses as [response_id]
            console.log("submit has been successful", response_ids);
        },
        error: function (e) {
            // Receives the event object defined in the Event section
            console.log("submit has failed",e);
        },
        progress: function (e) {
            // Client custom progress event handler
            // e: uses the progress object defined bellow
            // See the Progress Event section for more information on this
            console.log("progress",e);
        }
    };
    
    itemsApp.submit(submitSettings);
}

const showReport = (status)=>{
    const responseStatus = status === 'lose' ? "BOMB EXPLODED!!!!" : "GOOD JOB! BOMB DEFUSED";
    const scores = Object.values(itemsApp.getScores()).reduce(
        (accumulator, current) => accumulator + (current.score || 0),
        0
      );
    const attempts = (itemsApp.attemptedItems() || []).length;
    $('.reports-container').show();
    $('.reports-container').addClass( status === 'lose' ? 'alert-danger' : 'alert-success' )
    $('.report-status').html(responseStatus);
    $('.report-scores').html(scores);
    $('.report-attempted').html(attempts); 
    $('.report-time').html(timeRemaining); 
    $('.scores').hide();
    $('.timer').hide();
    $('.answer-alert').hide();
    $('.btn-answer').hide(); 
    console.log('#CC xx ');
}

const gameOver = (status = 'lose')=> {
    isGameOver = true;
    $('.learnosity-item').hide();
    $('.btn-answer').hide();
    // update scores
    showReport(status);
    submit();  
}

const gameStart = (level = 1)=>{ 
    gameLevel = level;
    const questions = itemsApp.getQuestions(); 
    const totalQuestions = Object.keys(questions).length;

    $('.btn-answer').on('click',()=>{
        const currentQuestionId = Object.keys(questions)[currentQuestionIndex];
        const currentQuestion = itemsApp.question(currentQuestionId);
        const isCorrect = currentQuestion.isAttempted() && currentQuestion.isValid();
        const response  = isCorrect ? "CORRECT!" : "WRONG!"; 
        // if game level hard
        if(gameLevel>1 && !isCorrect){
            gameOver('lose');
            return;
        }

        $('.answer-alert').html(response).show();
        if( isCorrect){
            updateScores();
            $('.btn-answer').hide();
            if(currentQuestionIndex>=totalQuestions-1){
                gameOver('win');
            }else{
               setTimeout(nextQuestion,2000); 
            }
        }
   
    });

    nextQuestion();
    timer(MAX_TIME, (seconds)=>{
        timeRemaining = seconds;
        if(seconds<=0){
            gameOver('lose');
        }
        $('.timer').html(secondsToMinute(seconds));
    });
    //
    $('.preloader').hide();
} 