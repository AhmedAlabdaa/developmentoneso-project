<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign & Share Contract</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #signature-pad { border:1px solid #000; width:100%; height:200px; }
    </style>
</head>
<body>
<div class="container my-4">
    <h4 class="mb-3">Please sign below to confirm you have read and agreed to this contract.</h4>
    <p>يرجى التوقيع أدناه لتأكيد أنك قرأت ووافقت على شروط هذا العقد.</p>

    @include('contracts.partials.show1', ['contract'=>$contract])

    <canvas id="signature-pad"></canvas>

    <button id="clear" class="btn btn-secondary mt-2">Clear</button>

    <form id="signForm" action="{{ route('contracts.storeSignedShare', $contract) }}" method="POST">
        @csrf
        <input type="hidden" name="phone" value="{{ $contract->client->mobile }}">
        <input type="hidden" name="signature" id="signature">
        <button type="submit" class="btn btn-success mt-3">Save & Send on WhatsApp</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById('signature-pad');
    const pad    = new SignaturePad(canvas, { backgroundColor: '#fff' });
    document.getElementById('clear').addEventListener('click', () => pad.clear());
    document.getElementById('signForm').addEventListener('submit', e => {
        if (pad.isEmpty()) {
            alert('Please provide a signature.');
            e.preventDefault();
        } else {
            document.getElementById('signature').value = pad.toDataURL();
        }
    });
    window.addEventListener('resize', () => {
        const data = pad.toData();
        canvas.width = canvas.offsetWidth;
        canvas.height = 200;
        pad.fromData(data);
    });
    window.dispatchEvent(new Event('resize'));
</script>
</body>
</html>
