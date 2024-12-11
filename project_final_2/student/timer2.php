<?php
function timer_quiz($time){
    $total_time=$time*60*100;
    echo "
    <script type =\"text/javascript\">
    let wait=setTimeOut(\"document.question_quiz.submit();\",".$total_time.");
    </script>
    <div> Time :<span id=\"time\">".$time.":00</span>Minutes</div>
    <script>
    function startTimer(duration,display){
        let timer=duration,minutes,seconds;
        setInterval(function(){
            minutes=parseInt(timer/60,10);
            seconds=parseInt(timer%60,10);

            minutes=minutes<10?\"0\"+ minutes : minutes;
            seconds=seconds<10?\"0\"+ seconds : seconds;
            display.textContent=minutes+\":\"+seconds;

            if(--timer <0){
                timer=duration;
                

            }
        },1000);
    }
    window.onload=function(){
        let minutes=60*".$time.",
        display=document.querySelector('#time');
        startTimer(minutes,display);
    };
    </script>";
}
?>