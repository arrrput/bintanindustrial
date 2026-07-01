    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.getElementById('logs-table-body');
        const filterForm = document.getElementById('filter-form');
        const liveIndicator = document.getElementById('live-indicator');
        let pollingInterval;
        let searchTimeout;

        function fetchLogs(showIndicator = false) {
            if (showIndicator) liveIndicator.classList.remove('d-none');

            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            const fetchUrl = `${window.location.pathname}?${params.toString()}`;

            fetch(fetchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = data.table;
                liveIndicator.classList.add('d-none');
            })
            .catch(error => {
                console.error('Error fetching logs:', error);
                liveIndicator.classList.add('d-none');
            });
        }

        // Real-time listeners for filters
        ['filter-module', 'filter-action'].forEach(id => {
            document.getElementById(id).addEventListener('change', () => fetchLogs(true));
        });

        // Debounced listener for search
        document.getElementById('filter-search').addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => fetchLogs(true), 500);
        });

        // Poll every 5 seconds
        pollingInterval = setInterval(fetchLogs, 5000);
    });
