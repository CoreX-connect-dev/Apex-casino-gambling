@php $user=auth()->user(); $docs=\VanguardLTE\KycDocument::where('user_id',$user->id)->get()->keyBy('type'); $types=['id_front'=>'Government ID — Front','id_back'=>'Government ID — Back','selfie'=>'Selfie Holding ID','proof_address'=>'Proof of Address']; @endphp
<div class="kyc-section">
  <h2>Identity Verification</h2>
  <div class="alert-box alert-box--info"><p>Upload the documents below to verify your identity. Required for withdrawals.</p></div>
  <div class="kyc-documents">
    @foreach($types as $type=>$label)
    @php $doc=$docs->get($type); @endphp
    <div class="kyc-doc-card">
      <div class="kyc-doc-header">
        <span style="font-weight:600">{{ $label }}</span>
        @if($doc)
          @if($doc->status==='approved')<span class="badge badge--success">✅ Approved</span>
          @elseif($doc->status==='rejected')<span class="badge badge--danger">❌ Rejected</span>
          @else<span class="badge badge--pending">⏳ Under Review</span>@endif
        @else<span class="badge badge--grey">Not Uploaded</span>@endif
      </div>
      @if($doc&&$doc->status==='rejected')<p style="color:#e74c3c;font-size:.82rem;margin-bottom:8px">Reason: {{ $doc->rejection_reason }}</p>@endif
      @if(!$doc||$doc->status==='rejected')
      <form class="kyc-upload-form" action="{{ route('frontend.kyc.upload') }}" method="POST" enctype="multipart/form-data">@csrf
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="kyc-upload-area">
          <input type="file" name="document" id="file-{{ $type }}" accept="image/jpeg,image/png,application/pdf" required style="display:none">
          <label for="file-{{ $type }}" class="kyc-upload-label"><span style="font-size:2rem">📎</span><span>Click to upload</span><small>JPG, PNG or PDF — max 5MB</small></label>
          <div class="kyc-file-preview" id="preview-{{ $type }}" style="display:none"></div>
        </div>
        <button type="submit" class="button button-secondary" style="width:100%;margin-top:8px">Submit Document</button>
      </form>
      @elseif($doc&&$doc->status==='pending')<p style="color:#f1c40f;font-size:.85rem;margin-top:8px">📋 Document is under review. We'll notify you within 24-48 hours.</p>
      @elseif($doc&&$doc->status==='approved')<p style="color:#27ae60;font-size:.85rem;margin-top:8px">✅ Approved on {{ $doc->reviewed_at }}</p>@endif
    </div>
    @endforeach
  </div>
</div>
<script>
document.querySelectorAll('.kyc-upload-form').forEach(function(form){
  var inp=form.querySelector('input[type=file]'), preview=form.querySelector('.kyc-file-preview'), type=form.querySelector('input[name=type]').value;
  inp.addEventListener('change',function(){if(this.files[0]){preview.style.display='block';preview.innerText='📄 '+this.files[0].name+' ('+(this.files[0].size/1024).toFixed(1)+' KB)';}});
  form.addEventListener('submit',function(e){
    e.preventDefault();
    var btn=form.querySelector('[type=submit]');btn.disabled=true;btn.innerText='Uploading...';
    fetch(form.action,{method:'POST',body:new FormData(form),headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(function(d){
      if(d.success){btn.innerText='✅ Uploaded';setTimeout(()=>location.reload(),1200);}
      else{btn.disabled=false;btn.innerText='Submit Document';alert(d.error||'Upload failed');}
    });
  });
});
</script>
