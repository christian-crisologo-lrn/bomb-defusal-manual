 
const MAX_TIME = 240;
let currentQuestionIndex = -1; 
let isGameOver = false;
let timeRemaining = 0;
let gameLevel = 1;
let questionReady = false;

jQuery.fn.enterKey = function (fnc) {
    return this.each(function () {
        $(this).keypress(function (ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                fnc.call(this, ev);
            }
        })
    })
}

jQuery.fn.shake = function() {
    this.each(function(i) {
        $(this).css({
            "position": "absolute"
        });
        const shake = 10;
        for (var x = 1; x <= 3; x++) {
            $(this).animate({
                left: Math.round(Math.random() * shake) - ((shake + 1) / 2) +'px', 
                top: Math.round(Math.random() * shake) - ((shake + 1) / 2) +'px'
            }, 10).animate({
                left: Math.round(Math.random() * shake) - ((shake + 1) / 2) +'px', 
                top: Math.round(Math.random() * shake) - ((shake + 1) / 2) +'px'
            }, 50).animate({
                left: Math.round(Math.random() * shake) - ((shake + 1) / 2) +'px', 
                top: Math.round(Math.random() * shake) - ((shake + 1) / 2) +'px'
            }, 10).animate({
                left: Math.round(Math.random() * shake) - ((shake + 1) / 2) +'px', 
                top: Math.round(Math.random() * shake) - ((shake + 1) / 2) +'px'
            }, 50);
        }
    });
    return this;
}

const initBgSounds = () => {
    const audioControl =  document.getElementById("bg-sound"); 
    audioControl.volume = 0.5;
    $('.enable-sound').on('click',(e)=>{
        e.preventDefault();
        if( !audioControl.paused){
            audioControl.pause();
            $('.enable-sound').html('ON 🔈'); 

        }else{
            $('.enable-sound').html('OFF 🔇');
            audioControl.play()
        }
    });
     
  }

const playExplosionSound = ()=>{
    const audioControl =  document.getElementById("explosion-sound"); 
    audioControl.play()
}

const newGame = () => {
    $('.preloader').show();
    $('.question-container').hide(); 
    $('.btn-answer').hide();
    $('.reports-container').hide(); 
    $('.select-level').hide();
    $('.alert-response-wrapper').hide();
    $('.alert-correct').hide();
    $('.alert-wrong').hide();
    $('.top-stats-box').hide();
    initBgSounds();
}  

const secondsToMinute = (d)=> { 
    const m = Math.floor(d % 3600 / 60);
    const s = Math.floor(d % 3600 % 60); 
    return   ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
}

const showExplosions = (count=1)=>{
    let ctr = 0;
    
    function loop(){
       playExplosionSound();
       $('.game-container').shake();
       $(".blinking-effect").fadeIn();
        $(".explosive-effect:hidden").fadeIn( 1000,() =>{
            $(".explosive-effect").fadeOut(()=>{
                ctr++;
                $(".blinking-effect").hide();
                if(ctr<count){
                    loop();
                    
                } 
            });
          
        });
    }
    loop();
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



const toScores = (score="0") => score.toString().padStart(2, '0');

const updateScores= () => {
    const nextScore = Object.values(itemsApp.getScores()).reduce(
      (accumulator, current) => accumulator + (current.score || 0),
      0
    );
    $('.scores').html(toScores(nextScore));
  }

const nextQuestion = () => {
    questionReady = false;
    currentQuestionIndex++; 
    $('.learnosity-item').hide();
    $('.alert-response-wrapper').hide();
    $('.alert-correct').hide();
    $('.alert-wrong').hide();
    $('.question-container').fadeIn();
    $('.top-stats-box ').animate({ "top": "+=50px" }  ).fadeIn('fast',()=>{
        $(`.question-container div:nth-child(${currentQuestionIndex+1})`).fadeIn(1000);
    });
    $('.btn-answer').fadeIn(3000,()=>{
        questionReady = true;
    });

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
    const isWin = status === 'win';
    const responseStatus = isWin ?  "🎖️ MISSION SUCCESS!! 🎖️" : "☠️ MISSION FAILED!! ☠️ " ;
    const scores = Object.values(itemsApp.getScores()).reduce(
        (accumulator, current) => accumulator + (current.score || 0),
        0
      );
    if(!isWin){
        showExplosions(2);
    }
    const attempts = (itemsApp.attemptedItems() || []).length;

    $('.report-img').attr('src', isWin ? "images/tech-win.png" : "images/tech-lose.png")
    $('.reports-container').show();
    $('.reports-container').addClass( isWin  ? 'report-win'  : 'report-lose' )
    $('.report-status').html(responseStatus);
    $('.report-scores').html(toScores(scores));
    $('.report-attempted').html(attempts); 
    $('.report-time').html(secondsToMinute(timeRemaining)); 

}

const gameOver = (status = 'lose')=> {
    isGameOver = true;
    $('.learnosity-item').hide();
    $('.btn-answer').hide();
    $('.top-stats-box').fadeOut('slow');
    $('.alert-response-wrapper').hide();
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

    const runAnswer = ()=>{
        const currentQuestionId = Object.keys(questions)[currentQuestionIndex];
        const currentQuestion = itemsApp.question(currentQuestionId);
        const isCorrect = currentQuestion.isAttempted() && currentQuestion.isValid();
        const isLastQuestion = currentQuestionIndex>=totalQuestions-1;
 
        // if game level hard
        if(gameLevel>1 && !isCorrect){
            gameOver('lose');
            return;
        }

        $('.alert-response-wrapper').show();
        $('.alert-wrong').hide();
        $('.alert-correct').hide();
     
        if( isCorrect){
            updateScores();
            if(!isLastQuestion){
                $('.alert-correct').fadeIn('fast',()=>{
                    setTimeout(()=>$('.alert-response-wrapper').fadeOut('fast'),1000);
                });
           }
            if(isLastQuestion){
                gameOver('win');
            }else{
          
                $('.btn-answer').fadeOut();
               setTimeout(nextQuestion,2000); 
            }
        }else{
            $('.alert-wrong').fadeIn('slow',()=>{
                setTimeout(()=>$('.alert-response-wrapper').fadeOut('slow'),1000);
            });
            showExplosions(1);
        }
    }

    $(document).on('keypress', (e)=>{
        if(e.which === 13 && questionReady) {
            runAnswer();
        }
    });

    $('.btn-answer').on('click',runAnswer);

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