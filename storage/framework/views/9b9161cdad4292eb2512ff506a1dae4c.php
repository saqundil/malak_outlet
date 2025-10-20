<style>
/* Enhanced animations and effects */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-gradient {
    animation: gradient 15s ease infinite;
}

.card-shine::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.card-shine:hover::before {
    left: 100%;
}

.product-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-card:hover {
    transform: translateY(-8px) scale(1.02);
}

.btn-gradient {
    background: linear-gradient(135deg, #f97316, #ea580c, #dc2626);
    background-size: 200% 200%;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    background-position: right center;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(249, 115, 22, 0.4);
}

.text-gradient {
    background: linear-gradient(135deg, #f97316, #ea580c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Section dividers */
.section-divider {
    position: relative;
    margin: 3rem 0;
}

.section-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 2px;
    background: linear-gradient(90deg, transparent, #f97316, transparent);
}

/* Countdown timer styles */
.countdown-timer {
    background: rgba(0, 0, 0, 0.8);
    border-radius: 8px;
    padding: 8px 12px;
    color: white;
    font-size: 12px;
    font-weight: bold;
}

/* Custom scrollbar for horizontal scroll sections */
.custom-scrollbar::-webkit-scrollbar {
    height: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #f97316;
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #ea580c;
}

/* Enhanced product cards */
.product-card-enhanced {
    position: relative;
    overflow: hidden;
}

.product-card-enhanced::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s;
}

.product-card-enhanced:hover::after {
    transform: translateX(100%);
}

/* Pulse animation for badges */
@keyframes pulse-orange {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.animate-pulse-orange {
    animation: pulse-orange 2s infinite;
}

/* Modern glass effect */
.glass-effect {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Enhanced hover effects */
.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* Newsletter section background animation */
.newsletter-bg {
    background: linear-gradient(-45deg, #f97316, #ea580c, #dc2626, #f59e0b);
    background-size: 400% 400%;
    animation: gradient 15s ease infinite;
}

/* Enhanced loading animation */
.loading-dots::after {
    content: '';
    animation: loading-dots 1.5s infinite;
}

@keyframes loading-dots {
    0%, 20% { content: ''; }
    40% { content: '.'; }
    60% { content: '..'; }
    80%, 100% { content: '...'; }
}
</style>
<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/partials/home/styles.blade.php ENDPATH**/ ?>