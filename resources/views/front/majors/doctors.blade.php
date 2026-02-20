@extends('front.inc.master')
@section('title', $major->title . ' — Specialists')

@section('content')

<style>
/* ============================================================
   MAJOR SHOW PAGE — prefix ms- to avoid conflicts
   Inherits dp- card styles, extends with specialty header
   ============================================================ */
@keyframes msCardIn {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes msSpin   { to { transform: rotate(360deg); } }
@keyframes msPulse  {
  0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.45); }
  50%     { box-shadow: 0 0 0 6px rgba(16,185,129,0); }
}

/* ── HERO ── */
.ms-hero {
  background: #05143a;
  padding: 90px 0 70px;
  position: relative;
  overflow: hidden;
}
.ms-blob1 {
  position: absolute; top: -120px; right: -120px;
  width: 500px; height: 500px; border-radius: 50%;
  background: radial-gradient(circle, rgba(0,106,255,0.18) 0%, transparent 70%);
  pointer-events: none;
}
.ms-blob2 {
  position: absolute; bottom: -80px; left: -80px;
  width: 380px; height: 380px; border-radius: 50%;
  background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
  pointer-events: none;
}
.ms-grid-bg {
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 60px 60px; pointer-events: none;
}
.ms-hero-inner {
  position: relative; z-index: 2;
  max-width: 1200px; margin: 0 auto; padding: 0 24px;
  display: grid; grid-template-columns: 1fr auto; gap: 40px; align-items: center;
}

/* Breadcrumb */
.ms-bc {
  display: inline-flex; align-items: center; gap: 10px;
  font-size: 0.78rem; color: rgba(255,255,255,0.36);
  margin-bottom: 20px;
}
.ms-bc a { color: rgba(255,255,255,0.50); text-decoration: none; transition: .3s; }
.ms-bc a:hover { color: #fff; }
.ms-bc i { font-size: 0.5em; color: rgba(255,255,255,0.2); }
.ms-bc span { color: #c9a84c; font-weight: 600; }

/* Eyebrow */
.ms-eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: 0.7rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase;
  color: rgba(255,255,255,0.55);
  border: 1px solid rgba(255,255,255,0.14); border-radius: 9999px;
  padding: 6px 18px; margin-bottom: 18px;
  background: rgba(255,255,255,0.05);
}
.ms-eyebrow i { color: #c9a84c; }

.ms-h1 {
  font-family: 'Fraunces', serif;
  font-size: 2.8rem; font-weight: 700; color: #fff;
  line-height: 1.1; letter-spacing: -1px; margin-bottom: 14px;
}
.ms-h1 em { font-style: italic; color: rgba(255,255,255,0.4); }
.ms-desc {
  color: rgba(255,255,255,0.50); font-size: 0.95rem;
  line-height: 1.75; font-weight: 300; max-width: 560px;
}

/* Hero Image Box */
.ms-hero-img-box {
  position: relative; width: 220px; height: 220px; flex-shrink: 0;
}
.ms-hero-img-box img {
  width: 100%; height: 100%; object-fit: cover;
  border-radius: 24px;
  border: 2px solid rgba(255,255,255,0.1);
  box-shadow: 0 20px 60px rgba(0,0,0,0.4);
}
.ms-hero-img-box::before {
  content: '';
  position: absolute; inset: -6px;
  border-radius: 28px;
  background: linear-gradient(135deg, rgba(0,106,255,0.4), rgba(201,168,76,0.3));
  z-index: -1;
}

/* Stats Bar */
.ms-stats {
  display: flex; align-items: center; gap: 28px;
  margin-top: 36px; padding-top: 28px;
  border-top: 1px solid rgba(255,255,255,0.08);
  flex-wrap: wrap;
}
.ms-stat-num {
  font-family: 'Fraunces', serif;
  font-size: 1.8rem; font-weight: 700; color: #fff; line-height: 1; margin-bottom: 4px;
}
.ms-stat-num span { color: #c9a84c; }
.ms-stat-lbl { font-size: 0.66rem; color: rgba(255,255,255,0.30); letter-spacing: 0.12em; text-transform: uppercase; }
.ms-stat-div { width: 1px; height: 32px; background: rgba(255,255,255,0.09); }

/* ── FILTER BAR ── */
.ms-bar {
  background: #fff; border-bottom: 1px solid #e8ecf4;
  position: sticky; top: 72px; z-index: 200;
}
.ms-bar-in {
  max-width: 1200px; margin: 0 auto; padding: 0 24px;
  display: flex; align-items: center; gap: 14px;
  min-height: 60px; flex-wrap: wrap;
}
.ms-srch { position: relative; flex: 0 0 280px; }
.ms-srch i {
  position: absolute; left: 14px; top: 50%;
  transform: translateY(-50%); color: #9aa4b8; font-size: 12px; pointer-events: none;
}
.ms-srch input {
  width: 100%; height: 40px; padding: 0 14px 0 38px;
  border: 1.5px solid #e8ecf4; border-radius: 9999px;
  font-family: 'DM Sans', sans-serif; font-size: 0.86rem; color: #05143a;
  background: #f5f7fc; outline: none; transition: .3s;
}
.ms-srch input:focus { border-color: #006aff; background: #fff; box-shadow: 0 0 0 4px rgba(0,106,255,0.09); }
.ms-srch input::placeholder { color: #b0b9cc; }
.ms-srt { position: relative; flex: 0 0 160px; }
.ms-srt select {
  width: 100%; height: 40px; padding: 0 32px 0 12px;
  border: 1.5px solid #e8ecf4; border-radius: 12px;
  font-family: 'DM Sans', sans-serif; font-size: 0.8rem; font-weight: 600;
  color: #3d4a63; background: #fff; appearance: none; cursor: pointer; outline: none; transition: .3s;
}
.ms-srt select:focus { border-color: #006aff; box-shadow: 0 0 0 4px rgba(0,106,255,0.09); }
.ms-srt i { position: absolute; right: 11px; top: 50%; transform: translateY(-50%); color: #9aa4b8; font-size: 10px; pointer-events: none; }
.ms-cnt { font-size: 0.8rem; color: #9aa4b8; font-weight: 500; white-space: nowrap; margin-left: auto; }
.ms-cnt strong { color: #05143a; }

/* ── SECTION ── */
.ms-section { padding: 52px 0 100px; background: #f5f7fc; min-height: 50vh; }
.ms-wrap { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
.ms-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
  gap: 22px;
}

/* ── CARD (identical to dp-card) ── */
.ms-card {
  background: #fff; border-radius: 26px;
  padding: 30px 22px 24px;
  box-shadow: 0 2px 10px rgba(5,20,58,0.06), 0 6px 28px rgba(5,20,58,0.04);
  border: 1px solid #e8ecf4;
  transition: transform .4s cubic-bezier(.22,1,.36,1), box-shadow .4s, border-color .4s;
  position: relative; text-align: center;
  display: flex; flex-direction: column; align-items: center;
  overflow: hidden;
}
.ms-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, #006aff 0%, #c9a84c 100%);
  transform: scaleX(0); transform-origin: left;
  transition: transform .4s cubic-bezier(.22,1,.36,1);
}
.ms-card:hover { transform: translateY(-10px); box-shadow: 0 10px 40px rgba(0,106,255,0.16); border-color: transparent; }
.ms-card:hover::before { transform: scaleX(1); }

/* Avatar */
.ms-av { position: relative; width: 98px; height: 98px; margin: 0 auto 18px; }
.ms-av-ring {
  position: absolute; inset: -5px; border-radius: 50%;
  background: conic-gradient(#006aff 0%, #c9a84c 50%, #006aff 100%);
  opacity: 0; transition: opacity .4s;
  animation: msSpin 3s linear infinite; z-index: 0;
}
.ms-card:hover .ms-av-ring { opacity: 1; }
.ms-av img {
  width: 100%; height: 100%; object-fit: cover;
  border-radius: 50%; border: 3px solid #fff;
  position: relative; z-index: 1;
}
.ms-online {
  position: absolute; bottom: 4px; right: 4px; z-index: 2;
  width: 14px; height: 14px; border-radius: 50%;
  background: #10b981; border: 2px solid #fff;
  animation: msPulse 2s ease-in-out infinite;
}

/* Card Content */
.ms-name { font-family: 'Fraunces', serif; font-size: 1.18rem; font-weight: 600; color: #05143a; margin-bottom: 8px; line-height: 1.3; }
.ms-badge { display: inline-block; background: #eef3ff; color: #006aff; padding: 4px 14px; border-radius: 9999px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; margin-bottom: 14px; }
.ms-contact { width: 100%; margin-bottom: 14px; }
.ms-crow { display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 0.77rem; color: #8892aa; font-weight: 300; margin-bottom: 5px; }
.ms-crow i { color: #006aff; font-size: 0.7rem; }
.ms-price { font-family: 'Fraunces', serif; font-size: 1.3rem; font-weight: 700; color: #05143a; line-height: 1; margin-bottom: 10px; }
.ms-price small { font-family: 'DM Sans', sans-serif; font-size: 0.65rem; font-weight: 400; color: #9aa4b8; }
.ms-stars { display: flex; align-items: center; justify-content: center; gap: 3px; color: #c9a84c; font-size: 0.82rem; margin-bottom: 18px; }
.ms-hr { width: 100%; height: 1px; background: #e8ecf4; margin-bottom: 16px; }
.ms-btns { display: flex; gap: 9px; width: 100%; }
.ms-book, .ms-profile {
  flex: 1; display: inline-flex; align-items: center; justify-content: center;
  gap: 6px; padding: 10px 0; border-radius: 12px;
  font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: .3s;
}
.ms-book { background: #006aff; color: #fff !important; box-shadow: 0 4px 14px rgba(0,106,255,0.26); }
.ms-book:hover { background: #0052cc; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,106,255,0.36); }
.ms-profile { background: #f5f7fc; color: #3d4a63 !important; border: 1.5px solid #e8ecf4; }
.ms-profile:hover { background: #e8ecf4; color: #05143a !important; }

/* Empty */
.ms-empty { grid-column: 1/-1; text-align: center; padding: 80px 24px; }
.ms-empty-ico { width: 78px; height: 78px; border-radius: 20px; background: #eef3ff; color: #006aff; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 20px; }
.ms-empty h3 { font-family: 'Fraunces', serif; font-size: 1.4rem; color: #05143a; margin-bottom: 8px; }
.ms-empty p { color: #9aa4b8; font-weight: 300; font-size: 0.9rem; }

/* Back button */
.ms-back-btn {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
  color: rgba(255,255,255,0.8); padding: 8px 20px; border-radius: 9999px;
  font-size: 0.8rem; font-weight: 600; text-decoration: none;
  transition: .3s; margin-bottom: 22px; display: inline-flex;
}
.ms-back-btn:hover { background: rgba(255,255,255,0.18); color: #fff; }

/* Pagination */
.ms-pages { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 56px; }
.ms-pages .page-item a,
.ms-pages .page-item span {
  display: flex; align-items: center; justify-content: center;
  width: 42px; height: 42px; border-radius: 12px;
  font-size: 0.88rem; font-weight: 600; text-decoration: none;
  border: 1.5px solid #e8ecf4; color: #3d4a63; background: #fff;
  transition: .3s;
}
.ms-pages .page-item.active span,
.ms-pages .page-item a:hover { background: #006aff; border-color: #006aff; color: #fff; box-shadow: 0 4px 18px rgba(0,106,255,0.32); }
.ms-pages .page-item.disabled span { opacity: 0.35; cursor: not-allowed; }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
  .ms-hero-inner { grid-template-columns: 1fr; }
  .ms-hero-img-box { display: none; }
  .ms-h1 { font-size: 2.2rem; }
  .ms-bar-in { flex-wrap: wrap; padding: 10px 20px; gap: 10px; }
  .ms-srch { flex: 1 1 100%; }
  .ms-cnt { margin-left: 0; }
}
@media (max-width: 640px) {
  .ms-hero { padding: 60px 0 50px; }
  .ms-h1 { font-size: 1.8rem; }
  .ms-stat-div { display: none; }
  .ms-grid { grid-template-columns: 1fr; }
  .ms-btns { flex-direction: column; }
}
</style>

{{-- ══ HERO ══ --}}
<section class="ms-hero">
  <div class="ms-blob1"></div>
  <div class="ms-blob2"></div>
  <div class="ms-grid-bg"></div>

  <div class="ms-hero-inner">
    <div>
      {{-- Back Button --}}
      <a href="{{ route('front.majors') }}" class="ms-back-btn">
        <i class="fa-solid fa-arrow-left"></i> All Specialties
      </a>

      {{-- Breadcrumb --}}
      <div class="ms-bc">
        <a href="{{ route('front.home') }}"><i class="fa-solid fa-house"></i> Home</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('front.majors') }}">Specialties</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>{{ $major->title }}</span>
      </div>

      <div class="ms-eyebrow">
        <i class="fa-solid fa-stethoscope"></i>
        Medical Specialty
      </div>

      <h1 class="ms-h1">{{ $major->title }} <em>Specialists</em></h1>

      @if($major->description)
        <p class="ms-desc">{{ $major->description }}</p>
      @endif

      <div class="ms-stats">
        <div>
          <div class="ms-stat-num">{{ $doctors->count() }}<span>+</span></div>
          <div class="ms-stat-lbl">Specialists</div>
        </div>
        <div class="ms-stat-div"></div>
        <div>
          <div class="ms-stat-num">24<span>/7</span></div>
          <div class="ms-stat-lbl">Available</div>
        </div>
        <div class="ms-stat-div"></div>
        <div>
          <div class="ms-stat-num">100<span>%</span></div>
          <div class="ms-stat-lbl">Certified</div>
        </div>
      </div>
    </div>

    {{-- Specialty Image --}}
    <div class="ms-hero-img-box">
      <img
        src="{{ $major->image ? asset('images/majors/' . $major->image) : asset('images/majors/default.png') }}"
        alt="{{ $major->title }}"
        onerror="this.src='https://placehold.co/220x220/eef3ff/006aff?text={{ urlencode($major->title) }}'"
      />
    </div>
  </div>
</section>

{{-- ══ FILTER BAR ══ --}}
<div class="ms-bar">
  <div class="ms-bar-in">
    <div class="ms-srch">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="msSearch" placeholder="Search by doctor name…" autocomplete="off" />
    </div>

    <div class="ms-srt">
      <select id="msSort">
        <option value="default">Default</option>
        <option value="fee-asc">Fee: Low → High</option>
        <option value="fee-desc">Fee: High → Low</option>
        <option value="name-asc">Name: A → Z</option>
        <option value="name-desc">Name: Z → A</option>
      </select>
      <i class="fa-solid fa-chevron-down"></i>
    </div>

    <div class="ms-cnt">
      Showing <strong id="msCount">{{ $doctors->count() }}</strong>
      {{ Str::plural('specialist', $doctors->count()) }} in {{ $major->title }}
    </div>
  </div>
</div>

{{-- ══ DOCTORS GRID ══ --}}
<section class="ms-section">
  <div class="ms-wrap">
    <div class="ms-grid" id="msGrid">

      @forelse ($doctors as $doctor)
        <div
          class="ms-card"
          data-name="{{ strtolower($doctor->user->name) }}"
          data-fee="{{ $doctor->consultation_fee }}"
          style="animation: msCardIn .55s {{ $loop->index * 0.07 }}s both ease-out;"
        >
          <div class="ms-av">
            <div class="ms-av-ring"></div>
            <img
              src="{{ $doctor->image ? asset('images/doctors/' . $doctor->image) : asset('images/default-doctor.png') }}"
              alt="Dr. {{ $doctor->user->name }}"
              onerror="this.onerror=null;this.src='https://placehold.co/200x200/eef3ff/006aff?text=Dr'"
            />
            <div class="ms-online"></div>
          </div>

          <h3 class="ms-name">Dr. {{ $doctor->user->name }}</h3>
          <span class="ms-badge">{{ $major->title }}</span>

          <div class="ms-contact">
            <div class="ms-crow">
              <i class="fa-solid fa-envelope"></i>
              <span>{{ $doctor->user->email }}</span>
            </div>
            @if($doctor->user->phone)
              <div class="ms-crow">
                <i class="fa-solid fa-phone"></i>
                <span>{{ $doctor->user->phone }}</span>
              </div>
            @endif
          </div>

          <div class="ms-price">
            {{ number_format($doctor->consultation_fee, 0) }}
            <small>EGP / session</small>
          </div>

          <div class="ms-stars">
            @for ($i = 1; $i <= 5; $i++)
              <i class="fa{{ $i <= 4 ? '-solid' : '-regular' }} fa-star"></i>
            @endfor
          </div>

          <div class="ms-hr"></div>

          <div class="ms-btns">
            <a href="#" class="ms-book">
              <i class="fa-regular fa-calendar-check"></i> Book
            </a>
            <a href="{{ route('front.doctor.show', $doctor->id) }}" class="ms-profile">
              <i class="fa-regular fa-user"></i> Profile
            </a>
          </div>
        </div>

      @empty
        <div class="ms-empty">
          <div class="ms-empty-ico"><i class="fa-solid fa-user-doctor"></i></div>
          <h3>No Specialists Yet</h3>
          <p>No doctors are currently listed under <strong>{{ $major->title }}</strong>.</p>
        </div>
      @endforelse

      <div id="msNoRes" style="display:none;" class="ms-empty">
        <div class="ms-empty-ico"><i class="fa-solid fa-magnifying-glass"></i></div>
        <h3>No results found</h3>
        <p>Try a different name or clear the search</p>
      </div>

    </div>

    @if(method_exists($doctors, 'links') && $doctors->hasPages())
      <div class="ms-pages">{{ $doctors->links('pagination::bootstrap-5') }}</div>
    @endif

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var S = document.getElementById('msSearch');
  var R = document.getElementById('msSort');
  var C = document.getElementById('msCount');
  var N = document.getElementById('msNoRes');
  var G = document.getElementById('msGrid');
  if (!S || !G) return;

  function cards() { return Array.from(G.querySelectorAll('.ms-card')); }

  function run() {
    var q   = S.value.trim().toLowerCase();
    var val = R.value;
    var all = cards();

    all.forEach(function(c) {
      var name = (c.getAttribute('data-name') || '').toLowerCase();
      c.style.display = name.indexOf(q) !== -1 ? '' : 'none';
    });

    var vis = all.filter(function(c){ return c.style.display !== 'none'; });

    if (val !== 'default') {
      vis.sort(function(a, b) {
        var fa = parseFloat(a.getAttribute('data-fee')) || 0;
        var fb = parseFloat(b.getAttribute('data-fee')) || 0;
        var na = a.getAttribute('data-name') || '';
        var nb = b.getAttribute('data-name') || '';
        if (val === 'fee-asc')   return fa - fb;
        if (val === 'fee-desc')  return fb - fa;
        if (val === 'name-asc')  return na.localeCompare(nb);
        if (val === 'name-desc') return nb.localeCompare(na);
        return 0;
      });
      vis.forEach(function(c){ G.appendChild(c); });
    }

    if (C) C.textContent = vis.length;
    if (N) N.style.display = vis.length === 0 ? 'block' : 'none';
  }

  S.addEventListener('input', run);
  R.addEventListener('change', run);
  run();
});
</script>

@endsection