@php $user=auth()->user(); $currency=$user->shop?$user->shop->currency:'USD'; @endphp
<div class="withdraw-section">
  <div style="background:var(--bg-input);border-radius:var(--radius);padding:12px 16px;margin-bottom:16px;display:flex;justify-content:space-between;align-items:center">
    <span style="color:#888">{{ __('app.available_to_withdraw') }}</span>
    <strong style="color:#e8b84b;font-size:1.1rem">{{ number_format($user->balance,2) }} {{ $currency }}</strong>
  </div>
  <form id="withdraw-form" action="{{ route('frontend.profile.withdraw') }}" method="POST">@csrf
    <div class="form-row"><label>{{ __('app.amount') }}</label><input type="number" name="amount" class="input-elem" min="1" max="{{ $user->balance }}" step="0.01" required></div>
    <div class="form-row"><label>{{ __('app.wallet_address') }}</label><input type="text" name="wallet" class="input-elem" placeholder="Enter your wallet address" required></div>
    <div class="form-row"><label>Currency</label><select name="currency" class="input-elem"><option>{{ $currency }}</option><option>BTC</option><option>ETH</option><option>USDT</option></select></div>
    <div class="alert-box alert-box--info">Withdrawals processed within 24-48 hours after admin approval.</div>
    <button type="submit" class="button button-secondary">{{ __('app.submit_withdrawal') }}</button>
  </form>
</div>
<script>
document.getElementById('withdraw-form').addEventListener('submit',function(e){
  e.preventDefault();
  fetch(this.action,{method:'POST',body:new FormData(this),headers:{'X-Requested-With':'XMLHttpRequest'}})
  .then(r=>r.json()).then(d=>{
    var el=document.createElement('div');el.style.cssText='position:fixed;top:20px;right:20px;z-index:9999;padding:12px 20px;border-radius:8px;color:#fff';
    if(d.success){el.style.background='#27ae60';el.innerText=d.success;setTimeout(()=>location.reload(),1500);}
    else{el.style.background='#e74c3c';el.innerText=d.error||'Error';}
    document.body.appendChild(el);setTimeout(()=>el.remove(),4000);
  });
});
</script>
