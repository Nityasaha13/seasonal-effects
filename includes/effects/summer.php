<?php
/**
 * Hot Summer (Bright Sun) Effect Template
 * File: includes/effects/summer.php
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
    
    const baseColor = {r: <?php echo esc_js($rgb['r']); ?>, g: <?php echo esc_js($rgb['g']); ?>, b: <?php echo esc_js($rgb['b']); ?>};
    const intensity = '<?php echo esc_js($intensity); ?>';
    
    // Sun configuration
    const sun = {
        x: canvas.width * 0.85,
        y: canvas.height * 0.15,
        radius: intensity === 'light' ? 40 : intensity === 'heavy' ? 80 : 60,
        pulsePhase: 0,
        pulseSpeed: 0.02
    };
    
    // Heat wave particles
    const heatWaves = [];
    const numberOfWaves = <?php echo esc_js($particle_count); ?>;
    
    for (let i = 0; i < numberOfWaves; i++) {
        heatWaves.push({
            x: Math.random() * canvas.width,
            y: canvas.height,
            width: Math.random() * 40 + 20,
            height: Math.random() * 100 + 50,
            speed: Math.random() * 1.5 + 0.5,
            opacity: Math.random() * 0.15 + 0.05,
            phase: Math.random() * Math.PI * 2,
            waveSpeed: Math.random() * 0.05 + 0.02
        });
    }
    
    // Light rays
    const rays = [];
    const numberOfRays = intensity === 'light' ? 8 : intensity === 'heavy' ? 16 : 12;
    
    for (let i = 0; i < numberOfRays; i++) {
        rays.push({
            angle: (Math.PI * 2 / numberOfRays) * i,
            length: sun.radius * 2,
            opacity: Math.random() * 0.3 + 0.2,
            rotationSpeed: 0.001
        });
    }
    
    function drawSun() {
        ctx.save();
        
        // Pulsing effect
        const pulse = Math.sin(sun.pulsePhase) * 0.1 + 1;
        const currentRadius = sun.radius * pulse;
        
        // Draw sun rays
        for (let ray of rays) {
            ctx.save();
            ctx.translate(sun.x, sun.y);
            ctx.rotate(ray.angle);
            
            const rayGradient = ctx.createLinearGradient(0, 0, ray.length, 0);
            rayGradient.addColorStop(0, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, ${ray.opacity})`);
            rayGradient.addColorStop(1, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, 0)`);
            
            ctx.beginPath();
            ctx.moveTo(0, -5);
            ctx.lineTo(ray.length, -2);
            ctx.lineTo(ray.length, 2);
            ctx.lineTo(0, 5);
            ctx.closePath();
            ctx.fillStyle = rayGradient;
            ctx.fill();
            
            ctx.restore();
            
            ray.angle += ray.rotationSpeed;
        }
        
        // Draw sun outer glow
        const outerGlow = ctx.createRadialGradient(sun.x, sun.y, currentRadius * 0.5, sun.x, sun.y, currentRadius * 2);
        outerGlow.addColorStop(0, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, 0.4)`);
        outerGlow.addColorStop(0.5, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, 0.2)`);
        outerGlow.addColorStop(1, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, 0)`);
        
        ctx.beginPath();
        ctx.arc(sun.x, sun.y, currentRadius * 2, 0, Math.PI * 2);
        ctx.fillStyle = outerGlow;
        ctx.fill();
        
        // Draw sun main body
        const gradient = ctx.createRadialGradient(sun.x, sun.y, 0, sun.x, sun.y, currentRadius);
        gradient.addColorStop(0, `rgba(${Math.min(baseColor.r + 80, 255)}, ${Math.min(baseColor.g + 80, 255)}, ${Math.min(baseColor.b + 50, 255)}, 0.9)`);
        gradient.addColorStop(0.7, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, 0.8)`);
        gradient.addColorStop(1, `rgba(${baseColor.r}, ${baseColor.g}, ${baseColor.b}, 0.6)`);
        
        ctx.beginPath();
        ctx.arc(sun.x, sun.y, currentRadius, 0, Math.PI * 2);
        ctx.fillStyle = gradient;
        ctx.fill();
        
        ctx.restore();
        
        sun.pulsePhase += sun.pulseSpeed;
    }
    
    function drawHeatWaves() {
        for (let wave of heatWaves) {
            ctx.save();
            
            // Create wavy distortion effect
            const waveOffset = Math.sin(wave.phase) * 15;
            
            const gradient = ctx.createLinearGradient(wave.x, wave.y, wave.x, wave.y - wave.height);
            gradient.addColorStop(0, `rgba(${baseColor.r}, ${Math.min(baseColor.g + 50, 255)}, ${baseColor.b}, 0)`);
            gradient.addColorStop(0.5, `rgba(${baseColor.r}, ${Math.min(baseColor.g + 50, 255)}, ${baseColor.b}, ${wave.opacity})`);
            gradient.addColorStop(1, `rgba(${baseColor.r}, ${Math.min(baseColor.g + 50, 255)}, ${baseColor.b}, 0)`);
            
            ctx.fillStyle = gradient;
            ctx.beginPath();
            ctx.moveTo(wave.x + waveOffset, wave.y);
            ctx.quadraticCurveTo(
                wave.x + wave.width / 2 - waveOffset, wave.y - wave.height / 2,
                wave.x + waveOffset, wave.y - wave.height
            );
            ctx.lineTo(wave.x - wave.width + waveOffset, wave.y - wave.height);
            ctx.quadraticCurveTo(
                wave.x - wave.width / 2 - waveOffset, wave.y - wave.height / 2,
                wave.x - wave.width + waveOffset, wave.y
            );
            ctx.closePath();
            ctx.fill();
            
            ctx.restore();
        }
    }
    
    function updateHeatWaves() {
        for (let wave of heatWaves) {
            wave.y -= wave.speed;
            wave.phase += wave.waveSpeed;
            
            if (wave.y < -wave.height) {
                wave.y = canvas.height;
                wave.x = Math.random() * canvas.width;
            }
        }
    }
    
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        drawHeatWaves();
        drawSun();
        updateHeatWaves();
    }
    
    function animate() {
        draw();
        requestAnimationFrame(animate);
    }
    
    animate();
    
    window.addEventListener('resize', function() {
        const oldWidth = canvas.width;
        const oldHeight = canvas.height;
        resizeCanvas();
        
        // Adjust sun position proportionally
        sun.x = (sun.x / oldWidth) * canvas.width;
        sun.y = (sun.y / oldHeight) * canvas.height;
    });
})();
</script>