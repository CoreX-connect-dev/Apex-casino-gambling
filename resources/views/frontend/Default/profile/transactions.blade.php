@php $stats=\VanguardLTE\Statistic::where('user_id',auth()->id())->orderBy('id','DESC')->limit(50)->get(); $currency=auth()->user()->shop?auth()->user()->shop->currency:''; @endphp
@if($stats->count()===0)<p class="no-data">No transactions yet.</p>
@else
<div class="table-wrap"><table class="data-table">
  <thead><tr><th>#</th><th>Date</th><th>Type</th><th>System</th><th>Amount</th></tr></thead>
  <tbody>
  @foreach($stats as $s)
  <tr>
    <td>{{ $s->id }}</td>
    <td style="font-size:.82rem;color:#888">{{ $s->created_at }}</td>
    <td><span class="badge {{ $s->type==='add'?'badge--success':'badge--danger' }}">{{ $s->type==='add'?'+ Deposit':'- Withdraw' }}</span></td>
    <td style="color:#888">{{ strtoupper($s->system) }}</td>
    <td class="{{ $s->type==='add'?'text-green':'text-red' }}" style="font-weight:700">{{ $s->type==='add'?'+':'-' }}{{ number_format($s->sum,2) }} {{ $currency }}</td>
  </tr>
  @endforeach
  </tbody>
</table></div>
@endif
