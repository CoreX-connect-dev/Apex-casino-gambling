<!DOCTYPE html>
<html>
<head>
    <title>Game</title>
</head>

<body style="background:black; color:white; text-align:center;">

<h1>🎰 Simple Casino Game 🎰</h1>

<br>

<button onclick="play()" style="padding:10px 20px; background:yellow;">Spin</button>

<h2 id="result"></h2>

<br>

<a href="/games" style="color:yellow;">⬅ Back to Games</a>

<script>
function play() {
    let num = Math.floor(Math.random() * 10);
    document.getElementById("result").innerText = "Result: " + num;

    if(num == 7){
        document.getElementById("result").innerText += " 🎉 JACKPOT!";
    }
}
</script>

</body>
</html>