@php $user=auth()->user(); $limit=\VanguardLTE\DepositLimit::where('user_id',$user->id)->first(); $excl=\VanguardLTE\SelfExclusion::where('user_id',$user->id)->where(function($q){$q->whereNull('ends_at')->orWhere('ends_at','>',now());})->first(); $currency=$user->shop?$user->shop->currency:'USD'; @endphp
<div class="responsible-section">
  <h2 style="color:#e8b84b;font-size:1.1rem;font-weight:700;margin-bottom:8px">Responsible Gambling</h2>
  <p style="color:#888;font-size:.88rem;margin-bottom:20px">We are committed to providing a safe gaming environment.</p>
  <div class="rg-card">
    <h3>🚫 Self Exclusion</h3>
    @if($excl)<div class="alert-box alert-box--warning"><strong>Account excluded until: {{ $excl->ends_at ?? 'Permanently' }}</strong></div>
    @else<p style="color:#888;font-size:.88rem">Temporarily or permanently block yourself from gambling.</p>
    <form action="{{ route('frontend.responsible.exclude') }}" method="POST">@csrf
      <div class="rg-options">
        @foreach(['1'=>'24 Hours','7'=>'7 Days','30'=>'30 Days','180'=>'6 Months','365'=>'1 Year','permanent'=>'Permanent'] as $val=>$label)
        <label><input type="radio" name="period" value="{{ $val }}"> {{ $label }}</label>
        @endforeach
      </div>
      <p style="color:#f1c40f;font-size:.82rem;margin:10px 0">⚠️ Once activated you will be logged out immediately.</p>
      <button type="submit" class="button button-danger" onclick="return confirm('Are you sure? This will log you out and block access.')">Activate Self Exclusion</button>
    </form>@endif
  </div>
  <div class="rg-card">
    <h3>💰 Deposit Limits ({{ $currency }})</h3>
    <form action="{{ route('frontend.responsible.limits') }}" method="POST">@csrf
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:14px">
        <div class="form-row"><label>Daily Limit</label><input type="number" name="daily_limit" class="input-elem" min="0" value="{{ $limit?$limit->daily_limit:'' }}" placeholder="No limit"></div>
        <div class="form-row"><label>Weekly Limit</label><input type="number" name="weekly_limit" class="input-elem" min="0" value="{{ $limit?$limit->weekly_limit:'' }}" placeholder="No limit"></div>
        <div class="form-row"><label>Monthly Limit</label><input type="number" name="monthly_limit" class="input-elem" min="0" value="{{ $limit?$limit->monthly_limit:'' }}" placeholder="No limit"></div>
      </div>
      <button type="submit" class="button button-secondary">Save Limits</button>
    </form>
  </div>
  <div class="rg-card">
    <h3>⏱️ Session Time Limit</h3>
    <form action="{{ route('frontend.responsible.session') }}" method="POST">@csrf
      <div class="form-row"><label>Max Session Duration</label>
        <select name="session_limit" class="input-elem">
          <option value="">No Limit</option>
          @foreach([30,60,90,120,180,240] as $m)<option value="{{ $m }}" {{ $limit&&$limit->session_limit==$m?'selected':'' }}>{{ $m }} minutes</option>@endforeach
        </select>
      </div>
      <button type="submit" class="button button-secondary">Save</button>
    </form>
  </div>
  <div class="rg-card">
    <h3>🔔 Reality Check</h3>
    <form action="{{ route('frontend.responsible.reality') }}" method="POST">@csrf
      <div class="form-row"><label>Remind me every</label>
        <select name="reality_check" class="input-elem">
          <option value="">Disabled</option>
          @foreach([15,30,60,120] as $m)<option value="{{ $m }}" {{ $limit&&$limit->reality_check==$m?'selected':'' }}>{{ $m }} minutes</option>@endforeach
        </select>
      </div>
      <button type="submit" class="button button-secondary">Save</button>
    </form>
  </div>
  <div style="margin-top:16px"><h4 style="color:#888;font-size:.9rem;margin-bottom:8px">Need Help?</h4>
    <div style="display:flex;gap:16px;flex-wrap:wrap">
      <a href="https://www.begambleaware.org" target="_blank" style="color:#3498db;font-size:.85rem">BeGambleAware.org</a>
      <a href="https://www.gamblingtherapy.org" target="_blank" style="color:#3498db;font-size:.85rem">GamblingTherapy.org</a>
    </div>
  </div>
</div>
