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

  $basePaidAmount = $agreementReceivedAmount > 0
      ? $agreementReceivedAmount
      : (float) ($totalPaidAmount ?? 0);

  $initialRefundBalance = isset($refundBalance)
      ? (float) $refundBalance
      : $basePaidAmount;

  $maidSalary = isset($maidSalary) ? (float) $maidSalary : 0;
@endphp

<style>
  .custom-modal .form-control,
  .custom-modal .form-select{height:30px;padding:4px 8px;font-size:12px}
  .custom-modal textarea.form-control{min-height:60px}
  .custom-modal label{font-size:12px}
  .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
  .grid-2{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
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
  <div class="col-md-4">
    <label class="form-label">LC No</label>
    <input type="text" class="form-control" value="{{ $lcNo ?? '' }}" readonly>
  </div>
  <div class="col-md-4">
    <label class="form-label">Return Date</label>
    <input type="date" class="form-control js-trial-return" name="trial_return_date" value="{{ $endDate }}" required>
  </div>
  <div class="col-md-4">
    <label class="form-label">Number of Days (Worked)</label>
    <input type="number" class="form-control js-trial-days" name="number_of_days" min="0" step="1" value="0" readonly>
  </div>

  <div class="col-md-4">
    <label class="form-label">Refund Reason</label>
    <select class="form-select js-reason-select">
      <option value="" selected>Select</option>
      @foreach($refundReasons as $rr)
        <option value="{{ $rr }}">{{ $rr }}</option>
      @endforeach
      <option value="Other">Other</option>
    </select>
    <input type="text" class="form-control mt-2 d-none js-reason-other" placeholder="Type other reason">
    <input type="hidden" name="refund_reason_text" class="js-reason-final">
  </div>

  <div class="col-md-4">
    <label class="form-label">Refund Available Date</label>
    <input type="date" name="refund_due_date" class="form-control js-refund-due" required>
  </div>

  <div class="col-md-4">
    <label class="form-label">Worker Passport</label>
    <select class="form-select" name="refund_original_passport">
      <option value="">Select</option>
      <option value="Office">Office</option>
      <option value="Sponsor">Sponsor</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Worker Belongings</label>
    <select class="form-select" name="refund_worker_belongings">
      <option value="">Select</option>
      <option value="Office">Office</option>
      <option value="Sponsor House">Sponsor House</option>
      <option value="Accommodation">Accommodation</option>
      <option value="Others">Others</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Total Paid Amount (Received)</label>
    <input type="number" step="0.01" min="0" name="total_paid_amount" class="form-control js-total-paid" value="{{ number_format($basePaidAmount, 2, '.', '') }}">
  </div>

  <div class="col-md-4">
    <label class="form-label">
      Monthly Salary <span style="font-size: 8px;">(Per day 1200 / 30 = 40)</span>
    </label>
    <input type="number" step="0.01" min="0" class="form-control js-salary-amount" name="maid_salary" value="{{ number_format($maidSalary, 2, '.', '') }}">
  </div>

  <div class="col-md-4">
    <label class="form-label">Balance Salary</label>
    <input type="number" step="0.01" min="0" class="form-control js-salary-total" name="refund_total_worker_salary" value="0">
  </div>

  <div class="col-md-4">
    <label class="form-label">Worker Salary Status</label>
    <select class="form-select js-salary-type" name="refund_worker_salary_type">
      <option value="">Select</option>
      <option value="Customer paid to Office by Cash">Customer paid to Office by Cash</option>
      <option value="Customer paid to Office by Bank Transfer">Customer paid to Office by Bank Transfer</option>
      <option value="Paid to Worker">Paid to Worker</option>
      <option value="POS">POS</option>
      <option value="Deduct From Balance">Deduct From Balance</option>
    </select>
  </div>

  <div class="col-md-4 js-bank-amount-wrap d-none">
    <label class="form-label">Bank Transfer Amount</label>
    <input type="number" step="0.01" min="0" class="form-control js-bank-amount" name="refund_bank_amount" value="0">
  </div>

  <div class="col-md-4 js-bank-proof-wrap d-none">
    <label class="form-label">Upload Payment Proof</label>
    <input type="file" class="form-control js-bank-proof" name="refund_bank_proof" accept="image/png,image/jpg,image/jpeg,application/pdf">
  </div>

  <input type="hidden" class="js-balance-base" value="{{ number_format($basePaidAmount, 2, '.', '') }}">

  <div class="col-md-4">
    <label class="form-label">Refund Balance</label>
    <input type="number" step="0.01" min="0" class="form-control js-final" name="refund_balance" value="{{ number_format($initialRefundBalance, 2, '.', '') }}">
  </div>

  <div class="col-12">
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

  function getWorkedDays(){var input=document.querySelector(".js-trial-days");return input?toNumber(input.value):0}
  function getSalaryStatus(){var el=document.querySelector(".js-salary-type");return el?el.value:""}
  function getMonthlySalary(){var el=document.querySelector(".js-salary-amount");return toNumber(el?el.value:0)}
  function getTotalWorkerSalary(){var el=document.querySelector(".js-salary-total");return toNumber(el?el.value:0)}

  function getBaseAmount(){
    var baseHidden=document.querySelector(".js-balance-base");
    var totalPaid=document.querySelector(".js-total-paid");
    if(baseHidden&&baseHidden.value!=="")return toNumber(baseHidden.value);
    if(totalPaid)return toNumber(totalPaid.value);
    return 0;
  }

  function updateBaseFromTotal(){
    var baseHidden=document.querySelector(".js-balance-base");
    var totalPaid=document.querySelector(".js-total-paid");
    if(!baseHidden||!totalPaid)return;
    baseHidden.value=totalPaid.value||"0";
  }

  function updateWorkedDays(){
    var input=document.querySelector(".js-trial-days");
    if(!input)return;
    var start=getStartDate();
    var end=getReturnDate();
    input.value=diffDays(start,end);
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
    var finalInput=document.querySelector(".js-final");
    if(!finalInput)return;
    var base=getBaseAmount();
    var deduction=getSalaryDeduction();
    var result=base-deduction;
    if(result<0)result=0;
    finalInput.value=result.toFixed(2);
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

  function notify(msg){
    if(window.toastr&&window.toastr.error){window.toastr.error(msg)}else{alert(msg)}
  }

  function initReturnDate(){
    var input=document.querySelector(".js-trial-return");
    if(input&&!input.value){
      var now=new Date();
      now.setHours(0,0,0,0);
      input.value=now.toISOString().slice(0,10);
    }
  }

  function initRefundDueConstraints(){
    var due=document.querySelector(".js-refund-due");
    if(!due)return;
    var today=new Date();
    today.setHours(0,0,0,0);
    var min=new Date(today.getTime()+7*86400000);
    due.min=min.toISOString().slice(0,10);
  }

  function isFriday(date){return date&&date.getDay()===5}

  function validateRefundDue(){
    var due=document.querySelector(".js-refund-due");
    if(!due)return true;
    var value=due.value;
    if(!value)return true;
    var selected=toDate(value);
    var returnDate=getReturnDate();
    var today=new Date();
    today.setHours(0,0,0,0);
    var min=new Date(today.getTime()+7*86400000);

    if(selected<min){
      notify("Refund Available Date must be at least 7 days ahead.");
      due.value="";
      return false;
    }
    if(isFriday(selected)){
      notify("Friday is not allowed.");
      due.value="";
      return false;
    }
    if(returnDate&&selected&&selected.getTime()===returnDate.getTime()){
      notify("Refund Available Date cannot be the same as Return Date.");
      due.value="";
      return false;
    }
    return true;
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

  function init(){
    initReturnDate();
    initRefundDueConstraints();
    updateBaseFromTotal();
    updateWorkedDays();
    togglePaymentProof();
    syncReason();
    updateSalaryTotal();
    updateFinalBalance();
  }

  init();

  document.addEventListener("input",function(e){
    if(e.target.matches(".js-total-paid")){
      updateBaseFromTotal();
      updateFinalBalance();
    }
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
      validateRefundDue();
    }
    if(e.target.matches(".js-salary-type")){
      togglePaymentProof();
      updateFinalBalance();
    }
    if(e.target.matches(".js-reason-select")){
      syncReason();
    }
    if(e.target.matches(".js-refund-due")){
      validateRefundDue();
    }
  });
})();
</script>
