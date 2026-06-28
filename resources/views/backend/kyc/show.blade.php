@extends('backend.layouts.app') @section('page-title','Review Document')
@section('content')
<section class="content"><div class="box"><div class="box-header"><h3>KYC Document Review</h3></div><div class="box-body">
<table class="table table-bordered" style="max-width:600px">
  <tr><th>User</th><td>{{ $doc->user?$doc->user->username:'—' }}</td></tr>
  <tr><th>Type</th><td>{{ ['id_front'=>'ID Front','id_back'=>'ID Back','selfie'=>'Selfie','proof_address'=>'Proof of Address'][$doc->type]??$doc->type }}</td></tr>
  <tr><th>Status</th><td><span class="label label-{{ $doc->status==='approved'?'success':($doc->status==='rejected'?'danger':'warning') }}">{{ ucfirst($doc->status) }}</span></td></tr>
  <tr><th>Submitted</th><td>{{ $doc->created_at }}</td></tr>
  @if($doc->rejection_reason)<tr><th>Rejection Reason</th><td style="color:red">{{ $doc->rejection_reason }}</td></tr>@endif
</table>
<div style="margin:20px 0">
  <a href="{{ route('backend.kyc.file',$doc->id) }}" class="btn btn-default" target="_blank">📥 View/Download Document</a>
</div>
@if($doc->status==='pending')
<div class="btn-group">
  <button class="btn btn-success btn-approve" data-id="{{ $doc->id }}">✅ Approve</button>
  <button class="btn btn-danger btn-reject" data-id="{{ $doc->id }}">❌ Reject</button>
</div>
@endif
<a href="{{ route('backend.kyc.list') }}" class="btn btn-default" style="margin-left:10px">← Back</a>
</div></div></section>
<script>
document.querySelectorAll('.btn-approve').forEach(b=>b.addEventListener('click',()=>{if(!confirm('Approve?'))return;kycAct('/admin/kyc/'+b.dataset.id+'/approve',{});}));
document.querySelectorAll('.btn-reject').forEach(b=>b.addEventListener('click',()=>{var r=prompt('Reason:');if(!r)return;kycAct('/admin/kyc/'+b.dataset.id+'/reject',{reason:r});}));
function kycAct(url,data){data['_token']='{{ csrf_token() }}';fetch(url,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(data)}).then(r=>r.json()).then(d=>{if(d.success)window.location.href='{{ route("backend.kyc.list") }}';else alert(d.error);});}
</script>
@endsection
