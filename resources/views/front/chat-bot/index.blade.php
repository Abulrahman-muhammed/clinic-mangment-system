@extends('front.inc.master')
@section('title', 'AI Health Assistant')

@push('style')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
  --blue-deep:  #0d47a1;
  --blue-mid:   #1a73e8;
  --blue-light: #4a9ef5;
  --blue-pale:  #e8f0fe;
  --blue-glow:  rgba(26,115,232,0.13);
  --white:      #ffffff;
  --bg:         #f0f4fb;
  --border:     #dde6f5;
  --text:       #1a1f36;
  --text-muted: #6b7a99;
  --success:    #34a853;
  --shadow:     0 8px 48px rgba(13,71,161,0.11);
  --shadow-btn: 0 4px 18px rgba(26,115,232,0.32);
  --r-card:     26px;
  --r-pill:     999px;
  --font-ui:    'Plus Jakarta Sans', sans-serif;
  --font-body:  'Nunito', sans-serif;
}

/* ── PAGE ── */
.cb-page {
  min-height: 100vh;
  background: var(--bg);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 36px 20px;
  font-family: var(--font-body);
  position: relative;
}
.cb-page::before {
  content: '';
  position: fixed; inset: 0;
  background:
    radial-gradient(ellipse 80% 50% at 0% 0%,    rgba(26,115,232,0.08) 0%, transparent 55%),
    radial-gradient(ellipse 60% 60% at 100% 100%, rgba(13,71,161,0.07) 0%, transparent 55%);
  pointer-events: none; z-index: 0;
}

/* ── WRAP ── */
.cb-wrap {
  position: relative; z-index: 1;
  width: 100%; max-width: 960px;   /* wider */
}

/* ── EYEBROW ── */
.cb-eyebrow {
  display: flex; align-items: center; gap: 14px;
  margin-bottom: 18px;
}
.cb-eyebrow hr { flex: 1; border: none; border-top: 1px solid var(--border); margin: 0; }
.cb-eyebrow-label {
  font-family: var(--font-ui);
  font-size: 0.72rem; font-weight: 700;
  letter-spacing: 0.13em; text-transform: uppercase;
  color: var(--blue-mid); white-space: nowrap;
}
.cb-online-dot {
  width: 8px; height: 8px; border-radius: 50%;
  background: var(--success);
  box-shadow: 0 0 0 3px rgba(52,168,83,0.22);
  animation: blink 2.2s infinite; flex-shrink: 0;
}
@keyframes blink {
  0%,100% { box-shadow: 0 0 0 3px rgba(52,168,83,0.22); }
  50%      { box-shadow: 0 0 0 7px rgba(52,168,83,0.07); }
}

/* ── CARD ── */
.cb-card {
  background: var(--white);
  border-radius: var(--r-card);
  box-shadow: var(--shadow);
  border: 1px solid var(--border);
  display: flex; flex-direction: column;
  height: 82vh;          /* taller */
  max-height: 860px;     /* taller */
  overflow: hidden;
}

/* ── HEADER ── */
.cb-header {
  background: linear-gradient(120deg, var(--blue-deep) 0%, var(--blue-mid) 100%);
  padding: 24px 32px;    /* more padding */
  display: flex; align-items: center; gap: 16px;
  flex-shrink: 0; position: relative; overflow: hidden;
}
.cb-header::before {
  content: ''; position: absolute;
  width: 200px; height: 200px; border-radius: 50%;
  background: rgba(255,255,255,0.05);
  right: -50px; top: -70px;
}
.cb-header::after {
  content: ''; position: absolute;
  width: 110px; height: 110px; border-radius: 50%;
  background: rgba(255,255,255,0.04);
  right: 80px; bottom: -45px;
}
.cb-hdr-avatar {
  width: 54px; height: 54px;   /* bigger */
  border-radius: 16px;
  background: rgba(255,255,255,0.15);
  border: 1px solid rgba(255,255,255,0.22);
  display: flex; align-items: center; justify-content: center;
  font-size: 24px; color: #fff;   /* bigger icon */
  flex-shrink: 0; position: relative; z-index: 1;
}
.cb-hdr-info { position: relative; z-index: 1; }
.cb-hdr-info h2 {
  font-family: var(--font-ui);
  font-size: 1.20rem; font-weight: 700;  /* bigger */
  color: #fff; margin: 0 0 3px;
}
.cb-hdr-info span {
  font-size: 0.80rem;   /* bigger */
  color: rgba(255,255,255,0.68);
}
.cb-hdr-badge {
  margin-left: auto;
  display: flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,0.12);
  border: 1px solid rgba(255,255,255,0.18);
  border-radius: var(--r-pill);
  padding: 6px 16px;
  font-size: 0.74rem; font-weight: 600;
  font-family: var(--font-ui);
  color: rgba(255,255,255,0.92);
  flex-shrink: 0; position: relative; z-index: 1;
}

/* ── MESSAGES ── */
.cb-messages {
  flex: 1; overflow-y: auto;
  padding: 30px 28px;   /* more breathing room */
  display: flex; flex-direction: column;
  gap: 20px; scroll-behavior: smooth;
}
.cb-messages::-webkit-scrollbar { width: 4px; }
.cb-messages::-webkit-scrollbar-thumb { background: var(--border); border-radius: 99px; }

.cb-row {
  display: flex; align-items: flex-end; gap: 10px;
  animation: pop-in 0.28s cubic-bezier(0.34,1.56,0.64,1) both;
}
.cb-row.user { flex-direction: row-reverse; }
@keyframes pop-in {
  from { opacity: 0; transform: translateY(10px) scale(0.97); }
  to   { opacity: 1; transform: none; }
}

.cb-av {
  width: 36px; height: 36px;   /* bigger */
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px; flex-shrink: 0;
}
.cb-row.bot  .cb-av { background: var(--blue-pale); color: var(--blue-mid); }
.cb-row.user .cb-av { background: #e8eaf6; color: var(--blue-deep); }

.cb-bubble {
  max-width: 68%;
  padding: 14px 20px;      /* more padding */
  border-radius: 20px;
  font-size: 1rem;         /* bigger — was 0.875 */
  line-height: 1.70;
  word-wrap: break-word; white-space: pre-wrap;
  font-family: var(--font-body);
}
.cb-row.bot .cb-bubble {
  background: var(--bg); color: var(--text);
  border: 1px solid var(--border);
  border-bottom-left-radius: 4px;
}
.cb-row.user .cb-bubble {
  background: linear-gradient(135deg, var(--blue-mid), var(--blue-deep));
  color: #fff;
  border-bottom-right-radius: 4px;
}

/* ── TYPING ── */
.cb-typing { display: none; align-items: flex-end; gap: 10px; }
.cb-typing-dots {
  background: var(--bg); border: 1px solid var(--border);
  border-radius: 20px; border-bottom-left-radius: 4px;
  padding: 14px 18px; display: flex; gap: 5px; align-items: center;
}
.cb-dot {
  width: 7px; height: 7px; border-radius: 50%;
  background: var(--blue-light);
  animation: bounce-dot 1.2s infinite ease-in-out;
}
.cb-dot:nth-child(2) { animation-delay: 0.16s; }
.cb-dot:nth-child(3) { animation-delay: 0.32s; }
@keyframes bounce-dot {
  0%,80%,100% { transform: translateY(0); opacity: 0.4; }
  40%         { transform: translateY(-8px); opacity: 1; }
}

/* ── SEPARATOR ── */
.cb-sep { height: 1px; background: var(--border); flex-shrink: 0; }

/* ── CHIPS ── */
.cb-chips {
  display: flex; gap: 8px;
  padding: 12px 28px 6px;
  overflow-x: auto; flex-shrink: 0;
}
.cb-chips::-webkit-scrollbar { display: none; }
.cb-chip {
  white-space: nowrap;
  background: var(--blue-pale);
  border: 1.5px solid transparent;
  color: var(--blue-deep);
  border-radius: var(--r-pill);
  padding: 7px 16px;
  font-size: 0.82rem; font-weight: 600;  /* bigger */
  font-family: var(--font-ui);
  cursor: pointer; transition: all 0.18s; flex-shrink: 0;
}
.cb-chip:hover { background: var(--blue-mid); color: #fff; border-color: var(--blue-mid); }

/* ── INPUT ── */
.cb-input-row {
  display: flex; align-items: flex-end; gap: 12px;
  padding: 14px 28px 22px; flex-shrink: 0;
}
#cbInput {
  flex: 1;
  background: var(--bg);
  border: 1.5px solid var(--border);
  border-radius: 16px;
  padding: 13px 18px;
  font-size: 1rem;        /* bigger */
  font-family: var(--font-body);
  color: var(--text);
  resize: none; outline: none;
  max-height: 120px; overflow-y: auto;
  line-height: 1.55;
  transition: border-color 0.2s, box-shadow 0.2s;
}
#cbInput::placeholder { color: var(--text-muted); opacity: 0.6; }
#cbInput:focus {
  border-color: var(--blue-mid);
  box-shadow: 0 0 0 3px var(--blue-glow);
  background: #fff;
}
.cb-send {
  width: 48px; height: 48px;   /* bigger */
  border-radius: 14px;
  background: linear-gradient(135deg, var(--blue-mid), var(--blue-deep));
  color: #fff; border: none;
  display: flex; align-items: center; justify-content: center;
  font-size: 17px; cursor: pointer;
  transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
  box-shadow: var(--shadow-btn); flex-shrink: 0;
}
.cb-send:hover  { transform: scale(1.07); }
.cb-send:active { transform: scale(0.93); }
.cb-send:disabled { opacity: 0.38; cursor: default; transform: none; box-shadow: none; }

/* ── FOOTER NOTE ── */
.cb-note {
  text-align: center;
  font-size: 0.72rem; color: var(--text-muted); opacity: 0.5;
  padding: 0 28px 14px; flex-shrink: 0;
  font-family: var(--font-ui);
}

/* ── RESPONSIVE ── */
@media (max-width: 640px) {
  .cb-page  { padding: 0; }
  .cb-wrap  { max-width: 100%; }
  .cb-card  { border-radius: 0; height: 100dvh; max-height: none; }
  .cb-eyebrow { display: none; }
  .cb-bubble  { max-width: 82%; font-size: 0.95rem; }
}
</style>
@endpush

@section('content')
<div class="cb-page">
  <div class="cb-wrap">

    {{-- Eyebrow --}}
    <div class="cb-eyebrow">
      <hr>
      <div class="cb-online-dot"></div>
      <span class="cb-eyebrow-label">AI Health Assistant &middot; Online 24/7</span>
      <hr>
    </div>

    <div class="cb-card">

      {{-- Header --}}
      <div class="cb-header">
        <div class="cb-hdr-avatar"><i class="fa-solid fa-robot"></i></div>
        <div class="cb-hdr-info">
          <h2>Health Assistant</h2>
          <span>Powered by Gemini AI &middot; Medical guidance at your fingertips</span>
        </div>
        <div class="cb-hdr-badge">
          <div class="cb-online-dot"></div>
          Live
        </div>
      </div>

      {{-- Messages --}}
      <div class="cb-messages" id="cbMessages">
        <div class="cb-row bot">
          <div class="cb-av"><i class="fa-solid fa-robot"></i></div>
          <div class="cb-bubble">👋 Hello! I'm your AI Health Assistant.

I can help with general health questions, symptoms, medications, and wellness advice.

⚠️ My answers are informational only and don't replace professional medical advice. For emergencies, call your local emergency number immediately.

How can I help you today?</div>
        </div>

        <div class="cb-typing" id="cbTyping">
          <div class="cb-av" style="background:var(--blue-pale);color:var(--blue-mid);">
            <i class="fa-solid fa-robot"></i>
          </div>
          <div class="cb-typing-dots">
            <div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div>
          </div>
        </div>
      </div>

      <div class="cb-sep"></div>

      {{-- Chips --}}
      <div class="cb-chips">
        <button class="cb-chip" onclick="useSuggestion(this)">💊 Medication info</button>
        <button class="cb-chip" onclick="useSuggestion(this)">🤒 I have a fever</button>
        <button class="cb-chip" onclick="useSuggestion(this)">😴 Sleep problems</button>
        <button class="cb-chip" onclick="useSuggestion(this)">🥗 Healthy diet tips</button>
      </div>

      {{-- Input --}}
      <div class="cb-input-row">
        <textarea id="cbInput" rows="1" placeholder="Ask a health question…" maxlength="1000" aria-label="Your message"></textarea>
        <button class="cb-send" id="cbSend" onclick="sendMessage()" aria-label="Send">
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>

      <div class="cb-note">For emergencies please call your local emergency services immediately.</div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
  const CSRF     = '{{ csrf_token() }}';
  const SEND_URL = '{{ route("front.chatbot.send") }}';
  const msgEl    = document.getElementById('cbMessages');
  const inputEl  = document.getElementById('cbInput');
  const sendBtn  = document.getElementById('cbSend');
  const typingEl = document.getElementById('cbTyping');
  let   history  = [];

  inputEl.addEventListener('input', () => {
    inputEl.style.height = 'auto';
    inputEl.style.height = Math.min(inputEl.scrollHeight, 120) + 'px';
  });

  inputEl.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
  });

  window.useSuggestion = btn => {
    inputEl.value = btn.textContent.trim().replace(/^[\p{Emoji}\s]+/u, '').trim();
    sendMessage();
  };

  window.sendMessage = async function () {
    const text = inputEl.value.trim();
    if (!text || sendBtn.disabled) return;

    sendBtn.disabled = true;
    inputEl.value = '';
    inputEl.style.height = 'auto';

    addBubble('user', text);
    typingEl.style.display = 'flex';
    scrollDown();

    try {
      const res  = await fetch(SEND_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ message: text, history }),
      });
      const data = await res.json();
      typingEl.style.display = 'none';

      const reply = data.error ? '⚠️ ' + data.error : data.reply;
      addBubble('bot', reply);

      if (!data.error) {
        history.push({ role: 'user',      content: text });
        history.push({ role: 'assistant', content: data.reply });
        if (history.length > 40) history = history.slice(-40);
      }
    } catch {
      typingEl.style.display = 'none';
      addBubble('bot', '⚠️ Network error. Please check your connection and try again.');
    }

    sendBtn.disabled = false;
    inputEl.focus();
    scrollDown();
  };

  function addBubble(role, content) {
    const row = document.createElement('div');
    row.className = `cb-row ${role}`;

    const av = document.createElement('div');
    av.className = 'cb-av';
    av.innerHTML = role === 'bot'
      ? '<i class="fa-solid fa-robot"></i>'
      : '<i class="fa-solid fa-user"></i>';

    const bubble = document.createElement('div');
    bubble.className = 'cb-bubble';
    bubble.textContent = content;

    row.appendChild(av);
    row.appendChild(bubble);
    msgEl.insertBefore(row, typingEl);
    scrollDown();
  }

  function scrollDown() { msgEl.scrollTop = msgEl.scrollHeight; }
})();
</script>
@endpush