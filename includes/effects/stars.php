<?php
/**
 * Stars Effect Template
 * File: includes/effects/stars.php
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
    
    const stars = [];
    const numberOfStars = <?php echo esc_js($particle_count); ?>;
    const baseColor = {r: <?php echo esc_js($seasonal_effects_rgb['r']); ?>, g: <?php echo esc_js($seasonal_effects_rgb['g']); ?>, b: <?php echo esc_js($seasonal_effects_rgb['b']); ?>};
    
    // Initialize stars
    for (let i = 0; i < numberOfStars; i++) {
        stars.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            size: Math.random() * 2.5 + 0.5,
            baseOpacity: Math.random() * 0.5 + 0.5,
            opacity: Math.random(),
            twinkleSpeed: Math.random() * 0.03 + 0.01,
            phase: Math.random() * Math.PI * 2
        });
    }
    
    function drawStar(star) {
        ctx.save();
        
        // Calculate twinkling opacity
        const twinkle = Math.sin(star.phase) * 0.5 + 0.5;
        const finalOpacity = star.baseOpacity * twinkle;
        
        // Draw star glow
        const gradient = ctx.createRadialGradient(star.x, star.y, 0, star.x, star.y, star.size * 4);
        gradient.addColorStop(0, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, ${finalOpacity})`);
        gradient.addColorStop(0.3, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, ${finalOpacity * 0.6})`);
        gradient.addColorStop(1, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, 0)`);
        
        ctx.beginPath();
        ctx.arc(star.x, star.y, star.size * 4, 0, Math.PI * 2);
        ctx.fillStyle = gradient;
        ctx.fill();
        
        // Draw bright star center
        ctx.beginPath();
        ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${Math.min(baseColor.r + 50, 255)}, ${Math.min(baseColor.g + 50, 255)}, ${Math.min(baseColor.b + 50, 255)}, ${finalOpacity})`;
        ctx.fill();
        
        // Draw star sparkle points
        ctx.strokeStyle = `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, ${finalOpacity * 0.8})`;
        ctx.lineWidth = 0.5;
        ctx.beginPath();
        ctx.moveTo(star.x - star.size * 2, star.y);
        ctx.lineTo(star.x + star.size * 2, star.y);
        ctx.moveTo(star.x, star.y - star.size * 2);
        ctx.lineTo(star.x, star.y + star.size * 2);
        ctx.stroke();
        
        ctx.restore();
    }
    
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        for (let star of stars) {
            drawStar(star);
        }
        
        updateStars();
    }
    
    function updateStars() {
        for (let star of stars) {
            star.phase += star.twinkleSpeed;
            if (star.phase > Math.PI * 2) {
                star.phase -= Math.PI * 2;
            }
        }
    }
    
    function animate() {
        draw();
        requestAnimationFrame(animate);
    }
    
    animate();
    
    window.addEventListener('resize', function() {
        resizeCanvas();
        // Regenerate stars on resize
        stars.length = 0;
        for (let i = 0; i < numberOfStars; i++) {
            stars.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                size: Math.random() * 2.5 + 0.5,
                baseOpacity: Math.random() * 0.5 + 0.5,
                opacity: Math.random(),
                twinkleSpeed: Math.random() * 0.03 + 0.01,
                phase: Math.random() * Math.PI * 2
            });
        }
    });
})();
</script>