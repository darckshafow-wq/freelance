document.addEventListener('DOMContentLoaded', function() {
    const messageForm = document.getElementById('messageForm');
    const chatMessages = document.getElementById('chatMessages');
    const messageContent = document.getElementById('messageContent');
    const taskId = document.getElementById('taskId').value;
    const receiverId = document.getElementById('receiverId').value;
    const currentUserId = document.getElementById('currentUserId').value;

    let lastMessageId = 0;
    const lastMessageElement = chatMessages.querySelector('.message:last-child');
    if (lastMessageElement) {
        lastMessageId = lastMessageElement.getAttribute('data-id');
    }

    // Scroll to bottom on load
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Send Message
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const content = messageContent.value.trim();
        if (!content) return;

        const formData = new FormData();
        formData.append('task_id', taskId);
        formData.append('receiver_id', receiverId);
        formData.append('content', content);

        fetch('index.php?page=send_message', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                messageContent.value = '';
                // Pull immediately after sending
                pollMessages();
            }
        })
        .catch(error => console.error('Error sending message:', error));
    });

    // Polling for new messages
    function pollMessages() {
        fetch(`index.php?page=get_new_messages&task_id=${taskId}&receiver_id=${receiverId}&last_id=${lastMessageId}`)
        .then(response => response.json())
        .then(messages => {
            if (messages.length > 0) {
                messages.forEach(msg => {
                    const isSent = msg.sender_id == currentUserId;
                    const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    
                    const group = document.createElement('div');
                    group.className = 'message-group';
                    if (isSent) group.style.alignItems = 'flex-end';
                    
                    group.innerHTML = `
                        <div class="message-info" style="${isSent ? 'justify-content: flex-end;' : ''}">
                            <span>${isSent ? 'Moi' : 'Partenaire'}</span> • <span>${time}</span>
                        </div>
                        <div class="bubble ${isSent ? 'sent' : 'received'}">
                            ${escapeHtml(msg.content)}
                        </div>
                    `;
                    
                    chatMessages.appendChild(group);
                    lastMessageId = msg.id;
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        })
        .catch(error => console.error('Error polling messages:', error));
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Poll every 3 seconds
    setInterval(pollMessages, 3000);
});