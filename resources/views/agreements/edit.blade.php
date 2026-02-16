@include('role_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

@php
  $startDate  = $agreement->agreement_start_date ? \Carbon\Carbon::parse($agreement->agreement_start_date)->toDateString() : '';
  $endDate    = $agreement->agreement_end_date   ? \Carbon\Carbon::parse($agreement->agreement_end_date)->toDateString()   : '';
  $hasOld     = session()->hasOldInput();

  $visaOptions = ['D-SPO','D-HIRE','TADBEER','TOURIST','VISIT','OFFICE-VISA'];
  $currentVisa = old('visa_type', $agreement->visa_type);
  if ($currentVisa && !in_array($currentVisa, $visaOptions, true)) {
      $visaOptions[] = $currentVisa;
  }
@endphp

<main id="main" class="main">
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <h5 class="card-title mb-0">
                <i class="fas fa-file-signature me-2"></i>
                Update Agreement
                <small class="text-muted">({{ $agreement->reference_no }})</small>
              </h5>
            </div>

            @if (session('success'))
              <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" class="mt-4" id="agreementEditForm" action="{{ route('agreements.update', ['reference_no' => $agreement->reference_no]) }}" novalidate>
              @csrf
              @method('PUT')

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Customer<span class="text-danger">*</span></label>
                  <select name="client_id" id="client_id" class="form-control select2" required>
                    <option value="">Select Customer</option>
                    @foreach($customers as $c)
                      <option value="{{ $c->id }}"
                              data-cl="{{ $c->CL_Number }}"
                              {{ (int)old('client_id', $agreement->client_id)===(int)$c->id ? 'selected' : '' }}>
                        {{ $c->first_name }} {{ $c->last_name }} {{ $c->CL_Number ? '(' . $c->CL_Number . ')' : '' }}
                      </option>
                    @endforeach
                  </select>
                  @error('client_id')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Candidate<span class="text-danger">*</span></label>
                  <select name="candidate_id" id="candidate_id" class="form-control select2" required>
                    <option value="">Select Candidate</option>
                    @foreach($candidates as $cand)
                      <option
                        value="{{ $cand->id }}"
                        data-cn="{{ $cand->CN_Number }}"
                        data-name="{{ $cand->candidate_name }}"
                        data-passport-no="{{ $cand->passport_no }}"
                        data-passport-expiry="{{ $cand->passport_expiry_date ? \Carbon\Carbon::parse($cand->passport_expiry_date)->toDateString() : '' }}"
                        data-dob="{{ $cand->date_of_birth ? \Carbon\Carbon::parse($cand->date_of_birth)->toDateString() : '' }}"
                        data-nationality="{{ $cand->nationality }}"
                        data-visa="{{ $cand->visa_type }}"
                        {{ (int)old('candidate_id', $agreement->candidate_id)===(int)$cand->id ? 'selected' : '' }}
                      >
                        {{ $cand->candidate_name }} {{ $cand->CN_Number ? '(' . $cand->CN_Number . ')' : '' }}
                      </option>
                    @endforeach
                  </select>
                  @error('candidate_id')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Total Amount<span class="text-danger">*</span></label>
                  <input type="number" step="0.01" min="0" name="total_amount" id="total_amount" class="form-control" value="{{ old('total_amount', $agreement->total_amount) }}" required inputmode="decimal">
                  @error('total_amount')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Received Amount<span class="text-danger">*</span></label>
                  <input type="number" step="0.01" min="0" name="received_amount" id="received_amount" class="form-control" value="{{ old('received_amount', $agreement->received_amount) }}" required inputmode="decimal">
                  @error('received_amount')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Remaining Amount</label>
                  <input type="number" step="0.01" min="0" name="remaining_amount" id="remaining_amount" class="form-control" value="{{ old('remaining_amount', $agreement->remaining_amount) }}" readonly>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Visa Type</label>
                  <select name="visa_type" id="visa_type" class="form-control select2">
                    <option value="">Select Visa Type</option>
                    @foreach($visaOptions as $opt)
                      <option value="{{ $opt }}" {{ $currentVisa===$opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                  </select>
                  @error('visa_type')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Agreement Start Date<span class="text-danger">*</span></label>
                  <input type="date" name="agreement_start_date" id="agreement_start_date" class="form-control" value="{{ old('agreement_start_date', $startDate) }}" required>
                  @error('agreement_start_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Agreement End Date<span class="text-danger">*</span></label>
                  <input type="date" name="agreement_end_date" id="agreement_end_date" class="form-control" value="{{ old('agreement_end_date', $endDate) }}" required>
                  @error('agreement_end_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label">Number of Days</label>
                  <input type="number" name="number_of_days" id="number_of_days" class="form-control" value="{{ old('number_of_days', $agreement->number_of_days) }}" readonly>
                </div>

                <div class="col-12">
                  <label class="form-label">Notes</label>
                  <input type="text" name="notes" class="form-control" value="{{ old('notes', $agreement->notes) }}" autocomplete="off">
                </div>
              </div>

              <div class="d-flex justify-content-end align-items-center mt-4 gap-2">
                <button type="submit" class="btn btn-primary" id="saveBtn">
                  <i class="fas fa-save me-1"></i> Save Changes
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                  Back
                </a>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@include('../layout.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
(function () {
  const HAS_OLD = {{ $hasOld ? 'true' : 'false' }};

  const $q = (sel) => document.querySelector(sel);
  const totalEl = $q('#total_amount');
  const receivedEl = $q('#received_amount');
  const remainingEl = $q('#remaining_amount');
  const startEl = $q('#agreement_start_date');
  const endEl = $q('#agreement_end_date');
  const daysEl = $q('#number_of_days');
  const visaSel = $('#visa_type');

  function toNum(v){ const n = parseFloat(v); return isNaN(n) ? 0 : n; }

  function calcRemaining() {
    const t = toNum(totalEl.value);
    const r = toNum(receivedEl.value);
    remainingEl.value = Math.max(0, +(t - r).toFixed(2));
    receivedEl.classList.toggle('is-invalid', r > t);
  }

  function setEndMin() {
    if (startEl.value) endEl.min = startEl.value; else endEl.removeAttribute('min');
  }

  function calcDays() {
    if (!startEl.value || !endEl.value) return;
    const s = new Date(startEl.value);
    const e = new Date(endEl.value);
    if (e < s) {
      endEl.classList.add('is-invalid');
      daysEl.value = '';
      return;
    }
    endEl.classList.remove('is-invalid');
    const one = 1000 * 60 * 60 * 24;
    const diff = Math.round((e - s) / one) + 1;
    daysEl.value = Math.max(1, diff);
  }

  function ensureVisaOption(value) {
    if (!value) return;
    const exists = !!visaSel.find('option').filter(function(){ return $(this).val() === value; }).length;
    if (!exists) {
      const newOpt = new Option(value, value, true, true);
      visaSel.append(newOpt).trigger('change.select2');
    } else {
      visaSel.val(value).trigger('change');
    }
  }

  function applyCandidateVisa() {
    const $opt = $('#candidate_id').find(':selected');
    if (!$opt.length) return;
    const candVisa = ($opt.data('visa') || '').toString();
    if (!HAS_OLD) ensureVisaOption(candVisa);
    else if (candVisa) visaSel.val(candVisa).trigger('change');
  }

  function wire() {
    ['input','change'].forEach(evt => {
      totalEl.addEventListener(evt, calcRemaining);
      receivedEl.addEventListener(evt, calcRemaining);
      startEl.addEventListener(evt, () => { setEndMin(); calcDays(); });
      endEl.addEventListener(evt, calcDays);
    });

    $('#client_id').select2({ width: '100%' });
    $('#candidate_id').select2({ width: '100%', placeholder: 'Select Candidate', allowClear: true });
    visaSel.select2({ width: '100%', placeholder: 'Select Visa Type', allowClear: true });

    $('#candidate_id').on('change', function () {
      const $opt = $(this).find(':selected');
      const candVisa = ($opt.data('visa') || '').toString();
      ensureVisaOption(candVisa);
    });
  }

  wire();
  setEndMin();
  calcRemaining();
  calcDays();
  applyCandidateVisa();

  const form = document.getElementById('agreementEditForm');
  const save = document.getElementById('saveBtn');
  form.addEventListener('submit', function(e){
    if (receivedEl.classList.contains('is-invalid') || endEl.classList.contains('is-invalid')) {
      e.preventDefault();
      return;
    }
    save.disabled = true;
    save.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...';
  });
})();
</script>
