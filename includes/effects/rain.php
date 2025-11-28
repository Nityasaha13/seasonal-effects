<?php
/**
 * Rain Effect Template
 * File: includes/effects/rain.php
 */

if (!defined('ABSPATH')) {
    exit;
}

$seasonal_effects_rgb = seasonal_effects_hex_to_rgb($color);
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
    
    const raindrops = [];
    const numberOfDrops = <?php echo esc_js($particle_count); ?>;
    const baseColor = {r: <?php echo esc_js($seasonal_effects_rgb['r']); ?>, g: <?php echo esc_js($seasonal_effects_rgb['g']); ?>, b: <?php echo esc_js($seasonal_effects_rgb['b']); ?>};
    
    // Initialize raindrops
    for (let i = 0; i < numberOfDrops; i++) {
        raindrops.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            length: Math.random() * 20 + 10,
            speed: Math.random() * 10 + 10,
            opacity: Math.random() * 0.5 + 0.3
        });
    }
    
    function drawRain() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.lineWidth = 1;
        ctx.lineCap = 'round';
        
        for (let drop of raindrops) {
            ctx.beginPath();
            ctx.moveTo(drop.x, drop.y);
            ctx.lineTo(drop.x, drop.y + drop.length);
            ctx.strokeStyle = `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, ${drop.opacity})`;
            ctx.stroke();
        }
        
        updateRain();
    }
    
    function updateRain() {
        for (let drop of raindrops) {
            drop.y += drop.speed;
            
            if (drop.y > canvas.height) {
                drop.y = -drop.length;
                drop.x = Math.random() * canvas.width;
            }
        }
    }
    
    function animate() {
        drawRain();
        requestAnimationFrame(animate);
    }
    
    animate();
    
    window.addEventListener('resize', resizeCanvas);
})();
</script>