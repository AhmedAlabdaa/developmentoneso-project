@php
  use Carbon\Carbon;

  $refundReasons = $refundReasons ?? [
    'NOT SATISFIED',
    'UNSKILLED',
    'LANGUAGE ISSUE',
    'BEHAVIOR ISSUES',
    'MOBILE USAGE',
    'HEALTH REASONS',
    'REFUSE TO WORK',
    'MOI ISSUE - FROM PREVIOUS SPO',
    'OTHER',
  ];

  $tz = 'Asia/Qatar';

  $startDate = $agreementStartDate
    ?? $trialStartDate
    ?? $contractStartDate
    ?? null;

  $endDate = $agreementEndDate
    ?? $trialReturnDate
    ?? Carbon::now($tz)->format('Y-m-d');

  $agreementTotalAmount = isset($agreementTotal)
      ? (float) $agreementTotal
      : (float) ($contractedAmount ?? $totalAmount ?? 0);

  $agreementReceivedAmount = isset($agreementReceived)
      ? (float) $agreementReceived
      : (float) ($totalPaidAmount ?? $receivedAmount ?? 0);

  $replacementBalanceValue = isset($replacementBalance)
      ? (float) $replacementBalance
      : (float) ($contractedAmount ?? 0);

  $replacementWorkerSalaryAmount = isset($replacementWorkerSalaryAmount)
      ? (float) $replacementWorkerSalaryAmount
      : 0;
@endphp

<style>
  .kv{display:flex;align-items:center;justify-content:space-between;gap:10px;border:1px solid #e5e7eb;background:#fff;border-radius:8px;padding:8px 10px}
  .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
  .grid-2{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
  .custom-modal .form-control,.custom-modal .form-select{height:30px;padding:4px 8px;font-size:12px}
  .custom-modal textarea.form-control{min-height:60px}
  .custom-modal label{font-size:12px}
</style>

<div class="row g-3">
  <div class="col-12">
    <table class="table table-sm table-bordered mb-2">
      <tbody>
        <tr>
          <th style="width:25%">Agreement Start Date</th>
          <td style="width:25%">{{ $startDate ?? '-' }}</td>
          <th style="width:25%">Agreement End Date</th>
          <td style="width:25%">{{ $endDate ?? '-' }}</td>
        </tr>
        <tr>
          <th>Total Amount</th>
          <td>{{ number_format($agreementTotalAmount, 2, '.', '') }}</td>
          <th>Received Amount</th>
          <td>{{ number_format($agreementReceivedAmount, 2, '.', '') }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <input type="hidden" class="js-trial-start" name="trial_start_date" value="{{ $startDate }}">
  <input type="hidden" class="js-trial-days" name="total_trial_days" value="0">

  <div class="col-md-4">
    <label class="form-label">LC No</label>
    <input type="text" class="form-control" value="{{ $lcNo ?? '' }}" readonly>
  </div>

  <div class="col-md-4">
    <label class="form-label">Return Date</label>
    <input type="date" class="form-control js-trial-return" name="trial_return_date" value="{{ $endDate }}">
  </div>

  <div class="col-md-4">
    <label class="form-label">Days Worked With Sponsor</label>
    <input type="number" min="0" class="form-control js-worked-days" name="replacement_worked_days" value="0" readonly>
  </div>

  <div class="col-md-4">
    <label class="form-label">Replacement Reason</label>
    <select class="form-select js-reason-select">
      <option value="" selected>Select</option>
      @foreach($refundReasons as $rr)
        <option value="{{ $rr }}">{{ $rr }}</option>
      @endforeach
      <option value="Other">Other</option>
    </select>
    <input type="text" class="form-control mt-2 d-none js-reason-other" placeholder="Type other reason">
    <input type="hidden" name="replacement_reason_text" class="js-reason-final">
  </div>

  <div class="col-md-4">
    <label class="form-label">Worker Passport</label>
    <select class="form-select" name="replacement_original_passport">
      <option value="">Select</option>
      <option value="Office">Office</option>
      <option value="Sponsor">Sponsor</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Worker Belongings</label>
    <select class="form-select" name="replacement_worker_belongings">
      <option value="">Select</option>
      <option value="Office">Office</option>
      <option value="Sponsor House">Sponsor House</option>
      <option value="Accommodation">Accommodation</option>
      <option value="Others">Others</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">
      Monthly Salary <span style="font-size: 8px;">(Per day 1200 / 30 = 40)</span>
    </label>
    <input type="number" step="0.01" class="form-control js-salary-amount" name="replacement_worker_salary_amount" value="{{ number_format($replacementWorkerSalaryAmount, 2, '.', '') }}">
  </div>

  <div class="col-md-4">
    <label class="form-label">Balance Salary</label>
    <input type="number" step="0.01" class="form-control js-salary-total" name="replacement_total_worker_salary" value="0">
  </div>

  <div class="col-md-4">
    <label class="form-label">Worker Salary Status</label>
    <select class="form-select js-salary-type" name="replacement_worker_salary_type">
      <option value="">Select</option>
      <option value="Customer paid to Office by Cash">Customer paid to Office by Cash</option>
      <option value="Customer paid to Office by Bank Transfer">Customer paid to Office by Bank Transfer</option>
      <option value="Paid to Worker">Paid to Worker</option>
      <option value="POS">POS</option>
      <option value="Deduct From Balance">Deduct From Balance</option>
    </select>
  </div>

  <div class="col-lg-4 js-bank-amount-wrap d-none">
    <label class="form-label">Bank Transfer Amount</label>
    <input type="number" step="0.01" class="form-control js-bank-amount" name="replacement_bank_amount" value="0">
  </div>

  <div class="col-lg-4 js-bank-proof-wrap d-none">
    <label class="form-label">Upload Payment Proof</label>
    <input type="file" class="form-control js-bank-proof" name="replacement_bank_proof" accept="image/png,image/jpg,image/jpeg,application/pdf">
  </div>

  <input type="hidden" class="js-balance-base" value="{{ number_format($replacementBalanceValue, 2, '.', '') }}">

  <div class="col-md-4">
    <label class="form-label">Replacement Balance</label>
    <input type="number" step="0.01" class="form-control js-final" name="replacement_balance" value="{{ number_format($replacementBalanceValue, 2, '.', '') }}">
  </div>

  <div class="col-lg-12">
    <label class="form-label">Remarks</label>
    <textarea class="form-control" name="remarks" rows="3"></textarea>
  </div>
</div>

<script>
(function(){
  "use strict";

  function toNumber(v){var x=parseFloat(v);return isNaN(x)?0:x}
  function toDate(value){if(!value)return null;var d=new Date(value+"T00:00:00");d.setHours(0,0,0,0);return isNaN(d.getTime())?null:d}
  function diffDays(start,end){if(!start||!end)return 0;var ms=end.getTime()-start.getTime();if(ms<=0)return 0;return Math.floor(ms/86400000)}

  function getStartDate(){var el=document.querySelector(".js-trial-start");return toDate(el?el.value:"")}
  function getReturnDate(){var el=document.querySelector(".js-trial-return");return toDate(el?el.value:"")}

  function getWorkedDays(){
    var el=document.querySelector(".js-worked-days");
    return el?toNumber(el.value):0;
  }

  function getMonthlySalary(){
    var el=document.querySelector(".js-salary-amount");
    return toNumber(el?el.value:0);
  }

  function getTotalWorkerSalary(){
    var el=document.querySelector(".js-salary-total");
    return toNumber(el?el.value:0);
  }

  function getSalaryStatus(){
    var el=document.querySelector(".js-salary-type");
    return el?el.value:"";
  }

  function getBaseAmount(){
    var base=document.querySelector(".js-balance-base");
    return toNumber(base?base.value:0);
  }

  function updateWorkedDays(){
    var worked=document.querySelector(".js-worked-days");
    var hidden=document.querySelector(".js-trial-days");
    var start=getStartDate();
    var end=getReturnDate();
    var days=diffDays(start,end);
    if(worked)worked.value=days;
    if(hidden)hidden.value=days;
    updateSalaryTotal();
    updateFinalBalance();
  }

  function updateSalaryTotal(){
    var monthly=getMonthlySalary();
    var days=getWorkedDays();
    var perDay=monthly>0?monthly/30:0;
    var total=perDay*days;
    var totalInput=document.querySelector(".js-salary-total");
    if(totalInput)totalInput.value=total.toFixed(2);
  }

  function getSalaryDeduction(){
    return getSalaryStatus()==="Deduct From Balance" ? getTotalWorkerSalary() : 0;
  }

  function updateFinalBalance(){
    var final=document.querySelector(".js-final");
    if(!final)return;
    var base=getBaseAmount();
    var deduction=getSalaryDeduction();
    var result=base-deduction;
    if(result<0)result=0;
    final.value=result.toFixed(2);
  }

  function togglePaymentProof(){
    var type=getSalaryStatus();
    var amountWrap=document.querySelector(".js-bank-amount-wrap");
    var proofWrap=document.querySelector(".js-bank-proof-wrap");
    var amountInput=amountWrap?amountWrap.querySelector(".js-bank-amount"):null;
    var proofInput=proofWrap?proofWrap.querySelector(".js-bank-proof"):null;
    var isBank=type==="Customer paid to Office by Bank Transfer";
    var isPos=type==="POS";

    if(amountWrap)amountWrap.classList.toggle("d-none",!isBank);
    if(proofWrap)proofWrap.classList.toggle("d-none",!(isBank||isPos));

    if(isBank){
      if(amountInput)amountInput.setAttribute("required","required");
      if(proofInput)proofInput.setAttribute("required","required");
    }else if(isPos){
      if(amountInput){
        amountInput.removeAttribute("required");
        amountInput.value="0";
      }
      if(proofInput)proofInput.setAttribute("required","required");
    }else{
      if(amountInput){
        amountInput.removeAttribute("required");
        amountInput.value="0";
      }
      if(proofInput){
        proofInput.removeAttribute("required");
        proofInput.value="";
      }
    }
  }

  function syncReason(){
    var select=document.querySelector(".js-reason-select");
    var other=document.querySelector(".js-reason-other");
    var hidden=document.querySelector(".js-reason-final");
    var value=select?select.value:"";
    if(value==="Other"){
      if(other)other.classList.remove("d-none");
      if(hidden)hidden.value=(other&&other.value?other.value.trim():"");
    }else{
      if(other)other.classList.add("d-none");
      if(hidden)hidden.value=value;
    }
  }

  function initReturnDate(){
    var input=document.querySelector(".js-trial-return");
    if(input&&!input.value){
      var now=new Date();
      now.setHours(0,0,0,0);
      input.value=now.toISOString().slice(0,10);
    }
  }

  function init(){
    initReturnDate();
    updateWorkedDays();
    togglePaymentProof();
    syncReason();
    updateSalaryTotal();
    updateFinalBalance();
  }

  init();

  document.addEventListener("input",function(e){
    if(e.target.matches(".js-salary-amount")){
      updateSalaryTotal();
      updateFinalBalance();
    }
    if(e.target.matches(".js-reason-other")){
      syncReason();
    }
  });

  document.addEventListener("change",function(e){
    if(e.target.matches(".js-trial-return")){
      updateWorkedDays();
    }
    if(e.target.matches(".js-salary-type")){
      togglePaymentProof();
      updateFinalBalance();
    }
    if(e.target.matches(".js-reason-select")){
      syncReason();
    }
  });
})();
</script>
