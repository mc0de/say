/**
 * Confetti animation module
 * Creates a celebratory confetti effect with emerald green theme
 */
export class Confetti {
    constructor(options = {}) {
        this.canvasId = options.canvasId || 'confetti-canvas';
        this.colors = options.colors || ['#10b981', '#059669', '#34d399', '#6ee7b7', '#a7f3d0'];
        this.particleCount = options.particleCount || 80;
        this.duration = options.duration || 3000;
        this.canvas = null;
        this.ctx = null;
        this.animationId = null;
    }

    /**
     * Initialize the confetti canvas
     */
    init() {
        const canvas = document.getElementById(this.canvasId);
        if (!canvas) {
            console.warn(`Confetti canvas with id "${this.canvasId}" not found`);
            return false;
        }

        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.resize();
        
        // Handle window resize
        window.addEventListener('resize', () => this.resize());
        
        return true;
    }

    /**
     * Resize canvas to match window dimensions
     */
    resize() {
        if (this.canvas) {
            this.canvas.width = window.innerWidth;
            this.canvas.height = window.innerHeight;
        }
    }

    /**
     * Create and animate confetti particles
     */
    start() {
        if (!this.canvas || !this.ctx) {
            if (!this.init()) return;
        }

        this.canvas.style.display = 'block';
        
        const particles = this.createParticles();
        const startTime = Date.now();

        const animate = () => {
            const elapsed = Date.now() - startTime;
            const progress = elapsed / this.duration;

            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

            let activeParticles = 0;

            particles.forEach((particle) => {
                const fadeProgress = Math.min(progress * 1.5, 1);
                const currentOpacity = particle.opacity * (1 - fadeProgress);

                if (currentOpacity > 0 && particle.y < this.canvas.height) {
                    this.drawParticle(particle, currentOpacity);
                    this.updateParticle(particle);
                    activeParticles++;
                }
            });

            if (activeParticles > 0 && progress < 1) {
                this.animationId = requestAnimationFrame(animate);
            } else {
                this.stop();
            }
        };

        animate();
    }

    /**
     * Create confetti particles
     */
    createParticles() {
        const particles = [];

        for (let i = 0; i < this.particleCount; i++) {
            particles.push({
                x: Math.random() * this.canvas.width,
                y: -10,
                width: Math.random() * 8 + 4,
                height: Math.random() * 8 + 4,
                speed: Math.random() * 3 + 2,
                rotation: Math.random() * 360,
                rotationSpeed: Math.random() * 10 - 5,
                color: this.colors[Math.floor(Math.random() * this.colors.length)],
                opacity: Math.random() * 0.5 + 0.5,
            });
        }

        return particles;
    }

    /**
     * Draw a single particle
     */
    drawParticle(particle, opacity) {
        this.ctx.save();
        this.ctx.globalAlpha = opacity;
        this.ctx.fillStyle = particle.color;
        this.ctx.translate(particle.x, particle.y);
        this.ctx.rotate((particle.rotation * Math.PI) / 180);
        this.ctx.fillRect(
            -particle.width / 2,
            -particle.height / 2,
            particle.width,
            particle.height
        );
        this.ctx.restore();
    }

    /**
     * Update particle position and rotation
     */
    updateParticle(particle) {
        particle.y += particle.speed;
        particle.x += Math.sin(particle.y * 0.01) * 2;
        particle.rotation += particle.rotationSpeed;
    }

    /**
     * Stop the animation and hide canvas
     */
    stop() {
        if (this.animationId) {
            cancelAnimationFrame(this.animationId);
            this.animationId = null;
        }
        if (this.canvas) {
            this.canvas.style.display = 'none';
        }
    }
}

