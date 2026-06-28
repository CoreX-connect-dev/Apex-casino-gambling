@php $user=auth()->user(); $shop_id=$user->shop_id; $credits=\VanguardLTE\Credit::all(); $currency=$user->shop?$user->shop->currency:'USD'; @endphp
<div class="deposit-section">
  @if($credits->count()>0)
  <div class="deposit-credits">
    <h4>{{ __('app.select_package') }}</h4>
    <div class="credits-grid">
      @foreach($credits as $credit)
      <div class="credit-card js-credit-select{{ $loop->first?' selected':'' }}" data-credit-id="{{ $credit->id }}" data-price="{{ $credit->price }}">
        <span class="credit-coins">{{ $credit->credit }} {{ $currency }}</span>
        <span class="credit-price">{{ $credit->price }} {{ $currency }}</span>
      </div>
      @endforeach
    </div>
    <p style="text-align:center;color:#888;font-size:.82rem;margin:14px 0">— or enter custom amount —</p>
  </div>
  @endif
  <div class="form-row"><label>{{ __('app.amount') }} ({{ $currency }})</label><input type="number" id="deposit-amount" class="input-elem" min="1" step="0.01" placeholder="{{ __('app.enter_amount') }}"></div>
  <div class="deposit-methods">
    <h4>{{ __('app.select_payment_method') }}</h4>
    <div class="methods-grid">
      <button class="method-btn js-deposit-btn" data-system="interkassa"><span>💳 Interkassa</span></button>
      <button class="method-btn js-deposit-btn" data-system="coinbase"><span>₿ Coinbase</span></button>
      <button class="method-btn js-deposit-btn" data-system="btcpayserver"><span>🔐 BtcPayServer</span></button>
    </div>
  </div>
  <div id="deposit-loading" style="display:none" class="loading-spinner">Processing...</div>
  <div id="deposit-error" class="alert-box alert-box--error" style="display:none"></div>
</div>
<form id="deposit-post-form" method="POST" action="" style="display:none">@csrf<div id="deposit-post-fields"></div></form>
<script>
var selCreditId=null;
document.querySelectorAll('.js-credit-select').forEach(function(c){
  c.addEventListener('click',function(){
    document.querySelectorAll('.js-credit-select').forEach(x=>x.classList.remove('selected'));
    c.classList.add('selected'); selCreditId=c.dataset.creditId;
    document.getElementById('deposit-amount').value=c.dataset.price;
  });
});
document.querySelectorAll('.js-deposit-btn').forEach(function(btn){
  btn.addEventListener('click',function(){
    var system=btn.dataset.system, amount=document.getElementById('deposit-amount').value;
    if(!selCreditId&&(!amount||parseFloat(amount)<1)){document.getElementById('deposit-error').innerText='Please enter amount';document.getElementById('deposit-error').style.display='block';return;}
    document.getElementById('deposit-loading').style.display='block';
    document.getElementById('deposit-error').style.display='none';
    var body=new FormData();
    body.append('_token','{{ csrf_token() }}');body.append('system',system);
    if(selCreditId)body.append('credit_id',selCreditId);else body.append('sum',amount);
    fetch('{{ route("frontend.deposit.create") }}',{method:'POST',body:body,headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(function(data){
      document.getElementById('deposit-loading').style.display='none';
      if(data.error){document.getElementById('deposit-error').innerText=data.error;document.getElementById('deposit-error').style.display='block';return;}
      if(data.status==='redirect'){
        if(data.method==='GET'){window.location.href=data.url;}
        else{var f=document.getElementById('deposit-post-form');f.action=data.url;var d=document.getElementById('deposit-post-fields');d.innerHTML='';Object.keys(data.fields||{}).forEach(function(k){var i=document.createElement('input');i.type='hidden';i.name=k;i.value=data.fields[k];d.appendChild(i);});f.submit();}
      }
    }).catch(function(){document.getElementById('deposit-loading').style.display='none';document.getElementById('deposit-error').innerText='Failed. Try again.';document.getElementById('deposit-error').style.display='block';});
  });
});
</script>
