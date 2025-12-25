/**
 * Main Say application initialization
 * Coordinates confetti and message notifications
 */
import { Confetti } from './modules/confetti.js';
import { MessageNotifications } from './modules/messages.js';

class SayApp {
    constructor() {
        this.confetti = new Confetti({
            duration: 3000,
            particleCount: 80,
        });
        this.messages = new MessageNotifications({
            countdownDuration: 5000,
        });
    }

    /**
     * Initialize the application
     */
    init() {
        // Initialize confetti canvas
        this.confetti.init();

        // Initialize message notifications
        this.messages.init();

        // Trigger confetti if success message is present
        this.triggerConfettiOnSuccess();
    }

    /**
     * Trigger confetti animation when success message is displayed
     */
    triggerConfettiOnSuccess() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            this.confetti.start();
        }
    }
}

// Initialize app when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        const app = new SayApp();
        app.init();
    });
} else {
    // DOM is already ready
    const app = new SayApp();
    app.init();
}

