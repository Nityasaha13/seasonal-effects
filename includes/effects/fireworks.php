<?php
/**
 * Fireworks Effect Template
 * File: includes/effects/fireworks.php
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
    
    const fireworks = [];
    const particles = [];
    const baseColor = {r: <?php echo esc_js($seasonal_effects_rgb['r']); ?>, g: <?php echo esc_js($seasonal_effects_rgb['g']); ?>, b: <?php echo esc_js($seasonal_effects_rgb['b']); ?>};
    
    // Color variations based on base color
    const colorVariations = [
        baseColor,
        {r: Math.min(baseColor.r + 50, 255), g: baseColor.g, b: baseColor.b},
        {r: baseColor.r, g: Math.min(baseColor.g + 50, 255), b: baseColor.b},
        {r: baseColor.r, g: baseColor.g, b: Math.min(baseColor.b + 50, 255)},
        {r: Math.min(baseColor.r + 30, 255), g: Math.min(baseColor.g + 30, 255), b: Math.min(baseColor.b + 30, 255)}
    ];
    
    let nextFireworkTime = Date.now() + getRandomDelay();
    
    function getRandomDelay() {
        const intensity = '<?php echo esc_js($intensity); ?>';
        if (intensity === 'light') {
            return Math.random() * 2000 + 2000; // 2-4 seconds
        } else if (intensity === 'heavy') {
            return Math.random() * 500 + 500; // 0.5-1 second
        } else {
            return Math.random() * 1000 + 1000; // 1-2 seconds
        }
    }
    
    function createFirework() {
        const now = Date.now();
        if (now >= nextFireworkTime) {
            const color = colorVariations[Math.floor(Math.random() * colorVariations.length)];
            fireworks.push({
                x: Math.random() * canvas.width * 0.6 + canvas.width * 0.2, // Launch from center 20-80%
                y: canvas.height,
                targetY: Math.random() * canvas.height * 0.4 + canvas.height * 0.1, // Explode at 10-50% height
                speed: Math.random() * 3 + 5,
                color: color,
                trail: []
            });
            nextFireworkTime = now + getRandomDelay();
        }
    }
    
    function explode(x, y, color) {
        const particleCount = Math.random() * 30 + 50; // 50-80 particles
        for (let i = 0; i < particleCount; i++) {
            const angle = (Math.PI * 2 * i) / particleCount;
            const velocity = Math.random() * 3 + 3;
            particles.push({
                x: x,
                y: y,
                vx: Math.cos(angle) * velocity,
                vy: Math.sin(angle) * velocity,
                life: 1,
                color: color,
                size: Math.random() * 2 + 1
            });
        }
    }
    
    function draw() {
        // Clear with transparency instead of black background
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Draw and update fireworks
        for (let i = fireworks.length - 1; i >= 0; i--) {
            const fw = fireworks[i];
            
            // Add to trail
            fw.trail.push({x: fw.x, y: fw.y});
            if (fw.trail.length > 10) {
                fw.trail.shift();
            }
            
            // Draw trail
            for (let j = 0; j < fw.trail.length; j++) {
                const t = fw.trail[j];
                const alpha = (j / fw.trail.length) * 0.5;
                ctx.beginPath();
                ctx.arc(t.x, t.y, 2, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${fw.color.r}, ${fw.color.g}, ${fw.color.b}, ${alpha})`;
                ctx.fill();
            }
            
            // Draw firework
            ctx.beginPath();
            ctx.arc(fw.x, fw.y, 3, 0, Math.PI * 2);
            ctx.fillStyle = `rgb(${fw.color.r}, ${fw.color.g}, ${fw.color.b})`;
            ctx.shadowBlur = 10;
            ctx.shadowColor = `rgb(${fw.color.r}, ${fw.color.g}, ${fw.color.b})`;
            ctx.fill();
            ctx.shadowBlur = 0;
            
            fw.y -= fw.speed;
            
            if (fw.y <= fw.targetY) {
                explode(fw.x, fw.y, fw.color);
                fireworks.splice(i, 1);
            }
        }
        
        // Draw and update particles
        for (let i = particles.length - 1; i >= 0; i--) {
            const p = particles[i];
            
            // Draw particle with glow
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${p.color.r}, ${p.color.g}, ${p.color.b}, ${p.life})`;
            ctx.shadowBlur = 5;
            ctx.shadowColor = `rgba(${p.color.r}, ${p.color.g}, ${p.color.b}, ${p.life})`;
            ctx.fill();
            ctx.shadowBlur = 0;
            
            p.x += p.vx;
            p.y += p.vy;
            p.vy += 0.15; // gravity
            p.vx *= 0.99; // air resistance
            p.life -= 0.02;
            
            if (p.life <= 0) {
                particles.splice(i, 1);
            }
        }
        
        createFirework();
    }
    
    function animate() {
        draw();
        requestAnimationFrame(animate);
    }
    
    animate();
    
    window.addEventListener('resize', resizeCanvas);
})();
</script>