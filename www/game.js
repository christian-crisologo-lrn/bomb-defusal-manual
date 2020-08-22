 
const MAX_TIME = 240;
let currentQuestionIndex = -1; 
let isGameOver = false;
let timeRemaining = 0;
let gameLevel = 1;

const newGame = () => {
    $('.preloader').show();
    $('.question-container').hide(); 
    $('.btn-answer').hide();
    $('.reports-container').hide(); 
    $('.select-level').hide();
    $('.alert-correct').hide();
    $('.alert-wrong').hide();
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
    $('.question-container').fadeIn('slow');
    $('.learnosity-item').hide();
    $('.btn-answer').show();
    $('.alert-correct').hide();
    $('.alert-wrong').hide();
    $(`.question-container div:nth-child(${currentQuestionIndex+1})`).show();
}

const submit = () =>{
    var submitSettings = {
        success: function (response_ids) {
            console.log("submit has been successful", response_ids);
        },
        error: function (e) {
            console.log("submit has failed",e);
        },
        progress: function (e) { 
            console.log("progress",e);
        }
    };
    
    itemsApp.submit(submitSettings);
}

const showReport = (status)=>{
    const responseStatus = status === 'lose' ? "BOMB EXPLODED!!!!" : "GOOD JOB! The bomb has been defused!";
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
    $('.question-container ').hide();
}

const gameOver = (status = 'lose')=> {
    isGameOver = true;
    $('.learnosity-item').hide();
    $('.btn-answer').hide();
    // update scores
    showReport(status);
    submit();  
}

const initGame = ()=>{
    $('.preloader').fadeOut();
    $('.select-level').animate({ "left": "+=50px" }  ).fadeIn('slow');
    $('.btn-level-1').on('click',()=>{
        gameStart(1);
        $('.select-level').hide();
    })
    $('.btn-level-2').on('click',()=>{
        gameStart(2);
        $('.select-level').hide();
    })
}

const gameStart = (level = 1)=>{ 
    gameLevel = level;
    const questions = itemsApp.getQuestions(); 
    const totalQuestions = Object.keys(questions).length;

    $('.btn-answer').on('click',()=>{
        const currentQuestionId = Object.keys(questions)[currentQuestionIndex];
        const currentQuestion = itemsApp.question(currentQuestionId);
        const isCorrect = currentQuestion.isAttempted() && currentQuestion.isValid();
 
        // if game level hard
        if(gameLevel>1 && !isCorrect){
            gameOver('lose');
            return;
        }
        $('.alert-wrong').hide();
        $('.alert-correct').hide();
        if( isCorrect){
            $('.alert-correct').fadeIn();
            updateScores();
            $('.btn-answer').fadeOut();
            if(currentQuestionIndex>=totalQuestions-1){
                gameOver('win');
            }else{
               setTimeout(nextQuestion,2000); 
            }
        }else{
            $('.alert-wrong').show();
            $(".explosive-effect:hidden").fadeIn( function() {
                $(this).fadeOut();
            });
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
  

} 