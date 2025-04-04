<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Character Animation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #6e45e2 0%, #88d3ce 100%);
            overflow: hidden;
            font-family: 'Arial', sans-serif;
        }

        .anime-scene {
            position: relative;
            width: 300px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: flex-end;
        }

        .character {
            position: relative;
            width: 180px;
            height: 350px;
        }

        /* Head */
        .head {
            position: absolute;
            width: 120px;
            height: 140px;
            background: #ffdbac;
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            top: 40px;
            left: 30px;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Hair */
        .hair {
            position: absolute;
            width: 140px;
            height: 160px;
            background: #4a2a12;
            border-radius: 60% 60% 40% 40% / 70% 70% 30% 30%;
            top: 30px;
            left: 20px;
            z-index: 5;
            overflow: hidden;
        }

        .hair-bangs {
            position: absolute;
            width: 140px;
            height: 40px;
            background: #4a2a12;
            border-radius: 100% 100% 0 0 / 100%;
            top: 30px;
            left: 20px;
            z-index: 15;
        }

        /* Hair animation strands */
        .hair-strand {
            position: absolute;
            background: #3a2210;
            z-index: 6;
        }

        .hair-strand-1 {
            width: 15px;
            height: 60px;
            border-radius: 50px;
            top: 40px;
            left: 25px;
            transform: rotate(20deg);
            animation: hair-wave 3s ease-in-out infinite;
        }

        .hair-strand-2 {
            width: 12px;
            height: 50px;
            border-radius: 50px;
            top: 45px;
            left: 45px;
            transform: rotate(15deg);
            animation: hair-wave 3.2s ease-in-out infinite 0.2s;
        }

        .hair-strand-3 {
            width: 10px;
            height: 45px;
            border-radius: 50px;
            top: 50px;
            left: 65px;
            transform: rotate(10deg);
            animation: hair-wave 3.4s ease-in-out infinite 0.4s;
        }

        @keyframes hair-wave {
            0%, 100% { transform: rotate(10deg) translateY(0); }
            50% { transform: rotate(15deg) translateY(-5px); }
        }

        /* Eyes */
        .eyes {
            position: absolute;
            width: 60px;
            height: 20px;
            top: 85px;
            left: 30px;
            display: flex;
            justify-content: space-between;
            z-index: 20;
        }

        .eye {
            width: 25px;
            height: 20px;
            background: white;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }

        .eye::before {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            background: #333;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .eye::after {
            content: '';
            position: absolute;
            width: 5px;
            height: 5px;
            background: white;
            border-radius: 50%;
            top: 30%;
            left: 30%;
        }

        /* Blinking animation */
        .eye-lid {
            position: absolute;
            width: 25px;
            height: 20px;
            background: #ffdbac;
            border-radius: 0 0 50% 50%;
            top: -10px;
            left: 0;
            z-index: 21;
            animation: blink 4s infinite;
            transform-origin: top;
        }

        @keyframes blink {
            0%, 45%, 55%, 100% { transform: scaleY(0); }
            48%, 52% { transform: scaleY(1); }
        }

        /* Mouth */
        .mouth {
            position: absolute;
            width: 30px;
            height: 10px;
            background: #ff9e9e;
            border-radius: 0 0 50px 50px;
            top: 120px;
            left: 45px;
            z-index: 20;
            transition: all 0.3s ease;
        }

        /* Body */
        .body {
            position: absolute;
            width: 100px;
            height: 150px;
            background: #e63946;
            border-radius: 20px;
            top: 170px;
            left: 40px;
            z-index: 8;
        }

        /* Arms */
        .arm {
            position: absolute;
            width: 30px;
            height: 80px;
            background: #ffdbac;
            border-radius: 15px;
            z-index: 7;
        }

        .arm-left {
            top: 180px;
            left: 20px;
            transform-origin: top center;
            animation: arm-swing 3s ease-in-out infinite;
        }

        .arm-right {
            top: 180px;
            right: 20px;
            transform-origin: top center;
            animation: arm-swing 3s ease-in-out infinite 0.1s;
        }

        @keyframes arm-swing {
            0%, 100% { transform: rotate(-10deg); }
            50% { transform: rotate(10deg); }
        }

        /* Legs */
        .leg {
            position: absolute;
            width: 30px;
            height: 90px;
            background: #1d3557;
            border-radius: 0 0 15px 15px;
            bottom: 0;
            z-index: 5;
        }

        .leg-left {
            left: 50px;
            transform-origin: top center;
            animation: leg-move 3s ease-in-out infinite;
        }

        .leg-right {
            right: 50px;
            transform-origin: top center;
            animation: leg-move 3s ease-in-out infinite 0.1s;
        }

        @keyframes leg-move {
            0%, 100% { transform: rotate(-5deg); }
            50% { transform: rotate(5deg); }
        }

        /* Speech bubble */
        .speech-bubble {
            position: absolute;
            background: white;
            border-radius: 20px;
            padding: 15px;
            width: 150px;
            top: 20px;
            right: -170px;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .speech-bubble::after {
            content: '';
            position: absolute;
            left: -10px;
            top: 50%;
            border: 10px solid transparent;
            border-right: 10px solid white;
            transform: translateY(-50%);
        }

        .speech-text {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        /* Interactive elements */
        .controls {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .control-btn {
            padding: 8px 16px;
            background: rgba(255,255,255,0.8);
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.2s ease;
        }

        .control-btn:hover {
            background: white;
            transform: translateY(-2px);
        }

        /* Background elements */
        .sakura {
            position: absolute;
            width: 15px;
            height: 15px;
            background: #ffb7c5;
            border-radius: 50% 0 50% 50%;
            opacity: 0.7;
            animation: falling linear infinite;
        }

        @keyframes falling {
            0% { transform: translateY(-100vh) rotate(0deg); }
            100% { transform: translateY(100vh) rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="anime-scene">
        <!-- Sakura petals -->
        <div id="sakura-container"></div>
        
        <!-- Character -->
        <div class="character">
            <div class="hair"></div>
            <div class="hair-bangs"></div>
            <div class="hair-strand hair-strand-1"></div>
            <div class="hair-strand hair-strand-2"></div>
            <div class="hair-strand hair-strand-3"></div>
            
            <div class="head">
                <div class="eyes">
                    <div class="eye">
                        <div class="eye-lid"></div>
                    </div>
                    <div class="eye">
                        <div class="eye-lid"></div>
                    </div>
                </div>
                <div class="mouth" id="mouth"></div>
            </div>
            
            <div class="body"></div>
            <div class="arm arm-left"></div>
            <div class="arm arm-right"></div>
            <div class="leg leg-left"></div>
            <div class="leg leg-right"></div>
            
            <div class="speech-bubble" id="speech-bubble">
                <p class="speech-text" id="speech-text">Hello there!</p>
            </div>
        </div>
    </div>

    <div class="controls">
        <button class="control-btn" id="btn-happy">Happy</button>
        <button class="control-btn" id="btn-sad">Sad</button>
        <button class="control-btn" id="btn-surprised">Surprised</button>
        <button class="control-btn" id="btn-talk">Talk</button>
    </div>

    <script>
        // Create sakura petals
        function createSakura() {
            const container = document.getElementById('sakura-container');
            const petalCount = 15;
            
            for (let i = 0; i < petalCount; i++) {
                const petal = document.createElement('div');
                petal.classList.add('sakura');
                
                // Random properties
                const size = Math.random() * 10 + 5;
                const left = Math.random() * 100;
                const animationDuration = Math.random() * 5 + 5;
                const animationDelay = Math.random() * 5;
                const rotation = Math.random() * 360;
                
                petal.style.width = `${size}px`;
                petal.style.height = `${size}px`;
                petal.style.left = `${left}%`;
                petal.style.animationDuration = `${animationDuration}s`;
                petal.style.animationDelay = `${animationDelay}s`;
                petal.style.transform = `rotate(${rotation}deg)`;
                
                container.appendChild(petal);
            }
        }

        // Character expressions
        const mouth = document.getElementById('mouth');
        const speechBubble = document.getElementById('speech-bubble');
        const speechText = document.getElementById('speech-text');
        
        document.getElementById('btn-happy').addEventListener('click', () => {
            mouth.style.height = '10px';
            mouth.style.width = '30px';
            mouth.style.borderRadius = '0 0 50px 50px';
            mouth.style.backgroundColor = '#ff9e9e';
            showSpeech('I feel great today!');
        });
        
        document.getElementById('btn-sad').addEventListener('click', () => {
            mouth.style.height = '5px';
            mouth.style.width = '40px';
            mouth.style.borderRadius = '0';
            mouth.style.backgroundColor = '#b5e2fa';
            showSpeech('I feel a bit down...');
        });
        
        document.getElementById('btn-surprised').addEventListener('click', () => {
            mouth.style.height = '20px';
            mouth.style.width = '20px';
            mouth.style.borderRadius = '50%';
            mouth.style.backgroundColor = '#ff9e9e';
            showSpeech('Wow!');
        });
        
        document.getElementById('btn-talk').addEventListener('click', () => {
            const messages = [
                "What's your favorite anime?",
                "I love coding animations!",
                "CSS is magical ✨",
                "Let's create more animations!",
                "Have a wonderful day!"
            ];
            const randomMessage = messages[Math.floor(Math.random() * messages.length)];
            showSpeech(randomMessage);
            
            // Animate mouth while talking
            let talkInterval = setInterval(() => {
                mouth.style.height = mouth.style.height === '5px' ? '10px' : '5px';
            }, 200);
            
            setTimeout(() => {
                clearInterval(talkInterval);
                mouth.style.height = '10px';
            }, 2000);
        });
        
        function showSpeech(text) {
            speechText.textContent = text;
            speechBubble.style.opacity = '1';
            speechBubble.style.transform = 'translateY(0)';
            
            setTimeout(() => {
                speechBubble.style.opacity = '0';
                speechBubble.style.transform = 'translateY(10px)';
            }, 3000);
        }

        // Initialize
        createSakura();
        showSpeech('Hello there!');
    </script>
</body>
</html> 