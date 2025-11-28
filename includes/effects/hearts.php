<?php
/**
 * Hearts Effect Template (Valentine's Day)
 * File: includes/effects/hearts.php
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
    
    const hearts = [];
    const numberOfHearts = <?php echo esc_js($particle_count); ?>;
    const heartColors = ['#ff69b4', '#ff1493', '#ff6b9d', '#c71585'];
    
    // Initialize hearts
    for (let i = 0; i < numberOfHearts; i++) {
        hearts.push({
            x: Math.random() * canvas.width,
            y: canvas.height + Math.random() * 100,
            size: Math.random() * 20 + 15,
            speed: Math.random() * 1.5 + 0.5,
            drift: Math.random() * 2 - 1,
            color: heartColors[Math.floor(Math.random() * heartColors.length)],
            opacity: Math.random() * 0.5 + 0.3
        });
    }
    
    function drawHeart(x, y, size, color, opacity) {
        ctx.save();
        ctx.globalAlpha = opacity;
        ctx.fillStyle = color;
        ctx.beginPath();
        
        const topCurveHeight = size * 0.3;
        ctx.moveTo(x, y + topCurveHeight);
        
        // Left curve
        ctx.bezierCurveTo(
            x, y, 
            x - size / 2, y, 
            x - size / 2, y + topCurveHeight
        );
        
        ctx.bezierCurveTo(
            x - size / 2, y + (size + topCurveHeight) / 2, 
            x, y + (size + topCurveHeight) / 2, 
            x, y + size
        );
        
        // Right curve
        ctx.bezierCurveTo(
            x, y + (size + topCurveHeight) / 2, 
            x + size / 2, y + (size + topCurveHeight) / 2, 
            x + size / 2, y + topCurveHeight
        );
        
        ctx.bezierCurveTo(
            x + size / 2, y, 
            x, y, 
            x, y + topCurveHeight
        );
        
        ctx.closePath();
        ctx.fill();
        ctx.restore();
    }
    
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        for (let heart of hearts) {
            drawHeart(heart.x, heart.y, heart.size, heart.color, heart.opacity);
        }
        
        updateHearts();
    }
    
    function updateHearts() {
        for (let heart of hearts) {
            heart.y -= heart.speed;
            heart.x += Math.sin(heart.y / 50) * heart.drift;
            
            if (heart.y < -50) {
                heart.y = canvas.height + 20;
                heart.x = Math.random() * canvas.width;
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