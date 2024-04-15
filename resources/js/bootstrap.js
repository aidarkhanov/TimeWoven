import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.timezoneDetector = (timezone) => {
    return {
        timezone,
        detectTimezone() {
            this.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            document.getElementById('timezone').value = this.timezone; // Ensure the select reflects this value
        }
    }
};
