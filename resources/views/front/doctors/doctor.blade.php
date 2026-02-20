@extends('front.inc.master')
@section('title', 'All Doctors')

@section('content')

{{-- CSS injected inline to guarantee it loads before content --}}
<style>
/* ============================================================
   DOCTORS PAGE — prefix dp- to avoid any class conflicts
   All hex values hardcoded, zero var() dependencies
   ============================================================ */
@keyframes dpCardIn {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes dpSpin   { to { transform: rotate(360deg); } }
@keyframes dpPulse  {
  0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.45); }
  50%     { box-shadow: 0 0 0 6px rgba(16,185,129,0); }
}

/* HERO */
.dp-hero {
  background: #05143a;
  padding: 100px 0 80px;
  position: relative;
  overflow: hidden;
  text-align: center;
}
.dp-blob1 {
  position: absolute; top: -120px; right: -120px;
  width: 500px; height: 500px; border-radius: 50%;
  background: radial-gradient(circle, rgba(0,106,255,0.16) 0%, transparent 70%);
  pointer-events: none;
}
.dp-blob2 {
  position: absolute; bottom: -80px; left: -80px;
  width: 380px; height: 380px; border-radius: 50%;
  background: radial-gradient(circle, rgba(201,168,76,0.10) 0%, transparent 70%);
  pointer-events: none;
}
.dp-grid-bg {
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 60px 60px; pointer-events: none;
}
.dp-hero-inner {
  position: relative; z-index: 2;
  max-width: 720px; margin: 0 auto; padding: 0 24px;
}
.dp-eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: 0.7rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase;
  color: rgba(255,255,255,0.58);
  border: 1px solid rgba(255,255,255,0.14); border-radius: 9999px;
  padding: 7px 20px; margin-bottom: 28px;
  background: rgba(255,255,255,0.05);
}
.dp-eyebrow i { color: #c9a84c; }
.dp-h1 {
  font-family: 'Fraunces', serif;
  font-size: 3.2rem; font-weight: 700; color: #ffffff;
  line-height: 1.1; letter-spacing: -1px; margin-bottom: 18px;
}
.dp-h1 em { font-style: italic; color: rgba(255,255,255,0.46); }
.dp-hdesc {
  color: rgba(255,255,255,0.50); font-size: 1rem;
  line-height: 1.75; font-weight: 300;
  max-width: 540px; margin: 0 auto 36px;
}
.dp-bc {
  display: inline-flex; align-items: center; gap: 10px;
  font-size: 0.82rem; color: rgba(255,255,255,0.36);
}
.dp-bc a { color: rgba(255,255,255,0.50); text-decoration: none; transition: .3s; }
.dp-bc a:hover { color: #ffffff; }
.dp-bc i { font-size: 0.5em; color: rgba(255,255,255,0.2); }
.dp-bc span { color: #c9a84c; font-weight: 600; }
.dp-stats {
  display: flex; align-items: center; justify-content: center;
  gap: 32px; margin-top: 48px; padding-top: 32px;
  border-top: 1px solid rgba(255,255,255,0.08); flex-wrap: wrap;
}
.dp-stat-num {
  font-family: 'Fraunces', serif;
  font-size: 2rem; font-weight: 700; color: #fff; line-height: 1; margin-bottom: 4px;
}
.dp-stat-num span { color: #c9a84c; }
.dp-stat-lbl { font-size: 0.68rem; color: rgba(255,255,255,0.30); letter-spacing: 0.12em; text-transform: uppercase; }
.dp-stat-div { width: 1px; height: 36px; background: rgba(255,255,255,0.09); }

/* FILTER BAR */
.dp-bar {
  background: #ffffff; border-bottom: 1px solid #e8ecf4;
  position: sticky; top: 72px; z-index: 200;
}
.dp-bar-in {
  max-width: 1320px; margin: 0 auto; padding: 0 24px;
  display: flex; align-items: center; gap: 14px;
  min-height: 66px; flex-wrap: wrap;
}
.dp-srch { position: relative; flex: 0 0 300px; }
.dp-srch i {
  position: absolute; left: 15px; top: 50%;
  transform: translateY(-50%); color: #9aa4b8; font-size: 13px; pointer-events: none;
}
.dp-srch input {
  width: 100%; height: 42px; padding: 0 14px 0 42px;
  border: 1.5px solid #e8ecf4; border-radius: 9999px;
  font-family: 'DM Sans', sans-serif; font-size: 0.88rem; color: #05143a;
  background: #f5f7fc; outline: none; transition: .3s;
}
.dp-srch input:focus { border-color: #006aff; background: #fff; box-shadow: 0 0 0 4px rgba(0,106,255,0.09); }
.dp-srch input::placeholder { color: #b0b9cc; }
.dp-pills-wrap { display: flex; gap: 7px; align-items: center; overflow-x: auto; flex: 1; scrollbar-width: none; }
.dp-pills-wrap::-webkit-scrollbar { display: none; }
.dp-pill {
  display: inline-flex; align-items: center;
  padding: 6px 15px; border-radius: 9999px;
  font-size: 0.78rem; font-weight: 600; white-space: nowrap;
  border: 1.5px solid #e8ecf4; background: transparent; color: #3d4a63;
  cursor: pointer; transition: .3s; font-family: 'DM Sans', sans-serif;
}
.dp-pill:hover, .dp-pill.active { border-color: #006aff; background: #006aff; color: #fff; }
.dp-srt { position: relative; flex: 0 0 165px; }
.dp-srt select {
  width: 100%; height: 42px; padding: 0 34px 0 13px;
  border: 1.5px solid #e8ecf4; border-radius: 12px;
  font-family: 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 600;
  color: #3d4a63; background: #fff; appearance: none; cursor: pointer; outline: none; transition: .3s;
}
.dp-srt select:focus { border-color: #006aff; box-shadow: 0 0 0 4px rgba(0,106,255,0.09); }
.dp-srt i { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #9aa4b8; font-size: 10px; pointer-events: none; }
.dp-cnt { font-size: 0.82rem; color: #9aa4b8; font-weight: 500; white-space: nowrap; margin-left: auto; }
.dp-cnt strong { color: #05143a; }

/* GRID SECTION */
.dp-section { padding: 52px 0 100px; background: #f5f7fc; min-height: 60vh; }
.dp-wrap { max-width: 1320px; margin: 0 auto; padding: 0 24px; }
.dp-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(275px, 1fr));
  gap: 22px;
}

/* CARD */
.dp-card {
  background: #ffffff; border-radius: 26px;
  padding: 30px 22px 24px;
  box-shadow: 0 2px 10px rgba(5,20,58,0.06), 0 6px 28px rgba(5,20,58,0.04);
  border: 1px solid #e8ecf4;
  transition: transform .4s cubic-bezier(.22,1,.36,1), box-shadow .4s cubic-bezier(.22,1,.36,1), border-color .4s;
  position: relative; text-align: center;
  display: flex; flex-direction: column; align-items: center;
  overflow: hidden;
}
.dp-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, #006aff 0%, #c9a84c 100%);
  transform: scaleX(0); transform-origin: left;
  transition: transform .4s cubic-bezier(.22,1,.36,1);
}
.dp-card:hover { transform: translateY(-10px); box-shadow: 0 10px 40px rgba(0,106,255,0.16); border-color: transparent; }
.dp-card:hover::before { transform: scaleX(1); }

/* AVATAR */
.dp-av { position: relative; width: 98px; height: 98px; margin: 0 auto 18px; }
.dp-av-ring {
  position: absolute; inset: -5px; border-radius: 50%;
  background: conic-gradient(#006aff 0%, #c9a84c 50%, #006aff 100%);
  opacity: 0; transition: opacity .4s;
  animation: dpSpin 3s linear infinite; z-index: 0;
}
.dp-card:hover .dp-av-ring { opacity: 1; }
.dp-av img {
  width: 100%; height: 100%; object-fit: cover;
  border-radius: 50%; border: 3px solid #fff;
  position: relative; z-index: 1;
}
.dp-online {
  position: absolute; bottom: 4px; right: 4px; z-index: 2;
  width: 14px; height: 14px; border-radius: 50%;
  background: #10b981; border: 2px solid #fff;
  animation: dpPulse 2s ease-in-out infinite;
}

/* CARD CONTENT */
.dp-name { font-family: 'Fraunces', serif; font-size: 1.18rem; font-weight: 600; color: #05143a; margin-bottom: 8px; line-height: 1.3; }
.dp-badge { display: inline-block; background: #eef3ff; color: #006aff; padding: 4px 14px; border-radius: 9999px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; margin-bottom: 14px; }
.dp-contact { width: 100%; margin-bottom: 14px; }
.dp-crow { display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 0.77rem; color: #8892aa; font-weight: 300; margin-bottom: 5px; }
.dp-crow i { color: #006aff; font-size: 0.7rem; }
.dp-price { font-family: 'Fraunces', serif; font-size: 1.3rem; font-weight: 700; color: #05143a; line-height: 1; margin-bottom: 10px; }
.dp-price small { font-family: 'DM Sans', sans-serif; font-size: 0.65rem; font-weight: 400; color: #9aa4b8; }
.dp-stars { display: flex; align-items: center; justify-content: center; gap: 3px; color: #c9a84c; font-size: 0.82rem; margin-bottom: 18px; }
.dp-hr { width: 100%; height: 1px; background: #e8ecf4; margin-bottom: 16px; }
.dp-btns { display: flex; gap: 9px; width: 100%; }
.dp-book, .dp-profile {
  flex: 1; display: inline-flex; align-items: center; justify-content: center;
  gap: 6px; padding: 10px 0; border-radius: 12px;
  font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: .3s; letter-spacing: 0.02em;
}
.dp-book { background: #006aff; color: #fff !important; box-shadow: 0 4px 14px rgba(0,106,255,0.26); }
.dp-book:hover { background: #0052cc; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,106,255,0.36); }
.dp-profile { background: #f5f7fc; color: #3d4a63 !important; border: 1.5px solid #e8ecf4; }
.dp-profile:hover { background: #e8ecf4; color: #05143a !important; }

/* EMPTY */
.dp-empty { grid-column: 1/-1; text-align: center; padding: 80px 24px; }
.dp-empty-ico { width: 78px; height: 78px; border-radius: 20px; background: #eef3ff; color: #006aff; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 20px; }
.dp-empty h3 { font-family: 'Fraunces', serif; font-size: 1.4rem; color: #05143a; margin-bottom: 8px; }
.dp-empty p { color: #9aa4b8; font-weight: 300; font-size: 0.9rem; }

/* PAGINATION */
.dp-pages { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 56px; }
.dp-pages .page-item a,
.dp-pages .page-item span {
  display: flex; align-items: center; justify-content: center;
  width: 42px; height: 42px; border-radius: 12px;
  font-size: 0.88rem; font-weight: 600; text-decoration: none;
  border: 1.5px solid #e8ecf4; color: #3d4a63; background: #fff;
  transition: .3s; font-family: 'DM Sans', sans-serif;
}
.dp-pages .page-item.active span,
.dp-pages .page-item a:hover { background: #006aff; border-color: #006aff; color: #fff; box-shadow: 0 4px 18px rgba(0,106,255,0.32); }
.dp-pages .page-item.disabled span { opacity: 0.35; cursor: not-allowed; }

/* RESPONSIVE */
@media (max-width: 991px) {
  .dp-h1 { font-size: 2.4rem; }
  .dp-bar-in { padding: 12px 20px; gap: 10px; }
  .dp-srch { flex: 1 1 100%; }
  .dp-srt { flex: 0 0 145px; }
  .dp-cnt { margin-left: 0; }
}
@media (max-width: 768px) {
  .dp-hero { padding: 70px 0 55px; }
  .dp-h1 { font-size: 2rem; }
  .dp-stat-div { display: none; }
  .dp-grid { grid-template-columns: 1fr; }
  .dp-btns { flex-direction: column; }
}
</style>

{{-- ══ HERO ══ --}}
<section class="dp-hero">
  <div class="dp-blob1"></div>
  <div class="dp-blob2"></div>
  <div class="dp-grid-bg"></div>
  <div class="dp-hero-inner">

    <div class="dp-eyebrow">
      <i class="fa-solid fa-user-doctor"></i>
      Medical Specialists
    </div>

    <h1 class="dp-h1">Meet Our <em>Doctors</em></h1>

    <p class="dp-hdesc">
      Connect with our team of certified medical professionals —
      each specialist is dedicated to delivering expert, personalized care.
    </p>

    <div class="dp-bc">
      <a href="{{ route('front.home') }}"><i class="fa-solid fa-house"></i> Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Doctors</span>
    </div>

    <div class="dp-stats">
      <div>
        <div class="dp-stat-num">{{ method_exists($doctors,'total') ? $doctors->total() : $doctors->count() }}<span>+</span></div>
        <div class="dp-stat-lbl">Specialists</div>
      </div>
      <div class="dp-stat-div"></div>
      <div>
        <div class="dp-stat-num">{{ isset($specialties) ? $specialties->count() : 0 }}<span>+</span></div>
        <div class="dp-stat-lbl">Specialties</div>
      </div>
      <div class="dp-stat-div"></div>
      <div>
        <div class="dp-stat-num">24<span>/7</span></div>
        <div class="dp-stat-lbl">Available</div>
      </div>
    </div>

  </div>
</section>

{{-- ══ FILTER BAR ══ --}}
<div class="dp-bar">
  <div class="dp-bar-in">

    <div class="dp-srch">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="dpSearch" placeholder="Search by doctor name…" autocomplete="off" />
    </div>

    <div class="dp-pills-wrap" id="dpPills">
      <button class="dp-pill active" data-spec="all">All</button>
      @foreach($specialties ?? [] as $spec)
        <button class="dp-pill" data-spec="{{ $spec->id }}">{{ $spec->title }}</button>
      @endforeach
    </div>

    <div class="dp-srt">
      <select id="dpSort">
        <option value="default">Default</option>
        <option value="fee-asc">Fee: Low → High</option>
        <option value="fee-desc">Fee: High → Low</option>
        <option value="name-asc">Name: A → Z</option>
        <option value="name-desc">Name: Z → A</option>
      </select>
      <i class="fa-solid fa-chevron-down"></i>
    </div>

    <div class="dp-cnt">
      Showing <strong id="dpCount">{{ $doctors->count() }}</strong>
      of {{ method_exists($doctors,'total') ? $doctors->total() : $doctors->count() }} doctors
    </div>

  </div>
</div>

{{-- ══ GRID ══ --}}
<section class="dp-section">
  <div class="dp-wrap">
    <div class="dp-grid" id="dpGrid">

      @forelse ($doctors as $doctor)
        <div
          class="dp-card"
          data-name="{{ strtolower($doctor->user->name) }}"
          data-fee="{{ $doctor->consultation_fee }}"
          data-spec="{{ $doctor->major_id ?? '' }}"
          style="animation: dpCardIn .55s {{ $loop->index * 0.07 }}s both ease-out;"
        >
          {{-- Avatar --}}
          <div class="dp-av">
            <div class="dp-av-ring"></div>
            <img
              src="{{ $doctor->image ? asset('images/doctors/' . $doctor->image) : asset('images/default-doctor.png') }}"
              alt="Dr. {{ $doctor->user->name }}"
              onerror="this.onerror=null;this.src='https://placehold.co/200x200/eef3ff/006aff?text=Dr'"
            />
            <div class="dp-online"></div>
          </div>

          <h3 class="dp-name">Dr. {{ $doctor->user->name }}</h3>

          @if($doctor->major)
            <span class="dp-badge">{{ $doctor->major->title }}</span>
          @endif

          <div class="dp-contact">
            <div class="dp-crow">
              <i class="fa-solid fa-envelope"></i>
              <span>{{ $doctor->user->email }}</span>
            </div>
            @if($doctor->user->phone)
            <div class="dp-crow">
              <i class="fa-solid fa-phone"></i>
              <span>{{ $doctor->user->phone }}</span>
            </div>
            @endif
          </div>

          <div class="dp-price">
            {{ number_format($doctor->consultation_fee, 0) }}
            <small>EGP / session</small>
          </div>

          <div class="dp-stars">
            @for ($i = 1; $i <= 5; $i++)
              <i class="fa{{ $i <= 4 ? '-solid' : '-regular' }} fa-star"></i>
            @endfor
          </div>

          <div class="dp-hr"></div>

          <div class="dp-btns">
            <a href="#" class="dp-book">
              <i class="fa-regular fa-calendar-check"></i> Book
            </a>
            <a href="{{ route('front.doctor.show', $doctor->id) }}" class="dp-profile">
              <i class="fa-regular fa-user"></i> Profile
            </a>
          </div>

        </div>
      @empty
        <div class="dp-empty">
          <div class="dp-empty-ico"><i class="fa-solid fa-user-doctor"></i></div>
          <h3>No Doctors Yet</h3>
          <p>Our specialists will be listed here soon.</p>
        </div>
      @endforelse

      <div id="dpNoRes" style="display:none;" class="dp-empty">
        <div class="dp-empty-ico"><i class="fa-solid fa-magnifying-glass"></i></div>
        <h3>No results found</h3>
        <p>Try a different name or specialty</p>
      </div>

    </div>

    @if(method_exists($doctors,'links') && $doctors->hasPages())
      <div class="dp-pages">{{ $doctors->links('pagination::bootstrap-5') }}</div>
    @endif

  </div>
</section>

{{-- ══ JS ══ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  var S = document.getElementById('dpSearch');
  var R = document.getElementById('dpSort');
  var C = document.getElementById('dpCount');
  var N = document.getElementById('dpNoRes');
  var G = document.getElementById('dpGrid');
  var pills = document.querySelectorAll('.dp-pill');
  if (!S || !G) return;

  var activeSpec = 'all';

  function cards() { return Array.from(G.querySelectorAll('.dp-card')); }

  function run() {
    var q   = S.value.trim().toLowerCase();
    var val = R.value;
    var all = cards();

    all.forEach(function(c) {
      var name = (c.getAttribute('data-name') || '').toLowerCase();
      var spec = c.getAttribute('data-spec') || '';
      c.style.display = (name.indexOf(q) !== -1 && (activeSpec === 'all' || spec === activeSpec)) ? '' : 'none';
    });

    var vis = all.filter(function(c){ return c.style.display !== 'none'; });

    if (val !== 'default') {
      vis.sort(function(a,b){
        var fa = parseFloat(a.getAttribute('data-fee'))||0;
        var fb = parseFloat(b.getAttribute('data-fee'))||0;
        var na = a.getAttribute('data-name')||'';
        var nb = b.getAttribute('data-name')||'';
        if (val==='fee-asc')   return fa-fb;
        if (val==='fee-desc')  return fb-fa;
        if (val==='name-asc')  return na.localeCompare(nb);
        if (val==='name-desc') return nb.localeCompare(na);
        return 0;
      });
      vis.forEach(function(c){ G.appendChild(c); });
    }

    if (C) C.textContent = vis.length;
    if (N) N.style.display = vis.length === 0 ? 'block' : 'none';
  }

  pills.forEach(function(p){
    p.addEventListener('click', function(){
      pills.forEach(function(x){ x.classList.remove('active'); });
      p.classList.add('active');
      activeSpec = p.getAttribute('data-spec');
      run();
    });
  });

  S.addEventListener('input', run);
  R.addEventListener('change', run);
  run();
});
</script>

@endsection