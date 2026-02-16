@php
    $sub = explode('.', request()->getHost())[0] ?? 'default';
    $hdr = asset("assets/img/".strtolower($sub)."_header.jpg");
    $ftr = asset("assets/img/".strtolower($sub)."_footer.jpg");
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4; margin: 10px }
        body{margin:10px;font-family:Arial,Helvetica,sans-serif;font-size:13px}
        table{width:100%;border-collapse:collapse}
        th,td{border:1px solid #000;padding:8px;text-align:center;vertical-align:middle}
        .sig-box{margin-top:40px;text-align:center;}
        .sig-img{border-top:1px solid #000;width:300px;margin:0 auto;}
    </style>
</head>
<body>
<img src="{{ $hdr }}" style="width:100%">

@include('contracts.partials.show1', ['contract'=>$contract])

<div class="sig-box">
    <p><strong>Customer Signature / توقيع العميل</strong></p>
    <img src="file://{{ $signaturePath }}" class="sig-img">
    <p>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
</div>

<img src="{{ $ftr }}" style="width:100%">
</body>
</html>
