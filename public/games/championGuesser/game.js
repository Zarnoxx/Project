const URL = "https://ddragon.leagueoflegends.com/cdn/14.3.1/";
const APIUrl = "https://108464.cvoatweb.be";
let random = 0;
let champs = [];
let points = 0;
let counter = 15;
let timeDuration = 60

async function getChampions(){
    let response = await fetch(URL + "data/en_US/champion.json");
    const JSON = await response.json();
    Object.entries(JSON.data).forEach(element => {
        champs.push(element[0]);
        console.log(element);
    })
}

function endGame(message){
    alert(message);
    clearInterval(countdown);
    document.querySelector("#champImage").style.visibility = "hidden";
    document.querySelector("#start").style.visibility = "visible";
    document.querySelector("#timer").innerText = "Timer 00";
    document.querySelector('#points').value = '';
    document.querySelector('#guesses').value = '15';
}



async function timerStart(){

    timeDuration = 60;

    countdown = setInterval(function () {

        let seconds = timeDuration % 60;

        document.querySelector("#timer").innerText = "Timer " + seconds;

        if (timeDuration <= 0 || counter == 0) {
        clearInterval(countdown);
        endGame("Game over");
        } else {

        timeDuration = timeDuration - 1;
        }
    }, 1000);

}





document.querySelector("#start").addEventListener('click', async (event) => {
    await getChampions();
    timerStart();
    document.querySelector("#champImage").style.visibility = "visible";
    document.querySelector("#start").style.visibility = "hidden";
    random = champs[Math.floor(Math.random() * champs.length + 1)];
    while (random === 'Xayah' || random === 'Rakan' || random === 'Morgana' || random === 'Kayle') {
        random = champs[Math.floor(Math.random() * champs.length + 1)];
    }
    document.querySelector("#champImage").src = 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/' + random + '_0.jpg';
});

document.querySelector("#confirm").addEventListener('click',  () => {
    while (random === 'Xayah' || random === 'Rakan' || random === 'Morgana' || random === 'Kayle') {
        random = champs[Math.floor(Math.random() * champs.length + 1)];
    }
    if (document.querySelector('#guessChamp').value.toUpperCase().replace("'","").replace(" ","").replace("4","IV").replace("Wukong","MonkeyKing") === random.toUpperCase()) {
        document.querySelector('#points').innerText = points += 10;
        document.querySelector('#guessChamp').value = '';
    }
    document.querySelector('#guess').innerText = counter -= 1;
    document.querySelector('#guessChamp').value = '';
    random = champs[Math.floor(Math.random() * champs.length + 1)];
    document.querySelector("#champImage").src = 'https://ddragon.leagueoflegends.com/cdn/img/champion/splash/' + random + '_0.jpg';
});
