<?php
/**
 * Confetti Effect Template
 * File: includes/effects/confetti.php
 */

if (!defined('ABSPATH')) {
    exit;
}

$rgb = hex_to_rgb($color);
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
    
    const confetti = [];
    const numberOfPieces = <?php echo esc_js($particle_count); ?>;
    const baseColor = {r: <?php echo esc_js($rgb['r']); ?>, g: <?php echo esc_js($rgb['g']); ?>, b: <?php echo esc_js($rgb['b']); ?>};
    
    // Create color variations based on base color
    const colors = [
        baseColor,
        {r: Math.min(baseColor.r + 50, 255), g: baseColor.g, b: baseColor.b},
        {r: baseColor.r, g: Math.min(baseColor.g + 50, 255), b: baseColor.b},
        {r: baseColor.r, g: baseColor.g, b: Math.min(baseColor.b + 50, 255)},
        {r: Math.max(baseColor.r - 50, 0), g: Math.max(baseColor.g - 50, 0), b: Math.max(baseColor.b - 50, 0)},
        {r: Math.min(baseColor.r + 30, 255), g: Math.min(baseColor.g + 30, 255), b: baseColor.b}
    ];
    
    // Initialize confetti
    for (let i = 0; i < numberOfPieces; i++) {
        const color = colors[Math.floor(Math.random() * colors.length)];
        confetti.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height - canvas.height,
            width: Math.random() * 10 + 5,
            height: Math.random() * 5 + 3,
            speed: Math.random() * 3 + 2,
            rotation: Math.random() * 360,
            rotationSpeed: Math.random() * 10 - 5,
            drift: Math.random() * 2 - 1,
            color: color,
            opacity: Math.random() * 0.6 + 0.4
        });
    }
    
    function drawConfetti() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        for (let piece of confetti) {
            ctx.save();
            ctx.translate(piece.x, piece.y);
            ctx.rotate((piece.rotation * Math.PI) / 180);
            ctx.globalAlpha = piece.opacity;
            ctx.fillStyle = `rgb(${piece.color.r}, ${piece.color.g}, ${piece.color.b})`;
            ctx.fillRect(-piece.width / 2, -piece.height / 2, piece.width, piece.height);
            ctx.restore();
        }
        
        updateConfetti();
    }
    
    function updateConfetti() {
        for (let piece of confetti) {
            piece.y += piece.speed;
            piece.x += piece.drift;
            piece.rotation += piece.rotationSpeed;
            
            if (piece.y > canvas.height) {
                piece.y = -20;
                piece.x = Math.random() * canvas.width;
            }
        }
    }
    
    function animate() {
        drawConfetti();
        requestAnimationFrame(animate);
    }
    
    animate();
    
    window.addEventListener('resize', resizeCanvas);
})();
</script>