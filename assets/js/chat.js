let activeUser = null;
const usersList = document.getElementById('usersList');
const messagesEl = document.getElementById('messages');
const chatHeader = document.getElementById('chatHeader');

async function loadUsers() {
  const res = await fetch('api/users.php');
  const data = await res.json();
  usersList.innerHTML = '';
  data.data.forEach((u) => {
    const li = document.createElement('li');
    li.textContent = `${u.name} (@${u.username})`;
    li.onclick = () => { activeUser = u; chatHeader.textContent = `Chat with ${u.name}`; loadMessages(); };
    usersList.appendChild(li);
  });
}

async function loadMessages() {
  if (!activeUser) return;
  const res = await fetch(`api/get_messages.php?other=${activeUser.id}`);
  const data = await res.json();
  messagesEl.innerHTML = '';
  data.data.forEach((m) => {
    const div = document.createElement('div');
    div.className = `msg ${m.from === window.ME_ID ? 'me' : 'them'}`;
    div.textContent = m.text;
    messagesEl.appendChild(div);
  });
  messagesEl.scrollTop = messagesEl.scrollHeight;
}

document.getElementById('sendForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  if (!activeUser) return;
  const input = document.getElementById('messageInput');
  const fd = new FormData();
  fd.append('to', activeUser.id);
  fd.append('text', input.value);
  const res = await fetch('api/send_message.php', { method: 'POST', body: fd });
  const data = await res.json();
  if (data.success) { input.value = ''; loadMessages(); }
});

loadUsers();
setInterval(loadMessages, 3000);
