@extends('front.inc.master')

@section('title', 'Book Appointment — Dr. ' . $doctor->name)

@section('content')

<section class="bk-section">
  <div class="bk-wrapper">

    @if ($errors->any())
      <div class="bk-alert bk-alert--error" data-aos="fade-down">
        <i class="fa-solid fa-circle-exclamation"></i>
        <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif
    @if (session('success'))
      <div class="bk-alert bk-alert--success" data-aos="fade-down">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="bk-alert bk-alert--error" data-aos="fade-down">
        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
      </div>
    @endif

    <div class="bk-layout">

      {{-- ══════════ SIDEBAR ══════════ --}}
      <aside class="bk-sidebar" data-aos="fade-right">

        <div class="bk-card">
          <div class="bk-doc-avatar-bg">
            @if($doctor->image)
              <img src="{{ asset('images/doctors/' . $doctor->image) }}" alt="Dr. {{ $doctor->name }}"/>
            @else
              <div class="bk-doc-initials">
                <svg width="96" height="96" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg">
                  <defs>
                    <linearGradient id="av-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" style="stop-color:rgba(255,255,255,0.25)"/>
                      <stop offset="100%" style="stop-color:rgba(255,255,255,0.05)"/>
                    </linearGradient>
                  </defs>
                  <circle cx="48" cy="48" r="48" fill="url(#av-grad)" stroke="rgba(255,255,255,0.35)" stroke-width="1.5"/>
                  <ellipse cx="48" cy="88" rx="26" ry="16" fill="rgba(255,255,255,0.18)"/>
                  <circle cx="48" cy="36" r="17" fill="rgba(255,255,255,0.28)"/>
                  <text x="48" y="43" text-anchor="middle" dominant-baseline="middle"
                    font-family="'Fraunces',Georgia,serif" font-size="22" font-weight="700"
                    fill="white" letter-spacing="1">{{ strtoupper(substr($doctor->name,0,1)) }}</text>
                </svg>
              </div>
            @endif
          </div>
          <div class="bk-doc-meta">
            <h2 class="bk-doc-name">Dr. {{ $doctor->user->name }}</h2>
            <span class="bk-badge">{{ $doctor->major->title }}</span>
            <div class="bk-stars">
              @for($i=1;$i<=5;$i++)<i class="fa-solid fa-star{{ $i<=4?'':'-half-stroke' }}"></i>@endfor
              <small>4.8</small>
            </div>
          </div>
        </div>

        @if($schedules->count())
        <div class="bk-card bk-card--pad">
          <p class="bk-label"><i class="fa-regular fa-clock"></i> Working Days</p>
          @foreach($schedules as $s)
            <div class="bk-row">
              <span class="fw-600">{{ $s->day_of_week }}</span>
              <span class="c-muted fs-xs">
                {{ \Carbon\Carbon::parse($s->start_time)->format('g:i A') }}
                – {{ \Carbon\Carbon::parse($s->end_time)->format('g:i A') }}
              </span>
            </div>
          @endforeach
        </div>
        @endif

        <div class="bk-card bk-card--pad">
          <div class="bk-row">
            <span class="c-muted"><i class="fa-regular fa-calendar-check c-blue"></i> Consultation Fee</span>
            <strong>{{ number_format($doctor->consultation_fee, 2) }} EGP</strong>
          </div>

          <div class="bk-divider"></div>
          <div class="bk-row">
            <span class="fw-700">Total Due</span>
            <strong class="bk-total-price">{{ number_format($doctor->consultation_fee, 2) }} <em>EGP</em></strong>
          </div>
        </div>

        <div class="bk-card bk-card--pad bk-trust">
          {{-- Changed: PayMob → Stripe --}}
          <div class="bk-trust-item"><i class="fa-solid fa-lock c-blue"></i> Secured by Stripe</div>
          <div class="bk-trust-item"><i class="fa-solid fa-headset c-blue"></i> 24/7 Support</div>
        </div>

      </aside>

      {{-- ══════════ MAIN FORM ══════════ --}}
      <div class="bk-main" data-aos="fade-left">
        <form action="{{ route('front.booking.store', $doctor) }}" method="POST" id="bk-form">
          @csrf
          <input type="hidden" name="appointment_date" id="hidden-date">
          <input type="hidden" name="appointment_time" id="hidden-time">

          {{-- ① Date & Time --}}
          <div class="bk-block">
            <div class="bk-block-title">
              <div class="bk-num">1</div>
              <div>
                <h3>Choose Date & Time</h3>
                <p class="c-muted fs-sm">Pick one of the doctor's available days</p>
              </div>
            </div>

            <p class="bk-label mb-10"><i class="fa-regular fa-calendar-days c-blue"></i> Available Days</p>
            <div class="bk-day-grid" id="day-grid">
              @foreach($schedules as $s)
                <button type="button" class="bk-day-btn"
                  data-day="{{ $s->day_of_week }}"
                  data-start="{{ $s->start_time }}"
                  data-end="{{ $s->end_time }}">
                  <span class="bk-day-name">{{ substr($s->day_of_week,0,3) }}</span>
                  <span class="bk-day-hours">
                    {{ \Carbon\Carbon::parse($s->start_time)->format('g A') }}–{{ \Carbon\Carbon::parse($s->end_time)->format('g A') }}
                  </span>
                </button>
              @endforeach
            </div>

            <div id="sched-info" class="bk-sched-info" style="display:none">
              <i class="fa-regular fa-clock"></i>
              <span>Dr. {{ $doctor->name }} is available on
                <strong id="sched-day"></strong> from
                <strong id="sched-from"></strong> to
                <strong id="sched-to"></strong>
              </span>
            </div>

            <div id="slots-area" style="display:none;margin-top:20px">
              <p class="bk-label mb-10"><i class="fa-regular fa-clock c-blue"></i> Available Time Slots</p>
              <div class="bk-time-grid" id="slots-grid"></div>
              <p id="no-slots-msg" class="c-muted fs-sm" style="display:none;margin-top:10px">
                <i class="fa-solid fa-calendar-xmark"></i> No available slots for this day.
              </p>
            </div>
          </div>

          {{-- ② Patient Information --}}
          <div class="bk-block">
            <div class="bk-block-title">
              <div class="bk-num">2</div>
              <div>
                <h3>Patient Information</h3>
                <p class="c-muted fs-sm">Fill in the patient's details</p>
              </div>
            </div>

            <div class="bk-grid-2">

              <div class="bk-field">
                <label for="patient_name">Full Name <span class="req">*</span></label>
                <div class="bk-inp">
                  <i class="fa-regular fa-user"></i>
                  <input type="text" id="patient_name" name="patient_name" required
                    placeholder="Patient full name"
                    value="{{ old('patient_name', auth()->user()->name) }}">
                </div>
              </div>

              <div class="bk-field">
                <label for="patient_phone">Phone <span class="req">*</span></label>
                <div class="bk-inp">
                  <i class="fa-solid fa-phone"></i>
                  <input type="tel" id="patient_phone" name="patient_phone" required
                    placeholder="01xxxxxxxxx"
                    value="{{ old('patient_phone', auth()->user()->phone ?? '') }}">
                </div>
              </div>

              <div class="bk-field col-span-2">
                <label for="patient_email">Email <span class="req">*</span></label>
                <div class="bk-inp">
                  <i class="fa-regular fa-envelope"></i>
                  <input type="email" id="patient_email" name="patient_email" required
                    placeholder="patient@email.com"
                    value="{{ old('patient_email', auth()->user()->email) }}">
                </div>
              </div>

              <div class="bk-field">
                <label for="patient_dob">Date of Birth</label>
                <div class="bk-inp">
                  <i class="fa-regular fa-calendar"></i>
                  <input type="date" id="patient_dob" name="patient_dob"
                    max="{{ now()->subDay()->format('Y-m-d') }}"
                    value="{{ old('patient_dob') }}">
                </div>
              </div>

              <div class="bk-field">
                <label for="patient_gender">Gender</label>
                <div class="bk-inp bk-inp--select">
                  <i class="fa-solid fa-venus-mars"></i>
                  <select id="patient_gender" name="patient_gender">
                    <option value="">— Select —</option>
                    <option value="male"   {{ old('patient_gender') === 'male'   ? 'selected':'' }}>Male</option>
                    <option value="female" {{ old('patient_gender') === 'female' ? 'selected':'' }}>Female</option>
                  </select>
                </div>
              </div>

              <div class="bk-field">
                <label for="patient_blood_type">Blood Type</label>
                <div class="bk-inp bk-inp--select">
                  <i class="fa-solid fa-droplet"></i>
                  <select id="patient_blood_type" name="patient_blood_type">
                    <option value="">— Select —</option>
                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                      <option value="{{ $bt }}"
                        {{ old('patient_blood_type') === $bt ? 'selected':'' }}>
                        {{ $bt }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="bk-field col-span-2">
                <label for="patient_notes">Medical Notes <span class="c-muted fw-400">(optional)</span></label>
                <div class="bk-inp bk-inp--textarea">
                  <i class="fa-regular fa-note-sticky"></i>
                  <textarea id="patient_notes" name="patient_notes" rows="3"
                    placeholder="Allergies, chronic conditions, or notes for the doctor…">{{ old('patient_notes') }}</textarea>
                </div>
              </div>

            </div>
          </div>

          {{-- ③ Payment Method --}}
          <div class="bk-block">
            <div class="bk-block-title">
              <div class="bk-num">3</div>
              <div>
                <h3>Payment Method</h3>
                <p class="c-muted fs-sm">Choose how you'd like to pay</p>
              </div>
            </div>

            <div class="bk-pay-tabs">

              {{-- Changed: PayMob badge → Stripe brand --}}
              <label class="bk-pay-tab active" for="pay-card">
                <input type="radio" name="payment_method" id="pay-card" value="card" checked hidden>
                <i class="fa-regular fa-credit-card"></i>
                <span>Pay Online</span>
                <div class="bk-pay-brands">
                  <svg viewBox="0 0 48 16" height="12" fill="none">
                    <text y="13" font-size="13" font-weight="700" fill="#1a1f71" font-family="Arial">VISA</text>
                  </svg>
                  <svg viewBox="0 0 32 20" height="12">
                    <circle cx="12" cy="10" r="10" fill="#EB001B"/>
                    <circle cx="20" cy="10" r="10" fill="#F79E1B"/>
                    <path d="M16 4.8a10 10 0 0 1 0 10.4A10 10 0 0 1 16 4.8z" fill="#FF5F00"/>
                  </svg>
                  <span class="bk-stripe-badge">
                    <i class="fa-brands fa-stripe"></i>
                  </span>
                </div>
              </label>

              <label class="bk-pay-tab" for="pay-clinic">
                <input type="radio" name="payment_method" id="pay-clinic" value="at_clinic" hidden>
                <i class="fa-solid fa-hospital"></i>
                <span>Pay at Clinic</span>
              </label>

            </div>

            {{-- Changed: PayMob notice → Stripe notice --}}
            <div id="card-notice">
              <div class="bk-notice bk-notice--stripe">
                <i class="fa-brands fa-stripe-s"></i>
                <div>
                  You'll be redirected to <strong>Stripe</strong>'s secure checkout to pay
                  <strong>{{ number_format($doctor->consultation_fee, 2) }} EGP</strong>.
                  Supports Visa, Mastercard & Amex.
                </div>
              </div>
            </div>

            <div id="clinic-notice" style="display:none">
              <div class="bk-notice bk-notice--green">
                <i class="fa-solid fa-circle-check"></i>
                You'll pay <strong>{{ number_format($doctor->consultation_fee, 2) }} EGP</strong>
                directly at the clinic on your appointment day. No payment needed now.
              </div>
            </div>

          </div>

          {{-- Submit --}}
          <div class="bk-submit-row">
            <div class="bk-submit-total">
              Total: <strong>{{ number_format($doctor->consultation_fee, 2) }} EGP</strong>
            </div>
            <button type="submit" class="bk-btn" id="submit-btn" disabled>
              <i class="fa-solid fa-calendar-check"></i>
              <span id="btn-label">Confirm & Pay</span>
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>
</section>

@endsection

@push('style')
<style>
/* ─── Utilities ─── */
.fw-600{font-weight:600}.fw-700{font-weight:700}.fw-400{font-weight:400}
.fs-sm{font-size:.8rem}.fs-xs{font-size:.72rem}
.c-muted{color:var(--grey-500)}.c-blue{color:var(--blue)}
.col-span-2{grid-column:1/-1}
.req{color:#e53e3e}
.mb-10{margin-bottom:10px}

/* ─── Layout ─── */
.bk-section{padding:64px 0 100px;background:var(--grey-100);min-height:100vh}
.bk-wrapper{max-width:1080px;margin:0 auto;padding:0 24px}
.bk-layout{display:grid;grid-template-columns:272px 1fr;gap:22px;align-items:start}
.bk-sidebar{position:sticky;top:88px;display:flex;flex-direction:column;gap:14px}
.bk-main{display:flex;flex-direction:column;gap:18px}

/* ─── Alerts ─── */
.bk-alert{border-radius:var(--r-sm);padding:14px 18px;margin-bottom:28px;display:flex;align-items:flex-start;gap:12px;font-size:.88rem}
.bk-alert i{flex-shrink:0;margin-top:2px}
.bk-alert ul{margin:0;padding-left:16px}
.bk-alert--error{background:#fff5f5;border:1px solid #fed7d7;color:#c53030}
.bk-alert--success{background:#f0fff4;border:1px solid #9ae6b4;color:#276749}

/* ─── Cards ─── */
.bk-card{background:var(--white);border-radius:var(--r-lg);border:1px solid var(--grey-200);box-shadow:var(--shadow-card);overflow:hidden}
.bk-card--pad{padding:14px 16px}

/* ─── Doctor ─── */
.bk-doc-avatar-bg{height:160px;background:linear-gradient(135deg,var(--blue-dark),var(--blue));display:flex;align-items:center;justify-content:center}
.bk-doc-avatar-bg img{width:96px;height:96px;border-radius:50%;object-fit:cover;border:4px solid rgba(255,255,255,.9);box-shadow:0 6px 20px rgba(0,0,0,.2)}
.bk-doc-initials{display:flex;align-items:center;justify-content:center;filter:drop-shadow(0 6px 20px rgba(0,0,0,.2))}
.bk-doc-meta{padding:16px 16px 20px;text-align:center}
.bk-doc-name{font-family:'Fraunces',serif;font-size:1.05rem;font-weight:700;color:var(--text);margin-bottom:4px}
.bk-stars{display:flex;align-items:center;justify-content:center;gap:3px;color:var(--gold);font-size:.75rem;margin-top:8px}
.bk-stars small{color:var(--grey-500);margin-left:4px}
.bk-badge{display:inline-block;background:var(--blue-soft);color:var(--blue);padding:4px 14px;border-radius:var(--r-full);font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase}

/* ─── Rows ─── */
.bk-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px dashed var(--grey-200);font-size:.78rem}
.bk-row:last-child{border-bottom:none}
.bk-divider{height:1px;background:var(--grey-200);margin:6px 0}
.bk-total-price{font-family:'Fraunces',serif;font-size:1.2rem;color:var(--blue)}
.bk-total-price em{font-style:normal;font-size:.7rem;font-family:'DM Sans',sans-serif;color:var(--grey-500)}
.bk-label{font-size:.7rem;font-weight:700;color:var(--grey-500);text-transform:uppercase;letter-spacing:.1em;margin-bottom:10px;display:flex;align-items:center;gap:7px}

/* ─── Trust ─── */
.bk-trust{display:flex;flex-direction:column;gap:10px}
.bk-trust-item{display:flex;align-items:center;gap:10px;font-size:.76rem;color:var(--grey-700);font-weight:600}
.bk-trust-item i{width:14px}

/* ─── Blocks ─── */
.bk-block{background:var(--white);border-radius:var(--r-lg);padding:30px 28px;box-shadow:var(--shadow-card);border:1px solid var(--grey-200)}
.bk-block-title{display:flex;align-items:flex-start;gap:14px;margin-bottom:26px;padding-bottom:18px;border-bottom:1px solid var(--grey-200)}
.bk-num{width:34px;height:34px;background:var(--blue);color:var(--white);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.88rem;flex-shrink:0;box-shadow:0 4px 12px rgba(0,106,255,.3)}
.bk-block-title h3{font-family:'Fraunces',serif;font-size:1.2rem;font-weight:700;color:var(--text);margin-bottom:4px}

/* ─── Fields ─── */
.bk-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.bk-field{display:flex;flex-direction:column;gap:7px}
.bk-field label{font-size:.79rem;font-weight:600;color:var(--grey-700)}
.bk-inp{position:relative;display:flex;align-items:center}
.bk-inp>i:first-child{position:absolute;left:13px;color:var(--grey-500);font-size:.8rem;pointer-events:none;transition:color var(--t);z-index:1}
.bk-inp input,.bk-inp select,.bk-inp textarea{width:100%;padding:11px 14px 11px 38px;border:1.5px solid var(--grey-200);border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:.86rem;color:var(--text);background:var(--white);outline:none;transition:border-color var(--t)}
.bk-inp input:focus,.bk-inp select:focus,.bk-inp textarea:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(0,106,255,.08)}
.bk-inp:focus-within>i:first-child{color:var(--blue)}
.bk-inp--select select{appearance:none;padding-right:32px;cursor:pointer}
.bk-inp--select::after{content:'\f078';font-family:'Font Awesome 6 Free';font-weight:900;position:absolute;right:12px;color:var(--grey-500);font-size:.7rem;pointer-events:none}
.bk-inp--textarea{align-items:flex-start}
.bk-inp--textarea>i:first-child{top:12px}
.bk-inp--textarea textarea{resize:vertical;min-height:80px}

/* ─── Days ─── */
.bk-day-grid{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:16px}
.bk-day-btn{display:flex;flex-direction:column;align-items:center;gap:4px;padding:12px 18px;border:1.5px solid var(--grey-200);border-radius:var(--r-md);background:var(--white);cursor:pointer;transition:var(--t);min-width:90px;text-align:center}
.bk-day-btn:hover{border-color:var(--blue);background:var(--blue-soft)}
.bk-day-btn.active{border-color:var(--blue);background:var(--blue);color:var(--white)}
.bk-day-name{font-size:.9rem;font-weight:700;color:inherit}
.bk-day-hours{font-size:.68rem;color:var(--grey-500);white-space:nowrap}
.bk-day-btn.active .bk-day-hours{color:rgba(255,255,255,.75)}
.bk-sched-info{display:flex;align-items:center;gap:10px;background:var(--blue-soft);border:1px solid rgba(0,106,255,.15);border-radius:var(--r-sm);padding:11px 14px;font-size:.82rem;color:var(--blue);margin-bottom:4px}
.bk-sched-info i{flex-shrink:0}

/* ─── Slots ─── */
.bk-time-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(100px,1fr));gap:8px}
.bk-slot{padding:10px 8px;border:1.5px solid var(--grey-200);background:var(--white);border-radius:var(--r-sm);font-size:.82rem;font-weight:600;color:var(--grey-700);cursor:pointer;transition:var(--t);text-align:center}
.bk-slot:hover{border-color:var(--blue);color:var(--blue);background:var(--blue-soft)}
.bk-slot.selected{background:var(--blue);border-color:var(--blue);color:var(--white);box-shadow:0 4px 12px rgba(0,106,255,.25)}

/* ─── Pay tabs ─── */
.bk-pay-tabs{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:20px}
.bk-pay-tab{border:2px solid var(--grey-200);border-radius:var(--r-md);padding:18px 12px;cursor:pointer;transition:var(--t);display:flex;flex-direction:column;align-items:center;gap:8px;text-align:center;background:var(--white);user-select:none}
.bk-pay-tab i{font-size:1.4rem;color:var(--grey-400);transition:color var(--t)}
.bk-pay-tab span{font-size:.78rem;font-weight:700;color:var(--grey-600)}
.bk-pay-tab.active{border-color:var(--blue);background:var(--blue-soft)}
.bk-pay-tab.active i,.bk-pay-tab.active span{color:var(--blue)}
.bk-pay-brands{display:flex;gap:6px;align-items:center;margin-top:2px}

/* Changed: PayMob badge → Stripe badge */
.bk-stripe-badge{display:inline-flex;align-items:center;background:#635bff;color:white;padding:2px 7px;border-radius:4px;font-size:.75rem}
.bk-stripe-badge i{font-size:.9rem}

/* ─── Notices ─── */
.bk-notice{border-radius:var(--r-sm);padding:13px 16px;font-size:.81rem;display:flex;align-items:flex-start;gap:10px;line-height:1.7}
.bk-notice i{flex-shrink:0;margin-top:2px}
.bk-notice--green{background:#f0fff4;border:1px solid #9ae6b4;color:#276749}
.bk-notice--green i{color:#38a169}

/* Changed: paymob notice → stripe notice */
.bk-notice--stripe{background:#f0efff;border:1px solid #b5b0ff;color:#1a0080}
.bk-notice--stripe i{color:#635bff;font-size:1.1rem}

/* ─── Submit ─── */
.bk-submit-row{background:var(--white);border-radius:var(--r-lg);padding:20px 26px;box-shadow:var(--shadow-card);border:1px solid var(--grey-200);display:flex;align-items:center;justify-content:space-between;gap:20px}
.bk-submit-total{font-size:.85rem;color:var(--grey-500)}
.bk-submit-total strong{font-family:'Fraunces',serif;font-size:1.35rem;color:var(--text);margin-left:6px}
.bk-btn{display:inline-flex;align-items:center;gap:10px;padding:13px 38px;background:var(--blue);color:var(--white);border:none;border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:.9rem;font-weight:700;cursor:pointer;transition:var(--t);box-shadow:var(--shadow-btn)}
.bk-btn:hover:not(:disabled){background:var(--blue-mid);transform:translateY(-2px);box-shadow:0 8px 28px rgba(0,106,255,.4)}
.bk-btn:disabled{opacity:.38;cursor:not-allowed;transform:none;box-shadow:none}

/* ─── Responsive ─── */
@media(max-width:860px){.bk-layout{grid-template-columns:1fr}.bk-sidebar{position:static}.bk-block{padding:22px 16px}}
@media(max-width:560px){.bk-grid-2{grid-template-columns:1fr}.bk-pay-tabs{grid-template-columns:1fr}.bk-submit-row{flex-direction:column;text-align:center}.bk-btn{width:100%;justify-content:center}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  const nameToNum = {Sunday:0,Monday:1,Tuesday:2,Wednesday:3,Thursday:4,Friday:5,Saturday:6};
  const today = new Date(); today.setHours(0,0,0,0);
  let selectedDayName = null, selectedTime = null;

  document.querySelectorAll('.bk-day-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.bk-day-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      selectedDayName = btn.dataset.day;
      selectedTime = null;
      document.getElementById('hidden-time').value = '';

      const targetDow = nameToNum[selectedDayName];
      const date = new Date(today);
      let diff = targetDow - date.getDay();
      if (diff <= 0) diff += 7;
      date.setDate(date.getDate() + diff);

      const mm = String(date.getMonth()+1).padStart(2,'0');
      const dd = String(date.getDate()).padStart(2,'0');
      document.getElementById('hidden-date').value = `${date.getFullYear()}-${mm}-${dd}`;

      const fmt = t => { const [h,m]=t.split(':').map(Number); return `${h%12||12}:${String(m).padStart(2,'0')} ${h>=12?'PM':'AM'}`; };
      document.getElementById('sched-day').textContent  = selectedDayName;
      document.getElementById('sched-from').textContent = fmt(btn.dataset.start);
      document.getElementById('sched-to').textContent   = fmt(btn.dataset.end);
      document.getElementById('sched-info').style.display = 'flex';

      checkSubmit();
      showSlots(btn.dataset.start, btn.dataset.end);
    });
  });

  function showSlots(start, end) {
    const area = document.getElementById('slots-area');
    const grid = document.getElementById('slots-grid');
    const noMsg = document.getElementById('no-slots-msg');
    area.style.display = 'block';
    grid.innerHTML = '';
    noMsg.style.display = 'none';

    const slots = generateSlots(start, end, 30);
    if (!slots.length) { noMsg.style.display = 'block'; return; }

    slots.forEach(slot => {
      const btn = document.createElement('button');
      btn.type = 'button'; btn.className = 'bk-slot';
      btn.textContent = formatTime(slot);
      btn.addEventListener('click', function () {
        document.querySelectorAll('.bk-slot').forEach(s => s.classList.remove('selected'));
        btn.classList.add('selected');
        selectedTime = slot;
        document.getElementById('hidden-time').value = slot;
        checkSubmit();
      });
      grid.appendChild(btn);
    });
  }

  function generateSlots(start, end, step) {
    const slots = []; let cur = toMins(start), endM = toMins(end);
    while (cur < endM) { slots.push(fromMins(cur)); cur += step; }
    return slots;
  }
  function toMins(t)   { const [h,m] = t.split(':').map(Number); return h*60+m; }
  function fromMins(m) { return `${String(Math.floor(m/60)).padStart(2,'0')}:${String(m%60).padStart(2,'0')}`; }
  function formatTime(t) { const [h,m]=t.split(':').map(Number); return `${h%12||12}:${String(m).padStart(2,'0')} ${h>=12?'PM':'AM'}`; }
  function checkSubmit() { document.getElementById('submit-btn').disabled = !(selectedDayName && selectedTime); }

  document.querySelectorAll('.bk-pay-tab').forEach(tab => {
    tab.addEventListener('click', function () {
      document.querySelectorAll('.bk-pay-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      tab.querySelector('input').checked = true;
      const isCard = tab.querySelector('input').value === 'card';
      document.getElementById('card-notice').style.display   = isCard  ? 'block' : 'none';
      document.getElementById('clinic-notice').style.display = !isCard ? 'block' : 'none';
      document.getElementById('btn-label').textContent = isCard ? 'Confirm & Pay' : 'Confirm Booking';
    });
  });

});
</script>
@endpush