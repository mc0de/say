/**
 * Message notification module
 * Handles success and error message display, countdown, and auto-hide
 */
export class MessageNotifications {
    constructor(options = {}) {
        this.successMessageId = options.successMessageId || 'success-message';
        this.errorMessageId = options.errorMessageId || 'error-message';
        this.countdownTimerId = options.countdownTimerId || 'countdown-timer';
        this.countdownDuration = options.countdownDuration || 5000;
        this.fadeDuration = options.fadeDuration || 150;
    }

    /**
     * Initialize message notifications
     */
    init() {
        this.handleSuccessMessage();
        this.handleErrorMessage();
    }

    /**
     * Handle success message with countdown and auto-hide
     */
    handleSuccessMessage() {
        const successMessage = document.getElementById(this.successMessageId);
        if (!successMessage) return;

        const countdownTimer = document.getElementById(this.countdownTimerId);
        let seconds = Math.floor(this.countdownDuration / 1000);

        const updateCountdown = () => {
            seconds--;
            if (countdownTimer) {
                countdownTimer.textContent = seconds + 's';
            }

            if (seconds > 0) {
                setTimeout(updateCountdown, 1000);
            } else {
                this.fadeOut(successMessage);
            }
        };

        // Start countdown after 1 second
        setTimeout(updateCountdown, 1000);
    }

    /**
     * Handle error message with auto-hide
     */
    handleErrorMessage() {
        const errorMessage = document.getElementById(this.errorMessageId);
        if (!errorMessage) return;

        setTimeout(() => {
            this.fadeOut(errorMessage);
        }, this.countdownDuration);
    }

    /**
     * Fade out and remove message element
     */
    fadeOut(element) {
        element.style.opacity = '0';
        element.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            element.remove();
        }, this.fadeDuration);
    }
}

