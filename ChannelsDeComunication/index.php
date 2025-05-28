<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ConcileV2</title>
    <link rel="stylesheet" href="/css/styles.css">
    <?php include '../facivon/index.php'; ?>
</head>
<body class="Claire">
        <?php include '../header/index.php'; ?>


    <div class="chat-container">
        <h2>Canal de communication en direct</h2>
        <div id="chat-messages" class="chat-messages"></div>
        <form id="chat-form" class="chat-input" autocomplete="off">
            <input type="text" id="chat-message" placeholder="Votre message..." required maxlength="200">
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <script>
        function fetchMessages() {
            fetch('chat_handler.php?action=get')
                .then(response => response.json())
                .then(data => {
                    const chat = document.getElementById('chat-messages');
                    chat.innerHTML = '';
                    data.forEach(msg => {
                        const div = document.createElement('div');
                        div.textContent = `[${msg.time}] ${msg.user}: ${msg.text}`;
                        chat.appendChild(div);
                    });
                    chat.scrollTop = chat.scrollHeight;
                });
        }

        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const input = document.getElementById('chat-message');
            const message = input.value.trim();
            if (message.length === 0) return;
            fetch('chat_handler.php?action=send', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'message=' + encodeURIComponent(message)
            }).then(() => {
                input.value = '';
                fetchMessages();
            });
        });

        setInterval(fetchMessages, 2000);
        fetchMessages();
    </script>
</body>

<script src="/Scripts/MoteurRendu.js"></script>
<script src="/Scripts/Langages.js"></script>
<script src="/Scripts/cookie.js"></script>

</html>