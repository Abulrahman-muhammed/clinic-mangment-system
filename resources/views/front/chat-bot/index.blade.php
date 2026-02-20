@extends('front.inc.master')
@section('title', 'AI Health Assistant')

@section('content')

<style>
/* ========================================================
   CHATBOT PAGE — prefix: cb-
   Dark clinical aesthetic — deep navy + electric blue + gold
   ======================================================== */

@keyframes cbFadeIn  { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
@keyframes cbSlideR  { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
@keyframes cbSlideL  { from { opacity:0; transform:translateX(-20px); } to { opacity:1; transform:translateX(0); } }
@keyframes cbPulse   { 0%,100%{opacity:1;} 50%{opacity:0.3;} }
@keyframes cbSpin    { to { transform:rotate(360deg); } }
@keyframes cbGlow    { 0%,100%{box-shadow:0 0 20px rgba(0,106,255,0.3);} 50%{box-shadow:0 0 40px rgba(0,106,255,0.6);} }
@keyframes cbTyping  { 0%,60%,100%{transform:translateY(0);} 30%{transform:translateY(-6px);} }
@keyframes cbWave    {
  0%   { background-position: 0% 50%; }
  50%  { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* ── PAGE WRAPPER ── */
.cb-page {
  background: #030d1f;
  min-height: calc(100vh - 72px);
  display: flex;
  flex-direction: column;
  font-family: 'DM Sans', sans-serif;
}

/* ── TOP HEADER ── */
.cb-header {
  background: rgba(5,20,58,0.95);
  backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(0,106,255,0.15);
  padding: 16px 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 50;
}
.cb-header-left { display: flex; align-items: center; gap: 14px; }
.cb-bot-avatar {
  width: 44px; height: 44px;
  border-radius: 14px;
  background: linear-gradient(135deg, #006aff 0%, #0040cc 100%);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.1rem; color: #fff;
  box-shadow: 0 0 20px rgba(0,106,255,0.4);
  animation: cbGlow 3s ease-in-out infinite;
  position: relative;
  flex-shrink: 0;
}
.cb-bot-status {
  position: absolute; bottom: -2px; right: -2px;
  width: 12px; height: 12px; border-radius: 50%;
  background: #10b981; border: 2px solid #030d1f;
}
.cb-bot-name {
  font-family: 'Fraunces', serif;
  font-size: 1.05rem; font-weight: 600; color: #fff;
  line-height: 1.2;
}
.cb-bot-subtitle {
  font-size: 0.72rem; color: rgba(255,255,255,0.38);
  font-weight: 300; letter-spacing: 0.04em;
}
.cb-header-badges { display: flex; gap: 8px; }
.cb-badge {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 5px 12px; border-radius: 9999px;
  font-size: 0.7rem; font-weight: 600;
  border: 1px solid rgba(255,255,255,0.1);
  color: rgba(255,255,255,0.5);
  background: rgba(255,255,255,0.05);
  letter-spacing: 0.04em;
}
.cb-badge i { color: #c9a84c; font-size: 0.65rem; }
.cb-clear-btn {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 8px 16px; border-radius: 10px;
  font-size: 0.78rem; font-weight: 600; color: rgba(255,255,255,0.45);
  background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
  cursor: pointer; transition: .3s; font-family: 'DM Sans', sans-serif;
}
.cb-clear-btn:hover { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.75); }

/* ── CHAT AREA ── */
.cb-chat-area {
  flex: 1;
  overflow-y: auto;
  padding: 32px 0;
  scroll-behavior: smooth;
}
.cb-chat-area::-webkit-scrollbar { width: 4px; }
.cb-chat-area::-webkit-scrollbar-track { background: transparent; }
.cb-chat-area::-webkit-scrollbar-thumb { background: rgba(0,106,255,0.3); border-radius: 9999px; }

.cb-messages {
  max-width: 820px; margin: 0 auto; padding: 0 24px;
  display: flex; flex-direction: column; gap: 20px;
}

/* ── WELCOME ── */
.cb-welcome {
  text-align: center; padding: 40px 0 20px;
  animation: cbFadeIn .6s ease-out;
}
.cb-welcome-icon {
  width: 80px; height: 80px; border-radius: 24px;
  background: linear-gradient(135deg, #006aff 0%, #0040cc 100%);
  display: flex; align-items: center; justify-content: center;
  font-size: 2rem; color: #fff; margin: 0 auto 20px;
  box-shadow: 0 0 40px rgba(0,106,255,0.4);
  animation: cbGlow 3s ease-in-out infinite;
}
.cb-welcome h2 {
  font-family: 'Fraunces', serif;
  font-size: 1.8rem; font-weight: 700; color: #fff;
  margin-bottom: 10px;
}
.cb-welcome h2 em { font-style: italic; color: rgba(255,255,255,0.45); }
.cb-welcome p {
  color: rgba(255,255,255,0.38); font-size: 0.9rem;
  font-weight: 300; line-height: 1.7; max-width: 420px; margin: 0 auto 28px;
}

/* suggestion chips */
.cb-suggestions {
  display: flex; flex-wrap: wrap; gap: 10px;
  justify-content: center; margin-bottom: 8px;
}
.cb-chip {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 18px; border-radius: 9999px;
  font-size: 0.82rem; font-weight: 500;
  background: rgba(0,106,255,0.1);
  border: 1px solid rgba(0,106,255,0.25);
  color: rgba(255,255,255,0.65);
  cursor: pointer; transition: .3s;
}
.cb-chip:hover { background: rgba(0,106,255,0.22); border-color: rgba(0,106,255,0.5); color: #fff; transform: translateY(-1px); }
.cb-chip i { color: #006aff; font-size: 0.78rem; }

/* ── MESSAGE BUBBLES ── */
.cb-msg { display: flex; gap: 12px; max-width: 100%; }

/* BOT message */
.cb-msg.bot { animation: cbSlideL .35s ease-out; }
.cb-msg.bot .cb-msg-avatar {
  width: 36px; height: 36px; border-radius: 11px; flex-shrink: 0;
  background: linear-gradient(135deg, #006aff 0%, #0040cc 100%);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.85rem; color: #fff;
  box-shadow: 0 0 12px rgba(0,106,255,0.35);
  align-self: flex-end;
}
.cb-msg.bot .cb-bubble {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.09);
  border-radius: 18px 18px 18px 4px;
  padding: 14px 18px;
  color: rgba(255,255,255,0.85);
  font-size: 0.9rem; line-height: 1.7; font-weight: 300;
  max-width: 85%;
  backdrop-filter: blur(10px);
}

/* USER message */
.cb-msg.user { flex-direction: row-reverse; animation: cbSlideR .35s ease-out; }
.cb-msg.user .cb-bubble {
  background: linear-gradient(135deg, #006aff 0%, #0052cc 100%);
  border-radius: 18px 18px 4px 18px;
  padding: 14px 18px;
  color: #fff;
  font-size: 0.9rem; line-height: 1.7; font-weight: 400;
  max-width: 75%;
  box-shadow: 0 4px 20px rgba(0,106,255,0.35);
}

/* timestamp */
.cb-msg-time {
  font-size: 0.68rem; color: rgba(255,255,255,0.2);
  margin-top: 5px; display: block; padding: 0 4px;
}
.cb-msg.user .cb-msg-time { text-align: right; }

/* ── TYPING INDICATOR ── */
.cb-typing { display: none; }
.cb-typing.show { display: flex; }
.cb-typing-dots {
  display: flex; align-items: center; gap: 5px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.09);
  border-radius: 18px 18px 18px 4px;
  padding: 14px 18px;
  backdrop-filter: blur(10px);
}
.cb-typing-dots span {
  width: 7px; height: 7px; border-radius: 50%;
  background: rgba(255,255,255,0.4);
  animation: cbTyping 1.2s ease-in-out infinite;
}
.cb-typing-dots span:nth-child(2) { animation-delay: .15s; }
.cb-typing-dots span:nth-child(3) { animation-delay: .3s; }

/* ── INPUT AREA ── */
.cb-input-area {
  background: rgba(5,20,58,0.95);
  backdrop-filter: blur(20px);
  border-top: 1px solid rgba(0,106,255,0.12);
  padding: 16px 24px 20px;
}
.cb-input-wrap {
  max-width: 820px; margin: 0 auto;
}
.cb-input-box {
  display: flex; align-items: flex-end; gap: 12px;
  background: rgba(255,255,255,0.05);
  border: 1.5px solid rgba(0,106,255,0.2);
  border-radius: 18px;
  padding: 10px 12px 10px 18px;
  transition: border-color .3s, box-shadow .3s;
}
.cb-input-box:focus-within {
  border-color: rgba(0,106,255,0.5);
  box-shadow: 0 0 0 4px rgba(0,106,255,0.1);
}
.cb-textarea {
  flex: 1; background: transparent; border: none; outline: none;
  color: #fff; font-family: 'DM Sans', sans-serif;
  font-size: 0.92rem; font-weight: 300; line-height: 1.6;
  resize: none; max-height: 160px; min-height: 24px;
  scrollbar-width: none;
}
.cb-textarea::-webkit-scrollbar { display: none; }
.cb-textarea::placeholder { color: rgba(255,255,255,0.2); }
.cb-send-btn {
  width: 40px; height: 40px; border-radius: 12px; flex-shrink: 0;
  background: #006aff; border: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 0.9rem; transition: .3s;
  box-shadow: 0 4px 14px rgba(0,106,255,0.4);
}
.cb-send-btn:hover { background: #0052cc; transform: scale(1.05); box-shadow: 0 6px 20px rgba(0,106,255,0.55); }
.cb-send-btn:disabled { background: rgba(255,255,255,0.08); box-shadow: none; cursor: not-allowed; transform: none; }
.cb-send-btn .cb-spinner { animation: cbSpin .7s linear infinite; display: none; }
.cb-send-btn.loading .fa-paper-plane { display: none; }
.cb-send-btn.loading .cb-spinner { display: block; }

/* footer hint */
.cb-hint {
  text-align: center; margin-top: 10px;
  font-size: 0.7rem; color: rgba(255,255,255,0.18);
  display: flex; align-items: center; justify-content: center; gap: 6px;
}
.cb-hint i { font-size: 0.65rem; color: #c9a84c; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
  .cb-header-badges { display: none; }
  .cb-welcome h2 { font-size: 1.4rem; }
  .cb-suggestions { gap: 8px; }
  .cb-chip { font-size: 0.76rem; padding: 7px 14px; }
}
</style>

<div class="cb-page">

  {{-- ── HEADER ── --}}
  <div class="cb-header">
    <div class="cb-header-left">
      <div class="cb-bot-avatar">
        <i class="fa-solid fa-robot"></i>
        <div class="cb-bot-status"></div>
      </div>
      <div>
        <div class="cb-bot-name">CarePoint AI</div>
        <div class="cb-bot-subtitle">Medical Assistant · Powered by Gemini</div>
      </div>
    </div>

    <div class="cb-header-badges">
      <div class="cb-badge"><i class="fa-solid fa-circle-dot"></i> Online</div>
      <div class="cb-badge"><i class="fa-solid fa-shield-halved"></i> Secure</div>
      <div class="cb-badge"><i class="fa-solid fa-bolt"></i> Gemini AI</div>
    </div>

    <button class="cb-clear-btn" id="cbClearBtn">
      <i class="fa-solid fa-rotate-left"></i> New Chat
    </button>
  </div>

  {{-- ── CHAT MESSAGES ── --}}
  <div class="cb-chat-area" id="cbChatArea">
    <div class="cb-messages" id="cbMessages">

      {{-- Welcome screen --}}
      <div class="cb-welcome" id="cbWelcome">
        <div class="cb-welcome-icon">
          <i class="fa-solid fa-robot"></i>
        </div>
        <h2>CarePoint <em>AI Assistant</em></h2>
        <p>Ask me anything about your health, symptoms, medications, or find the right specialist for you.</p>
        <div class="cb-suggestions">
          <div class="cb-chip" onclick="cbSuggest(this)">
            <i class="fa-solid fa-stethoscope"></i> What are symptoms of diabetes?
          </div>
          <div class="cb-chip" onclick="cbSuggest(this)">
            <i class="fa-solid fa-pills"></i> Common cold remedies
          </div>
          <div class="cb-chip" onclick="cbSuggest(this)">
            <i class="fa-solid fa-heart-pulse"></i> How to lower blood pressure?
          </div>
          <div class="cb-chip" onclick="cbSuggest(this)">
            <i class="fa-solid fa-user-doctor"></i> When should I see a doctor?
          </div>
          <div class="cb-chip" onclick="cbSuggest(this)">
            <i class="fa-solid fa-brain"></i> Tips for better sleep
          </div>
          <div class="cb-chip" onclick="cbSuggest(this)">
            <i class="fa-solid fa-apple-whole"></i> Healthy diet basics
          </div>
        </div>
      </div>

      {{-- Typing indicator --}}
      <div class="cb-msg bot cb-typing" id="cbTyping">
        <div class="cb-msg-avatar"><i class="fa-solid fa-robot"></i></div>
        <div class="cb-typing-dots">
          <span></span><span></span><span></span>
        </div>
      </div>

    </div>
  </div>

  {{-- ── INPUT ── --}}
  <div class="cb-input-area">
    <div class="cb-input-wrap">
      <div class="cb-input-box">
        <textarea
          class="cb-textarea"
          id="cbInput"
          placeholder="Ask me about your health…"
          rows="1"
        ></textarea>
        <button class="cb-send-btn" id="cbSendBtn">
          <i class="fa-solid fa-paper-plane"></i>
          <i class="fa-solid fa-spinner cb-spinner"></i>
        </button>
      </div>
      <div class="cb-hint">
        <i class="fa-solid fa-triangle-exclamation"></i>
        For informational purposes only — not a substitute for professional medical advice
      </div>
    </div>
  </div>

</div>

<script>
(function () {

  /* ── CONFIG ── */
  // ضع الـ Gemini API key هنا أو استخدم route من Laravel
  var GEMINI_ENDPOINT = '/chatbot/ask'; // Laravel route يستدعي Gemini
  var USE_LARAVEL     = true;           // true = يستخدم Laravel backend

  // لو عايز تستخدم Gemini مباشرة من frontend (مش مستحسن للـ production):
  // var GEMINI_API_KEY = 'YOUR_KEY_HERE';
  // var USE_LARAVEL    = false;

  var SYSTEM_PROMPT = `You are CarePoint AI, a helpful and knowledgeable medical assistant for CarePoint clinic. 
You answer questions about symptoms, medications, general health advice, and help patients understand medical topics.
Always remind users that your answers are informational only and they should consult a doctor for diagnosis or treatment.
Be warm, clear, and concise. Format responses with line breaks for readability.
If asked about CarePoint services or doctors, mention that users can browse the website to find specialists.`;

  /* ── STATE ── */
  var history   = [];   // { role, parts: [{text}] }
  var isLoading = false;

  /* ── DOM ── */
  var messagesEl = document.getElementById('cbMessages');
  var inputEl    = document.getElementById('cbInput');
  var sendBtn    = document.getElementById('cbSendBtn');
  var typingEl   = document.getElementById('cbTyping');
  var chatArea   = document.getElementById('cbChatArea');
  var welcomeEl  = document.getElementById('cbWelcome');
  var clearBtn   = document.getElementById('cbClearBtn');

  /* ── AUTO-RESIZE TEXTAREA ── */
  inputEl.addEventListener('input', function () {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 160) + 'px';
  });

  /* ── SEND ON ENTER (SHIFT+ENTER = new line) ── */
  inputEl.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });

  sendBtn.addEventListener('click', sendMessage);
  clearBtn.addEventListener('click', clearChat);

  /* ── SUGGESTION CHIPS ── */
  window.cbSuggest = function (el) {
    inputEl.value = el.textContent.trim();
    inputEl.dispatchEvent(new Event('input'));
    sendMessage();
  };

  /* ── SEND MESSAGE ── */
  function sendMessage() {
    var text = inputEl.value.trim();
    if (!text || isLoading) return;

    // hide welcome
    if (welcomeEl) welcomeEl.style.display = 'none';

    // add user message
    appendMessage('user', text);
    history.push({ role: 'user', parts: [{ text: text }] });

    // reset input
    inputEl.value = '';
    inputEl.style.height = 'auto';

    // show typing
    isLoading = true;
    setLoading(true);

    // call API
    if (USE_LARAVEL) {
      callLaravel(text);
    } else {
      callGeminiDirect(text);
    }
  }

  /* ── CALL LARAVEL BACKEND ── */
  function callLaravel(userText) {
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    fetch(GEMINI_ENDPOINT, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : '',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        message:  userText,
        history:  history.slice(-10) // send last 10 turns for context
      })
    })
    .then(function (res) { return res.json(); })
    .then(function (data) {
      var reply = data.reply || data.text || data.message || 'Sorry, I could not process that.';
      handleBotReply(reply);
    })
    .catch(function (err) {
      handleBotReply('Sorry, something went wrong. Please try again.');
      console.error('Chatbot error:', err);
    });
  }

  /* ── CALL GEMINI DIRECTLY (frontend) ── */
  function callGeminiDirect(userText) {
    // Build contents array with system prompt prepended
    var contents = [];
    // add history
    history.slice(-8).forEach(function(h) { contents.push(h); });

    fetch('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' + (window.GEMINI_API_KEY || ''), {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        system_instruction: { parts: [{ text: SYSTEM_PROMPT }] },
        contents: contents,
        generationConfig: { maxOutputTokens: 800, temperature: 0.7 }
      })
    })
    .then(function(r){ return r.json(); })
    .then(function(data) {
      var reply = 'Sorry, I could not process that.';
      try { reply = data.candidates[0].content.parts[0].text; } catch(e){}
      handleBotReply(reply);
    })
    .catch(function(err){
      handleBotReply('Connection error. Please try again.');
      console.error(err);
    });
  }

  /* ── HANDLE BOT REPLY ── */
  function handleBotReply(text) {
    setLoading(false);
    isLoading = false;
    appendMessage('bot', text);
    history.push({ role: 'model', parts: [{ text: text }] });
  }

  /* ── APPEND MESSAGE ── */
  function appendMessage(role, text) {
    var msg = document.createElement('div');
    msg.className = 'cb-msg ' + role;

    var now = new Date();
    var time = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');

    var html = '';
    if (role === 'bot') {
      html += '<div class="cb-msg-avatar"><i class="fa-solid fa-robot"></i></div>';
    }
    html += '<div>';
    html += '<div class="cb-bubble">' + formatText(text) + '</div>';
    html += '<span class="cb-msg-time">' + time + '</span>';
    html += '</div>';

    msg.innerHTML = html;

    // insert before typing indicator
    messagesEl.insertBefore(msg, typingEl);
    scrollBottom();
  }

  /* ── FORMAT TEXT ── */
  function formatText(text) {
    return text
      .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
      .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
      .replace(/\*(.*?)\*/g, '<em>$1</em>')
      .replace(/\n/g, '<br>');
  }

  /* ── LOADING STATE ── */
  function setLoading(on) {
    typingEl.className = 'cb-msg bot cb-typing' + (on ? ' show' : '');
    sendBtn.disabled   = on;
    sendBtn.className  = 'cb-send-btn' + (on ? ' loading' : '');
    if (on) scrollBottom();
  }

  /* ── SCROLL ── */
  function scrollBottom() {
    setTimeout(function () {
      chatArea.scrollTop = chatArea.scrollHeight;
    }, 50);
  }

  /* ── CLEAR CHAT ── */
  function clearChat() {
    history = [];
    // remove all messages except welcome + typing
    var msgs = messagesEl.querySelectorAll('.cb-msg:not(.cb-typing)');
    msgs.forEach(function(m){ m.remove(); });
    if (welcomeEl) welcomeEl.style.display = 'block';
    isLoading = false;
    setLoading(false);
    inputEl.value = '';
    inputEl.style.height = 'auto';
  }

})();
</script>

@endsection