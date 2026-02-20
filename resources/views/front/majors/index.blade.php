@extends('front.inc.master')
@section('title', 'All Specialties')

@section('content')

<style>
/* ========================================================
   SPECIALTIES PAGE — prefix: sp- to avoid any conflicts
   All values hardcoded — zero var() dependencies
   ======================================================== */

@keyframes spCardIn {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes spPulse {
  0%,100% { box-shadow: 0 0 0 0 rgba(0,106,255,0.3); }
  50%      { box-shadow: 0 0 0 8px rgba(0,106,255,0); }
}

/* ── HERO ── */
.sp-hero {
  background: #05143a;
  padding: 100px 0 80px;
  position: relative;
  overflow: hidden;
  text-align: center;
}
.sp-blob1 {
  position: absolute; top: -120px; right: -120px;
  width: 500px; height: 500px; border-radius: 50%;
  background: radial-gradient(circle, rgba(0,106,255,0.16) 0%, transparent 70%);
  pointer-events: none;
}
.sp-blob2 {
  position: absolute; bottom: -80px; left: -80px;
  width: 380px; height: 380px; border-radius: 50%;
  background: radial-gradient(circle, rgba(201,168,76,0.10) 0%, transparent 70%);
  pointer-events: none;
}
.sp-grid-bg {
  position: absolute; inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
  background-size: 60px 60px; pointer-events: none;
}
.sp-hero-inner {
  position: relative; z-index: 2;
  max-width: 720px; margin: 0 auto; padding: 0 24px;
}
.sp-eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: 0.7rem; font-weight: 700;
  letter-spacing: 0.18em; text-transform: uppercase;
  color: rgba(255,255,255,0.58);
  border: 1px solid rgba(255,255,255,0.14);
  border-radius: 9999px; padding: 7px 20px; margin-bottom: 28px;
  background: rgba(255,255,255,0.05);
}
.sp-eyebrow i { color: #c9a84c; }
.sp-h1 {
  font-family: 'Fraunces', serif;
  font-size: 3.2rem; font-weight: 700; color: #ffffff;
  line-height: 1.1; letter-spacing: -1px; margin-bottom: 18px;
}
.sp-h1 em { font-style: italic; color: rgba(255,255,255,0.46); }
.sp-hdesc {
  color: rgba(255,255,255,0.50); font-size: 1rem;
  line-height: 1.75; font-weight: 300;
  max-width: 540px; margin: 0 auto 36px;
}
.sp-bc {
  display: inline-flex; align-items: center; gap: 10px;
  font-size: 0.82rem; color: rgba(255,255,255,0.36);
}
.sp-bc a { color: rgba(255,255,255,0.50); text-decoration: none; transition: .3s; }
.sp-bc a:hover { color: #ffffff; }
.sp-bc i { font-size: 0.5em; color: rgba(255,255,255,0.2); }
.sp-bc span { color: #c9a84c; font-weight: 600; }
.sp-stats {
  display: flex; align-items: center; justify-content: center;
  gap: 32px; margin-top: 48px; padding-top: 32px;
  border-top: 1px solid rgba(255,255,255,0.08); flex-wrap: wrap;
}
.sp-stat-num {
  font-family: 'Fraunces', serif;
  font-size: 2rem; font-weight: 700; color: #fff; line-height: 1; margin-bottom: 4px;
}
.sp-stat-num span { color: #c9a84c; }
.sp-stat-lbl { font-size: 0.68rem; color: rgba(255,255,255,0.30); letter-spacing: 0.12em; text-transform: uppercase; }
.sp-stat-div { width: 1px; height: 36px; background: rgba(255,255,255,0.09); }

/* ── FILTER BAR ── */
.sp-bar {
  background: #ffffff; border-bottom: 1px solid #e8ecf4;
  position: sticky; top: 72px; z-index: 200;
}
.sp-bar-in {
  max-width: 1320px; margin: 0 auto; padding: 0 24px;
  display: flex; align-items: center; gap: 14px;
  min-height: 66px; flex-wrap: wrap;
}
.sp-srch { position: relative; flex: 0 0 300px; }
.sp-srch i {
  position: absolute; left: 15px; top: 50%;
  transform: translateY(-50%); color: #9aa4b8; font-size: 13px; pointer-events: none;
}
.sp-srch input {
  width: 100%; height: 42px; padding: 0 14px 0 42px;
  border: 1.5px solid #e8ecf4; border-radius: 9999px;
  font-family: 'DM Sans', sans-serif; font-size: 0.88rem; color: #05143a;
  background: #f5f7fc; outline: none; transition: .3s;
}
.sp-srch input:focus { border-color: #006aff; background: #fff; box-shadow: 0 0 0 4px rgba(0,106,255,0.09); }
.sp-srch input::placeholder { color: #b0b9cc; }
.sp-cnt { font-size: 0.82rem; color: #9aa4b8; font-weight: 500; white-space: nowrap; margin-left: auto; }
.sp-cnt strong { color: #05143a; }

/* ── SECTION ── */
.sp-section { padding: 52px 0 100px; background: #f5f7fc; min-height: 60vh; }
.sp-wrap { max-width: 1320px; margin: 0 auto; padding: 0 24px; }
.sp-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 24px;
}

/* ── CARD ── */
.sp-card {
  background: #ffffff;
  border-radius: 26px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(5,20,58,0.06), 0 6px 28px rgba(5,20,58,0.04);
  border: 1px solid #e8ecf4;
  transition: transform .4s cubic-bezier(.22,1,.36,1),
              box-shadow .4s cubic-bezier(.22,1,.36,1),
              border-color .4s;
  position: relative;
  display: flex; flex-direction: column;
  cursor: pointer;
}
/* left accent line */
.sp-card::before {
  content: '';
  position: absolute; top: 0; left: 0; bottom: 0; width: 3px;
  background: linear-gradient(180deg, #006aff 0%, #c9a84c 100%);
  opacity: 0; transition: opacity .4s; z-index: 2;
}
.sp-card:hover { transform: translateY(-8px); box-shadow: 0 10px 40px rgba(0,106,255,0.16); border-color: transparent; }
.sp-card:hover::before { opacity: 1; }

/* image */
.sp-img-box {
  position: relative; height: 200px; overflow: hidden;
  background: #e8f0ff; flex-shrink: 0;
}
.sp-img-box img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .7s cubic-bezier(.22,1,.36,1); display: block;
}
.sp-card:hover .sp-img-box img { transform: scale(1.06); }
.sp-img-box::after {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(180deg, transparent 50%, rgba(5,20,58,0.12) 100%);
  pointer-events: none;
}

/* doctor count badge on image */
.sp-doc-badge {
  position: absolute; top: 14px; right: 14px; z-index: 3;
  background: rgba(255,255,255,0.94); color: #006aff;
  padding: 5px 14px; border-radius: 9999px;
  font-size: 11px; font-weight: 700; letter-spacing: 0.04em;
  border: 1px solid rgba(0,106,255,0.18);
  display: flex; align-items: center; gap: 5px;
}
.sp-doc-badge i { font-size: 10px; }

/* body */
.sp-body { padding: 22px 22px 20px; flex: 1; display: flex; flex-direction: column; }
.sp-title {
  font-family: 'Fraunces', serif;
  font-size: 1.2rem; font-weight: 600; color: #05143a;
  margin-bottom: 10px; line-height: 1.3;
}
.sp-desc {
  font-size: 0.85rem; color: #8892aa; line-height: 1.7;
  font-weight: 300; flex: 1; margin-bottom: 18px;
}

/* meta row */
.sp-meta {
  display: flex; align-items: center; gap: 8px; margin-bottom: 18px; flex-wrap: wrap;
}
.sp-meta-item {
  display: flex; align-items: center; gap: 5px;
  font-size: 0.77rem; color: #8892aa; font-weight: 500;
}
.sp-meta-item i { color: #006aff; font-size: 0.72rem; }
.sp-meta-dot { width: 3px; height: 3px; border-radius: 50%; background: #d8dce8; }

/* footer */
.sp-footer {
  padding-top: 16px; border-top: 1px solid #e8ecf4;
}
.sp-btn {
  display: flex; align-items: center; justify-content: center; gap: 8px;
  width: 100%; padding: 11px 0;
  background: #006aff; color: #ffffff !important;
  border-radius: 14px; font-size: 0.82rem; font-weight: 700;
  text-decoration: none; transition: .3s; letter-spacing: 0.03em;
  box-shadow: 0 4px 14px rgba(0,106,255,0.25); border: none; cursor: pointer;
}
.sp-btn:hover { background: #0052cc; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,106,255,0.36); color: #fff !important; }
.sp-btn i { font-size: 0.8rem; transition: transform .3s; }
.sp-btn:hover i { transform: translateX(3px); }

/* ── EMPTY ── */
.sp-empty { grid-column: 1/-1; text-align: center; padding: 80px 24px; }
.sp-empty-ico {
  width: 78px; height: 78px; border-radius: 20px;
  background: #eef3ff; color: #006aff;
  display: flex; align-items: center; justify-content: center;
  font-size: 28px; margin: 0 auto 20px;
}
.sp-empty h3 { font-family: 'Fraunces', serif; font-size: 1.4rem; color: #05143a; margin-bottom: 8px; }
.sp-empty p { color: #9aa4b8; font-weight: 300; font-size: 0.9rem; }

/* ── PAGINATION ── */
.sp-pages { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 56px; }
.sp-pages .page-item a,
.sp-pages .page-item span {
  display: flex; align-items: center; justify-content: center;
  width: 42px; height: 42px; border-radius: 12px;
  font-size: 0.88rem; font-weight: 600; text-decoration: none;
  border: 1.5px solid #e8ecf4; color: #3d4a63; background: #fff;
  transition: .3s; font-family: 'DM Sans', sans-serif;
}
.sp-pages .page-item.active span,
.sp-pages .page-item a:hover {
  background: #006aff; border-color: #006aff;
  color: #fff; box-shadow: 0 4px 18px rgba(0,106,255,0.32);
}
.sp-pages .page-item.disabled span { opacity: 0.35; cursor: not-allowed; }

/* ── RESPONSIVE ── */
@media (max-width: 991px) {
  .sp-h1 { font-size: 2.4rem; }
  .sp-bar-in { padding: 12px 20px; gap: 10px; }
  .sp-srch { flex: 1 1 100%; }
  .sp-cnt { margin-left: 0; }
}
@media (max-width: 768px) {
  .sp-hero { padding: 70px 0 55px; }
  .sp-h1 { font-size: 2rem; }
  .sp-stat-div { display: none; }
  .sp-grid { grid-template-columns: 1fr; }
}
</style>

{{-- ══ HERO ══ --}}
<section class="sp-hero">
  <div class="sp-blob1"></div>
  <div class="sp-blob2"></div>
  <div class="sp-grid-bg"></div>
  <div class="sp-hero-inner">

    <div class="sp-eyebrow">
      <i class="fa-solid fa-circle-dot"></i>
      Medical Specialties
    </div>

    <h1 class="sp-h1">Our <em>Specialties</em></h1>

    <p class="sp-hdesc">
      Explore our wide range of medical specialties — each staffed with
      certified professionals dedicated to your health and wellbeing.
    </p>

    <div class="sp-bc">
      <a href="{{ route('front.home') }}"><i class="fa-solid fa-house"></i> Home</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Specialties</span>
    </div>

    <div class="sp-stats">
      <div>
        <div class="sp-stat-num">
          {{ method_exists($majors, 'total') ? $majors->total() : $majors->count() }}<span>+</span>
        </div>
        <div class="sp-stat-lbl">Specialties</div>
      </div>
      <div class="sp-stat-div"></div>
      <div>
        <div class="sp-stat-num">{{ $totalDoctors ?? $majors->sum(fn($m) => $m->doctors->count()) }}<span>+</span></div>
        <div class="sp-stat-lbl">Doctors</div>
      </div>
      <div class="sp-stat-div"></div>
      <div>
        <div class="sp-stat-num">24<span>/7</span></div>
        <div class="sp-stat-lbl">Available</div>
      </div>
    </div>

  </div>
</section>

{{-- ══ FILTER BAR ══ --}}
<div class="sp-bar">
  <div class="sp-bar-in">

    <div class="sp-srch">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="text" id="spSearch" placeholder="Search specialties…" autocomplete="off" />
    </div>

    <div class="sp-cnt">
      Showing <strong id="spCount">{{ $majors->count() }}</strong>
      of {{ method_exists($majors, 'total') ? $majors->total() : $majors->count() }} specialties
    </div>

  </div>
</div>

{{-- ══ GRID ══ --}}
<section class="sp-section">
  <div class="sp-wrap">
    <div class="sp-grid" id="spGrid">

      @forelse ($majors as $major)
        <div
          class="sp-card"
          data-name="{{ strtolower($major->title) }}"
          style="animation: spCardIn .55s {{ $loop->index * 0.07 }}s both ease-out;"
        >
          {{-- Image --}}
          <div class="sp-img-box">
            <img
              src="{{ $major->image ? asset('images/majors/' . $major->image) : asset('images/majors/default.png') }}"
              alt="{{ $major->title }}"
              loading="lazy"
              onerror="this.onerror=null;this.src='https://placehold.co/600x400/eef3ff/006aff?text={{ urlencode($major->title) }}'"
            />
            <span class="sp-doc-badge">
              <i class="fa-solid fa-user-doctor"></i>
              {{ $major->doctors->count() }} Doctor{{ $major->doctors->count() != 1 ? 's' : '' }}
            </span>
          </div>

          {{-- Body --}}
          <div class="sp-body">
            <h3 class="sp-title">{{ $major->title }}</h3>
            <p class="sp-desc">{{ \Illuminate\Support\Str::limit($major->description, 100) }}</p>

            <div class="sp-meta">
              <div class="sp-meta-item">
                <i class="fa-solid fa-user-doctor"></i>
                <span>{{ $major->doctors->count() }} Specialist{{ $major->doctors->count() != 1 ? 's' : '' }}</span>
              </div>
              <div class="sp-meta-dot"></div>
              <div class="sp-meta-item">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Certified</span>
              </div>
              <div class="sp-meta-dot"></div>
              <div class="sp-meta-item">
                <i class="fa-solid fa-circle-check" style="color:#10b981;"></i>
                <span style="color:#059669;">Available</span>
              </div>
            </div>

            <div class="sp-footer">
              <a href="{{ route('front.major.show', $major->id) }}" class="sp-btn">
                View Doctors <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="sp-empty">
          <div class="sp-empty-ico"><i class="fa-solid fa-stethoscope"></i></div>
          <h3>No Specialties Yet</h3>
          <p>Our specialties will be listed here soon.</p>
        </div>
      @endforelse

      <div id="spNoRes" style="display:none;" class="sp-empty">
        <div class="sp-empty-ico"><i class="fa-solid fa-magnifying-glass"></i></div>
        <h3>No results found</h3>
        <p>Try a different specialty name</p>
      </div>

    </div>

    @if(method_exists($majors, 'links') && $majors->hasPages())
      <div class="sp-pages">
        {{ $majors->links('pagination::bootstrap-5') }}
      </div>
    @endif

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var S = document.getElementById('spSearch');
  var C = document.getElementById('spCount');
  var N = document.getElementById('spNoRes');
  var G = document.getElementById('spGrid');
  if (!S || !G) return;

  function cards() { return Array.from(G.querySelectorAll('.sp-card')); }

  function run() {
    var q   = S.value.trim().toLowerCase();
    var all = cards();

    all.forEach(function(c) {
      var name = (c.getAttribute('data-name') || '').toLowerCase();
      c.style.display = name.indexOf(q) !== -1 ? '' : 'none';
    });

    var vis = all.filter(function(c) { return c.style.display !== 'none'; });
    if (C) C.textContent = vis.length;
    if (N) N.style.display = vis.length === 0 ? 'block' : 'none';
  }

  S.addEventListener('input', run);
  run();
});
</script>

@endsection