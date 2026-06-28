@extends('backend.layouts.app') @section('page-title','KYC Review') @section('page-heading','KYC Document Review')
@section('content')
<section class="content"><div class="box"><div class="box-header">
  <div class="btn-group">
    <a href="?status=pending" class="btn {{ $status=='pending'?'btn-warning':'btn-default' }}">⏳ Pending</a>
    <a href="?status=approved" class="btn {{ $status=='approved'?'btn-success':'btn-default' }}">✅ Approved</a>
    <a href="?status=rejected" class="btn {{ $status=='rejected'?'btn-danger':'btn-default' }}">❌ Rejected</a>
    <a href="?status=all" class="btn {{ $status=='all'?'btn-primary':'btn-default' }}">All</a>
  </div>
</div><div class="box-body table-responsive">
<table class="table table-bordered table-hover"><thead><tr><th>#</th><th>User</th><th>Document</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead><tbody>
@forelse($docs as $doc)
<tr><td>{{ $doc->id }}</td><td>{{ $doc->user?$doc->user->username:'—' }}</td>
<td>{{ ['id_front'=>'ID Front','id_back'=>'ID Back','selfie'=>'Selfie','proof_address'=>'Proof of Address'][$doc->type]??$doc->type }}</td>
<td><span class="label label-{{ $doc->status==='approved'?'success':($doc->status==='rejected'?'danger':'warning') }}">{{ ucfirst($doc->status) }}</span></td>
<td>{{ $doc->created_at }}</td>
<td>
  <a href="{{ route('backend.kyc.show',$doc->id) }}" class="btn btn-xs btn-info">👁 View</a>
  @if($doc->status==='pending')
  <button class="btn btn-xs btn-success btn-approve" data-id="{{ $doc->id }}">✅ Approve</button>
  <button class="btn btn-xs btn-danger btn-reject" data-id="{{ $doc->id }}">❌ Reject</button>
  @endif
</td></tr>
@empty<tr><td colspan="6" class="text-center">No documents found</td></tr>@endforelse
</tbody></table>{{ $docs->links() }}
</div></div></section>
<script>
document.querySelectorAll('.btn-approve').forEach(b=>b.addEventListener('click',()=>{if(!confirm('Approve?'))return;kycAct('/admin/kyc/'+b.dataset.id+'/approve',{});}));
document.querySelectorAll('.btn-reject').forEach(b=>b.addEventListener('click',()=>{var r=prompt('Reason:');if(!r)return;kycAct('/admin/kyc/'+b.dataset.id+'/reject',{reason:r});}));
function kycAct(url,data){data['_token']='{{ csrf_token() }}';fetch(url,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(data)}).then(r=>r.json()).then(d=>{if(d.success)location.reload();else alert(d.error||'Error');});}
</script>
@endsection
