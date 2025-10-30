const words = 'in one good real one not school set they state high life consider on and not come what also for set point can want as while with of order child about school thing never hold find order each too between program work end you home place around while place problem end begin interest while public or where see time those increase interest be give end think seem small as both another a child same eye you between way do who into again good fact than under very head become real possible some write know however late each that with because that place nation only for each change form consider we would interest with world so order or run more open that large write turn never over open each over change still old take hold need give by consider line only leave while what set up number part form want against great problem can because head so first this here would course become help year first end want both fact public long word down also long for without new turn against the because write seem line interest call not if line thing what work people way may old consider leave hold want life between most place may if go who need fact such program where which end off child down change to from people high during people find to however into small new general it do that could old for last get another hand much eye great no work and with but good there last think can around use like number never since world need what we around part show new come seem while some and since still small these you general which seem will place come order form how about just also they with state late use both early too lead general seem there point take general seem few out like might under if ask while such interest feel word right again how about system such between late want fact up problem stand new say move a lead small however large public out by eye here over so be way use like say people work for since interest so face order school good not most run problem group run she late other problem real form what just high no man do under would to each too end point give number child through so this large see get form also all those course to work during about he plan still so like down he look down where course at who plan way so since come against he all who at world because while so few last these mean take house who old way large no first too now off would in this course present order home public school back own little about he develop of do over help day house stand present another by few come that down last or use say take would each even govern play around back under some line think she even when from do real problem between long as there school do as mean to all on other good may from might call world thing life turn of he look last problem after get show want need thing old other during be again develop come from consider the now number say life interest to system only group world same state school one problem between for turn run at very against eye must go both still all a as so after play eye little be those should out after which these both much house become both school this he real and may mean time by real number other as feel at end ask plan come turn by all head increase he present increase use stand after see order lead than system here ask in of look point little too without each for both but right we come world much own set we right off long those stand go both but under now must real general then before with much those at no of we only back these person plan from run new as own take early just increase only look open follow get that on system the mean plan man over it possible if most late line would first without real hand say turn point small set at in system however to be home show new again come under because about show face child know person large program how over could thing from out world while nation stand part run have look what many system order some one program you great could write day do he any also where child late face eye run still again on by as call high the must by late little mean never another seem to leave because for day against public long number word about after much need open change also'.split(' ');

const wordsCount = words.length;

// ALTER TABLE users
//ADD CONSTRAINT unique_user_name UNIQUE (user_name);


/*CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL, -- Referencing user_name in the users table
    wpm INT NOT NULL, -- Words Per Minute
    playtime INT NOT NULL, -- Game duration in seconds
    played_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Time and date of the game
    FOREIGN KEY (user_name) REFERENCES users(user_name) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
*/

let gameTime = 30*1000;

document.querySelectorAll(".control-button").forEach(button => {
    button.addEventListener("click", (e) => {
        gameTime = parseInt(e.target.innerHTML) * 1000; 
        document.getElementById("cursor").style.top= document.getElementById("words").firstChild.getBoundingClientRect().top +5+'px';
        document.getElementById("cursor").style.left= document.getElementById("words").firstChild.getBoundingClientRect().left +2+'px';    
        stopGame(); 
        newGame();
        document.getElementById("info").innerHTML = parseInt(e.target.innerHTML); 
    });
});


window.timer = null;
window.gameStart = null;
document.getElementById("cursor").style.left= document.getElementById("words").getBoundingClientRect().top +2+'px';
document.getElementById("cursor").style.left= document.getElementById("words").getBoundingClientRect().left +5+'px';

function addClass(el,name){
    el.className+=' '+name;
}

function removeClass(el,name){
    el.className = el.className.replace(name,"");
}



function randomWord(){
    const randomIndex = Math.ceil(Math.random()*wordsCount);
    return words[randomIndex-1];
}


function formatWord(word){
    return `<div class="word"><span class="letter">${word.split("").join("</span><span class='letter'>")}</span></div>`;
}

function newGame(){
    document.getElementById('words').innerHTML="";
    for(i=0;i<200;i++){
        document.getElementById('words').innerHTML += formatWord(randomWord());
    }
    addClass(document.querySelector('.word'),'current');
    addClass(document.querySelector('.letter'),'current');
    window.timer = null;
}

function getWpm(){
    const words = [...document.querySelectorAll(".word")];
    const lastTypedWord = document.querySelector(".word.current");
    const lastTypedWordIndex = words.indexOf(lastTypedWord);
    const typedWords= words.slice(0,lastTypedWordIndex);
    const correctWords = typedWords.filter(word =>{
        const letters = [...word.children];
        const incorrectLetters = letters.filter(letter => letter.className.includes("incorrect"));
        const correctletters = letters.filter(letter=> letter.className.includes("correct"));
        return incorrectLetters.length===0 && correctletters.length === letters.length;
    });
    return correctWords.length / gameTime*60000;
}

function stopGame() {
    clearInterval(window.timer); 
    window.timer = null;
    window.gameStart = null;
    const words = document.getElementById('words');
    words.innerHTML = ""; 
    words.style.marginTop = "0px"; 
    removeClass(document.getElementById('game'), "over");
    document.getElementById("info").innerHTML = ""; 
}


let isPaused = false;
let startTime = null; // The time when the game started
let remainingTime = 30; // Starting time in seconds (e.g., 30 seconds)
let lastUpdateTime = null; // Last timestamp when the game was active
let stopped = false

// Pause the game when focus is lost
window.addEventListener("blur", () => {
    if (window.timer) {
        clearInterval(window.timer);
        window.timer = null;
        isPaused = true;
    }
    lastUpdateTime = new Date().getTime(); // Record when the game lost focus
    stopped = true;
});

// Resume the game when focus is regained
window.addEventListener("focus", () => {
    if (isPaused && !document.querySelector("#game.over")) {
        isPaused = false;

        // Recalculate remaining time based on elapsed real time
        const now = new Date().getTime();
        if(stopped===false){
        let elapsedWhileBlurred = (now ) / 1000;}
        else{
            let elapsedWhileBlurred = (lastUpdateTime) / 1000;
        }

        // Adjust the `startTime` to avoid any extra deduction of elapsed time
        startTime = new Date().getTime() - (30 - elapsedWhileBlurred) * 1000;

        // Restart the timer without reducing the remaining time
        startTimer();
    }
});

// Start or restart the timer
function startTimer() {
    window.timer = setInterval(() => {
        const now = new Date().getTime();
        const elapsed = Math.floor((now - startTime) / 1000);

        remainingTime = Math.max(30 - elapsed, 0); // Calculate the remaining time

        if (remainingTime <= 0) {
            gameOver();
            return;
        }

        document.getElementById("info").innerHTML = `${remainingTime}`; // Update remaining time dynamically
    }, 1000);
}


function gameOver() {
    clearInterval(window.timer);
    window.timer = null;
    addClass(document.getElementById("game"), "over");

    // Calculate WPM and play time
    const wpm = Math.round(getWpm());
    const playTime = gameTime / 1000;

    // Display the WPM on the page
    document.getElementById("info").innerHTML = `WpM: ${wpm}`;

    // Create a button to submit the score
    const submitButton = document.createElement("button");
    submitButton.textContent = "Submit Score";
    submitButton.className = "submit-button"; // Ensuring it's styled correctly
    submitButton.onclick = () => submitGameData(wpm, playTime);
    
    // Append the button directly within the game container
    submitButton.style.color = "#E2B714";
    submitButton.style.textDecoration = "none";
    submitButton.style.display = "inline-flex";
    submitButton.style.alignItems = "center";
    submitButton.style.justifyContent = "center";
    submitButton.style.padding = "8px 16px";
    submitButton.style.border = "1px solid #646669";
    submitButton.style.borderRadius = "8px";
    submitButton.style.fontSize = "14px";
    submitButton.style.backgroundColor = "#2C2E31";
    submitButton.style.transition = "color 0.3s, background-color 0.3s, border-color 0.3s";
    submitButton.style.marginLeft="3%";


    document.getElementById("info").appendChild(submitButton);
}

function submitGameData(wpm, playTime) {
    // Prepare the data to send
    const formData = new FormData();
    formData.append('wpm', wpm);
    formData.append('playTime', playTime);

    // Create a new form element and submit it
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "save_game.php";

    for (let [key, value] of formData.entries()) {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }

    // Append form directly to game container before submission
    document.getElementById("game").appendChild(form); // Ensure it's appended to the game div
    form.submit();
}








document.getElementById('game').addEventListener('keyup',ev=>{
    const key =ev.key;
    const currentWord = document.querySelector(".word.current");
    const currentLetter = document.querySelector('.letter.current');
    const expected = currentLetter?.innerHTML ||" ";
    const isLetter=key.length===1&& key!=" ";
    // console.log({key,expected});
    const isSpace =key ===" ";
    const isbackspace = key=== 'Backspace';
    const isFirstLetter=currentLetter===currentWord.firstChild;

if(document.querySelector("#game.over")){
    return;
}

if(!window.timer && isLetter){
    window.timer = setInterval(()=>{
    if(!window.gameStart){
        window.gameStart = (new Date()).getTime(); // just to get the time from the Date datatype
    }
    const currenttime = (new Date()).getTime();
    const msPassed = currenttime - window.gameStart;
    const sPassed = Math.round(msPassed/1000);
    const sLeft = (gameTime /1000) -sPassed;
    if(sLeft <=0){
        gameOver();
        return;
    }
    document.getElementById("info").innerHTML=sLeft+"";

    },1000); // updated every second. and the first parameters will be handler function to update the value
}

if (isLetter){
    if(currentLetter){
        addClass(currentLetter,key===expected?"correct":"incorrect");
        removeClass(currentLetter,'current');
        if(currentLetter.nextSibling){
            addClass(currentLetter.nextSibling,'current');
        }
        

    }
    else{
        const incorrectLetter = document.createElement("span");
        incorrectLetter.innerHTML = key;
        incorrectLetter.className="letter incorrect extra";
        currentWord.appendChild(incorrectLetter);
    }
}
// if (isSpace){
//     if(expected!==" "){
//         const restOfLetter = [...document.querySelectorAll('.word.current .letter:not(.correct)')];
//         restOfLetter.forEach(letter=>{
//             addClass(letter,"incorrect");
//         });
//     }
//     removeClass(currentWord,"current");
//     addClass(currentWord.nextSibling,"current");
//     if(currentLetter){
//         removeClass(currentLetter,'current');
//     }
//     addClass(currentWord.nextSibling.firstChild,'current');
// }
if (isSpace){
    
    if(currentLetter){
        removeClass(currentLetter,"current");
        if(currentLetter.nextSibling){
        addClass(currentLetter.nextSibling,"current");
        addClass(currentLetter,"incorrect");
        }
    
        else{
            addClass(currentWord.nextSibling.firstChild,'current');
            addClass(currentWord.nextSibling,'current');
            removeClass(currentWord,'current');
            addClass(currentLetter,"incorrect");
        }
    }
    else if(expected===" "){
        addClass(currentWord.nextSibling.firstChild,'current');
        addClass(currentWord.nextSibling,'current');
        removeClass(currentWord,'current');
    }
}



if(isbackspace){
    if(currentLetter&& isFirstLetter){
        // we will make the prevoius word cuurrent to the last letter currenntt
        removeClass(currentWord,'current');
        addClass(currentWord.previousSibling,"current");
        removeClass(currentLetter,"current");
        addClass(currentWord.previousSibling.lastChild,"current");
        removeClass(currentWord.previousSibling.lastChild,"incorrect")
        removeClass(currentWord.previousSibling.lastChild,"correct")
        if(currentWord.previousSibling.lastChild.classList.contains("extra")){
            
            addClass(currentWord.previousSibling.lastChild.previousSibling,"current");
            removeClass(currentWord.previousSibling.lastChild.previousSibling,"current");
            currentWord.previousSibling.lastChild.remove();
        }
    }
    if(currentLetter&& !isFirstLetter){
        // just one letter back
        removeClass(currentLetter,"current");
        addClass(currentLetter.previousSibling,"current");
        removeClass(currentLetter.previousSibling,"incorrect");
        removeClass(currentLetter.previousSibling,"correct");


    }
    if(!currentLetter){
        addClass(currentWord.lastChild,'current');
        removeClass(currentWord.lastChild,"incorrect");
        removeClass(currentWord.lastChild,"correct");
        if(currentWord.lastChild.classList.contains("extra")){
            // addClass(currentWord.lastChild.previousSibling,'current');
            if(!currentWord.lastChild.previousSibling.classList.contains("extra")){
            // removeClass(currentWord.lastChild.previousSibling,"incorrect");
            // removeClass(currentWord.lastChild.previousSibling,"correct");
            currentWord.lastChild.remove();
            }
            else{
                currentWord.lastChild.remove();
            removeClass(currentWord.lastChild,"current");

                
            }
            
        }
        
    }
}


//move the lines and show the wordds
if(currentWord.getBoundingClientRect().top >280){
    const words=document.getElementById('words');
    const margin = parseInt(words.style.marginTop||"0px");
    words.style.marginTop=(margin -35)+'px';
}



//end of the all event we will move the cursor
const nextLetter=document.querySelector(".letter.current");
const nextword = document.querySelector(".word.current");
const cursor =document.getElementById("cursor");
if(nextLetter){
    cursor.style.top=nextLetter.getBoundingClientRect().top +2+'px';
    cursor.style.left=nextLetter.getBoundingClientRect().left +'px';
}
else{
    cursor.style.left=nextword.getBoundingClientRect().right +'px';
}
})


newGame();
