<link rel="icon" href="/img/LogoCouleur.png" type="image/x-icon">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.cookie.split('; ').find(row => row.startsWith('modeSombre=true'))) {
            const favicon = document.querySelector('link[rel="icon"]');
            if (favicon) {
                favicon.href = "/img/Logo_N&B.png";
            }
        }
    });
</script>
