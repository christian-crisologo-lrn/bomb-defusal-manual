 
const MAX_TIME = 240;
let currentQuestionIndex = -1; 

const newGame = () => {
    $('.question-container').hide(); 
    $('.answer-alert').hide();
    $('.btn-answer').hide(); 
} 

function secondsToMinute(d) { 
    const m = Math.floor(d % 3600 / 60);
    const s = Math.floor(d % 3600 % 60); 
    return   ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
}

const  timer = (seconds, cb) => {
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

const gameOver = (status = 'lose')=> {
    $('.question-container').hide();
    $('.learnosity-item').hide();
    $('.btn-answer').hide();
    const response = status === 'lose' ? "BOMB EXPLODED!!!!" : "GOOD JOB! BOMB DEFUSED";
    $('.answer-alert').html(response).show(); 
}

const gameStart = ()=>{ 
    
    const questions = itemsApp.getQuestions(); 
    const totalQuestions = Object.keys(questions).length;

    $('.btn-answer').on('click',()=>{
        const currentQuestionId = Object.keys(questions)[currentQuestionIndex];
        const currentQuestion = itemsApp.question(currentQuestionId);
        const isCorrect = currentQuestion.isAttempted() && currentQuestion.isValid();
        const response  = isCorrect ? "CORRECT!" : "WRONG!"; 

        $('.answer-alert').html(response).show();
        if( isCorrect){
            updateScores();
            $('.btn-answer').hide();
            if(currentQuestionIndex>=totalQuestions-2){
                gameOver('win');
            }else{
               setTimeout(nextQuestion,2000); 
            }
        }
   
    });

    nextQuestion();
    timer(MAX_TIME, (seconds)=>{
        if(seconds<=0){
            gameOver('lose');
        }
        $('.timer').html(secondsToMinute(seconds));
    });
    //
    $('.preloader').hide();
} 