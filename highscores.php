<?php

$nicknames = array(

    "the Clickmaster",
    "the Orb Hoarder",
    "Crash Magnet",
    "the Button Masher",
    "Captain Oops",
    "the Mildly Adequate",
    "Pilot McWiggles",
    "Sufferer of Hyperspace Regret",
    "the Unlicensed Navigator",
    "the Rectangle Whisperer",
    "the Hovering Hazard",
    "the Flashbang Survivor",
    "the Wielder of Lag",
    "the Grob Whisperer",
    "Not a Robot (Probably)",
    "Manager of the Department of Clicks",
    "the Galactic Disappointment",
    "the Cosmic Distraction",
    "First of Their Name, Last in the Leaderboard",
    "Grob Fanatic",
    "Has Too Much Free Time",
    "Pizza Lover",
    "Sucks at This Game",
    "Sold Their House to Preorder Grob",
    "Cheater",
    "Just Lucky",
    "Shadaloo Cats Enthusiast"
);



function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if (($number % 100) >= 11 && ($number % 100) <= 13) {
        return $number . 'th';
    } else {
        return $number . $ends[$number % 10];
    }
}

function compare_scores($a, $b) {
    return $b['score'] - $a['score'];
}

$scores = array();

if (file_exists('scores.xml')) {
    $xml = simplexml_load_file('scores.xml');
    foreach ($xml->user as $user) {
        $scores[] = array(
            'name' => (string)$user['name'],
            'score' => (int)$user
        );
    }

    usort($scores, 'compare_scores');
}
?>
<!DOCTYPE html>
<html>
<head>
<title>High Scores</title>
<link href="https://fonts.googleapis.com/css?family=VT323" rel="stylesheet">
<style>

@keyframes animatedBackground {
	from { background-position: 0 0; }
	to { background-position: 0 100%; }
}

body {
	font-family: 'VT323', monospace;
    background-color: black;
	background-image: url("/rp2/assets/starry.gif");
	
	animation: animatedBackground 40s linear infinite;
}

h1 {
	font-family: 'VT323', monospace;
	font-size: 70px;
	padding-top: 50px;
	padding-bottom: 5px;
	margin-bottom: 5px;
    color: #7CFC00;
    text-align: center;
}

h2 {
	font-family: 'VT323', monospace;
	font-size: 40px;
	padding-bottom: 10px;
    color: green;
    text-align: center;
}



p {
    font-family: 'VT323', monospace;
	color: #7CFC00;
    font-size: 40px;
}

.override {
    font-family: 'VT323', monospace;
	color: green !important;
    font-size: 40px;
}

table {

transform: perspective( 200px ) rotateX( 5deg );
margin-bottom: 80px;

}

.blink_text {

    animation:1.5s blinker linear infinite;
    -webkit-animation:1.5s blinker linear infinite;
    -moz-animation:1.5s blinker linear infinite;

     color: red;
    }

    @-moz-keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }

    @-webkit-keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }

    @keyframes blinker {  
     0% { opacity: 1.0; }
     50% { opacity: 0.0; }
     100% { opacity: 1.0; }
     }
	 
	 .confirm_selection {
    animation: glow 2s infinite alternate;
}

@keyframes glow {
    to {
        text-shadow: 0 0 5px white;
    }
}

.confirm_selection {
    font-family: 'VT323', monospace;
	color: #7CFC00;
    font-size: 40px;
}

.marquee {
    width: 100%;
    margin: 0 auto;
    white-space: nowrap;
    overflow: hidden;
    box-sizing: border-box;
}

.marquee span {

    display: inline-block;
    padding-left: 100%;
    text-indent: 0;
    animation: marquee 15s linear infinite;
}
.marquee span:hover {
    animation-play-state: paused
}

@keyframes marquee {
    0%   { transform: translate(0, 0); }
    100% { transform: translate(-100%, 0); }
}

.name-wrapper {
    display: inline-block;
    text-align: center;
    line-height: 1;
}

.nickname {
    color: #00e6f6;
    font-size: 26px;
    text-shadow: 0 0 5px rgba(0, 230, 246, 0.6);
    margin-bottom: 2px;
    animation: glowTitle 2s infinite alternate;
}

.username {
    color: #7CFC00;
    font-size: 36px;
}

@keyframes glowTitle {
    from { text-shadow: 0 0 3px #00e6f6; }
    to { text-shadow: 0 0 8px #00ffff; }
}

</style>

</head>
<body>
<h1><span class="blink_text">HIGH SCORES</span></h1>
<table style="width:50%" align="center">
  <tr>
    <th><h2>RANK</h2></th>
    <th><h2>NAME</h2></th> 
    <th><h2>POINTS</h2></th>
  </tr>

<?php
$maxDisplayed = 10;
$runnerUps = array();

for ($i = 0; $i < count($scores); $i++) {
    $rank = $i + 1;

    if ($rank <= $maxDisplayed) {
        $ord = ordinal($rank);
        $name = htmlspecialchars($scores[$i]['name']);
$nickname = $nicknames[array_rand($nicknames)];
$displayName = '<div class="name-wrapper">
    <div class="nickname">' . $nickname . '</div>
    <div class="username">' . $name . '</div>
</div>';

        $score = $scores[$i]['score'];

        echo '<tr>';
        echo '<td><p align="center"><span class="confirm_selection">' . $ord . '</span></p></td>';
        echo '<td><div class="confirm_selection" style="text-align:center;">' . $displayName . '</div></td>';

        echo '<td><p align="center"><span class="confirm_selection">' . $score . '</span></p></td>';
        echo '</tr>';
    } else {
        $runnerUps[] = htmlspecialchars($scores[$i]['name']);
    }
}
?>
</table>

<?php if (count($runnerUps) > 0): ?>
<div class="marquee">
  <span><h2>RUNNER-UPS: <?php echo implode(', ', $runnerUps); ?></h2></span>
</div>
<?php endif; ?>

</body>
</html>
