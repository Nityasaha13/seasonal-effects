<?php
/**
 * Autumn Leaves Effect Template
 * File: includes/effects/autumn.php
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
    
    const leaves = [];
    const numberOfLeaves = <?php echo esc_js($particle_count); ?>;
    const leafColors = ['#e63946', '#f77f00', '#fcbf49', '#d62828', '#8b4513'];
    
    // Initialize leaves
    for (let i = 0; i < numberOfLeaves; i++) {
        leaves.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height - canvas.height,
            size: Math.random() * 15 + 10,
            speed: Math.random() * 2 + 0.5,
            drift: Math.random() * 2 - 1,
            rotation: Math.random() * 360,
            rotationSpeed: Math.random() * 4 - 2,
            color: leafColors[Math.floor(Math.random() * leafColors.length)],
            opacity: Math.random() * 0.6 + 0.4
        });
    }
    
    function drawLeaves() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        for (let leaf of leaves) {
            ctx.save();
            ctx.translate(leaf.x, leaf.y);
            ctx.rotate((leaf.rotation * Math.PI) / 180);
            ctx.globalAlpha = leaf.opacity;
            
            // Draw simple leaf shape
            ctx.beginPath();
            ctx.ellipse(0, 0, leaf.size / 2, leaf.size, 0, 0, Math.PI * 2);
            ctx.fillStyle = leaf.color;
            ctx.fill();
            
            ctx.restore();
        }
        
        updateLeaves();
    }
    
    function updateLeaves() {
        for (let leaf of leaves) {
            leaf.y += leaf.speed;
            leaf.x += Math.sin(leaf.y / 50) * leaf.drift;
            leaf.rotation += leaf.rotationSpeed;
            
            if (leaf.y > canvas.height) {
                leaf.y = -20;
                leaf.x = Math.random() * canvas.width;
            }
        }
    }
    
    function animate() {
        drawLeaves();
        requestAnimationFrame(animate);
    }
    
    animate();
    
    window.addEventListener('resize', resizeCanvas);
})();
</script>