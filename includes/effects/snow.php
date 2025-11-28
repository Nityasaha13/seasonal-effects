<?php
/**
 * Snow Effect Template
 * File: includes/effects/snow.php
 */

if (!defined('ABSPATH')) {
    exit;
}

$rgb = seasonal_effects_hex_to_rgb($color);
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
    
    const snowflakes = [];
    const numberOfFlakes = <?php echo esc_js($particle_count); ?>;
    const baseColor = {r: <?php echo esc_js($rgb['r']); ?>, g: <?php echo esc_js($rgb['g']); ?>, b: <?php echo esc_js($rgb['b']); ?>};
    
    // Initialize snowflakes
    for (let i = 0; i < numberOfFlakes; i++) {
        snowflakes.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            radius: Math.random() * 3 + 1,
            speed: Math.random() * 1 + 0.5,
            drift: Math.random() * 0.5 - 0.25,
            opacity: Math.random() * 0.6 + 0.4
        });
    }
    
    function drawSnowflakes() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        for (let flake of snowflakes) {
            ctx.beginPath();
            ctx.arc(flake.x, flake.y, flake.radius, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, ${flake.opacity})`;
            ctx.fill();
            
            // Add slight glow
            ctx.shadowBlur = 3;
            ctx.shadowColor = `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, ${flake.opacity * 0.5})`;
            ctx.fill();
            ctx.shadowBlur = 0;
        }
        
        updateSnowflakes();
    }
    
    function updateSnowflakes() {
        for (let flake of snowflakes) {
            flake.y += flake.speed;
            flake.x += flake.drift;
            
            if (flake.y > canvas.height) {
                flake.y = -10;
                flake.x = Math.random() * canvas.width;
            }
            
            if (flake.x > canvas.width) {
                flake.x = 0;
            } else if (flake.x < 0) {
                flake.x = canvas.width;
            }
        }
    }
    
    function animate() {
        drawSnowflakes();
        requestAnimationFrame(animate);
    }
    
    animate();
    
    window.addEventListener('resize', resizeCanvas);
})();
</script>