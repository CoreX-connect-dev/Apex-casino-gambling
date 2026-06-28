@extends('backend.layouts.app') @section('page-title','Withdrawals') @section('page-heading','Withdrawal Requests')
@section('content')
<section class="content"><div class="box"><div class="box-header">
  <div class="btn-group">
    <a href="?status=0" class="btn {{ $status=='0'?'btn-warning':'btn-default' }}">⏳ Pending</a>
    <a href="?status=1" class="btn {{ $status=='1'?'btn-success':'btn-default' }}">✅ Approved</a>
    <a href="?status=2" class="btn {{ $status=='2'?'btn-danger':'btn-default' }}">❌ Rejected</a>
    <a href="?status=all" class="btn {{ $status=='all'?'btn-primary':'btn-default' }}">All</a>
  </div>
</div><div class="box-body table-responsive">
<table class="table table-bordered table-hover"><thead><tr><th>#</th><th>User</th><th>Amount</th><th>Currency</th><th>Wallet</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead><tbody>
@forelse($withdrawals as $w)
<tr><td>{{ $w->id }}</td><td>{{ $w->user?$w->user->username:'—' }}</td>
<td><strong>{{ number_format($w->amount,2) }}</strong></td>
<td>{{ $w->currency }}</td><td><small>{{ Str::limit($w->wallet,24) }}</small></td>
<td><span class="label label-{{ $w->status==1?'success':($w->status==2?'danger':'warning') }}">{{ ['Pending','Approved','Rejected'][$w->status]??'Unknown' }}</span></td>
<td>{{ $w->created_at }}</td>
<td>@if($w->status==0)
  <button class="btn btn-xs btn-success btn-wd-approve" data-id="{{ $w->id }}">✅ Approve</button>
  <button class="btn btn-xs btn-danger btn-wd-reject" data-id="{{ $w->id }}">❌ Reject</button>
@endif</td></tr>
@empty<tr><td colspan="8" class="text-center">No withdrawals found</td></tr>@endforelse
</tbody></table>{{ $withdrawals->links() }}
</div></div></section>
<script>
document.querySelectorAll('.btn-wd-approve').forEach(b=>b.addEventListener('click',()=>{if(!confirm('Approve this withdrawal?'))return;wdAct('/admin/withdrawals/'+b.dataset.id+'/approve',{});}));
document.querySelectorAll('.btn-wd-reject').forEach(b=>b.addEventListener('click',()=>{var r=prompt('Rejection reason (optional):');wdAct('/admin/withdrawals/'+b.dataset.id+'/reject',{reason:r||''});}));
function wdAct(url,data){data['_token']='{{ csrf_token() }}';fetch(url,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(data)}).then(r=>r.json()).then(d=>{if(d.success)location.reload();else alert(d.error||'Error');});}
</script>
@endsection
