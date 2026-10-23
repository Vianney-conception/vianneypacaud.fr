document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contact-form');
    if (!form) return;

    // Métriques de suivi
    const metrics = {
        keyPressIntervals: [],
        lastKeyDownTime: null,
        backspaceCount: 0, 
        mouseMovements: 0,     
        pasteEvents: 0,     
        focusEvents: 0,        
        startTime: Date.now()
    };

    const inputs = form.querySelectorAll('input:not([type="hidden"]), textarea');
    const messageField = document.getElementById('message');
    form.addEventListener('mousemove', () => metrics.mouseMovements++);
    form.addEventListener('touchstart', () => metrics.mouseMovements += 5);
    inputs.forEach(input => {
        input.addEventListener('focus', () => metrics.focusEvents++);

        input.addEventListener('keydown', (e) => {
            const now = Date.now();

            if (metrics.lastKeyDownTime) {
                const interval = now - metrics.lastKeyDownTime;
                metrics.keyPressIntervals.push(interval);
            }
            metrics.lastKeyDownTime = now;

            if (e.key === 'Backspace' || e.key === 'Delete') {
                metrics.backspaceCount++;
            }
        });

        input.addEventListener('paste', () => metrics.pasteEvents++);
    });
    function calculateHumanScore() {
        let score = 0;
        const intervals = metrics.keyPressIntervals;
        if (metrics.mouseMovements > 5) score += 20;
        if (metrics.focusEvents > 0) score += 15;

        if (intervals.length > 5) {
            const sum = intervals.reduce((a, b) => a + b, 0);
            const avg = sum / intervals.length;

            if (avg >= 40 && avg <= 500) {
                score += 30;
            }

            const variance = intervals.reduce((acc, val) => acc + Math.pow(val - avg, 2), 0) / intervals.length;
            const stdDev = Math.sqrt(variance);
            if (stdDev > 15) {
                score += 25;
            }
        } else if (metrics.pasteEvents > 0 && metrics.mouseMovements > 2) {
            score += 35;
        }
        if (metrics.backspaceCount > 0) score += 10;

        return Math.min(score, 100);
    }
    form.addEventListener('submit', (e) => {
        const score = calculateHumanScore();
        document.getElementById('bot_human_score').value = score;
        document.getElementById('bot_behavior_data').value = JSON.stringify({
            avgInterval: intervalsAverage(metrics.keyPressIntervals),
            totalKeypresses: metrics.keyPressIntervals.length,
            mouseMovements: metrics.mouseMovements,
            backspaces: metrics.backspaceCount,
            pastes: metrics.pasteEvents,
            elapsedTimeMs: Date.now() - metrics.startTime
        });
    });

    function intervalsAverage(arr) {
        if (!arr.length) return 0;
        return Math.round(arr.reduce((a, b) => a + b, 0) / arr.length);
    }
});