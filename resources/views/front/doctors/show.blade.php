@extends('front.inc.master')
@section('title', 'Dr. ' . $doctor->user->name)

@section('content')

<style>
/* ========================================================
   DOCTOR SHOW PAGE — prefix: ds- (doctor-show)
   All hex values hardcoded — zero var() dependencies
   ======================================================== */

@keyframes dsFadeUp {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes dsPulse {
  0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.4); }
  50%      { box-shadow: 0 0 0 6px rgba(16,185,129,0); }
}
@keyframes dsSpin { to { transform: rotate(360deg); } }

/* ── HERO BANNER ── */
.ds-hero {
  background: #05143a;
  padding: 60px 0 0;
  position: relative;
  overflow: hidden;
}
.ds-hero-blob1 {
  position: absolute; top: -80px; right: -80px;
  width: 400px; height: 400px; border-radius: 50%;
  background: radial-gradient(circle, rgba(0,106,255,0.15) 0%, transparent 70%);
  pointer-events: none;
}
.ds-hero-blob2 {
  position: absolute; bottom: -60px; left: -60px;
  width: 300px; height: 300px; border-radius: 50%;
  background: radial-gradient(circle, rgba(201,168,76,0.10) 0%, transparent 70%);
  pointer-events: none;
}
.ds-hero-grid {
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 60px 60px; pointer-events: none;
}

.ds-hero-inner {
  position: relative; z-index: 2;
  max-width: 1100px; margin: 0 auto; padding: 0 24px 48px;
  display: flex; align-items: flex-end; gap: 36px;
}

/* avatar */
.ds-hero-avatar {
  position: relative; flex-shrink: 0;
  width: 150px; height: 150px;
}
.ds-av-ring {
  position: absolute; inset: -5px; border-radius: 50%;
  background: conic-gradient(#006aff 0%, #c9a84c 50%, #006aff 100%);
  animation: dsSpin 4s linear infinite; z-index: 0;
}
.ds-hero-avatar img {
  width: 100%; height: 100%; object-fit: cover;
  border-radius: 50%; border: 4px solid #fff;
  position: relative; z-index: 1;
}
.ds-online {
  position: absolute; bottom: 8px; right: 8px; z-index: 2;
  width: 18px; height: 18px; border-radius: 50%;
  background: #10b981; border: 3px solid #fff;
  animation: dsPulse 2s ease-in-out infinite;
}

/* hero info */
.ds-hero-info { flex: 1; padding-bottom: 4px; }
.ds-bc {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: 0.78rem; color: rgba(255,255,255,0.38);
  margin-bottom: 16px;
}
.ds-bc a { color: rgba(255,255,255,0.50); text-decoration: none; transition: .3s; }
.ds-bc a:hover { color: #fff; }
.ds-bc i { font-size: 0.5em; color: rgba(255,255,255,0.2); }
.ds-bc span { color: #c9a84c; font-weight: 600; }
.ds-hero-name {
  font-family: 'Fraunces', serif;
  font-size: 2.4rem; font-weight: 700; color: #fff;
  line-height: 1.1; margin-bottom: 10px;
}
.ds-hero-spec {
  display: inline-block;
  background: rgba(0,106,255,0.2); color: #7ab0ff;
  padding: 5px 18px; border-radius: 9999px;
  font-size: 0.78rem; font-weight: 700;
  letter-spacing: 0.07em; text-transform: uppercase;
  border: 1px solid rgba(0,106,255,0.3);
  margin-bottom: 16px;
}
.ds-hero-meta {
  display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
}
.ds-hero-meta-item {
  display: flex; align-items: center; gap: 7px;
  font-size: 0.84rem; color: rgba(255,255,255,0.55); font-weight: 300;
}
.ds-hero-meta-item i { color: #c9a84c; font-size: 0.8rem; }

/* stars */
.ds-stars { display: flex; gap: 3px; color: #c9a84c; font-size: 0.85rem; }

/* hero actions */
.ds-hero-actions { display: flex; gap: 10px; flex-shrink: 0; align-self: flex-end; padding-bottom: 4px; }
.ds-book-hero-btn {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 28px; background: #006aff; color: #fff !important;
  border-radius: 14px; font-size: 0.88rem; font-weight: 700;
  text-decoration: none; transition: .3s;
  box-shadow: 0 4px 20px rgba(0,106,255,0.4);
}
.ds-book-hero-btn:hover { background: #0052cc; transform: translateY(-1px); box-shadow: 0 6px 28px rgba(0,106,255,0.5); color: #fff !important; }
.ds-msg-btn {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 22px; background: rgba(255,255,255,0.1); color: #fff !important;
  border-radius: 14px; font-size: 0.88rem; font-weight: 600;
  text-decoration: none; transition: .3s;
  border: 1.5px solid rgba(255,255,255,0.2);
}
.ds-msg-btn:hover { background: rgba(255,255,255,0.18); color: #fff !important; }

/* ── STATS BAR ── */
.ds-stats-bar {
  background: #fff;
  border-bottom: 1px solid #e8ecf4;
}
.ds-stats-inner {
  max-width: 1100px; margin: 0 auto; padding: 0 24px;
  display: flex; align-items: stretch;
}
.ds-stat-item {
  flex: 1; padding: 20px 24px; text-align: center;
  border-right: 1px solid #e8ecf4;
  transition: background .3s;
}
.ds-stat-item:last-child { border-right: none; }
.ds-stat-item:hover { background: #f5f7fc; }
.ds-stat-val {
  font-family: 'Fraunces', serif;
  font-size: 1.7rem; font-weight: 700; color: #05143a; line-height: 1; margin-bottom: 4px;
}
.ds-stat-val span { color: #006aff; }
.ds-stat-key { font-size: 0.72rem; color: #9aa4b8; letter-spacing: 0.08em; text-transform: uppercase; font-weight: 500; }

/* ── MAIN CONTENT ── */
.ds-main {
  background: #f5f7fc; padding: 48px 0 100px;
}
.ds-main-inner {
  max-width: 1100px; margin: 0 auto; padding: 0 24px;
  display: grid; grid-template-columns: 1fr 380px; gap: 28px;
}

/* ── CARD BASE ── */
.ds-card {
  background: #fff; border-radius: 22px; padding: 30px;
  box-shadow: 0 2px 10px rgba(5,20,58,0.05), 0 6px 28px rgba(5,20,58,0.04);
  border: 1px solid #e8ecf4;
  animation: dsFadeUp .5s ease-out both;
}
.ds-card-title {
  font-family: 'Fraunces', serif;
  font-size: 1.15rem; font-weight: 600; color: #05143a;
  margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
}
.ds-card-title i { color: #006aff; font-size: 1rem; }
.ds-card + .ds-card { margin-top: 24px; }

/* ── ABOUT ── */
.ds-about-text {
  font-size: 0.92rem; color: #5a6380; line-height: 1.8; font-weight: 300;
}

/* ── INFO LIST ── */
.ds-info-list { display: flex; flex-direction: column; gap: 14px; }
.ds-info-row {
  display: flex; align-items: center; gap: 14px;
  padding: 12px 16px; background: #f5f7fc;
  border-radius: 12px; border: 1px solid #e8ecf4;
  transition: border-color .3s, box-shadow .3s;
}
.ds-info-row:hover {
  border-color: rgba(0,106,255,0.2);
  box-shadow: 0 4px 14px rgba(0,106,255,0.07);
}
.ds-info-icon {
  width: 36px; height: 36px; border-radius: 10px;
  background: #eef3ff; color: #006aff;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.82rem; flex-shrink: 0;
}
.ds-info-label { font-size: 0.72rem; color: #9aa4b8; font-weight: 500; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 2px; }
.ds-info-val { font-size: 0.88rem; color: #05143a; font-weight: 500; }

/* ── EXPERIENCE ROW ── */
.ds-exp-val {
  display: flex;
  flex-direction: column;
  gap: 7px;
}
.ds-exp-dots {
  display: flex;
  gap: 4px;
  align-items: center;
  flex-wrap: wrap;
}
.ds-exp-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #d8dce8;
  transition: background .3s, transform .3s;
  display: inline-block;
}
.ds-exp-dot.active {
  background: linear-gradient(135deg, #006aff, #c9a84c);
}
.ds-info-row:hover .ds-exp-dot.active {
  transform: scale(1.4);
}

/* ── SCHEDULE ── */
.ds-schedule-grid {
  display: flex; flex-direction: column; gap: 10px;
}
.ds-day-row {
  display: flex; align-items: center; gap: 14px;
  padding: 14px 16px; border-radius: 14px;
  border: 1.5px solid #e8ecf4; background: #fff;
  transition: .3s;
}
.ds-day-row.available {
  border-color: rgba(0,106,255,0.2);
  background: linear-gradient(135deg, #f2f6ff 0%, #fff 100%);
}
.ds-day-row:hover.available { border-color: #006aff; box-shadow: 0 4px 16px rgba(0,106,255,0.1); }
.ds-day-dot {
  width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
  background: #d8dce8;
}
.ds-day-row.available .ds-day-dot { background: #10b981; animation: dsPulse 2s ease-in-out infinite; }
.ds-day-name {
  font-size: 0.88rem; font-weight: 700; color: #3d4a63; min-width: 90px;
}
.ds-day-row.available .ds-day-name { color: #05143a; }
.ds-day-time {
  flex: 1; font-size: 0.82rem; color: #8892aa; font-weight: 300;
}
.ds-day-row.available .ds-day-time { color: #3d4a63; font-weight: 500; }
.ds-day-off {
  font-size: 0.72rem; font-weight: 600; color: #c0c8da;
  letter-spacing: 0.06em; text-transform: uppercase;
}
.ds-time-from {
  font-size: 0.82rem; font-weight: 600; color: #006aff;
  display: inline-flex; align-items: center; gap: 5px;
}
.ds-time-from i { font-size: 0.72rem; }
.ds-time-arrow {
  color: #9aa4b8; font-size: 0.78rem; margin: 0 6px;
}
.ds-time-to {
  font-size: 0.82rem; font-weight: 600; color: #05143a;
}

/* ── BOOK CARD ── */
.ds-book-card {
  background: linear-gradient(135deg, #05143a 0%, #06234e 100%);
  border-radius: 22px; padding: 28px;
  box-shadow: 0 8px 32px rgba(5,20,58,0.18);
  border: 1px solid rgba(255,255,255,0.06);
  position: relative; overflow: hidden;
}
.ds-book-card::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(90deg, #006aff, #c9a84c);
}
.ds-book-card-title {
  font-family: 'Fraunces', serif;
  font-size: 1.15rem; font-weight: 600; color: #fff;
  margin-bottom: 6px;
}
.ds-book-card-sub {
  font-size: 0.82rem; color: rgba(255,255,255,0.45);
  font-weight: 300; margin-bottom: 24px;
}
.ds-price-display {
  display: flex; align-items: baseline; gap: 6px; margin-bottom: 20px;
}
.ds-price-big {
  font-family: 'Fraunces', serif;
  font-size: 2.8rem; font-weight: 700; color: #fff; line-height: 1;
}
.ds-price-curr {
  font-size: 1rem; color: rgba(255,255,255,0.5); font-weight: 300;
}
.ds-price-per {
  font-size: 0.78rem; color: rgba(255,255,255,0.35);
  font-weight: 300; align-self: flex-end; padding-bottom: 4px;
}
.ds-book-features { display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px; }
.ds-book-feat {
  display: flex; align-items: center; gap: 10px;
  font-size: 0.82rem; color: rgba(255,255,255,0.6); font-weight: 300;
}
.ds-book-feat i { color: #c9a84c; font-size: 0.8rem; width: 14px; }
.ds-hr-light { height: 1px; background: rgba(255,255,255,0.08); margin-bottom: 22px; }
.ds-big-book-btn {
  display: flex; align-items: center; justify-content: center; gap: 10px;
  width: 100%; padding: 14px;
  background: #006aff; color: #fff !important;
  border-radius: 14px; font-size: 0.92rem; font-weight: 700;
  text-decoration: none; transition: .3s; letter-spacing: 0.02em;
  box-shadow: 0 4px 20px rgba(0,106,255,0.5);
}
.ds-big-book-btn:hover { background: #0052cc; transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,106,255,0.55); color: #fff !important; }

/* ── RESPONSIVE ── */
@media (max-width: 991px) {
  .ds-main-inner { grid-template-columns: 1fr; }
  .ds-hero-inner { flex-direction: column; align-items: flex-start; gap: 20px; }
  .ds-hero-actions { align-self: stretch; }
  .ds-book-hero-btn, .ds-msg-btn { flex: 1; justify-content: center; }
  .ds-hero-name { font-size: 1.9rem; }
  .ds-stats-inner { flex-wrap: wrap; }
  .ds-stat-item { flex: 0 0 50%; border-bottom: 1px solid #e8ecf4; }
}
@media (max-width: 768px) {
  .ds-hero-name { font-size: 1.6rem; }
  .ds-hero-avatar { width: 110px; height: 110px; }
  .ds-stat-item { flex: 0 0 100%; }
}
</style>

{{-- ══ HERO ══ --}}
<section class="ds-hero">
  <div class="ds-hero-blob1"></div>
  <div class="ds-hero-blob2"></div>
  <div class="ds-hero-grid"></div>
  <div class="ds-hero-inner">

    {{-- Avatar --}}
    <div class="ds-hero-avatar">
      <div class="ds-av-ring"></div>
      <img
        src="{{ $doctor->image ? asset('images/doctors/' . $doctor->image) : asset('images/default-doctor.png') }}"
        alt="Dr. {{ $doctor->user->name }}"
        onerror="this.onerror=null;this.src='https://placehold.co/300x300/eef3ff/006aff?text=Dr'"
      />
      <div class="ds-online"></div>
    </div>

    {{-- Info --}}
    <div class="ds-hero-info">
      <div class="ds-bc">
        <a href="{{ route('front.home') }}"><i class="fa-solid fa-house"></i> Home</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('front.doctors') }}">Doctors</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>Dr. {{ $doctor->user->name }}</span>
      </div>

      <h1 class="ds-hero-name">Dr. {{ $doctor->user->name }}</h1>

      @if($doctor->major)
        <div class="ds-hero-spec">{{ $doctor->major->title }}</div>
      @endif

      <div class="ds-hero-meta">
        <div class="ds-hero-meta-item">
          <i class="fa-solid fa-envelope"></i>
          <span>{{ $doctor->user->email }}</span>
        </div>
        @if($doctor->user->phone)
        <div class="ds-hero-meta-item">
          <i class="fa-solid fa-phone"></i>
          <span>{{ $doctor->user->phone }}</span>
        </div>
        @endif
        <div class="ds-stars">
          @for($i = 1; $i <= 5; $i++)
            <i class="fa{{ $i <= 4 ? '-solid' : '-regular' }} fa-star"></i>
          @endfor
        </div>
      </div>
    </div>

    {{-- Actions --}}
    <div class="ds-hero-actions">
      <a href="#book" class="ds-book-hero-btn">
        <i class="fa-regular fa-calendar-check"></i> Book Appointment
      </a>
      <a href="mailto:{{ $doctor->user->email }}" class="ds-msg-btn">
        <i class="fa-regular fa-envelope"></i> Message
      </a>
    </div>

  </div>
</section>

{{-- ══ STATS BAR ══ --}}
<div class="ds-stats-bar">
  <div class="ds-stats-inner">
    <div class="ds-stat-item">
      <div class="ds-stat-val">{{ number_format($doctor->consultation_fee, 0) }} <span>EGP</span></div>
      <div class="ds-stat-key">Consultation Fee</div>
    </div>
    <div class="ds-stat-item">
      <div class="ds-stat-val">{{ $doctor->years_of_experience }}<span>+</span></div>
      <div class="ds-stat-key">Years Experience</div>
    </div>
    <div class="ds-stat-item">
      <div class="ds-stat-val">{{ $doctor->schedules->count() ?? 0 }}<span>/7</span></div>
      <div class="ds-stat-key">Available Days</div>
    </div>
    <div class="ds-stat-item">
      <div class="ds-stat-val">4.8 <span style="font-size:1rem;">★</span></div>
      <div class="ds-stat-key">Rating</div>
    </div>
    <div class="ds-stat-item">
      <div class="ds-stat-val">100<span>%</span></div>
      <div class="ds-stat-key">Certified</div>
    </div>
  </div>
</div>

{{-- ══ MAIN CONTENT ══ --}}
<section class="ds-main">
  <div class="ds-main-inner">

    {{-- LEFT COLUMN --}}
    <div>

      {{-- About --}}
      <div class="ds-card" style="animation-delay:.05s">
        <div class="ds-card-title">
          <i class="fa-solid fa-circle-info"></i>
          About Dr. {{ $doctor->user->name }}
        </div>
        <p class="ds-about-text">
          {{ $doctor->bio ?? 'Dr. ' . $doctor->user->name . ' is a certified specialist in ' . ($doctor->major->title ?? 'medicine') . ', dedicated to delivering high-quality, patient-centered care. With extensive clinical experience and a commitment to continuous learning, they provide expert consultations tailored to each patient\'s individual needs.' }}
        </p>
      </div>

      {{-- Contact Info --}}
      <div class="ds-card" style="animation-delay:.1s">
        <div class="ds-card-title">
          <i class="fa-solid fa-address-card"></i>
          Contact Information
        </div>
        <div class="ds-info-list">
          <div class="ds-info-row">
            <div class="ds-info-icon"><i class="fa-solid fa-user"></i></div>
            <div>
              <div class="ds-info-label">Full Name</div>
              <div class="ds-info-val">Dr. {{ $doctor->user->name }}</div>
            </div>
          </div>
          <div class="ds-info-row">
            <div class="ds-info-icon"><i class="fa-solid fa-envelope"></i></div>
            <div>
              <div class="ds-info-label">Email</div>
              <div class="ds-info-val">{{ $doctor->user->email }}</div>
            </div>
          </div>
          @if($doctor->user->phone)
          <div class="ds-info-row">
            <div class="ds-info-icon"><i class="fa-solid fa-phone"></i></div>
            <div>
              <div class="ds-info-label">Phone</div>
              <div class="ds-info-val">{{ $doctor->user->phone }}</div>
            </div>
          </div>
          @endif
          @if($doctor->major)
          <div class="ds-info-row">
            <div class="ds-info-icon"><i class="fa-solid fa-stethoscope"></i></div>
            <div>
              <div class="ds-info-label">Specialty</div>
              <div class="ds-info-val">{{ $doctor->major->title }}</div>
            </div>
          </div>
          @endif
          <div class="ds-info-row">
            <div class="ds-info-icon"><i class="fa-solid fa-briefcase-medical"></i></div>
            <div style="flex:1;">
              <div class="ds-info-label">Experience</div>
              <div class="ds-info-val ds-exp-val">
                <span>{{ $doctor->years_of_experience }} years of practice</span>
                <span class="ds-exp-dots">
                  @for($i = 1; $i <= 10; $i++)
                    <span class="ds-exp-dot {{ $i <= min($doctor->years_of_experience, 10) ? 'active' : '' }}"></span>
                  @endfor
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Weekly Schedule --}}
      <div class="ds-card" style="animation-delay:.15s">
        <div class="ds-card-title">
          <i class="fa-solid fa-calendar-days"></i>
          Weekly Schedule
        </div>
        <div class="ds-schedule-grid">
          @php
            $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            $scheduleByDay = $doctor->schedules->keyBy('day_of_week');
          @endphp
          @foreach($days as $day)
            @php
              $slot     = $scheduleByDay->get($day);
              $fromTime = $slot ? \Carbon\Carbon::parse($slot->start_time)->format('g:i A') : null;
              $toTime   = $slot ? \Carbon\Carbon::parse($slot->end_time)->format('g:i A')   : null;
            @endphp
            <div class="ds-day-row">
              <div class="ds-day-dot"></div>
              <div class="ds-day-name">{{ $day }}</div>

              @if($daySlot = $doctor->schedules->firstWhere('day_of_week', $day))
                <div class="ds-day-time">
                  <span class="ds-time-from">
                    <i class="fa-regular fa-clock"></i> {{ $fromTime }}
                  </span>
                  <span class="ds-time-arrow">→</span>
                  <span class="ds-time-to">{{ $toTime }}</span>
                </div>
              @else
                <div class="ds-day-time"></div>
                <div class="ds-day-off">Day Off</div>
              @endif
            </div>
          @endforeach
        </div>
      </div>

    </div>

    {{-- RIGHT COLUMN ── BOOKING CARD ── --}}
    <div id="book">

      <div class="ds-book-card" style="animation: dsFadeUp .5s .2s both ease-out; position: sticky; top: 100px;">
        <div class="ds-book-card-title">Book an Appointment</div>
        <div class="ds-book-card-sub">Choose a convenient time and confirm your session</div>

        <div class="ds-price-display">
          <div class="ds-price-big">{{ number_format($doctor->consultation_fee, 0) }}</div>
          <div class="ds-price-curr">EGP</div>
          <div class="ds-price-per">/ session</div>
        </div>

        <div class="ds-book-features">
          <div class="ds-book-feat">
            <i class="fa-solid fa-circle-check"></i>
            <span>Certified specialist</span>
          </div>
          <div class="ds-book-feat">
            <i class="fa-solid fa-briefcase-medical"></i>
            <span>{{ $doctor->years_of_experience }}+ years of experience</span>
          </div>
          <div class="ds-book-feat">
            <i class="fa-solid fa-lock"></i>
            <span>Secure & private consultation</span>
          </div>
          <div class="ds-book-feat">
            <i class="fa-regular fa-clock"></i>
            <span>30–60 minute session</span>
          </div>
          <div class="ds-book-feat">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Flexible scheduling</span>
          </div>
        </div>

        <div class="ds-hr-light"></div>

        {{-- Available days quick-select --}}
        @if($doctor->schedules->where('is_available', true)->count() > 0)
        <div style="margin-bottom:20px;">
          <div style="font-size:0.75rem;font-weight:600;color:rgba(255,255,255,0.4);letter-spacing:.08em;text-transform:uppercase;margin-bottom:12px;">
            Available Days
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @foreach($doctor->schedules->where('is_available', true) as $slot)
              <div style="
                padding:7px 14px;border-radius:9999px;
                background:rgba(0,106,255,0.15);
                border:1px solid rgba(0,106,255,0.3);
                color:rgba(255,255,255,0.8);
                font-size:0.78rem;font-weight:600;
              ">
                {{ $slot->day_of_week }}
              </div>
            @endforeach
          </div>
        </div>
        @endif

        <a href="{{ route('front.booking.create', $doctor->id) }}" class="ds-big-book-btn">
          <i class="fa-regular fa-calendar-check"></i>
          Confirm Booking
        </a>

        <div style="text-align:center;margin-top:14px;font-size:0.76rem;color:rgba(255,255,255,0.28);">
          Free cancellation up to 24 hours before
        </div>
      </div>

    </div>

  </div>
</section>

@endsection