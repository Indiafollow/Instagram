let activeUser = null;
let users = [];

const usersList = document.getElementById('usersList');
const messagesEl = document.getElementById('messages');
const chatHeader = document.getElementById('chatHeader');
const searchInput = document.getElementById('searchUsers');
const inboxPanel = document.getElementById('inboxPanel');
const chatPanel = document.getElementById('chatPanel');

const formatTime = (iso) => iso ? new Date(iso).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' }) : '';

function openChat(u) {
  activeUser = u;
  chatHeader.innerHTML = `<button class="back-btn" onclick="closeChat()">←</button> <img class="mini-avatar" src="${u.avatar}"/> <div><strong>${u.name}</strong><small>@${u.username}</small></div>`;
  inboxPanel.classList.add('hide-mobile');
  chatPanel.classList.add('show-mobile');
  renderUsers(searchInput.value);
  loadMessages();
}
window.closeChat = function() {
  inboxPanel.classList.remove('hide-mobile');
  chatPanel.classList.remove('show-mobile');
};

function renderUsers(filter = '') {
  usersList.innerHTML = '';
  const needle = filter.toLowerCase();
  users.filter((u)=>!needle||u.name.toLowerCase().includes(needle)||u.username.toLowerCase().includes(needle)).forEach((u)=>{
    const li = document.createElement('li');
    li.className = `thread ${activeUser?.id===u.id?'active':''}`;
    li.innerHTML = `<img class="avatar ring" src="${u.avatar}"><div class="meta"><div class="row"><strong>${u.username}</strong><span>${u.last_time?formatTime(u.last_time):''}</span></div><p>${u.last_text||'Start chat'}</p></div>${u.unread?`<b class="count">${u.unread}</b>`:''}`;
    li.onclick=()=>openChat(u);
    usersList.appendChild(li);
  });
}

async function loadUsers(){const r=await fetch('api/users.php');const d=await r.json();if(d.success){users=d.data;renderUsers(searchInput.value);}}

async function loadMessages(){
  if(!activeUser) return;
  const r=await fetch(`api/get_messages.php?other=${activeUser.id}`); const d=await r.json(); if(!d.success) return;
  messagesEl.innerHTML='';
  d.data.forEach((m)=>{const el=document.createElement('article');el.className=`msg ${m.from===window.ME_ID?'me':'them'}`;el.innerHTML=`<p>${m.text}</p><small>${formatTime(m.time)}</small>`;messagesEl.appendChild(el);});
  messagesEl.scrollTop=messagesEl.scrollHeight;
}

document.getElementById('sendForm').addEventListener('submit', async(e)=>{
  e.preventDefault(); if(!activeUser) return;
  const input=document.getElementById('messageInput'); const text=input.value.trim(); if(!text) return;
  const fd=new FormData(); fd.append('to',activeUser.id); fd.append('text',text);
  const r=await fetch('api/send_message.php',{method:'POST',body:fd}); const d=await r.json();
  if(d.success){input.value=''; await loadMessages(); await loadUsers();}
});
searchInput.addEventListener('input',()=>renderUsers(searchInput.value));
loadUsers(); setInterval(async()=>{await loadUsers(); await loadMessages();},2500);
