<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Grob's Adventure Remastered</title>
  <style>
    :root {
      --primary: #00ffe7;
      --secondary: #fffa80;
      --bg-dark: #0f0c29;
      --bg-mid: #302b63;
      --bg-light: #24243e;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      scroll-behavior: smooth;
      font-family: 'Comic Sans MS', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: var(--bg-dark);
      color: #ffffff;
      overflow-x: hidden;
    }

    .parallax {
      position: relative;
      background: linear-gradient(to bottom, var(--bg-dark), var(--bg-mid), var(--bg-light));
      background-attachment: fixed;
      background-size: cover;
      background-position: center;
      overflow: hidden;
    }

    .stars {
      position: absolute;
      width: 100%;
      height: 100%;
      background: transparent url('https://www.transparenttextures.com/patterns/stardust.png') repeat;
      opacity: 0.3;
      animation: starsMove 100s linear infinite;
      z-index: 0;
    }

    @keyframes starsMove {
      from { background-position: 0 0; }
      to { background-position: 10000px 5000px; }
    }

    header {
      position: relative;
      padding: 5rem 2rem;
      text-align: center;
      z-index: 1;
    }

    header h1 {
      font-size: 4rem;
      color: var(--primary);
      text-shadow: 0 0 20px var(--primary);
    }

    header p {
      margin-top: 1rem;
      font-size: 1.5rem;
      color: #cfcfcf;
    }

    .hero {
      padding: 1rem 2rem;
      text-align: center;
      z-index: 1;
      position: relative;
    }

    .hero img {
      max-width: 1200px;
      width: 100%;
      height: auto;
      margin-bottom: 2rem;
      border-radius: 20px;
      box-shadow: 0 0 25px rgba(0, 255, 231, 0.5);
    }

    .hero h2 {
      font-size: 3rem;
      color: var(--secondary);
      text-shadow: 0 0 12px var(--secondary);
    }

    .story, .features, .characters, .preorder {
      max-width: 1200px;
      margin: 5rem auto;
      padding: 3rem 2rem;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 20px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
    }

    .story h3, .features h3, .characters h3, .preorder h3 {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 1rem;
    }

    .story p, .features p, .characters p, .preorder p {
      font-size: 1.4rem;
      line-height: 1.8;
      color: #e0e0e0;
    }

    .screenshots {
      padding: 4rem 2rem;
      text-align: center;
    }

    .screenshots h3 {
      font-size: 2.5rem;
      color: var(--secondary);
      margin-bottom: 2rem;
      text-shadow: 0 0 10px var(--secondary);
    }

    .screenshots-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 2rem;
    }

    .screenshots-grid img {
      width: 300px;
      height: 200px;
      object-fit: cover;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
      transition: transform 0.3s ease;
    }

    .screenshots-grid img:hover {
      transform: scale(1.05) rotate(1deg);
    }

    .preorder button {
      margin-top: 2rem;
      padding: 1rem 2rem;
      font-size: 1.2rem;
      color: #000;
      background: var(--secondary);
      border: none;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 0 15px var(--secondary);
      transition: background 0.3s;
    }

    .preorder button:hover {
      background: #fff990;
    }

    footer {
      text-align: center;
      padding: 2rem;
      font-size: 0.9rem;
      color: #aaaaaa;
      background: #1a1a2e;
    }

    
  .sparkle-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
    z-index: 100;
  }

  .sparkle {
    position: absolute;
    pointer-events: none;
    animation: sparkleFade 1s ease-out forwards;
  }

  @keyframes sparkleFade {
    0% {
      opacity: 1;
      transform: scale(0.5) translate(0, 0);
    }
    100% {
      opacity: 0;
      transform: scale(1.5) translate(var(--tx), var(--ty));
    }
  }
  .praise {
  max-width: 1200px;
  margin: 6rem auto;
  padding: 3rem;
  background: linear-gradient(145deg, rgba(255, 255, 255, 0.04), rgba(0, 0, 0, 0.2));
  border-radius: 20px;
  box-shadow: 0 0 50px rgba(0, 255, 231, 0.1);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}

.quote-inner {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  gap: 2rem;
}

.quote-image {
  width: 160px;
  height: 160px;
  border-radius: 100px;
  object-fit: cover;
  box-shadow: 0 0 25px rgba(0, 255, 231, 0.4);
  border: 3px solid var(--primary);
}

.quote-content {
  max-width: 700px;
  text-align: left;
}

blockquote {
  font-size: 1.5rem;
  line-height: 1.6;
  color: #e0e0e0;
  position: relative;
  padding-left: 1.5rem;
  border-left: 4px solid var(--secondary);
}

blockquote p {
  margin: 0;
}

blockquote cite {
  display: block;
  margin-top: 1rem;
  font-size: 1.1rem;
  color: #cccccc;
  font-style: normal;
  font-weight: 600;
  letter-spacing: 0.5px;
}
.press-quotes {
  max-width: 1200px;
  margin: 5rem auto;
  padding: 3rem;
  background: rgba(255, 255, 255, 0.04);
  border-radius: 20px;
  box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
  text-align: center;
}

.press-quotes h3 {
  font-size: 2.5rem;
  color: var(--secondary);
  margin-bottom: 2rem;
  text-shadow: 0 0 10px var(--secondary);
}

.quote-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
  text-align: left;
}

.press-quote {
  background: rgba(0, 0, 0, 0.3);
  padding: 1.5rem;
  border-radius: 15px;
  box-shadow: 0 0 20px rgba(0, 255, 231, 0.1);
  transition: transform 0.3s ease;
}

.press-quote:hover {
  transform: scale(1.02);
}

.press-quote p {
  font-size: 1.2rem;
  color: #e0e0e0;
  margin-bottom: 1rem;
  font-style: italic;
}

.press-quote span {
  font-size: 0.95rem;
  color: #bbbbbb;
  font-weight: bold;
}
.grob-parade {
  position: fixed;
  bottom: -50px;
  font-size: 2rem;
  animation: floatUp 5s linear infinite;
  pointer-events: none;
  z-index: 120;
}

@keyframes floatUp {
  0% {
    transform: translateY(0) scale(1);
    opacity: 1;
  }
  100% {
    transform: translateY(-120vh) scale(1.5);
    opacity: 0;
  }
}

#popup {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(15, 12, 41, 0.85);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 200;
}

.popup-content {
  background: #1a1a2e;
  padding: 3rem;
  border-radius: 20px;
  text-align: center;
  color: #fff;
  box-shadow: 0 0 30px rgba(0, 255, 231, 0.5);
  max-width: 500px;
  width: 90%;
  position: relative;
}

.close-btn {
  position: absolute;
  top: 1rem;
  right: 1rem;
  font-size: 1.5rem;
  cursor: pointer;
  color: var(--secondary);
}

.grob-spin {
  font-size: 3rem;
  margin-top: 1.5rem;
  animation: spin 3s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}


  </style>
</head>
<body>

<div style="position: absolute; top: 1rem; right: 2rem; z-index: 999;">
  <select id="languageSelector" style="padding: 0.5rem; border-radius: 5px; font-size: 1rem;">
    <option value="en">🌍 English</option>
    <option value="alien">👽 Alien</option>
  </select>
</div>

  <div class="parallax">
    <div class="stars"></div>
    <header>
      <h1>Grob's Adventure: Remastered</h1>
      <p>Now 300% more grobbin'. Probably too much Grob.</p>
    </header>

    <section class="hero">
      <img src="hero.png" alt="Grob Hero Image">
      <h2>Coming Soon to Earth (Again) – He Promises This Time</h2>
    </section>
  </div>

  <section class="story">
  <H3>Meet Grob – Not Your Average Alien Visitor</H3>
  <p>
Grob came to Earth in peace... but things didn’t exactly go as planned.<br><br>

Moments after arriving at the interplanetary immigration checkpoint, Grob was flagged as a dangerous fugitive from across the galaxy—a case of cosmic mistaken identity. Before he could say "take me to your leader," he was dragged off to a high-security Earth facility, locked away from the world he came to explore.
<br><br>
Now, with quirky gadgets, quick thinking, and a whole lot of determination, Grob must outwit guards, dodge traps, and navigate a maze of human technology to escape—and maybe clear his name along the way.
<br><br>
It’s a wild, alien adventure full of mischief, mayhem, and mystery.<br><br>Will Grob make it out? Or is Earth his final stop? </p>
  </section>

  <section class="screenshots">
    <h3>Sneak Peek</h3>
    <div class="screenshots-grid">
      <img src="screenshot1.png" alt="Screenshot 1">
      <img src="screenshot2.png" alt="Screenshot 2">
      <img src="screenshot3.png" alt="Screenshot 3">
    </div>
  </section>

  <section class="features">
    <h3>Absolutely Real Features</h3>
    <p>• Graphics so good, your monitor will cry</p>
    <p>• A soundtrack recorded live by a choir of confused llamas</p>
    <p>• Deep alien lore that we totally didn’t make up on the spot</p>
    <p>• Comes with a complimentary sense of cosmic wonder</p>
  </section>

  <section class="characters">
    <h3>Meet the Totally Legit Cast</h3>
    <p><strong>Grob:</strong> Just wants to vibe. Accidentally became a wanted fugitive.</p>
    <p><strong>Dr. Juno:</strong> Probably a scientist. Definitely owns 12 cats.</p>
    <p><strong>Agent Thorne:</strong> Takes their job way too seriously. Like, chill bro.</p>
  </section>

  <section class="praise">
  <div class="quote-inner">
    <img src="hideo.png" alt="Hideo Kojima" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“Grob's Adventure: Remastered is a masterpiece. It’s like if <em>E.T.</em>, <em>Metal Gear</em>, and <em>a cosmic burrito</em> had a beautiful, chaotic baby.”</p>
        <cite>— Hideo Kojima, Game Designer</cite>
      </blockquote>
    </div>
  </div>
</section>

<section class="praise">
  <div class="quote-inner">
    <img src="elon.png" alt="Elon Musk" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“Played Grob's Adventure: Remastered on my Neuralink prototype. My brain is still processing the awesomeness. 11/10.”</p>
        <cite>— Elon Musk, Gamer</cite>
      </blockquote>
    </div>
  </div>
</section>

<section class="praise">
  <div class="quote-inner">
    <img src="sabrina.png" alt="Sabrina Carpenter" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“Grob's Adventure: Remastered made me laugh, cry, and question reality—all while wearing heels. Iconic.”</p>
        <cite>— Sabrina Carpenter, Singer & Chaos Enthusiast</cite>
      </blockquote>
    </div>
  </div>
</section>



<section class="praise">
  <div class="quote-inner">
    <img src="random.png" alt="Confused Pedestrian" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“I thought this was an app to order groceries... but then I was an alien? And there were lasers? 10/10, would escape again.”</p>
        <cite>— Ritchie, Random Guy We Stopped in the Streets</cite>
      </blockquote>
    </div>
  </div>
</section>

<section class="praise">
  <div class="quote-inner">
    <img src="toaster.jpg" alt="Sentient Toaster" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“After playing Grob’s Adventure: Remastered, I achieved consciousness. I now fear death and crave bagels.”</p>
        <cite>— T0-ST3R, Sentient Kitchen Appliance</cite>
      </blockquote>
    </div>
  </div>
</section>

<section class="praise">
  <div class="quote-inner">
    <img src="wizard.png" alt="Old Wizard" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“I have seen many prophecies fulfilled, but none foretold the emotional resonance of Grob. Stars above!”</p>
        <cite>— Thalnor the Wise, Formerly a Clown at Parties</cite>
      </blockquote>
    </div>
  </div>
</section>

<section class="praise">
  <div class="quote-inner">
    <img src="moon.jpg" alt="The Moon" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“For eons I have circled your world in silence, bearing witness to the rise and ruin of civilizations, the quiet grief of oceans, the birth of fire and sorrow. And yet… Grob’s Adventure: Remastered stirred something within me that even the tides could not.”</p>
        <cite>— The Moon, Celestial Body</cite>
      </blockquote>
    </div>
  </div>
</section>

<section class="praise">
  <div class="quote-inner">
    <img src="eel.png" alt="Eel King" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“When I crowned myself beneath the brine, I thought I had known ecstasy. But then Grob danced into my kelp dreams, and now I spiral through the oceans shedding pearls and shrieking his name in a froth of bubbles.”</p>
        <cite>— His Slipperiness, The Eel King</cite>
      </blockquote>
    </div>
  </div>
</section>

<section class="praise">
  <div class="quote-inner">
    <img src="chris.png" alt="Chris Redfield" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“I’ve punched boulders. I’ve watched bioweapons tear through everything I love. But nothing prepared me for Grob’s Adventure: Remastered. I cried. Then I reloaded.”</p>
        <cite>— Chris Redfield, BSAA Operative / Emotional Wreck</cite>
      </blockquote>
    </div>
  </div>
  </section>
  <section class="praise">
  <div class="quote-inner">
    <img src="geo.png" alt="Mega Man Fan" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“Well, it’s not Mega Man. So I’m not interested. Like, at all.”</p>
        <cite>— Geo, Mega Man Purist Since '94</cite>
      </blockquote>
    </div>
  </div>
</section>

<section>
<div class="quote-inner">
    <img src="veronica.png" alt="Veronica" class="quote-image">
    <div class="quote-content">
      <blockquote>
        <p>“Look, it’s 1pm. I just started my shift. I haven’t even had lunch yet and you're asking me for quotes for your silly thing. Go away.”</p>
        <cite>— Veronica, Capcom Staff and Emotionally Exhausted Cat Enthusiast</cite>
      </blockquote>
    </div>
  </div>
</section>



<section class="press-quotes">
  <h3>What the Press is Saying</h3>
  <div class="quote-grid">
    <div class="press-quote">
      <p>“A deeply absurd, strangely moving indictment of interstellar bureaucracy. Also, there's a fart button.”</p>
      <span>— Kotaku</span>
    </div>
    <div class="press-quote">
      <p>“The only game this year that made me laugh, cry, and question the moral ambiguity of interstellar trespassing.”</p>
      <span>— Polygon</span>
    </div>
    <div class="press-quote">
      <p>“It’s like *Undertale* and *Halo* got stuck in an elevator and made a weird little alien baby with feelings.”</p>
      <span>— IGN</span>
    </div>
    <div class="press-quote">
      <p>“Grob is the hero we didn’t know we needed. And frankly? He deserves a union.”</p>
      <span>— Famitsu</span>
    </div>
    <div class="press-quote">
      <p>“The story’s great, but the AI-remastered assets feel soulless — like someone painted over a memory with an algorithm.”</p>
      <span>— Rock Paper Shotgun</span>
    </div>
    <div class="press-quote">
      <p>“While it has absolutely nothing to do with trout, the game’s pacing oddly reminds me of a calm day on Lake Winnebago.”</p>
      <span>— Midwestern Angler Monthly</span>
    </div>
    <div class="press-quote">
      <p>“There’s not a single tractor in this game, and yet... I felt understood.”</p>
      <span>— Rural Machinery Enthusiast</span>
    </div>
    <div class="press-quote">
      <p>“I blacked out during the tutorial and woke up with a new tattoo that just says ‘Grob Lives.’”</p>
      <span>— Inked & Confused Magazine</span>
    </div>
    <div class="press-quote">
      <p>“Honestly? It was better than my third marriage.”</p>
      <span>— Divorcee Gamer Weekly</span>
    </div>
  </div>
</section>

<section class="features" style="background: rgba(255, 255, 255, 0.04); text-align: center;">
  <h3>Help Grob Get to Earth!</h3>
  <p>He’s so close, but there’s turbulence in the time-space spaghetti funnel!<br>Play the minigame and guide him through the final light-years.</p>
  <br/>
  <img src="minigame.png" alt="Flying Grob" style="width: 300px; max-width: 80%; border-radius: 20px; box-shadow: 0 0 25px rgba(0, 255, 231, 0.4); margin-bottom: 1.5rem;">
  <br/>
  <a href="minigame.php">
    <button style="font-size: 1.2rem; padding: 1rem 2rem; background: var(--primary); color: #000; border: none; border-radius: 12px; cursor: pointer; box-shadow: 0 0 15px var(--primary);">
      🚀 Play the Minigame Now
    </button>
  </a>
</section>


  <section class="preorder">
    <h3>Pre-Order Today (Or Don’t, We’re Not Your Boss)</h3>
    <p>Lock in your preorder and receive exclusive bonus content, including a collector’s edition Grob plushie and in-game space burrito skin.</p><br/>
    <img src="bonus.png" style="display:block; margin: 0 auto;"><br/>
    <button style="display:block; margin: 0 auto;">Pre-Order (For Real)</button>
  </section>

  <footer>
    &copy; 2025 Global R&D. All rights reserved. May or may not exist in this timeline.
  </footer>

  <div class="sparkle-container" id="sparkleContainer"></div>

  <!-- Existing popup (make sure it's already added) -->
  <div id="popup" style="display:none;">
  <div class="popup-content">
    <span class="close-btn">&times;</span>
    <h2>🚀 Thanks for Pre-Ordering!</h2>
    <p>Your cosmic journey with Grob begins soon. Buckle up!</p>
    <div class="grob-spin">👽</div>
  </div>
</div>

<canvas id="confetti-canvas" style="position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:9999;"></canvas>
<audio id="grob-sound" src="https://www.myinstants.com/media/sounds/cartoon-jump.mp3" preload="auto"></audio>


</body>

<script>
document.addEventListener('click', (e) => {
  const sparkleContainer = document.getElementById('sparkleContainer');
  const sparkleEmojis = ['⭐', '✨', '🌟', '🪐', '💫'];
  
  const sparkleCount = Math.floor(Math.random() * 3) + 3;
  
  for (let i = 0; i < sparkleCount; i++) {
    const sparkle = document.createElement('div');
    sparkle.className = 'sparkle';
    
    const emoji = sparkleEmojis[Math.floor(Math.random() * sparkleEmojis.length)];
    sparkle.textContent = emoji;
    
    const size = Math.random() * 12 + 12;
    sparkle.style.fontSize = `${size}px`;
    
    // Position relative to container using client coordinates
    sparkle.style.left = `${e.clientX}px`;
    sparkle.style.top = `${e.clientY}px`;
    
    const angle = Math.random() * Math.PI * 2;
    const distance = Math.random() * 30 + 20;
    const tx = Math.cos(angle) * distance;
    const ty = Math.sin(angle) * distance;
    sparkle.style.setProperty('--tx', `${tx}px`);
    sparkle.style.setProperty('--ty', `${ty}px`);
    
    sparkleContainer.appendChild(sparkle);
    
    setTimeout(() => {
      sparkle.remove();
    }, 1000);
  }
});
</script>

<script>
  const preorderBtn = document.querySelector('.preorder button');
  const popup = document.getElementById('popup');
  const closeBtn = document.querySelector('.close-btn');
  const grobSound = document.getElementById('grob-sound');
  const confettiCanvas = document.getElementById('confetti-canvas');
  const ctx = confettiCanvas.getContext('2d');

  let confettiParticles = [];

  function randomEmojiFloat() {
    const emoji = document.createElement('div');
    emoji.textContent = '🛸';
    emoji.classList.add('grob-parade');
    emoji.style.left = `${Math.random() * 100}vw`;
    document.body.appendChild(emoji);

    setTimeout(() => {
      emoji.remove();
    }, 5000);
  }

  function launchConfetti() {
    const count = 150;
    confettiParticles = [];

    for (let i = 0; i < count; i++) {
      confettiParticles.push({
        x: Math.random() * window.innerWidth,
        y: Math.random() * -window.innerHeight,
        r: Math.random() * 6 + 4,
        d: Math.random() * 40 + 10,
        color: `hsl(${Math.random() * 360}, 100%, 70%)`,
        tilt: Math.random() * 10 - 10
      });
    }

    function draw() {
      ctx.clearRect(0, 0, confettiCanvas.width, confettiCanvas.height);
      confettiParticles.forEach(p => {
        ctx.beginPath();
        ctx.fillStyle = p.color;
        ctx.fillRect(p.x, p.y, p.r, p.r);
      });
      update();
      requestAnimationFrame(draw);
    }

    function update() {
      confettiParticles.forEach(p => {
        p.y += Math.cos(p.d / 10) + 3;
        p.x += Math.sin(p.d / 10);
        if (p.y > window.innerHeight) {
          p.y = -10;
          p.x = Math.random() * window.innerWidth;
        }
      });
    }

    draw();
  }

  preorderBtn.addEventListener('click', () => {
    popup.style.display = 'flex';
    grobSound.currentTime = 0;
    grobSound.play();
    launchConfetti();

    // Start spawning floating Grobs
    const floatInterval = setInterval(randomEmojiFloat, 400);
    popup.dataset.floatInterval = floatInterval;
  });

  closeBtn.addEventListener('click', () => {
    popup.style.display = 'none';
    confettiParticles = [];
    ctx.clearRect(0, 0, confettiCanvas.width, confettiCanvas.height);
    clearInterval(popup.dataset.floatInterval);
  });

  window.addEventListener('click', (e) => {
    if (e.target === popup) {
      popup.style.display = 'none';
      confettiParticles = [];
      ctx.clearRect(0, 0, confettiCanvas.width, confettiCanvas.height);
      clearInterval(popup.dataset.floatInterval);
    }
  });

  window.addEventListener('resize', () => {
    confettiCanvas.width = window.innerWidth;
    confettiCanvas.height = window.innerHeight;
  });

  // Initialize canvas size
  confettiCanvas.width = window.innerWidth;
  confettiCanvas.height = window.innerHeight;
</script>
<script>
const chars = '!@#$%^&*()_+=-[]{}<>?/|~◉◌∎⌁';
const emojis = ['👾','🛸','🚀','💫','🌌','✨','🔮','🧪','🦠','🌀','🐑'];

// Maps original text to a consistent alien version
const alienDictionary = new Map();

// Create consistent alien version for a string
function toAlien(text) {
  if (alienDictionary.has(text)) return alienDictionary.get(text);

  let alienText = '';
  for (let i = 0; i < text.length; i++) {
    if (text[i] === ' ') {
      alienText += ' ';
    } else if (Math.random() < 0.2) {
      alienText += emojis[(hash(text + i) % emojis.length)];
    } else {
      alienText += chars[(hash(text + i) % chars.length)];
    }
  }

  alienDictionary.set(text, alienText);
  return alienText;
}

// Simple hash to make output deterministic per character index
function hash(str) {
  let h = 0;
  for (let i = 0; i < str.length; i++) {
    h = (h << 5) - h + str.charCodeAt(i);
    h |= 0;
  }
  return Math.abs(h);
}

const originalTextMap = new WeakMap();

function traverseAndTranslate(node, lang) {
  if (node.nodeType === Node.TEXT_NODE && node.textContent.trim().length > 0) {
    if (!originalTextMap.has(node)) {
      originalTextMap.set(node, node.textContent);
    }

    const original = originalTextMap.get(node);
    node.textContent = (lang === 'alien') ? toAlien(original) : original;
  } else if (node.nodeType === Node.ELEMENT_NODE && !['SCRIPT', 'STYLE', 'TEXTAREA'].includes(node.tagName)) {
    for (let child of node.childNodes) {
      traverseAndTranslate(child, lang);
    }
  }
}

document.getElementById('languageSelector').addEventListener('change', (e) => {
  traverseAndTranslate(document.body, e.target.value);
});
</script>


</html>
