@extends('front.inc.master')
@section('title', 'AI Health Assistant')

@push('style')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ════════════════════════════════════════
   DESIGN TOKENS
════════════════════════════════════════ */
:root {
  --blue-deep:   #0d47a1;
  --blue-mid:    #1a73e8;
  --blue-light:  #4a9ef5;
  --blue-pale:   #e8f0fe;
  --blue-glow:   rgba(26,115,232,0.14);
  --white:       #ffffff;
  --bg:          #f0f4fb;
  --surface:     #f7f9ff;
  --border:      #dde6f5;
  --text:        #1a1f36;
  --text-muted:  #6b7a99;
  --success:     #34a853;
  --warn-bg:     #fff8e1;
  --warn-border: #f9a825;
  --warn-text:   #e65100;
  --danger-bg:   #ffebee;
  --danger-brd:  #ef9a9a;
  --danger-text: #b71c1c;
  --shadow-card: 0 4px 32px rgba(13,71,161,0.10), 0 1px 4px rgba(13,71,161,0.06);
  --shadow-btn:  0 4px 16px rgba(26,115,232,0.35);
  --r-xl:        28px;
  --r-lg:        18px;
  --r-md:        12px;
  --r-sm:        8px;
  --r-pill:      999px;
  --font-ui:     'Plus Jakarta Sans', sans-serif;
  --font-body:   'Nunito', sans-serif;
  --speed:       0.22s;
}

/* ════════════════════════════════════════
   PAGE SHELL
════════════════════════════════════════ */
.cb-page {
  min-height: 100vh;
  background: var(--bg);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 32px 16px;
  font-family: var(--font-body);
  position: relative;
  overflow: hidden;
}
.cb-page::before,
.cb-page::after {
  content: '';
  position: fixed;
  border-radius: 50%;
  pointer-events: none;
  z-index: 0;
}
.cb-page::before {
  width: 700px; height: 700px;
  background: radial-gradient(circle, rgba(26,115,232,0.07) 0%, transparent 70%);
  top: -200px; left: -200px;
}
.cb-page::after {
  width: 500px; height: 500px;
  background: radial-gradient(circle, rgba(13,71,161,0.06) 0%, transparent 70%);
  bottom: -150px; right: -150px;
}

.cb-wrap {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 980px;
  display: flex;
  flex-direction: column;
  gap: 18px;
}

/* ════════════════════════════════════════
   EYEBROW
════════════════════════════════════════ */
.cb-eyebrow {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 4px;
}
.cb-eyebrow hr {
  flex: 1;
  border: none;
  border-top: 1px solid var(--border);
  margin: 0;
}
.cb-eyebrow-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: var(--font-ui);
  font-size: 0.70rem;
  font-weight: 700;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: var(--blue-mid);
  white-space: nowrap;
}

/* ════════════════════════════════════════
   ANIMATED DOT
════════════════════════════════════════ */
.cb-pulse {
  position: relative;
  width: 8px; height: 8px;
  flex-shrink: 0;
}
.cb-pulse-core {
  position: absolute; inset: 0;
  border-radius: 50%;
  background: var(--success);
}
.cb-pulse-ring {
  position: absolute; inset: -3px;
  border-radius: 50%;
  border: 2px solid var(--success);
  opacity: 0;
  animation: pulse-ring 2.4s ease-out infinite;
}
@keyframes pulse-ring {
  0%   { transform: scale(0.7); opacity: 0.6; }
  100% { transform: scale(1.8); opacity: 0; }
}

/* ════════════════════════════════════════
   MAIN CARD
════════════════════════════════════════ */
.cb-card {
  background: var(--white);
  border-radius: var(--r-xl);
  box-shadow: var(--shadow-card);
  border: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  height: 80vh;
  max-height: 840px;
  min-height: 500px;
  overflow: hidden;
}

/* ════════════════════════════════════════
   HEADER
════════════════════════════════════════ */
.cb-header {
  background: linear-gradient(118deg, var(--blue-deep) 0%, #1565c0 50%, var(--blue-mid) 100%);
  padding: 20px 28px;
  display: flex;
  align-items: center;
  gap: 16px;
  flex-shrink: 0;
  position: relative;
  overflow: hidden;
}
.cb-header-orb {
  position: absolute;
  border-radius: 50%;
  background: rgba(255,255,255,0.06);
  pointer-events: none;
}
.cb-header-orb-1 { width: 220px; height: 220px; right: -60px; top: -90px; }
.cb-header-orb-2 { width: 130px; height: 130px; right: 110px; bottom: -60px; }
.cb-header-orb-3 { width: 60px;  height: 60px;  left: 40%;   top: -20px; }

.cb-hdr-avatar {
  width: 52px; height: 52px;
  border-radius: 16px;
  background: rgba(255,255,255,0.15);
  border: 1.5px solid rgba(255,255,255,0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  color: #fff;
  flex-shrink: 0;
  position: relative;
  z-index: 1;
}
.cb-hdr-info {
  position: relative;
  z-index: 1;
  flex: 1;
  min-width: 0;
}
.cb-hdr-info h2 {
  font-family: var(--font-ui);
  font-size: 1.15rem;
  font-weight: 700;
  color: #fff;
  margin: 0 0 3px;
  line-height: 1.2;
}
.cb-hdr-info p {
  font-size: 0.78rem;
  color: rgba(255,255,255,0.65);
  margin: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.cb-hdr-live {
  position: relative;
  z-index: 1;
  display: flex;
  align-items: center;
  gap: 7px;
  background: rgba(255,255,255,0.13);
  border: 1px solid rgba(255,255,255,0.20);
  border-radius: var(--r-pill);
  padding: 7px 16px;
  font-family: var(--font-ui);
  font-size: 0.75rem;
  font-weight: 600;
  color: rgba(255,255,255,0.92);
  flex-shrink: 0;
  backdrop-filter: blur(4px);
}

/* ════════════════════════════════════════
   MESSAGES AREA
════════════════════════════════════════ */
.cb-messages {
  flex: 1;
  overflow-y: auto;
  padding: 24px 24px 8px;
  display: flex;
  flex-direction: column;
  gap: 6px;
  scroll-behavior: smooth;
}
.cb-messages::-webkit-scrollbar { width: 3px; }
.cb-messages::-webkit-scrollbar-thumb {
  background: var(--border);
  border-radius: 99px;
}

/* ════════════════════════════════════════
   MESSAGE ROW
════════════════════════════════════════ */
.cb-row {
  display: flex;
  align-items: flex-end;
  gap: 10px;
  animation: msg-in 0.28s cubic-bezier(0.34,1.4,0.64,1) both;
}
.cb-row.user { flex-direction: row-reverse; }

@keyframes msg-in {
  from { opacity: 0; transform: translateY(12px) scale(0.97); }
  to   { opacity: 1; transform: none; }
}

/* avatar */
.cb-av {
  width: 34px; height: 34px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
  align-self: flex-end;
}
.cb-row.bot  .cb-av {
  background: var(--blue-pale);
  color: var(--blue-mid);
  border: 1px solid var(--border);
}
.cb-row.user .cb-av {
  background: linear-gradient(135deg, var(--blue-mid), var(--blue-deep));
  color: #fff;
}

/* bubble wrapper (holds bubble + timestamp) */
.cb-bubble-wrap {
  display: flex;
  flex-direction: column;
  gap: 4px;
  max-width: 70%;
}
.cb-row.bot  .cb-bubble-wrap { align-items: flex-start; }
.cb-row.user .cb-bubble-wrap { align-items: flex-end; }
.cb-bubble-wrap.wide { max-width: 88%; }

/* bubble itself */
.cb-bubble {
  padding: 13px 17px;
  border-radius: 20px;
  font-size: 0.97rem;
  line-height: 1.72;
  word-wrap: break-word;
  font-family: var(--font-body);
  width: fit-content;
}
.cb-row.bot .cb-bubble {
  background: var(--surface);
  color: var(--text);
  border: 1px solid var(--border);
  border-bottom-left-radius: 5px;
}
.cb-row.user .cb-bubble {
  background: linear-gradient(135deg, var(--blue-mid) 0%, var(--blue-deep) 100%);
  color: #fff;
  border-bottom-right-radius: 5px;
}

/* timestamp */
.cb-time {
  font-size: 0.67rem;
  color: var(--text-muted);
  opacity: 0.5;
  font-family: var(--font-ui);
  padding: 0 3px;
}

/* ════════════════════════════════════════
   MARKDOWN CONTENT
════════════════════════════════════════ */
.cb-md { white-space: normal; }
.cb-md > *:first-child { margin-top: 0; }
.cb-md > *:last-child  { margin-bottom: 0; }
.cb-md p  { margin: 0 0 8px; }
.cb-md ul,
.cb-md ol { margin: 4px 0 8px 18px; padding: 0; }
.cb-md li { margin-bottom: 4px; line-height: 1.6; }
.cb-md strong { font-weight: 700; }
.cb-md em     { font-style: italic; }
.cb-md code {
  background: rgba(26,115,232,0.10);
  border-radius: 5px;
  padding: 1px 6px;
  font-size: 0.87em;
  font-family: 'Courier New', monospace;
}
.cb-md pre {
  background: rgba(26,115,232,0.06);
  border: 1px solid var(--border);
  border-radius: var(--r-sm);
  padding: 10px 12px;
  overflow-x: auto;
  font-size: 0.85em;
  margin: 8px 0;
}
.cb-md h1, .cb-md h2, .cb-md h3 {
  font-family: var(--font-ui);
  font-weight: 700;
  margin: 10px 0 4px;
  color: var(--text);
}
.cb-md h1 { font-size: 1.05rem; }
.cb-md h2 { font-size: 0.97rem; }
.cb-md h3 { font-size: 0.90rem; }
.cb-md a  { color: var(--blue-mid); text-decoration: underline; }
.cb-md blockquote {
  border-left: 3px solid var(--blue-light);
  border-radius: 0;
  padding: 4px 12px;
  margin: 8px 0;
  color: var(--text-muted);
  font-style: italic;
}

/* ════════════════════════════════════════
   TYPEWRITER CURSOR
════════════════════════════════════════ */
.cb-cursor {
  display: inline-block;
  width: 2px; height: 1em;
  background: var(--blue-mid);
  vertical-align: text-bottom;
  margin-left: 2px;
  border-radius: 1px;
  animation: cur-blink 0.65s steps(1) infinite;
}
@keyframes cur-blink {
  0%, 100% { opacity: 1; }
  50%       { opacity: 0; }
}

/* ════════════════════════════════════════
   URGENCY + MAJOR BADGES
════════════════════════════════════════ */
.cb-meta-row {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  margin-top: 10px;
}
.cb-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  border-radius: var(--r-pill);
  padding: 4px 11px;
  font-size: 0.71rem;
  font-weight: 700;
  font-family: var(--font-ui);
  line-height: 1;
}
.cb-badge.low    { background: #e8f5e9; color: #2e7d32; }
.cb-badge.medium { background: var(--warn-bg); color: var(--warn-text); border: 1px solid #ffe082; }
.cb-badge.high   { background: var(--danger-bg); color: var(--danger-text); border: 1px solid var(--danger-brd); }
.cb-badge.major  { background: var(--blue-pale); color: var(--blue-deep); }

/* ════════════════════════════════════════
   EMERGENCY BUBBLE OVERRIDE
════════════════════════════════════════ */
.cb-bubble.emergency {
  border: 1px solid var(--danger-brd) !important;
  border-left: 4px solid #e53935 !important;
  border-radius: 20px !important;
  border-bottom-left-radius: 5px !important;
  background: #fff8f8 !important;
  animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
}
@keyframes shake {
  10%, 90%        { transform: translateX(-2px); }
  20%, 80%        { transform: translateX(3px);  }
  30%, 50%, 70%   { transform: translateX(-3px); }
  40%, 60%        { transform: translateX(3px);  }
}

/* ── EMERGENCY BANNER ── */
.cb-emg-banner {
  display: flex;
  align-items: center;
  gap: 9px;
  background: var(--danger-bg);
  border: 1px solid var(--danger-brd);
  border-left: 4px solid #e53935;
  border-radius: var(--r-md);
  border-bottom-left-radius: 0;
  padding: 10px 14px;
  margin-bottom: 8px;
  font-family: var(--font-ui);
  font-size: 0.80rem;
  font-weight: 700;
  color: var(--danger-text);
  animation: fade-slide 0.35s ease both;
}
.cb-emg-banner i { font-size: 15px; flex-shrink: 0; }
@keyframes fade-slide {
  from { opacity: 0; transform: translateY(-5px); }
  to   { opacity: 1; transform: none; }
}

/* ════════════════════════════════════════
   DOCTOR CARDS
════════════════════════════════════════ */
.cb-doctors {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-top: 12px;
}
.cb-doc-card {
  display: flex;
  align-items: center;
  gap: 12px;
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: var(--r-lg);
  padding: 11px 13px;
  transition: border-color var(--speed), box-shadow var(--speed);
}
.cb-doc-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 2px 12px var(--blue-glow);
}
.cb-doc-av {
  width: 44px; height: 44px;
  border-radius: var(--r-md);
  background: var(--blue-pale);
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
  overflow: hidden;
}
.cb-doc-av img {
  width: 100%; height: 100%;
  object-fit: cover;
  border-radius: calc(var(--r-md) - 1px);
}
.cb-doc-info { flex: 1; min-width: 0; }
.cb-doc-name {
  font-weight: 700;
  font-size: 0.87rem;
  color: var(--text);
  margin: 0 0 4px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.cb-doc-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  font-size: 0.72rem;
  color: var(--text-muted);
}
.cb-doc-meta span {
  display: flex;
  align-items: center;
  gap: 3px;
}
.cb-doc-meta i { font-size: 11px; }
.cb-doc-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 6px;
  flex-shrink: 0;
}
.cb-doc-fee {
  font-size: 0.84rem;
  font-weight: 700;
  color: var(--blue-mid);
  white-space: nowrap;
}
.cb-book-btn {
  padding: 6px 14px;
  border-radius: var(--r-sm);
  border: none;
  cursor: pointer;
  font-family: var(--font-ui);
  font-size: 0.75rem;
  font-weight: 700;
  background: linear-gradient(135deg, var(--blue-mid), var(--blue-deep));
  color: #fff;
  white-space: nowrap;
  transition: transform 0.15s, box-shadow 0.15s;
  box-shadow: 0 2px 8px rgba(26,115,232,0.28);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}
.cb-book-btn:hover  { transform: scale(1.04); box-shadow: var(--shadow-btn); color: #fff; }
.cb-book-btn:active { transform: scale(0.96); }

/* ════════════════════════════════════════
   TYPING INDICATOR
════════════════════════════════════════ */
.cb-typing {
  display: none;
  align-items: flex-end;
  gap: 10px;
}
.cb-typing-dots {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 20px;
  border-bottom-left-radius: 5px;
  padding: 13px 17px;
  display: flex;
  gap: 5px;
  align-items: center;
}
.cb-dot {
  width: 6px; height: 6px;
  border-radius: 50%;
  background: var(--blue-light);
  animation: dot-bounce 1.3s infinite ease-in-out;
}
.cb-dot:nth-child(2) { animation-delay: 0.18s; }
.cb-dot:nth-child(3) { animation-delay: 0.36s; }
@keyframes dot-bounce {
  0%, 80%, 100% { transform: translateY(0); opacity: 0.35; }
  40%           { transform: translateY(-7px); opacity: 1; }
}

/* ════════════════════════════════════════
   DIVIDER
════════════════════════════════════════ */
.cb-divider { height: 1px; background: var(--border); flex-shrink: 0; }

/* ════════════════════════════════════════
   SUGGESTION CHIPS
════════════════════════════════════════ */
.cb-chips {
  display: flex;
  gap: 7px;
  padding: 10px 24px 4px;
  overflow-x: auto;
  flex-shrink: 0;
}
.cb-chips::-webkit-scrollbar { display: none; }
.cb-chip {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  white-space: nowrap;
  background: var(--white);
  border: 1.5px solid var(--border);
  color: var(--text);
  border-radius: var(--r-pill);
  padding: 7px 15px;
  font-size: 0.80rem;
  font-weight: 600;
  font-family: var(--font-ui);
  cursor: pointer;
  flex-shrink: 0;
  transition: all var(--speed);
}
.cb-chip:hover {
  background: var(--blue-mid);
  color: #fff;
  border-color: var(--blue-mid);
  transform: translateY(-1px);
  box-shadow: 0 3px 10px var(--blue-glow);
}
.cb-chip:active { transform: translateY(0); }

/* ════════════════════════════════════════
   INPUT ROW
════════════════════════════════════════ */
.cb-input-row {
  display: flex;
  align-items: flex-end;
  gap: 10px;
  padding: 10px 20px 18px;
  flex-shrink: 0;
}
.cb-input-wrap {
  flex: 1;
  position: relative;
  display: flex;
  align-items: flex-end;
}
#cbInput {
  width: 100%;
  background: var(--surface);
  border: 1.5px solid var(--border);
  border-radius: 18px;
  padding: 12px 16px;
  font-size: 0.97rem;
  font-family: var(--font-body);
  color: var(--text);
  resize: none;
  outline: none;
  max-height: 120px;
  overflow-y: auto;
  line-height: 1.55;
  transition: border-color var(--speed), box-shadow var(--speed), background var(--speed);
  box-sizing: border-box;
}
#cbInput::placeholder { color: var(--text-muted); opacity: 0.55; }
#cbInput:focus {
  border-color: var(--blue-mid);
  box-shadow: 0 0 0 3px var(--blue-glow);
  background: var(--white);
}
#cbInput::-webkit-scrollbar { width: 3px; }
#cbInput::-webkit-scrollbar-thumb { background: var(--border); border-radius: 99px; }

.cb-char-count {
  position: absolute;
  bottom: 10px; right: 12px;
  font-size: 0.65rem;
  font-family: var(--font-ui);
  color: var(--text-muted);
  opacity: 0;
  transition: opacity var(--speed);
  pointer-events: none;
}
#cbInput:focus ~ .cb-char-count { opacity: 0.55; }

.cb-send {
  width: 46px; height: 46px;
  border-radius: 14px;
  background: linear-gradient(135deg, var(--blue-mid), var(--blue-deep));
  color: #fff;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  cursor: pointer;
  flex-shrink: 0;
  transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
  box-shadow: var(--shadow-btn);
}
.cb-send:hover  { transform: scale(1.06); }
.cb-send:active { transform: scale(0.93); }
.cb-send:disabled { opacity: 0.35; cursor: default; transform: none; box-shadow: none; }

/* ════════════════════════════════════════
   FOOTER NOTE
════════════════════════════════════════ */
.cb-note {
  text-align: center;
  font-size: 0.68rem;
  color: var(--text-muted);
  opacity: 0.45;
  padding: 0 20px 12px;
  flex-shrink: 0;
  font-family: var(--font-ui);
}

/* ════════════════════════════════════════
   RESPONSIVE
════════════════════════════════════════ */
@media (max-width: 640px) {
  .cb-page  { padding: 0; }
  .cb-wrap  { gap: 0; }
  .cb-card  { border-radius: 0; height: 100dvh; max-height: none; }
  .cb-eyebrow { display: none; }
  .cb-bubble-wrap    { max-width: 84%; }
  .cb-bubble-wrap.wide { max-width: 95%; }
  .cb-doc-card { flex-wrap: wrap; }
  .cb-doc-right { flex-direction: row; align-items: center; width: 100%; }
}
</style>
@endpush

@section('content')
<div class="cb-page">
  <div class="cb-wrap">

    {{-- ── EYEBROW ── --}}
    <div class="cb-eyebrow">
      <hr>
      <div class="cb-eyebrow-label">
        <div class="cb-pulse">
          <div class="cb-pulse-core"></div>
          <div class="cb-pulse-ring"></div>
        </div>
        AI Health Assistant &middot; Online 24/7
      </div>
      <hr>
    </div>

    {{-- ── MAIN CARD ── --}}
    <div class="cb-card">

      {{-- Header --}}
      <div class="cb-header">
        <div class="cb-header-orb cb-header-orb-1"></div>
        <div class="cb-header-orb cb-header-orb-2"></div>
        <div class="cb-header-orb cb-header-orb-3"></div>

        <div class="cb-hdr-avatar">
          <i class="fa-solid fa-robot"></i>
        </div>

        <div class="cb-hdr-info">
          <h2>Health Assistant</h2>
          <p>Powered by Gemini AI &middot; Medical guidance at your fingertips</p>
        </div>

        <div class="cb-hdr-live">
          <div class="cb-pulse">
            <div class="cb-pulse-core"></div>
            <div class="cb-pulse-ring"></div>
          </div>
          Live
        </div>
      </div>

      {{-- Messages --}}
      <div class="cb-messages" id="cbMessages">

        {{-- Welcome message --}}
        <div class="cb-row bot" style="margin-bottom:8px;">
          <div class="cb-av"><i class="fa-solid fa-robot"></i></div>
          <div class="cb-bubble-wrap">
            <div class="cb-bubble cb-md">
              <p>👋 Hello! I'm your <strong>AI Health Assistant</strong>.</p>
              <p>Describe your symptoms and I'll analyze them to guide you to the <strong>right medical specialty</strong> and suggest <strong>available doctors</strong> you can book instantly.</p>
              <p>⚠️ My answers are informational only and do not replace professional medical advice. For emergencies, call your local emergency number immediately.</p>
              <p style="margin-bottom:0">What symptoms are you experiencing, or which specialty are you looking for?</p>
            </div>
            <div class="cb-time" id="cbWelcomeTime"></div>
          </div>
        </div>

        {{-- Typing indicator --}}
        <div class="cb-typing" id="cbTyping">
          <div class="cb-av" style="background:var(--blue-pale);color:var(--blue-mid);border:1px solid var(--border);">
            <i class="fa-solid fa-robot"></i>
          </div>
          <div class="cb-typing-dots">
            <div class="cb-dot"></div>
            <div class="cb-dot"></div>
            <div class="cb-dot"></div>
          </div>
        </div>

      </div>{{-- /cb-messages --}}

      <div class="cb-divider"></div>

      {{-- Suggestion chips --}}
      <div class="cb-chips">
        <button class="cb-chip" onclick="useSuggestion(this)">🧠 Persistent headache and dizziness</button>
        <button class="cb-chip" onclick="useSuggestion(this)">🦴 Severe knee and joint pain</button>
        <button class="cb-chip" onclick="useSuggestion(this)">❤️ Irregular heartbeat</button>
        <button class="cb-chip" onclick="useSuggestion(this)">👶 Book a pediatrician</button>
        <button class="cb-chip" onclick="useSuggestion(this)">🔍 Book an internal medicine doctor</button>
        <button class="cb-chip" onclick="useSuggestion(this)">👁️ Eye pain and blurred vision</button>
      </div>

      {{-- Input row --}}
      <div class="cb-input-row">
        <div class="cb-input-wrap">
          <textarea
            id="cbInput"
            rows="1"
            placeholder="Describe your symptoms or the specialty you're looking for…"
            maxlength="1000"
            aria-label="Your message"
          ></textarea>
          <span class="cb-char-count" id="cbCharCount">0 / 1000</span>
        </div>
        <button class="cb-send" id="cbSend" onclick="sendMessage()" aria-label="Send message">
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>

      <div class="cb-note">For emergencies please call your local emergency services immediately.</div>

    </div>{{-- /cb-card --}}
  </div>{{-- /cb-wrap --}}
</div>{{-- /cb-page --}}
@endsection


@push('scripts')
{{-- Markdown renderer --}}
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
{{-- XSS sanitizer --}}
<script src="https://cdn.jsdelivr.net/npm/dompurify@3.1.6/dist/purify.min.js"></script>

<script>
(function () {
  /* ── Config ── */
  const CSRF     = '{{ csrf_token() }}';
  const SEND_URL = '{{ route("front.chatbot.send") }}';
  const TYPEWRITER_SPEED = 16; // ms per char

  /* ── DOM refs ── */
  const msgEl    = document.getElementById('cbMessages');
  const inputEl  = document.getElementById('cbInput');
  const sendBtn  = document.getElementById('cbSend');
  const typingEl = document.getElementById('cbTyping');
  const charEl   = document.getElementById('cbCharCount');

  /* ── State ── */
  let history  = [];
  let isTyping = false;

  /* ── Marked config ── */
  marked.setOptions({ breaks: true, gfm: true });

  /* ── Helpers ── */
  function now() {
    return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }

  function sanitizeHtml(raw) {
    const html = marked.parse(raw);
    return DOMPurify.sanitize(html, {
      ALLOWED_TAGS: ['p','strong','em','b','i','ul','ol','li',
                     'code','pre','h1','h2','h3','br','a','blockquote','hr'],
      ALLOWED_ATTR: ['href','target','rel'],
    });
  }

  function scrollDown() {
    msgEl.scrollTo({ top: msgEl.scrollHeight, behavior: 'smooth' });
  }

  /* ── Welcome timestamp ── */
  document.getElementById('cbWelcomeTime').textContent = now();

  /* ── Textarea auto-resize + char count ── */
  inputEl.addEventListener('input', () => {
    inputEl.style.height = 'auto';
    inputEl.style.height = Math.min(inputEl.scrollHeight, 120) + 'px';
    charEl.textContent = inputEl.value.length + ' / 1000';
  });

  inputEl.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
  });

  /* ── Chip click ── */
  window.useSuggestion = function(btn) {
    // شيل الـ emoji من أول النص
    const text = btn.textContent.trim().replace(/^[\p{Emoji_Presentation}\p{Extended_Pictographic}\s]+/u, '').trim();
    inputEl.value = text;
    inputEl.dispatchEvent(new Event('input'));
    sendMessage();
  };

  /* ════════════════════════════════════════
     TYPEWRITER ENGINE
  ════════════════════════════════════════ */
  function typewrite(el, rawText, speedMs, onDone) {
    el.classList.add('cb-md');
    el.innerHTML = sanitizeHtml(rawText);

    const walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT);
    const nodes  = [];
    let n;
    while ((n = walker.nextNode())) nodes.push(n);

    const originals = nodes.map(nd => {
      const t = nd.textContent;
      nd.textContent = '';
      return t;
    });

    const cursor = document.createElement('span');
    cursor.className = 'cb-cursor';
    el.appendChild(cursor);

    let ni = 0, ci = 0;

    function tick() {
      if (ni >= nodes.length) {
        cursor.remove();
        if (onDone) onDone();
        return;
      }
      nodes[ni].textContent += originals[ni][ci];
      ci++;
      if (ci >= originals[ni].length) { ni++; ci = 0; }
      scrollDown();
      setTimeout(tick, speedMs);
    }

    tick();
  }

  /* ════════════════════════════════════════
     SEND MESSAGE
  ════════════════════════════════════════ */
  window.sendMessage = async function () {
    const text = inputEl.value.trim();
    if (!text || sendBtn.disabled || isTyping) return;

    sendBtn.disabled = true;
    inputEl.value = '';
    inputEl.style.height = 'auto';
    charEl.textContent = '0 / 1000';

    addUserBubble(text);
    typingEl.style.display = 'flex';
    scrollDown();

    try {
      const res = await fetch(SEND_URL, {
        method:  'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': CSRF,
        },
        body: JSON.stringify({ message: text, history }),
      });

      // ✅ تعامل مع كل حالات الـ HTTP errors
      if (!res.ok) {
        const errData = await res.json().catch(() => ({}));
        throw new Error(errData.error || 'Server error (' + res.status + ')');
      }

      const data = await res.json();
      typingEl.style.display = 'none';

      if (data.error) {
        addBotBubble('⚠️ ' + data.error, null, null, []);
      } else {
        addBotBubble(data.reply, data.urgency, data.major, data.doctors || []);
        // ✅ بنحتفظ بآخر 10 رسايل بس (5 exchanges) في الـ frontend كمان
        history.push({ role: 'user',      content: text });
        history.push({ role: 'assistant', content: data.reply });
        if (history.length > 10) history = history.slice(-10);
      }

    } catch (err) {
      typingEl.style.display = 'none';
      addBotBubble('⚠️ ' + (err.message || 'Network error. Please check your connection and try again.'), null, null, []);
    } finally {
      // ✅ always re-enable the button even if typewriter runs (typewriter handles its own disable)
      if (!isTyping) {
        sendBtn.disabled = false;
      }
      inputEl.focus();
    }
  };

  /* ════════════════════════════════════════
     USER BUBBLE
  ════════════════════════════════════════ */
  function addUserBubble(text) {
    const row  = document.createElement('div');
    row.className = 'cb-row user';

    const av = document.createElement('div');
    av.className = 'cb-av';
    av.innerHTML = '<i class="fa-solid fa-user"></i>';

    const wrap = document.createElement('div');
    wrap.className = 'cb-bubble-wrap';

    const bubble = document.createElement('div');
    bubble.className = 'cb-bubble';
    bubble.textContent = text; // textContent بدل innerHTML عشان نتجنب XSS

    const time = document.createElement('div');
    time.className = 'cb-time';
    time.textContent = now();

    wrap.append(bubble, time);
    row.append(wrap, av);
    msgEl.insertBefore(row, typingEl);
    scrollDown();
  }

  /* ════════════════════════════════════════
     BOT BUBBLE
  ════════════════════════════════════════ */
  function addBotBubble(reply, urgency, major, doctors) {
    const isHigh     = urgency === 'high';
    const hasDoctors = doctors && doctors.length > 0;

    const row = document.createElement('div');
    row.className = 'cb-row bot';

    const av = document.createElement('div');
    av.className = 'cb-av';
    av.innerHTML = '<i class="fa-solid fa-robot"></i>';

    const wrap = document.createElement('div');
    wrap.className = 'cb-bubble-wrap' + (hasDoctors ? ' wide' : '');

    if (isHigh) {
      const banner = document.createElement('div');
      banner.className = 'cb-emg-banner';
      banner.innerHTML =
        '<i class="fa-solid fa-triangle-exclamation"></i>' +
        '<span>Emergency — Call your local emergency services immediately.</span>';
      wrap.appendChild(banner);
    }

    const bubble = document.createElement('div');
    bubble.className = 'cb-bubble' + (isHigh ? ' emergency' : '');

    const contentEl = document.createElement('div');
    bubble.appendChild(contentEl);

    const time = document.createElement('div');
    time.className = 'cb-time';
    time.textContent = now();

    wrap.append(bubble, time);
    row.append(av, wrap);
    msgEl.insertBefore(row, typingEl);
    scrollDown();

    /* typewriter */
    isTyping = true;
    sendBtn.disabled = true;

    typewrite(contentEl, reply, TYPEWRITER_SPEED, function onDone() {
      isTyping = false;
      sendBtn.disabled = false;

      /* badges */
      if (urgency) {
        const metaRow = document.createElement('div');
        metaRow.className = 'cb-meta-row';

        const urgencyMap = {
          low:    { icon: '●', label: 'Routine',           cls: 'low'    },
          medium: { icon: '⚠', label: 'See a doctor soon', cls: 'medium' },
          high:   { icon: '🚨', label: 'Emergency',         cls: 'high'   },
        };
        const u = urgencyMap[urgency] || { icon: '●', label: urgency, cls: 'low' };

        const ub = document.createElement('span');
        ub.className = 'cb-badge ' + u.cls;
        ub.textContent = u.icon + ' ' + u.label;
        metaRow.appendChild(ub);

        if (major) {
          const mc = document.createElement('span');
          mc.className = 'cb-badge major';
          mc.textContent = '🏥 ' + major;
          metaRow.appendChild(mc);
        }

        bubble.appendChild(metaRow);
      }

      if (hasDoctors) {
        bubble.appendChild(buildDoctorsStrip(doctors));
      }

      scrollDown();
    });
  }

  /* ════════════════════════════════════════
     DOCTOR CARDS BUILDER
  ════════════════════════════════════════ */
  function buildDoctorsStrip(doctors) {
    const strip = document.createElement('div');
    strip.className = 'cb-doctors';

    doctors.forEach(function(doc) {
      const card = document.createElement('div');
      card.className = 'cb-doc-card';

      /* avatar */
      const av = document.createElement('div');
      av.className = 'cb-doc-av';
      if (doc.image) {
        const img = document.createElement('img');
        img.src   = doc.image;
        img.alt   = doc.name;
        // ✅ fallback لو الصورة اتعطلت
        img.onerror = function() {
          av.removeChild(img);
          av.textContent = '🩺';
        };
        av.appendChild(img);
      } else {
        av.textContent = '🩺';
      }

      /* info */
      const info = document.createElement('div');
      info.className = 'cb-doc-info';

      const name = document.createElement('div');
      name.className  = 'cb-doc-name';
      name.textContent = doc.name;
      info.appendChild(name);

      const meta = document.createElement('div');
      meta.className = 'cb-doc-meta';

      if (doc.experience) {
        const exp = document.createElement('span');
        exp.innerHTML = '<i class="fa-solid fa-briefcase-medical"></i> ' + doc.experience + ' yrs';
        meta.appendChild(exp);
      }
      if (doc.schedule) {
        const sch = document.createElement('span');
        sch.innerHTML = '<i class="fa-regular fa-calendar"></i> ' + doc.schedule;
        meta.appendChild(sch);
      }
      info.appendChild(meta);

      /* right: fee + book */
      const right = document.createElement('div');
      right.className = 'cb-doc-right';

      if (doc.consultation_fee) {
        const fee = document.createElement('div');
        fee.className   = 'cb-doc-fee';
        fee.textContent = doc.consultation_fee + ' EGP';
        right.appendChild(fee);
      }

      // ✅ استخدام <a> بدل <button> عشان الـ booking_url يجي من الـ backend
      const btn = document.createElement('a');
      btn.className = 'cb-book-btn';
      btn.href      = doc.booking_url || '#';
      btn.innerHTML = '<i class="fa-solid fa-calendar-check"></i> Book Now';
      // افتح في نفس التاب
      right.appendChild(btn);

      card.append(av, info, right);
      strip.appendChild(card);
    });

    return strip;
  }

})();
</script>
@endpush