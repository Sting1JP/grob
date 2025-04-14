<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DeepA - Alien Translator</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
      color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 2rem;
      overflow: hidden;
    }

    .stars {
      position: fixed;
      top: 0;
      left: 0;
      width: 200%;
      height: 200%;
      background: transparent url('https://www.transparenttextures.com/patterns/stardust.png') repeat;
      opacity: 0.5;
      animation: starsMove 80s linear infinite;
      z-index: -1;
      filter: brightness(1.5) contrast(1.2);
    }

    @keyframes starsMove {
      from { transform: translate(0, 0); }
      to { transform: translate(-50%, -25%); }
    }

    h1 {
      font-size: 3rem;
      color: #00ffe7;
      text-shadow: 0 0 10px #00ffe7;
      margin-bottom: 2rem;
    }

    .translator-container {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      justify-content: center;
      width: 100%;
      max-width: 1000px;
    }

    .translator-box {
      flex: 1 1 400px;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 15px;
      padding: 1rem;
      box-shadow: 0 0 20px rgba(0, 255, 231, 0.2);
    }

    textarea {
      width: 100%;
      height: 200px;
      background: #1a1a2e;
      color: #ffffff;
      border: none;
      border-radius: 10px;
      padding: 1rem;
      font-size: 1rem;
      resize: none;
    }

    button {
      margin-top: 1rem;
      padding: 0.8rem 1.5rem;
      background: #fffa80;
      color: #000;
      font-size: 1rem;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      box-shadow: 0 0 10px #fffa80;
    }

    button:hover {
      background: #fff990;
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
  </style>
</head>
<body>
  <div class="stars"></div>
  <h1>DeepA: Intergalactic Translator</h1>
  <div class="translator-container">
    <div class="translator-box">
      <h3>English</h3>
      <textarea id="englishInput" placeholder="Type your message here..."></textarea>
      <button onclick="translateToAlien()">Translate to Alien 👽</button>
    </div>
    <div class="translator-box">
      <h3>Alien</h3>
      <textarea id="alienOutput" placeholder="Your alien message will appear here..."></textarea>
      <button onclick="translateToEnglish()">Translate to English 🌍</button>
    </div>
  </div>
  <div class="sparkle-container" id="sparkleContainer"></div>
  <script>
    const chars = '!@#$%^&*()_+=-[]{}<>?/|~◉◌∎⌁';
    const emojis = ['👾','🛸','🚀','💫','🌌','✨','🔮','🧪','🦠','🌀','🐑'];
    const alienDictionary = new Map();
    const reverseDictionary = new Map();

    function hash(str) {
      let h = 0;
      for (let i = 0; i < str.length; i++) {
        h = (h << 5) - h + str.charCodeAt(i);
        h |= 0;
      }
      return Math.abs(h);
    }

    function toAlien(text) {
      if (alienDictionary.has(text)) return alienDictionary.get(text);

      let alienText = '';
      for (let i = 0; i < text.length; i++) {
        const char = text[i];
        if (char === ' ') {
          alienText += ' ';
        } else if (Math.random() < 0.2) {
          alienText += emojis[(hash(text + i) % emojis.length)];
        } else {
          alienText += chars[(hash(text + i) % chars.length)];
        }
      }
      alienDictionary.set(text, alienText);
      reverseDictionary.set(alienText, text);
      return alienText;
    }

    function translateToAlien() {
      const english = document.getElementById('englishInput').value;
      const alien = toAlien(english);
      document.getElementById('alienOutput').value = alien;
    }

    function translateToEnglish() {
      const alien = document.getElementById('alienOutput').value;
      const english = reverseDictionary.get(alien) || '[Translation unavailable]';
      document.getElementById('englishInput').value = english;
    }
  </script>

  
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
</body>
</html>
