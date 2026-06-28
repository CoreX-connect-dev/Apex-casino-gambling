@extends('frontend.Default.layouts.app')
@section('page-title', __('app.my_profile'))
@section('content')
@include('frontend.Default.partials.header_logged')
<div class="page-content profile-page">
  <div class="profile-tabs">
    <a href="#" class="profile-tab active" data-tab="tab-info">{{ __('app.profile') }}</a>
    <a href="#" class="profile-tab" data-tab="tab-deposit">{{ __('app.deposit') }}</a>
    <a href="#" class="profile-tab" data-tab="tab-withdraw">{{ __('app.withdraw') }}</a>
    <a href="#" class="profile-tab" data-tab="tab-history">{{ __('app.history') }}</a>
    <a href="#" class="profile-tab" data-tab="tab-kyc">{{ __('app.verification') }}</a>
    <a href="#" class="profile-tab" data-tab="tab-responsible">{{ __('app.responsible_gambling') }}</a>
  </div>
  <div id="tab-info" class="profile-tab-content">
    <div class="profile-card">
      <h2>{{ __('app.account_details') }}</h2>
      <div class="profile-balance-row">
        <div class="profile-balance-box"><span class="label">{{ __('app.balance') }}</span><span class="value balanceValue">{{ number_format($user->balance,2) }}</span></div>
        <div class="profile-balance-box"><span class="label">{{ __('app.total_in') }}</span><span class="value">{{ number_format($user->total_in,2) }}</span></div>
        <div class="profile-balance-box"><span class="label">{{ __('app.total_out') }}</span><span class="value">{{ number_format($user->total_out,2) }}</span></div>
      </div>
      <form id="profile-form" action="{{ route('frontend.profile.update') }}" method="POST">@csrf
        <div class="form-row"><label>{{ __('app.username') }}</label><input type="text" name="username" value="{{ $user->username }}" class="input-elem" required></div>
        <div class="form-row"><label>{{ __('app.email') }}</label><input type="email" name="email" value="{{ $user->email }}" class="input-elem"></div>
        <div class="form-row"><label>{{ __('app.phone') }}</label><input type="text" name="phone" value="{{ $user->phone }}" class="input-elem" placeholder="+1234567890"></div>
        <button type="submit" class="button button-secondary">{{ __('app.save') }}</button>
      </form>
      <hr class="divider">
      <h3>{{ __('app.change_password') }}</h3>
      <form id="password-form" action="{{ route('frontend.profile.password') }}" method="POST">@csrf
        <div class="form-row"><label>{{ __('app.current_password') }}</label><input type="password" name="old_password" class="input-elem" required></div>
        <div class="form-row"><label>{{ __('app.new_password') }}</label><input type="password" name="password" class="input-elem" required></div>
        <div class="form-row"><label>{{ __('app.confirm_password') }}</label><input type="password" name="password_confirmation" class="input-elem" required></div>
        <button type="submit" class="button button-secondary">{{ __('app.change_password') }}</button>
      </form>
    </div>
  </div>
  <div id="tab-deposit" class="profile-tab-content" style="display:none"><div class="profile-card"><h2>{{ __('app.deposit') }}</h2>@include('frontend.Default.profile.deposit')</div></div>
  <div id="tab-withdraw" class="profile-tab-content" style="display:none"><div class="profile-card"><h2>{{ __('app.withdraw') }}</h2>@include('frontend.Default.profile.withdraw')</div></div>
  <div id="tab-history" class="profile-tab-content" style="display:none"><div class="profile-card"><h2>{{ __('app.transaction_history') }}</h2>@include('frontend.Default.profile.transactions')</div></div>
  <div id="tab-kyc" class="profile-tab-content" style="display:none"><div class="profile-card">@include('frontend.Default.kyc.index')</div></div>
  <div id="tab-responsible" class="profile-tab-content" style="display:none"><div class="profile-card">@include('frontend.Default.responsible.index')</div></div>
</div>
<script>
document.querySelectorAll('.profile-tab').forEach(function(tab){
  tab.addEventListener('click',function(e){
    e.preventDefault();
    document.querySelectorAll('.profile-tab').forEach(t=>t.classList.remove('active'));
    document.querySelectorAll('.profile-tab-content').forEach(t=>t.style.display='none');
    tab.classList.add('active');
    var el=document.getElementById(tab.getAttribute('data-tab'));
    if(el) el.style.display='block';
  });
});
['profile-form','password-form'].forEach(function(id){
  var f=document.getElementById(id);
  if(f) f.addEventListener('submit',function(e){
    e.preventDefault();
    fetch(f.action,{method:'POST',body:new FormData(f),headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(d=>{
      var el=document.createElement('div');
      el.style.cssText='position:fixed;top:20px;right:20px;z-index:9999;padding:12px 20px;border-radius:8px;color:#fff;font-size:.9rem';
      if(d.success){el.style.background='#27ae60';el.innerText=d.success;}else{el.style.background='#e74c3c';el.innerText=d.error||'Error';}
      document.body.appendChild(el);setTimeout(()=>el.remove(),4000);
    });
  });
});
</script>
@endsection
