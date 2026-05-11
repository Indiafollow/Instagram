let activeUser = null;
let users = [];

const usersList = document.getElementById('usersList');
const messagesEl = document.getElementById('messages');
const chatHeader = document.getElementById('chatHeader');
const searchInput = document.getElementById('searchUsers');

const formatTime = (iso) => {
  if (!iso) return '';
  const d = new Date(iso);
  return d.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
};

function renderUsers(filter = '') {
  usersList.innerHTML = '';
  const needle = filter.toLowerCase();
  users
    .filter((u) => !needle || u.name.toLowerCase().includes(needle) || u.username.toLowerCase().includes(needle))
    .forEach((u) => {
      const li = document.createElement('li');
      li.className = `user-item ${activeUser?.id === u.id ? 'active' : ''}`;
      li.innerHTML = `
        <img class="avatar" src="${u.avatar}" alt="${u.username}" />
        <div class="user-meta">
          <div class="name-row"><strong>${u.name}</strong><span>${u.last_time ? formatTime(u.last_time) : ''}</span></div>
          <div class="preview">${u.last_text || 'Start chatting...'}</div>
        </div>
        ${u.unread ? `<span class="badge">${u.unread}</span>` : ''}
      `;
      li.onclick = () => {
        activeUser = u;
        chatHeader.textContent = `${u.name} · @${u.username}`;
        renderUsers(searchInput.value);
        loadMessages();
      };
      usersList.appendChild(li);
    });
}

async function loadUsers() {
  const res = await fetch('api/users.php');
  const data = await res.json();
  if (data.success) {
    users = data.data;
    renderUsers(searchInput.value);
  }
}

async function loadMessages() {
  if (!activeUser) return;
  const res = await fetch(`api/get_messages.php?other=${activeUser.id}`);
  const data = await res.json();
  if (!data.success) return;
  messagesEl.innerHTML = '';
  data.data.forEach((m) => {
    const div = document.createElement('article');
    div.className = `msg ${m.from === window.ME_ID ? 'me' : 'them'}`;
    div.innerHTML = `<p>${m.text}</p><small>${formatTime(m.time)}${m.from === window.ME_ID ? (m.seen ? ' · Seen' : ' · Sent') : ''}</small>`;
    messagesEl.appendChild(div);
  });
  messagesEl.scrollTop = messagesEl.scrollHeight;
}

document.getElementById('sendForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  if (!activeUser) return;
  const input = document.getElementById('messageInput');
  const text = input.value.trim();
  if (!text) return;

  const fd = new FormData();
  fd.append('to', activeUser.id);
  fd.append('text', text);
  const res = await fetch('api/send_message.php', { method: 'POST', body: fd });
  const data = await res.json();
  if (data.success) {
    input.value = '';
    await loadMessages();
    await loadUsers();
  }
});

searchInput.addEventListener('input', () => renderUsers(searchInput.value));

loadUsers();
setInterval(async () => {
  await loadUsers();
  await loadMessages();
}, 2500);
