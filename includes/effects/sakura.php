<?php
/**
 * Sakura (Cherry Blossoms) Effect Template
 * File: includes/effects/sakura.php
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<canvas id="seasonal-effect-canvas" style="position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:<?php echo esc_attr($z_index); ?>;"></canvas>

<script>
(function() {
    'use strict';
    
    const canvas = document.getElementById('seasonal-effect-canvas');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    
    resizeCanvas();
    
    const petals = [];
    const numberOfPetals = <?php echo esc_js($particle_count); ?>;
    const petalColors = ['#ffb7c5', '#ffc0cb', '#ff69b4', '#ffe4e1'];
    
    // Initialize petals
    for (let i = 0; i < numberOfPetals; i++) {
        petals.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height - canvas.height,
            size: Math.random() * 8 + 5,
            speed: Math.random() * 1 + 0.5,
            drift: Math.random() * 3 - 1.5,
            rotation: Math.random() * 360,
            rotationSpeed: Math.random() * 5 - 2.5,
            swing: Math.random() * 2,
            color: petalColors[Math.floor(Math.random() * petalColors.length)],
            opacity: Math.random() * 0.5 + 0.4
        });
    }
    
    function drawPetal(petal) {
        ctx.save();
        ctx.translate(petal.x, petal.y);
        ctx.rotate((petal.rotation * Math.PI) / 180);
        ctx.globalAlpha = petal.opacity;
        
        // Draw 5-petal sakura
        ctx.fillStyle = petal.color;
        for (let i = 0; i < 5; i++) {
            ctx.save();
            ctx.rotate(((Math.PI * 2) / 5) * i);
            ctx.beginPath();
            ctx.ellipse(0, -petal.size / 3, petal.size / 2, petal.size, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }
        
        // Draw center
        ctx.beginPath();
        ctx.arc(0, 0, petal.size / 4, 0, Math.PI * 2);
        ctx.fillStyle = '#ffd700';
        ctx.fill();
        
        ctx.restore();
    }
    
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        for (let petal of petals) {
            drawPetal(petal);
        }
        
        updatePetals();
    }
    
    function updatePetals() {
        for (let petal of petals) {
            petal.y += petal.speed;
            petal.x += Math.sin(petal.y / 30) * petal.swing;
            petal.rotation += petal.rotationSpeed;
            
            if (petal.y > canvas.height) {
                petal.y = -20;
                petal.x = Math.random() * canvas.width;
            }
        }
    }
    
    function animate() {
        draw();
        requestAnimationFrame(animate);
    }
    
    animate();
    
    window.addEventListener('resize', resizeCanvas);
})();
</script>