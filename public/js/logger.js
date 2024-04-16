class Logger {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
    }

    log(message, type = "black") {
        const logEntry = document.createElement("li");
        logEntry.className = `text-${type}`;
        logEntry.textContent = message;
        this.container.prepend(logEntry);
    }

    info(message) {
        this.log(message, "primary");
    }

    succ(message) {
        this.log(message, "success");
    }

    warn(message) {
        this.log(message, "warning");
    }

    error(message) {
        this.log(message, "danger");
    }

    clear() {
        this.container.innerHTML = "";
    }
}
