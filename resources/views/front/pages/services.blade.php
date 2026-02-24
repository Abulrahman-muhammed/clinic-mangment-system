@extends('front.inc.master')
@section('title', 'All Services')

@push('style')
<style>

  /* ── PAGE HERO ── */
  .page-hero {
    background: #05143a;
    padding: 100px 0 80px;
    position: relative;
    overflow: hidden;
    text-align: center;
  }
  .page-hero::before {
    content: '';
    position: absolute;
    top: -120px; right: -120px;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0,106,255,0.18) 0%, transparent 70%);
    pointer-events: none;
  }
  .page-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -80px;
    width: 380px; height: 380px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
    pointer-events: none;
  }
  .page-hero-grid {
    position: absolute;
    inset: 0;
    background-image:
      linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 60px 60px;
    pointer-events: none;
  }
  .page-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 720px;
    margin: 0 auto;
    padding: 0 24px;
  }
  .page-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.6);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 9999px;
    padding: 7px 20px;
    margin-bottom: 28px;
    background: rgba(255,255,255,0.05);
  }
  .page-hero-eyebrow i { color: #c9a84c; }
  .page-hero h1 {
    font-family: 'Fraunces', serif;
    font-size: 3.2rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.1;
    letter-spacing: -1px;
    margin-bottom: 18px;
  }
  .page-hero h1 em { font-style: italic; color: rgba(255,255,255,0.5); }
  .hero-desc {
    color: rgba(255,255,255,0.52);
    font-size: 1rem;
    line-height: 1.75;
    font-weight: 300;
    max-width: 540px;
    margin: 0 auto 36px;
  }
  .page-breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 0.82rem;
    color: rgba(255,255,255,0.38);
  }
  .page-breadcrumb a { color: rgba(255,255,255,0.52); text-decoration: none; transition: 0.3s; }
  .page-breadcrumb a:hover { color: #fff; }
  .page-breadcrumb .bc-sep { font-size: 0.55em; color: rgba(255,255,255,0.2); }
  .page-breadcrumb span { color: #c9a84c; font-weight: 600; }
  .page-hero-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 32px;
    margin-top: 48px;
    padding-top: 32px;
    border-top: 1px solid rgba(255,255,255,0.08);
  }
  .hero-stat { text-align: center; }
  .hero-stat-num {
    font-family: 'Fraunces', serif;
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    line-height: 1;
    margin-bottom: 4px;
  }
  .hero-stat-num span { color: #c9a84c; }
  .hero-stat-label {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.32);
    letter-spacing: 0.1em;
    text-transform: uppercase;
  }
  .hero-stat-divider { width: 1px; height: 38px; background: rgba(255,255,255,0.1); }

  /* ── FILTER BAR ── */
  .svc-filter-bar {
    background: #fff;
    border-bottom: 1px solid #eef0f6;
    position: sticky;
    top: 72px;
    z-index: 100;
  }
  .svc-filter-inner {
    max-width: 1320px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    height: 68px;
  }
  .svc-search-wrap {
    position: relative;
    flex: 0 0 340px;
  }
  .svc-search-wrap i {
    position: absolute;
    left: 16px; top: 50%;
    transform: translateY(-50%);
    color: #8892aa;
    font-size: 14px;
    pointer-events: none;
  }
  .svc-search-wrap input {
    width: 100%;
    height: 44px;
    padding: 0 16px 0 44px;
    border: 1.5px solid #eef0f6;
    border-radius: 9999px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.9rem;
    color: #05143a;
    background: #f7f8fc;
    outline: none;
    transition: 0.3s;
  }
  .svc-search-wrap input:focus {
    border-color: #006aff;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(0,106,255,0.1);
  }
  .svc-search-wrap input::placeholder { color: #aab0be; }
  .svc-sort-wrap {
    position: relative;
    flex: 0 0 180px;
  }
  .svc-sort-wrap select {
    width: 100%;
    height: 44px;
    padding: 0 36px 0 14px;
    border: 1.5px solid #eef0f6;
    border-radius: 14px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.84rem;
    font-weight: 600;
    color: #3d4a63;
    background: #fff;
    appearance: none;
    cursor: pointer;
    outline: none;
    transition: 0.3s;
  }
  .svc-sort-wrap select:focus { border-color: #006aff; box-shadow: 0 0 0 4px rgba(0,106,255,0.1); }
  .svc-sort-wrap i {
    position: absolute;
    right: 13px; top: 50%;
    transform: translateY(-50%);
    color: #8892aa;
    font-size: 11px;
    pointer-events: none;
  }
  .svc-filter-count {
    font-size: 0.84rem;
    color: #8892aa;
    white-space: nowrap;
    font-weight: 500;
    margin-left: auto;
  }
  .svc-filter-count strong { color: #05143a; }

  /* ── SERVICES SECTION ── */
  .all-svc-section {
    padding: 56px 0 100px;
    background: #f7f8fc;
    min-height: 60vh;
  }
  .all-svc-wrapper {
    max-width: 1320px;
    margin: 0 auto;
    padding: 0 24px;
  }
  .all-svc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
  }

  /* ── SERVICE CARD ── */
  .svc-card {
    background: #fff;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(5,20,58,0.07), 0 8px 32px rgba(5,20,58,0.04);
    border: 1px solid #eef0f6;
    transition: transform 0.4s cubic-bezier(0.22,1,0.36,1),
                box-shadow 0.4s cubic-bezier(0.22,1,0.36,1),
                border-color 0.4s;
    position: relative;
    display: flex;
    flex-direction: column;
    opacity: 1;
    transform: none;
  }
  .svc-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, #006aff, #c9a84c);
    opacity: 0;
    transition: opacity 0.4s;
    z-index: 2;
  }
  .svc-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 40px rgba(0,106,255,0.18), 0 2px 10px rgba(5,20,58,0.05);
    border-color: transparent;
  }
  .svc-card:hover::before { opacity: 1; }

  .svc-img-box {
    position: relative;
    height: 210px;
    overflow: hidden;
    flex-shrink: 0;
    background: #e8f0ff;
  }
  .svc-img-box img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.7s cubic-bezier(0.22,1,0.36,1);
    display: block;
  }
  .svc-card:hover .svc-img-box img { transform: scale(1.06); }
  .svc-img-box::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 55%, rgba(5,20,58,0.1) 100%);
    pointer-events: none;
  }
  .svc-badge {
    position: absolute;
    top: 14px; right: 14px; z-index: 3;
    background: rgba(255,255,255,0.94);
    color: #006aff;
    padding: 5px 14px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.05em;
    border: 1px solid rgba(0,106,255,0.18);
  }

  .svc-body {
    padding: 22px 22px 18px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  .svc-name {
    font-family: 'Fraunces', serif;
    font-size: 1.2rem;
    font-weight: 600;
    color: #05143a;
    margin-bottom: 10px;
    line-height: 1.3;
  }
  .svc-desc {
    font-size: 0.86rem;
    color: #8892aa;
    line-height: 1.7;
    font-weight: 300;
    flex: 1;
    margin-bottom: 18px;
  }
  .svc-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
    flex-wrap: wrap;
  }
  .svc-meta-item {
    display: flex; align-items: center; gap: 5px;
    font-size: 0.78rem; color: #8892aa; font-weight: 500;
  }
  .svc-meta-item i { color: #006aff; font-size: 0.75rem; }
  .svc-meta-dot { width: 3px; height: 3px; border-radius: 50%; background: #d8dce8; }
  .svc-available {
    display: flex; align-items: center; gap: 6px;
    font-size: 0.75rem; font-weight: 600; color: #059669;
  }
  .svc-available-dot {
    width: 7px; height: 7px; border-radius: 50%; background: #10b981;
    animation: pulseDot 2s ease-in-out infinite;
  }
  @keyframes pulseDot {
    0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.4); }
    50%      { box-shadow: 0 0 0 5px rgba(16,185,129,0); }
  }

  /* footer — price only, no button */
  .svc-footer {
    display: flex;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid #eef0f6;
  }
  .svc-price {
    font-family: 'Fraunces', serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: #05143a;
    line-height: 1;
  }
  .svc-price-currency { font-size: 0.55em; font-weight: 400; color: #8892aa; }
  .svc-price-label { font-size: 0.7rem; color: #8892aa; font-weight: 400; margin-top: 3px; }

  /* ── EMPTY / NO RESULTS ── */
  .svc-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 24px;
  }
  .svc-empty-icon {
    width: 80px; height: 80px; border-radius: 22px;
    background: #f2f6ff;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px; font-size: 30px; color: #006aff;
  }
  .svc-empty h3 {
    font-family: 'Fraunces', serif;
    font-size: 1.4rem; color: #05143a; margin-bottom: 8px;
  }
  .svc-empty p { color: #8892aa; font-weight: 300; font-size: 0.92rem; }

  /* ── PAGINATION ── */
  .svc-pagination {
    display: flex; justify-content: center; align-items: center;
    gap: 8px; margin-top: 60px;
  }
  .svc-pagination .page-item a,
  .svc-pagination .page-item span {
    display: flex; align-items: center; justify-content: center;
    width: 42px; height: 42px; border-radius: 14px;
    font-size: 0.88rem; font-weight: 600;
    text-decoration: none;
    border: 1.5px solid #eef0f6;
    color: #3d4a63; background: #fff;
    transition: 0.3s; font-family: 'DM Sans', sans-serif;
  }
  .svc-pagination .page-item.active span,
  .svc-pagination .page-item a:hover {
    background: #006aff; border-color: #006aff;
    color: #fff; box-shadow: 0 4px 20px rgba(0,106,255,0.35);
  }
  .svc-pagination .page-item.disabled span { opacity: 0.35; cursor: not-allowed; }

  /* ── RESPONSIVE ── */
  @media (max-width: 991px) {
    .page-hero h1 { font-size: 2.4rem; }
    .svc-filter-inner { flex-wrap: wrap; height: auto; padding: 14px 24px; gap: 12px; }
    .svc-search-wrap { flex: 1 1 100%; }
    .svc-sort-wrap { flex: 0 0 160px; }
    .svc-filter-count { margin-left: 0; }
  }
  @media (max-width: 768px) {
    .page-hero { padding: 72px 0 56px; }
    .page-hero h1 { font-size: 2rem; }
    .page-hero-stats { flex-wrap: wrap; gap: 20px; }
    .hero-stat-divider { display: none; }
    .all-svc-grid { grid-template-columns: 1fr; }
  }
</style>
@endpush

@section('content')

  {{-- ── PAGE HERO ── --}}
  <section class="page-hero">
    <div class="page-hero-grid"></div>
    <div class="page-hero-inner">

      <div class="page-hero-eyebrow">
        <i class="fa-solid fa-circle-dot"></i>
        Healthcare Services
      </div>

      <h1>All Our <em>Services</em></h1>

      <p class="hero-desc">
        Explore our comprehensive range of medical services — from diagnostics to consultations —
        all designed around your wellbeing.
      </p>

      <div class="page-breadcrumb">
        <a href="{{ route('front.home') }}">
          <i class="fa-solid fa-house"></i> Home
        </a>
        <i class="fa-solid fa-chevron-right bc-sep"></i>
        <span>Services</span>
      </div>

      <div class="page-hero-stats">
        <div class="hero-stat">
          <div class="hero-stat-num">
            {{ method_exists($services, 'total') ? $services->total() : $services->count() }}<span>+</span>
          </div>
          <div class="hero-stat-label">Total Services</div>
        </div>
        <div class="hero-stat-divider"></div>
        <div class="hero-stat">
          <div class="hero-stat-num">24<span>/7</span></div>
          <div class="hero-stat-label">Availability</div>
        </div>
        <div class="hero-stat-divider"></div>
        <div class="hero-stat">
          <div class="hero-stat-num">100<span>%</span></div>
          <div class="hero-stat-label">Certified</div>
        </div>
      </div>

    </div>
  </section>

  {{-- ── FILTER BAR ── --}}
  <div class="svc-filter-bar">
    <div class="svc-filter-inner">

      <div class="svc-search-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input
          type="text"
          id="svcSearch"
          placeholder="Search by service name…"
          autocomplete="off"
        />
      </div>

      <div class="svc-sort-wrap">
        <select id="svcSort">
          <option value="default">Default Order</option>
          <option value="price-asc">Price: Low → High</option>
          <option value="price-desc">Price: High → Low</option>
          <option value="name-asc">Name: A → Z</option>
          <option value="name-desc">Name: Z → A</option>
        </select>
        <i class="fa-solid fa-chevron-down"></i>
      </div>

      <div class="svc-filter-count">
        Showing <strong id="svcCount">{{ $services->count() }}</strong>
        of {{ method_exists($services, 'total') ? $services->total() : $services->count() }} services
      </div>

    </div>
  </div>

  {{-- ── GRID ── --}}
  <section class="all-svc-section">
    <div class="all-svc-wrapper">
      <div class="all-svc-grid" id="svcGrid">

        @forelse ($services as $service)
          <div
            class="svc-card"
            data-name="{{ strtolower($service->name) }}"
            data-price="{{ $service->price }}"
            style="animation: cardIn 0.55s {{ $loop->index * 0.08 }}s both ease-out;"
          >
            <div class="svc-img-box">
              <img
                src="{{ $service->image ? asset('storage/services/' . $service->image) : asset('images/default-service.png') }}"
                alt="{{ $service->name }}"
                loading="lazy"
                onerror="this.onerror=null;this.src='https://placehold.co/600x400/e8f0ff/006aff?text={{ urlencode($service->name) }}'"
              />
              <span class="svc-badge">Available</span>
            </div>

            <div class="svc-body">
              <h3 class="svc-name">{{ $service->name }}</h3>
              <p class="svc-desc">{{ \Illuminate\Support\Str::limit($service->description, 110) }}</p>

              <div class="svc-meta">
                <div class="svc-meta-item">
                  <i class="fa-solid fa-clock"></i>
                  <span>30–60 min</span>
                </div>
                <div class="svc-meta-dot"></div>
                <div class="svc-meta-item">
                  <i class="fa-solid fa-shield-halved"></i>
                  <span>Certified</span>
                </div>
                <div class="svc-meta-dot"></div>
                <div class="svc-available">
                  <div class="svc-available-dot"></div>
                </div>
              </div>

              {{-- Price only — no Book button --}}
              <div class="svc-footer">
                <div>
                  <div class="svc-price">
                    {{ number_format($service->price, 0) }}
                    <small class="svc-price-currency">EGP</small>
                  </div>
                  <div class="svc-price-label">per session</div>
                </div>
              </div>

            </div>
          </div>
        @empty
          <div class="svc-empty">
            <div class="svc-empty-icon"><i class="fa-solid fa-stethoscope"></i></div>
            <h3>No Services Yet</h3>
            <p>We're adding new services soon. Check back shortly.</p>
          </div>
        @endforelse

        <div id="svcNoResults" style="display:none;" class="svc-empty">
          <div class="svc-empty-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
          <h3>No results found</h3>
          <p>Try a different service name</p>
        </div>

      </div>

      @if(method_exists($services, 'links') && $services->hasPages())
        <div class="svc-pagination">
          {{ $services->links('pagination::bootstrap-5') }}
        </div>
      @endif

    </div>
  </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  const styleTag = document.createElement('style');
  styleTag.textContent = '@keyframes cardIn { from { opacity:0; transform:translateY(22px); } to { opacity:1; transform:translateY(0); } }';
  document.head.appendChild(styleTag);

  const header = document.querySelector('.main-header');
  if (header) {
    window.addEventListener('scroll', function () {
      header.classList.toggle('scrolled', window.scrollY > 10);
    }, { passive: true });
  }

  var searchInput = document.getElementById('svcSearch');
  var sortSelect  = document.getElementById('svcSort');
  var countEl     = document.getElementById('svcCount');
  var noResults   = document.getElementById('svcNoResults');
  var grid        = document.getElementById('svcGrid');

  if (!searchInput || !sortSelect || !grid) return;

  function getCards() {
    return Array.from(grid.querySelectorAll('.svc-card'));
  }

  function run() {
    var q   = searchInput.value.trim().toLowerCase();
    var val = sortSelect.value;
    var all = getCards();

    all.forEach(function (card) {
      var name = (card.getAttribute('data-name') || '').toLowerCase();
      card.style.display = name.indexOf(q) !== -1 ? '' : 'none';
    });

    var visible = all.filter(function (c) { return c.style.display !== 'none'; });

    if (val !== 'default') {
      visible.sort(function (a, b) {
        var pa = parseFloat(a.getAttribute('data-price')) || 0;
        var pb = parseFloat(b.getAttribute('data-price')) || 0;
        var na = a.getAttribute('data-name') || '';
        var nb = b.getAttribute('data-name') || '';
        if (val === 'price-asc')  return pa - pb;
        if (val === 'price-desc') return pb - pa;
        if (val === 'name-asc')   return na.localeCompare(nb);
        if (val === 'name-desc')  return nb.localeCompare(na);
        return 0;
      });
      visible.forEach(function (c) { grid.appendChild(c); });
    }

    if (countEl) countEl.textContent = visible.length;
    if (noResults) noResults.style.display = visible.length === 0 ? 'block' : 'none';
  }

  searchInput.addEventListener('input', run);
  sortSelect.addEventListener('change', run);
  run();

});
</script>
@endpush