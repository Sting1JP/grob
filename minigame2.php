<?php

require_once "/var/www/html/blocks/session.php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Go Grob</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow: hidden;
            background: linear-gradient(180deg, #0d1b2a, #1a1a2e);
            font-family: 'Press Start 2P', cursive;
        }

        #gameCanvas {
            width: 1000px;
            height: 700px;
            position: relative;
            overflow: hidden;
            border: 4px solid #00e6f6;
            box-shadow: 0 0 20px rgba(0, 230, 246, 0.3);
            cursor: pointer;
        }

        /* Stars */
        #stars1, #stars2, #stars3 {
            position: absolute;
            pointer-events: none;
        }

        .star {
            position: absolute;
            background: #ffffff;
            border-radius: 50%;
            opacity: 0.9;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }

        #stars1 .star { width: 2px; height: 2px; }
        #stars2 .star { width: 3px; height: 3px; }
        #stars3 .star { width: 4px; height: 4px; }

    
        /* Pixel Layers */
        #bgLayer, #fgLayer {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .pixelBlock {
            position: absolute;
            background: #0f3460;
            image-rendering: pixelated;
        }

        /* Spaceship with Improved Trail */
        #spaceship {
    width: 120px;
    height: 99px;
    background: url('sprite2.png') no-repeat;
    background-size: contain;
    position: absolute;
    z-index: 10;
    overflow: visible;
    transition: transform 0.2s ease-out; /* Smooth transition */
}

        #spaceship::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 15px;
            background: rgba(255, 68, 68, 0.5);
            left: -30px;
            top: 59%;
            transform: translateY(-50%);
            border-radius: 50% 0 0 50%;
            filter: blur(3px);
            animation: pulse 0.3s infinite alternate;
        }

    #spaceship.hyperspeed::after {
    width: 120px;
    height: 25px;
    background: rgba(0, 170, 255, 0.6); /* 🔵 blue glow */
    left: -110px;
    top: 55%;
    transform: translateY(-50%) scaleY(1.5);
    filter: blur(4px);
    animation: pulseHyper 0.05s infinite alternate;
}

        @keyframes pulse {
            from { opacity: 0.6; }
            to { opacity: 1; }
        }

        @keyframes pulseHyper {
    from { opacity: 0.7; transform: translateY(-50%) scaleY(1.4); }
    to   { opacity: 1;   transform: translateY(-50%) scaleY(1.6); }
}

        .obstacle {
            width: 90px;
            height: 150px;
            background: linear-gradient(135deg, #00adb5, #006d75);
            position: absolute;
            border: 2px solid #00e6f6;
            box-shadow: 0 0 10px rgba(0, 173, 181, 0.5);
            z-index: 5;
        }

        #score {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #00e6f6;
            font-size: 28px;
            text-shadow: 0 0 5px rgba(0, 230, 246, 0.7);
            z-index: 15;
        }

        #gameOver {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #ff4444;
    font-size: 64px;
    text-shadow: 2px 2px 0 #000, -2px -2px 0 #000, 2px -2px 0 #000, -2px 2px 0 #000,
                 0 0 15px rgba(255, 68, 68, 0.8);
    display: none;
    z-index: 15;
    line-height: 1.2;
    text-align: center;
    animation: pulseGlow 1.8s ease-in-out infinite;
    user-select: none;
}

        @keyframes pulseGlow {
    0% {
        transform: translate(-50%, -50%) scale(1);
        text-shadow: 2px 2px 0 #000, -2px -2px 0 #000,
                     2px -2px 0 #000, -2px 2px 0 #000,
                     0 0 15px rgba(255, 68, 68, 0.8),
                     0 0 30px rgba(255, 68, 68, 0.6);
    }
    50% {
        transform: translate(-50%, -50%) scale(1.08);
        text-shadow: 2px 2px 0 #000, -2px -2px 0 #000,
                     2px -2px 0 #000, -2px 2px 0 #000,
                     0 0 25px rgba(255, 68, 68, 1),
                     0 0 40px rgba(255, 0, 0, 0.9);
    }
    100% {
        transform: translate(-50%, -50%) scale(1);
        text-shadow: 2px 2px 0 #000, -2px -2px 0 #000,
                     2px -2px 0 #000, -2px 2px 0 #000,
                     0 0 15px rgba(255, 68, 68, 0.8),
                     0 0 30px rgba(255, 68, 68, 0.6);
    }
}

        /* Glowing Orb */
        .orb {
    width: 30px;
    height: 30px;
    position: absolute;
    z-index: 8;
    border-radius: 50%;
    background: radial-gradient(circle at center, 
        rgba(255, 215, 0, 1) 0%, 
        rgba(255, 165, 0, 0.6) 60%, 
        rgba(255, 140, 0, 0.2) 85%, 
        transparent 100%);
    box-shadow: 0 0 12px 6px rgba(255, 200, 0, 0.5);
    animation: glow 1.5s infinite alternate;
    pointer-events: none;
}


        @keyframes glow {
            from { transform: scale(0.9); opacity: 0.8; }
            to { transform: scale(1.1); opacity: 1; }
        }

        /* Hyperspeed Effect on Spaceship */
        .hyperspeed {
    position: relative;
    animation: hyperspeedPulse 0.2s infinite alternate;
}

.hyperspeed::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 160px;
    height: 160px;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 150, 0.3) 0%, rgba(255, 215, 0, 0.5) 40%, transparent 80%);
    filter: blur(8px);
    z-index: -1;
    animation: glowPulse 0.3s infinite alternate;
    pointer-events: none;
}

        @keyframes hyperspeedPulse {
            from { transform: scale(1); }
            to { transform: scale(1.05); }
        }

        /* Obstacle Break Effect */
        .break {
            animation: breakApart 0.5s forwards;
        }

        @keyframes breakApart {
            0% { opacity: 1; transform: scale(1); }
            100% { opacity: 0; transform: scale(1.5) rotate(45deg); }
        }

        /* Lightspeed Mode Effects */
#gameCanvas.lightspeed {
    animation: warpFlash 0.3s ease-in-out;
    box-shadow: 0 0 60px rgba(255, 255, 100, 0.6), 0 0 120px rgba(255, 255, 100, 0.3) inset;
    border-color: #fff700;
    background: radial-gradient(circle at center, #111, #0d1b2a 60%, #1a1a2e);
    width: 100%;
}

@keyframes warpFlash {
    0% { box-shadow: 0 0 5px rgba(255,255,255,0.2); }
    50% { box-shadow: 0 0 60px rgba(255, 255, 255, 0.8); }
    100% { box-shadow: 0 0 30px rgba(255, 255, 255, 0.4); }
}

/* Screen flash effect */
#gameCanvas.flash {
    animation: flashIn 0.4s ease-out;
}

@keyframes flashIn {
    0% {
        background-color: rgba(255,255,255,0.9);
    }
    100% {
        background-color: transparent;
    }
}


/* Intense screenshake */
#gameCanvas.shake {
    animation: screenshake 0.05s infinite;
}

@keyframes screenshake {
    0% { transform: translate(4px, -3px); }
    25% { transform: translate(-3px, 3px); }
    50% { transform: translate(3px, -3px); }
    75% { transform: translate(-2px, 2px); }
    100% { transform: translate(2px, -1px); }
}

/* Even more intense shake for obstacle impact */
#gameCanvas.extreme-shake {
    animation: extremeShake 0.03s infinite;
}

@keyframes extremeShake {
    0% { transform: translate(4px, 4px) rotate(0.5deg); }
    25% { transform: translate(-5px, -3px) rotate(-0.5deg); }
    50% { transform: translate(3px, 5px) rotate(0.5deg); }
    75% { transform: translate(-4px, 3px) rotate(-0.5deg); }
    100% { transform: translate(2px, -4px) rotate(0.5deg); }
}

#flashOverlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: white;
    opacity: 0;
    pointer-events: none;
    z-index: 9999;
    transition: opacity 0.1s ease-out;
}
#flashOverlay.active {
    opacity: 0.8;
    transition: opacity 0.2s ease-out;
}

#gameCanvas.hyperspeed-exit {
    width: 1000px; /* restore original width */
    transition: width 1s ease, box-shadow 1s, border-color 1s;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.3), 0 0 40px rgba(255, 255, 255, 0.15) inset;
    border-color: #eeee88;
}

#highScore {
    position: absolute;
    top: 20px;
    right: 20px;
    color: #ffee88;
    font-size: 20px;
    text-shadow: 0 0 5px rgba(255, 255, 100, 0.6);
    z-index: 15;
    font-family: 'Press Start 2P', cursive;
}


.highScore {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 20px; /* 👈 spacing between buttons */
    z-index: 20;
}

.highScore a {
    padding: 12px 24px;
    background: #0f1a2b;
    color: #00e6f6;
    font-size: 14px;
    text-decoration: none;
    border: 2px solid #00e6f6;
    border-radius: 8px;
    text-shadow: 0 0 5px rgba(0, 230, 246, 0.7);
    box-shadow: 0 0 15px rgba(0, 230, 246, 0.3);
    transition: background 0.3s, color 0.3s, transform 0.2s;
    font-family: 'Press Start 2P', cursive;
    text-align: center;
    white-space: nowrap;
}

.highScore a:hover {
    background: #00e6f6;
    color: #0f1a2b;
    transform: scale(1.05);
    box-shadow: 0 0 25px rgba(0, 230, 246, 0.5);
}


#canvasWrapper {
    width: 1000px;
    margin: 40px auto;
    transition: width 1s ease;
    background: linear-gradient(180deg, #0d1b2a, #1a1a2e); /* moved here! */
    position: relative;     /* 🔥 Add this */
    overflow: visible;      /* 🔥 Ensure Grob can fly beyond bounds */
}

#canvasWrapper.expanded {
  width: 100%;
}

/* Spaceship explosion effect */
@keyframes explode {
    0% {
        opacity: 1;
        transform: scale(1) rotate(0deg);
        filter: brightness(1);
    }
    50% {
        transform: scale(1.5) rotate(90deg);
        filter: brightness(1.5);
    }
    100% {
        opacity: 0;
        transform: scale(0) rotate(180deg);
        filter: brightness(0);
    }
}

#spaceship.exploding {
    animation: explode 0.2s ease-out forwards;
    pointer-events: none;
}

.explosion-emoji {
    position: absolute;
    font-size: 24px;
    animation: flyOut 1.5s ease-out forwards; /* Longer duration */
    opacity: 0.9;
    z-index: 20;
    pointer-events: none;
    --spin: 720deg;
}

@keyframes flyOut {
    0% {
        transform: translate(0, 0) scale(0.8) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translate(var(--x), var(--y)) scale(1.6) rotate(var(--spin));
        opacity: 0;
    }
}
.explosion-flash {
    position: absolute;
    width: 140px;
    height: 140px;
    border-radius: 50%;
    pointer-events: none;
    z-index: 9999;
    transform: translate(-50%, -50%);
    animation: explodeFlash 0.5s ease-out forwards;
    transform-origin: center center;
    mix-blend-mode: screen;
    background: radial-gradient(
    circle at center,
    rgba(255, 120, 120, 0.95) 0%,
    rgba(255, 80, 80, 0.4) 35%,
    transparent 55%,
    rgba(255, 60, 60, 0.25) 60%,
    transparent 80%
);
filter: blur(3px) contrast(120%);

    margin-left: -40px;  /* nudges left */
    margin-top: -40px;   /* nudges up */
}


@keyframes explodeFlash {
  0% { transform: scale(1, 1) rotate(20deg); opacity: 1; }
  30% { transform: scale(1.5, 0.8) rotate(-10deg); }
  100% { transform: scale(2, 1.2) rotate(30deg); opacity: 0; }
}

#uselessTips {
    margin-top: 20px;
    font-size: 16px;
    color: #ffee88;
    text-shadow: 0 0 5px rgba(255, 255, 136, 0.7);
}


    </style>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>

<audio id="hyperspeedSfx" preload="auto">
  <source src="hyperspeed.mp3" type="audio/mpeg">
</audio>

<audio id="warpSfx" preload="auto">
  <source src="warp.mp3" type="audio/mpeg">
</audio>

<audio id="gameoverSfx" preload="auto">
  <source src="gameover.mp3" type="audio/mpeg">
</audio>

<audio id="crashSfx" preload="auto">
  <source src="crash2.mp3" type="audio/mpeg">
</audio>

<audio id="screamSfx" preload="auto">
  <source src="scream2.mp3" type="audio/mpeg">
</audio>

<audio id="collisionSfx" preload="auto">
  <source src="collision.mp3" type="audio/mpeg">
</audio>

<?php
$bgTracks = ['grobbintime.mp3', 'gogrob.mp3'];
$selectedTrack = $bgTracks[array_rand($bgTracks)];
?>
<audio id="bgMusic" preload="auto" loop>
  <source src="<?= htmlspecialchars($selectedTrack) ?>" type="audio/mpeg">
</audio>
<div id="highScore">High Score: 0</div>
<div id="flashOverlay"></div>
<div id="canvasWrapper">
    <div id="gameCanvas">
        <div id="stars1"></div>
        <div id="stars2"></div>
        <div id="stars3"></div>
        <div id="bgLayer"></div>
        <div id="spaceship"></div>
        <div id="fgLayer"></div>
        <div id="score">Score: 0</div>
        <div id="gameOver">
    GAME<br>OVER
    <div id="uselessTips">Tip: Never trust a banana in hyperspace.</div>
</div>
    </div>
    </div>
    <div class="highScore">
    <a href="highscores.php">High Scores</a>
    <a href="webmanual.php">Web Manual</a>
</div>
<script>
        // ### Constants
        const CANVAS_WIDTH = 1000;
        const CANVAS_HEIGHT = 700;
        const SHIP_WIDTH = 120;
        const SHIP_HEIGHT = 99;
        const OBSTACLE_WIDTH = 60;
        const ORB_WIDTH = 30;
        const ORB_HEIGHT = 30;
        const INITIAL_SHIP_X = 150;
        const INITIAL_SHIP_Y = 330; // From PHP
        const BASE_SPEED = 15;
        const HYPERSPEED_MULTIPLIER = 14;
        const GRAVITY = 0.8;
        const LIFT = -15;
        const MIN_GAP = 200;
        const MAX_OBSTACLE_HEIGHT = 400;
        const ORB_SPAWN_CHANCE = 0.1;
        const NARRATION_INTERVAL = 10000;
        const DEATH_NARRATION_DELAY = 400;
        const HYPERSPEED_DURATION = 5000;
        const POST_HYPERSPEED_BUFFER = 800;
        const EXPLOSION_DURATION = 600;
        const FLASH_DURATION = 300;
        const COLLISION_SFX_VOLUME = 0.55;
        const GAMEOVER_SFX_VOLUME = 1.0;
        const SCREAM_SFX_VOLUME = 0.25;
        const WARP_SFX_VOLUME = 0.45;
        const HYPERSPEED_SFX_VOLUME = 0.65;
        const BG_MUSIC_VOLUME = 0.2;

        // ### AudioManager Class
        class AudioManager {
            constructor() {
                this.narrations = this.loadNarrationFiles(42, 'narr', 'narr');
                this.deathNarrations = this.loadNarrationFiles(20, 'narrdeath', 'narrdeath');
                this.currentNarration = null;
                this.currentDeathNarration = null;
                this.narrationInterval = null;
                this.narrationPausedDueToDeath = false;

                this.bgMusic = document.getElementById('bgMusic');
                this.bgMusic.volume = BG_MUSIC_VOLUME;
                this.audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                this.sourceNode = this.audioCtx.createMediaElementSource(this.bgMusic);

                // Clean audio path
                this.cleanGain = this.audioCtx.createGain();
                this.cleanGain.gain.value = 1.0;
                this.sourceNode.connect(this.cleanGain);
                this.cleanGain.connect(this.audioCtx.destination);

                // Muffled audio path
                this.filterNode = this.audioCtx.createBiquadFilter();
                this.filterNode.type = 'lowpass';
                this.filterNode.frequency.value = 900;
                this.convolverNode = this.audioCtx.createConvolver();
                this.convolverNode.buffer = this.createMuffleImpulse();
                this.muffledGain = this.audioCtx.createGain();
                this.muffledGain.gain.value = 0.0;
                this.sourceNode.connect(this.filterNode);
                this.filterNode.connect(this.convolverNode);
                this.convolverNode.connect(this.muffledGain);
                this.muffledGain.connect(this.audioCtx.destination);
            }

            loadNarrationFiles(count, path, prefix) {
                const audios = [];
                for (let i = 1; i <= count; i++) {
                    const audio = new Audio(`${path}/${prefix}${i}.mp3`);
                    audio.preload = 'auto';
                    audios.push(audio);
                }
                return audios;
            }

            createMuffleImpulse() {
                const length = 0.3 * this.audioCtx.sampleRate;
                const impulse = this.audioCtx.createBuffer(2, length, this.audioCtx.sampleRate);
                for (let ch = 0; ch < 2; ch++) {
                    const channel = impulse.getChannelData(ch);
                    for (let i = 0; i < length; i++) {
                        channel[i] = (Math.random() * 2 - 1) * (1 - i / length);
                    }
                }
                return impulse;
            }

            startNarrationLoop(interval = NARRATION_INTERVAL) {
                this.narrationInterval = setInterval(() => this.playRandomNarration(), interval);
                setTimeout(() => this.playRandomNarration(), 1000); // Initial narration
            }

            playRandomNarration() {
                if (
    this.narrationPausedDueToDeath ||
    (this.currentNarration && !this.currentNarration.ended) ||
    (this.currentDeathNarration && !this.currentDeathNarration.ended)
) return;

                const audio = this.narrations[Math.floor(Math.random() * this.narrations.length)];
                this.currentNarration = audio;
                audio.volume = 1;
                audio.play();
            }

            playDeathNarration() {
                if (this.currentNarration && !this.currentNarration.paused) {
                    this.currentNarration.pause();
                    this.currentNarration.currentTime = 0;
                }
                clearInterval(this.narrationInterval);
                this.currentNarration = null;
                this.narrationPausedDueToDeath = true;

                const deathAudio = this.deathNarrations[Math.floor(Math.random() * this.deathNarrations.length)];
                this.currentDeathNarration = deathAudio;
                deathAudio.onended = () => {
                    this.currentDeathNarration = null;
                    this.narrationPausedDueToDeath = false;
                };
                setTimeout(() => {
                    deathAudio.volume = 1;
                    deathAudio.currentTime = 0;
                    deathAudio.play().catch(e => console.warn('Death narration error:', e));
                }, DEATH_NARRATION_DELAY);
            }

            muffleMusic() {
                this.cleanGain.gain.setTargetAtTime(0.2, this.audioCtx.currentTime, 0.3);
                this.muffledGain.gain.setTargetAtTime(2.5, this.audioCtx.currentTime, 0.3);
            }

            clearMuffle() {
                this.cleanGain.gain.setTargetAtTime(1.0, this.audioCtx.currentTime, 0.3);
                this.muffledGain.gain.setTargetAtTime(0.0, this.audioCtx.currentTime, 0.3);
            }

            fastMusic() {
                this.bgMusic.playbackRate = 1.3;
            }

            slowDownMusic() {
                this.bgMusic.playbackRate = 0.4;
            }

            restoreMusicSpeedSmoothly(targetRate = 1.0, duration = 1200) {
                const startRate = this.bgMusic.playbackRate;
                const startTime = performance.now();
                const animate = (time) => {
                    const elapsed = time - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    this.bgMusic.playbackRate = startRate + (targetRate - startRate) * progress;
                    if (progress < 1) requestAnimationFrame(animate);
                };
                requestAnimationFrame(animate);
            }
        }

        // ### CheatManager Class
        class CheatManager {
            constructor(game) {
                this.game = game;
                this.cheatCode = '';
                this.cheatCodeTarget = 'groovy';
                this.cheatActivated = false;
                this.cheatCodeTargetBig = 'bighead';
                this.bigSpriteActivated = false;
                this.cheatCodeTargetGhost = 'ghost';
                this.invisibleActivated = false;
                document.addEventListener('keydown', this.handleKeyDown.bind(this));
            }

            handleKeyDown(e) {
                this.cheatCode += e.key.toLowerCase();
                const maxLen = Math.max(
                    this.cheatCodeTarget.length,
                    this.cheatCodeTargetBig.length,
                    this.cheatCodeTargetGhost.length
                );
                if (this.cheatCode.length > maxLen) {
                    this.cheatCode = this.cheatCode.slice(-maxLen);
                }

                if (this.cheatCode.includes(this.cheatCodeTarget) && !this.cheatActivated) {
                    this.activateCheat();
                }
                if (this.cheatCode.includes(this.cheatCodeTargetBig) && !this.bigSpriteActivated) {
                    this.activateBigSpriteCheat();
                }
                if (this.cheatCode.includes(this.cheatCodeTargetGhost) && !this.invisibleActivated) {
                    this.activateInvisibleCheat();
                }
            }

            activateCheat() {
                this.cheatActivated = true;
                if (!this.game.gameRunning) this.game.reset();
                this.game.activateHyperspeed();
                this.game.hyperspeedTimer = Infinity;
                this.flashScreen();
            }

            activateBigSpriteCheat() {
                this.bigSpriteActivated = true;
                this.game.setShipTransform({ scale: 2 });
                this.flashScreen();
            }

            activateInvisibleCheat() {
                this.invisibleActivated = true;
                this.game.spaceship.style.opacity = '0';
                this.flashScreen();
            }

            flashScreen() {
                const flashOverlay = document.getElementById('flashOverlay');
                flashOverlay.classList.add('active');
                setTimeout(() => flashOverlay.classList.remove('active'), FLASH_DURATION);
            }
        }

        // ### Game Class
        class Game {
            constructor() {
                this.canvas = document.getElementById('gameCanvas');
                this.spaceship = document.getElementById('spaceship');
                this.scoreElement = document.getElementById('score');
                this.gameOverElement = document.getElementById('gameOver');
                this.highScoreElement = document.getElementById('highScore');

                this.shipWidth = SHIP_WIDTH;
                this.shipHeight = SHIP_HEIGHT;
                this.shipX = INITIAL_SHIP_X;
                this.shipY = INITIAL_SHIP_Y;
                this.velocity = 0;
                this.gravity = GRAVITY;
                this.lift = LIFT;
                this.score = 0;
                this.highScore = parseInt(localStorage.getItem('grobHighScore')) || 0;
                this.updateHighScoreDisplay();
                this.obstacles = [];
                this.orbs = [];
                this.gameRunning = true;
                this.lastObstacleY = 0;
                this.isHyperspeed = false;
                this.hyperspeedTimer = 0;
                this.baseSpeed = BASE_SPEED;
                this.hyperspeedMultiplier = HYPERSPEED_MULTIPLIER;
                this.hyperspeedFadeOut = 0;
                this.postHyperspeedBuffer = 0;
                this.currentRotation = 0;
                this.currentScale = 1;
                this.explosionDone = true;

                this.spaceship.style.left = this.shipX + 'px';
                this.spaceship.style.top = this.shipY + 'px';

                this.audioManager = new AudioManager();
                this.audioManager.startNarrationLoop();

                this.cheatManager = new CheatManager(this);

                this.initStars();
                this.initPixelLayers();
                this.bindEvents();
                this.gameLoop();
                this.spawnObstacles();
                this.spawnOrbs();
            }

            updateHighScoreDisplay() {
                this.highScoreElement.textContent = `High Score: ${this.highScore}`;
            }

            initStars() {
                const createStars = (layerId, count) => {
                    const layer = document.getElementById(layerId);
                    layer.innerHTML = ''; // Clear previous stars
                    const canvasWidth = this.canvas.getBoundingClientRect().width;
                    const canvasHeight = this.canvas.getBoundingClientRect().height;

                    layer.style.width = canvasWidth + 'px';
                    layer.style.height = canvasHeight + 'px';

                    for (let i = 0; i < count; i++) {
                        const star = document.createElement('div');
                        star.className = 'star';
                        star.style.left = Math.random() * canvasWidth + 'px';
                        star.style.top = Math.random() * canvasHeight + 'px';
                        layer.appendChild(star);
                    }
                };

                createStars('stars1', 60);
                createStars('stars2', 40);
                createStars('stars3', 25);
            }

            initPixelLayers() {
                const bgLayer = document.getElementById('bgLayer');
                const fgLayer = document.getElementById('fgLayer');

                for (let i = 0; i < 5; i++) {
                    const block = document.createElement('div');
                    block.className = 'pixelBlock';
                    block.style.width = '20px';
                    block.style.height = '20px';
                    block.style.left = Math.random() * CANVAS_WIDTH + 'px';
                    block.style.top = Math.random() * CANVAS_HEIGHT + 'px';
                    block.style.opacity = '0.5';
                    bgLayer.appendChild(block);
                }

                for (let i = 0; i < 3; i++) {
                    const block = document.createElement('div');
                    block.className = 'pixelBlock';
                    block.style.width = '10px';
                    block.style.height = '10px';
                    block.style.left = Math.random() * CANVAS_WIDTH + 'px';
                    block.style.top = Math.random() * CANVAS_HEIGHT + 'px';
                    block.style.opacity = '0.7';
                    fgLayer.appendChild(block);
                }
            }

            bindEvents() {
                this.canvas.addEventListener('click', () => {
                    if (this.audioManager.audioCtx.state === 'suspended') {
        this.audioManager.audioCtx.resume();
    }



                    if (this.gameRunning) {
                        this.velocity = this.lift;
                        this.setShipTransform({ rotate: -15, scale: this.cheatManager.bigSpriteActivated ? 2 : 1 });
                        setTimeout(() => {
                            this.setShipTransform({ rotate: 0, scale: this.cheatManager.bigSpriteActivated ? 2 : 1 });
                        }, 200);
                    } else if (this.explosionDone) {
                        this.reset();
                    }
                });
            }

            setShipTransform({ rotate = 0, scale = 1 }) {
                this.currentRotation = rotate;
                this.currentScale = scale;
                this.spaceship.style.transform = `scale(${scale}) rotate(${rotate}deg)`;
            }

            spawnObstacles() {
                if (!this.gameRunning) return;

                const obstacle = document.createElement('div');
                obstacle.className = 'obstacle';
                const isTop = Math.random() > 0.5;
                let height;

                if (isTop) {
                    height = Math.min(Math.random() * MAX_OBSTACLE_HEIGHT, CANVAS_HEIGHT - MIN_GAP - this.lastObstacleY);
                } else {
                    height = Math.min(Math.random() * MAX_OBSTACLE_HEIGHT, this.lastObstacleY - MIN_GAP);
                }
                height = Math.max(height, 180);

                obstacle.style.height = height + 'px';
                obstacle.style.left = CANVAS_WIDTH + 'px';
                obstacle.style.top = isTop ? '0px' : (CANVAS_HEIGHT - height) + 'px';

                this.canvas.appendChild(obstacle);
                this.obstacles.push({
                    element: obstacle,
                    x: CANVAS_WIDTH,
                    isTop: isTop,
                    height: height
                });

                this.lastObstacleY = isTop ? height : CANVAS_HEIGHT - height;
                setTimeout(() => this.spawnObstacles(), 1500 + Math.random() * 600);
            }

            spawnOrbs() {
                if (!this.gameRunning || this.isHyperspeed) {
                    setTimeout(() => this.spawnOrbs(), 1000);
                    return;
                }

                if (Math.random() < ORB_SPAWN_CHANCE) {
                    const orb = document.createElement('div');
                    orb.className = 'orb';
                    const orbY = Math.random() * (CANVAS_HEIGHT - ORB_HEIGHT);
                    orb.style.left = CANVAS_WIDTH + 'px';
                    orb.style.top = orbY + 'px';
                    this.canvas.appendChild(orb);
                    this.orbs.push({
                        element: orb,
                        x: CANVAS_WIDTH,
                        y: orbY,
                        width: ORB_WIDTH,
                        height: ORB_HEIGHT
                    });
                }
                setTimeout(() => this.spawnOrbs(), 1000);
            }

            checkOrbCollision() {
                const scale = this.cheatManager.bigSpriteActivated ? 2 : 1;
                const offsetY = this.cheatManager.bigSpriteActivated ? (this.shipHeight * (scale - 1)) / 2 : 0;
                const shipRect = {
                    x: this.shipX,
                    y: this.shipY - offsetY,
                    width: this.shipWidth * scale,
                    height: this.shipHeight * scale
                };

                this.orbs.forEach((orb, index) => {
                    const orbRect = {
                        x: orb.x,
                        y: orb.y,
                        width: orb.width,
                        height: orb.height
                    };

                    if (
                        shipRect.x < orbRect.x + orbRect.width &&
                        shipRect.x + shipRect.width > orbRect.x &&
                        shipRect.y < orbRect.y + orbRect.height &&
                        shipRect.y + shipRect.height > orbRect.y
                    ) {
                        this.orbs[index].element.remove();
                        this.orbs.splice(index, 1);
                        this.activateHyperspeed();
                    }
                });
            }

            activateHyperspeed() {
                this.isHyperspeed = true;
                this.audioManager.muffleMusic();
                this.audioManager.fastMusic();

                const hyperspeedSfx = document.getElementById('hyperspeedSfx');
                hyperspeedSfx.volume = HYPERSPEED_SFX_VOLUME;
                hyperspeedSfx.play().catch(e => console.warn('Hyperspeed SFX error:', e));

                const warpSfx = document.getElementById('warpSfx');
                warpSfx.volume = WARP_SFX_VOLUME;
                warpSfx.play().catch(e => console.warn('Warp SFX error:', e));

                if (!this.cheatManager.cheatActivated) {
                    this.hyperspeedTimer = HYPERSPEED_DURATION;
                }

                this.spaceship.classList.add('hyperspeed');
                document.getElementById('canvasWrapper').classList.add('expanded');
                this.canvas.classList.add('lightspeed', 'flash', 'shake');

                setTimeout(() => {
                    const canvasWidth = this.canvas.getBoundingClientRect().width;
                    ['stars1', 'stars2', 'stars3'].forEach(id => {
                        const layer = document.getElementById(id);
                        layer.style.width = canvasWidth + 'px';
                    });
                    this.initStars();
                }, 600);

                this.orbs.forEach(orb => orb.element.remove());
                this.orbs = [];

                setTimeout(() => this.canvas.classList.remove('flash'), 400);
            }

            updateHyperspeed() {
                if (this.isHyperspeed) {
                    this.hyperspeedTimer -= 1000 / 60;
                    if (this.hyperspeedTimer <= 0) {
                        this.isHyperspeed = false;
                        this.hyperspeedFadeOut = 1;
                        this.postHyperspeedBuffer = POST_HYPERSPEED_BUFFER;
                        this.canvas.classList.add('hyperspeed-exit');
                        setTimeout(() => {
                            this.spaceship.classList.remove('hyperspeed');
                            document.getElementById('canvasWrapper').classList.remove('expanded');
                            this.canvas.classList.remove('lightspeed', 'shake', 'extreme-shake');
                            this.canvas.classList.add('hyperspeed-exit');
                            this.audioManager.clearMuffle();
                            this.audioManager.restoreMusicSpeedSmoothly();
                            setTimeout(() => this.canvas.classList.remove('hyperspeed-exit'), 1200);
                        }, 200);
                    }
                } else if (this.hyperspeedFadeOut > 0) {
                    this.hyperspeedFadeOut -= 0.01;
                    if (this.hyperspeedFadeOut < 0) this.hyperspeedFadeOut = 0;
                }
            }

            update() {
                if (!this.gameRunning) return;
                this.updateSpaceship();
                this.updateObstacles();
                this.updateOrbs();
                this.checkOrbCollision();
                this.updateHyperspeed();
                if (this.postHyperspeedBuffer > 0) {
                    this.postHyperspeedBuffer -= 1000 / 60;
                    if (this.postHyperspeedBuffer < 0) this.postHyperspeedBuffer = 0;
                }
                this.moveLayers();
            }

            updateSpaceship() {
                this.velocity += this.gravity;
                this.shipY += this.velocity;
                this.spaceship.style.top = this.shipY + 'px';

                if (this.shipY < 0) {
                    this.shipY = 0;
                    this.velocity = 0;
                    if (!this.isHyperspeed && this.hyperspeedFadeOut <= 0 && this.postHyperspeedBuffer <= 0) {
                        this.gameOver();
                    }
                }
                if (this.shipY > CANVAS_HEIGHT - this.shipHeight) {
                    this.shipY = CANVAS_HEIGHT - this.shipHeight;
                    this.velocity = 0;
                    if (!this.isHyperspeed && this.hyperspeedFadeOut <= 0 && this.postHyperspeedBuffer <= 0) {
                        this.gameOver();
                    }
                }
            }

            updateObstacles() {
                const speedFactor = this.isHyperspeed
                    ? this.hyperspeedMultiplier
                    : 1 + this.hyperspeedFadeOut * (this.hyperspeedMultiplier - 1);
                const currentSpeed = this.baseSpeed * speedFactor;

                for (let i = this.obstacles.length - 1; i >= 0; i--) {
                    const obs = this.obstacles[i];
                    obs.x -= currentSpeed;
                    obs.element.style.left = obs.x + 'px';

                    if ((this.isHyperspeed || this.hyperspeedFadeOut > 0) && this.checkCollision(obs)) {
                        obs.element.classList.add('break');
                        this.canvas.classList.add('extreme-shake');
                        this.flashScreen();
                        setTimeout(() => this.canvas.classList.remove('extreme-shake'), 300);
                        setTimeout(() => obs.element.remove(), 500);
                        const collisionSfx = document.getElementById('collisionSfx');
                        collisionSfx.volume = COLLISION_SFX_VOLUME;
                        collisionSfx.play().catch(e => console.warn('Collision SFX error:', e));
                        this.obstacles.splice(i, 1);
                        this.score++;
                        this.scoreElement.textContent = `Score: ${this.score}`;
                    } else if (
                        !this.isHyperspeed &&
                        this.hyperspeedFadeOut <= 0 &&
                        this.postHyperspeedBuffer <= 0 &&
                        this.checkCollision(obs)
                    ) {
                        this.gameOver();
                    } else if (obs.x < -OBSTACLE_WIDTH) {
                        obs.element.remove();
                        this.obstacles.splice(i, 1);
                        this.score++;
                        this.scoreElement.textContent = `Score: ${this.score}`;
                    }
                }
            }

            updateOrbs() {
                const speedFactor = this.isHyperspeed
                    ? this.hyperspeedMultiplier
                    : 1 + this.hyperspeedFadeOut * (this.hyperspeedMultiplier - 1);
                const currentSpeed = this.baseSpeed * speedFactor;

                for (let i = this.orbs.length - 1; i >= 0; i--) {
                    const orb = this.orbs[i];
                    orb.x -= currentSpeed;
                    orb.element.style.left = orb.x + 'px';
                    if (orb.x < -ORB_WIDTH) {
                        orb.element.remove();
                        this.orbs.splice(i, 1);
                    }
                }
            }

            moveLayers() {
                this.moveLayer('stars1', this.isHyperspeed ? 3 * this.hyperspeedMultiplier : 0.7);
                this.moveLayer('stars2', this.isHyperspeed ? 6 * this.hyperspeedMultiplier : 1.3);
                this.moveLayer('stars3', this.isHyperspeed ? 10 * this.hyperspeedMultiplier : 2);
                this.moveLayer('bgLayer', this.isHyperspeed ? 6 * this.hyperspeedMultiplier : 1);
                this.moveLayer('fgLayer', this.isHyperspeed ? 12 * this.hyperspeedMultiplier : 2.5);
            }

            moveLayer(layerId, speed) {
                const layer = document.getElementById(layerId);
                const elements = layer.children;
                const canvasWidth = this.canvas.getBoundingClientRect().width;

                for (let el of elements) {
                    let x = parseFloat(el.style.left) - speed;
                    const elWidth = parseFloat(el.style.width || 20);
                    if (x < -elWidth) {
                        x = canvasWidth + Math.random() * 100;
                        el.style.top = Math.random() * CANVAS_HEIGHT + 'px';
                    }
                    el.style.left = x + 'px';
                }
            }

            checkCollision(obs) {
                const scale = this.cheatManager.bigSpriteActivated ? 2 : 1;
                const shipRect = {
                    x: this.shipX,
                    y: this.shipY,
                    width: this.shipWidth * scale,
                    height: this.shipHeight * scale
                };
                const obsRect = {
                    x: obs.x,
                    y: obs.isTop ? 0 : CANVAS_HEIGHT - obs.height,
                    width: OBSTACLE_WIDTH,
                    height: obs.height
                };
                return (
                    shipRect.x < obsRect.x + obsRect.width &&
                    shipRect.x + shipRect.width > obsRect.x &&
                    shipRect.y < obsRect.y + obsRect.height &&
                    shipRect.y + shipRect.height > obsRect.y
                );
            }

            flashScreen() {
                const flashOverlay = document.getElementById('flashOverlay');
                flashOverlay.classList.add('active');
                setTimeout(() => flashOverlay.classList.remove('active'), FLASH_DURATION);
            }

            createExplosion(centerX, centerY) {
                const emojis = ['💥', '🔥', '🦷', '🧠', '🤬', '⚙️', '🔩', '🍌', '💩'];
                const shuffled = emojis.slice();
                for (let i = shuffled.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
                }

                for (let i = 0; i < shuffled.length; i++) {
                    const emoji = document.createElement('div');
                    emoji.className = 'explosion-emoji';
                    emoji.innerText = shuffled[i];
                    emoji.style.left = centerX + 'px';
                    emoji.style.top = centerY + 'px';
                    const angle = Math.random() * 2 * Math.PI;
                    const distance = 800 + Math.random() * 100;
                    const x = Math.cos(angle) * distance + 'px';
                    const y = Math.sin(angle) * distance + 'px';
                    emoji.style.setProperty('--x', x);
                    emoji.style.setProperty('--y', y);
                    this.canvas.appendChild(emoji);
                    setTimeout(() => emoji.remove(), 1200);
                }

                const flash = document.createElement('div');
                flash.style.left = `${centerX}px`;
                flash.style.top = `${centerY}px`;
                flash.style.position = 'absolute';
                flash.style.transform = 'translate(-50%, -50%)';
                flash.style.zIndex = '10000';
                this.canvas.appendChild(flash);
                requestAnimationFrame(() => flash.classList.add('explosion-flash'));
                setTimeout(() => flash.remove(), 600);

                const deadImg = document.createElement('img');
                deadImg.src = 'dead2.png';
                deadImg.style.position = 'absolute';
                deadImg.style.width = '60px';
                deadImg.style.height = 'auto';
                deadImg.style.left = `${centerX}px`;
                deadImg.style.top = `${centerY}px`;
                deadImg.style.opacity = '1';
                deadImg.style.zIndex = 999;
                deadImg.style.pointerEvents = 'none';
                deadImg.style.transform = 'translate(-50%, -50%) scale(1.6) rotate(0deg)';
                deadImg.style.transformOrigin = 'center center';
                deadImg.style.transition = 'transform 2s ease-out';

                const angle = Math.PI / 5;
                const distance = 1800;
                const dx = Math.cos(angle) * distance;
                const dy = Math.sin(angle) * -distance;
                const spin = 60;

                requestAnimationFrame(() => {
                    deadImg.style.transform = `translate(${dx}px, ${dy}px) scale(3.5) rotate(${spin}deg)`;
                });

                const wrapper = document.getElementById('canvasWrapper');
                wrapper.appendChild(deadImg);
                setTimeout(() => deadImg.remove(), 2800);
            }

            gameOver() {
                this.audioManager.slowDownMusic();
                this.audioManager.playDeathNarration();

                const gameoverSfx = document.getElementById('gameoverSfx');
                gameoverSfx.volume = GAMEOVER_SFX_VOLUME;
                gameoverSfx.play().catch(e => console.warn('Gameover SFX error:', e));

                const crashSfx = document.getElementById('crashSfx');
                crashSfx.volume = 0.2;
                crashSfx.play().catch(e => console.warn('Crash SFX error:', e));

                const screamSfx = document.getElementById('screamSfx');
                screamSfx.volume = SCREAM_SFX_VOLUME;
                screamSfx.play().catch(e => console.warn('Scream SFX error:', e));

                this.gameRunning = false;
                this.explosionDone = false;
                const centerX = this.shipX + (this.shipWidth * this.currentScale) / 2;
                const centerY = this.shipY + (this.shipHeight * this.currentScale) / 2;
                this.createExplosion(centerX, centerY);

                const tips = [
                    "Tip: You have mastered the ancient art of crashing. Grob salutes you.",
                    "Tip: That rectangle definitely moved. Totally unfair.",
                    "Tip: Try yelling 'GO GROB!' louder next time. It probably helps.",
                    "Tip: If you're reading this, you're not clicking enough.",
                    "Tip: Space gravity: still undefeated.",
                    "Tip: Next time, blink less. Or more. We’re not sure.",
                    "Tip: Consider installing an actual steering wheel. It won't help.",
                    "Tip: Try pressing Alt+F4. It does... something. (Don’t actually.)",
                    "Tip: Don't name the obstacle Barry. Barry had a family.",
                    "Tip: Hyperspeed doesn't fix pilot error. We checked.",
                    "Tip: Pizza might improve reaction time. Worth testing.",
                    "Tip: If it glows, it goes. If it doesn't, it explodes.",
                    "Tip: You were only 872,948 clicks away from victory!",
                    "Tip: In space, no one can hear your excuses.",
                    "Tip: Sunglasses don't increase accuracy, but they increase vibe.",
                    "Tip: You have failed Grob. Again. He still loves you though.",
                    "Tip: Sorry, I don't tip.",
                    "Tip: There are cheats in the web manual. Trust me, you need those.",
                    "Tip: Losing is just another word for aggressively learning.",
                    "Tip: Pressing random keys still doesn’t do anything. Still.",
                    "Tip: You missed the orb. Barry is disappointed.",
                    "Tip: You're not bad, you're just... statistically unlucky.",
                    "Tip: Don't look now, but that rectangle is back for revenge.",
                    "Tip: Play again. Grob believes in your chaotic potential.",
                    "Tip: You reached the rarest ending: Failure Deluxe™.",
                    "Tip: This game is sponsored by GrobSpace™."
                ];
                document.getElementById('uselessTips').textContent = tips[Math.floor(Math.random() * tips.length)];

                this.gameOverElement.style.display = 'block';
                this.spaceship.classList.add('exploding');
                setTimeout(() => {
                    this.spaceship.style.display = 'none';
                    this.explosionDone = true;
                }, EXPLOSION_DURATION);

                if (!this.cheatManager.cheatActivated && this.score > this.highScore) {
                    this.highScore = this.score;
                    localStorage.setItem('grobHighScore', this.highScore);
                    this.updateHighScoreDisplay();
                    fetch('update_score.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `score=${this.highScore}`
                    }).then(res => res.text()).then(console.log).catch(console.error);
                }
            }

            reset() {
                this.audioManager.restoreMusicSpeedSmoothly();
                this.audioManager.clearMuffle();
                this.audioManager.startNarrationLoop(16000);

                this.obstacles.forEach(obs => obs.element.remove());
                this.obstacles = [];
                this.orbs.forEach(orb => orb.element.remove());
                this.orbs = [];

                this.shipY = INITIAL_SHIP_Y;
                this.velocity = 0;
                this.score = 0;
                this.gameRunning = true;
                this.lastObstacleY = 0;
                this.isHyperspeed = false;
                this.hyperspeedTimer = 0;
                this.hyperspeedFadeOut = 0;
                this.postHyperspeedBuffer = 0;

                this.spaceship.classList.remove('hyperspeed', 'exploding');
                this.spaceship.style.display = 'block';
                this.spaceship.style.opacity = this.cheatManager.invisibleActivated ? '0' : '1';
                this.spaceship.style.top = this.shipY + 'px';

                this.scoreElement.textContent = `Score: ${this.score}`;
                this.gameOverElement.style.display = 'none';

                this.spawnObstacles();
                this.spawnOrbs();

                this.setShipTransform({ rotate: 0, scale: this.cheatManager.bigSpriteActivated ? 2 : 1 });

                this.explosionDone = true;
            }

            gameLoop() {
                this.update();
                requestAnimationFrame(() => this.gameLoop());
            }
        }

        // ### Initialize Game
        window.onload = () => new Game();
    </script>


</body>
</html>