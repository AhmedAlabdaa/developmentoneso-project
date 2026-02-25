<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Action Notification</title>
    <style>
        body{margin:0;padding:0;background:#f5f7fb;font-family:Arial,Helvetica,sans-serif;}
        .wrapper{width:100%;background:#f5f7fb;padding:30px 0;}
        .container{max-width:600px;margin:0 auto;background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(15,35,52,0.08);}
        .header{padding:24px 20px 8px;text-align:center;}
        .logo{max-width:200px;height:auto;display:inline-block;}
        .content{padding:0 32px 28px;font-size:14px;line-height:1.6;color:#243b53;}
        .greeting{font-size:16px;font-weight:600;margin-bottom:12px;}
        .summary{margin:10px 0 18px;font-size:14px;}
        .details-title{font-size:15px;font-weight:600;margin:20px 0 10px;}
        .details-table{width:100%;border-collapse:collapse;font-size:13px;}
        .details-table th,
        .details-table td{padding:8px 6px;text-align:left;border-bottom:1px solid #e1e7f0;}
        .details-table th{width:35%;font-weight:600;color:#52606d;background:#f8fafc;}
        .details-table td{color:#243b53;}
        .note-block{margin-top:14px;padding:10px 12px;background:#f8fafc;border-radius:4px;font-size:13px;color:#52606d;}
        .button-row{margin:24px 0 12px;text-align:center;}
        .btn{display:inline-block;padding:10px 22px;border-radius:4px;background:#00a6e0;color:#ffffff;text-decoration:none;font-size:14px;}
        .footer{padding:16px 32px 24px;font-size:11px;color:#7b8794;text-align:center;background:#f8fafc;}
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <div class="header">
            <img src="https://tadbeeralebdaa.onesourceerp.com/assets/img/tadbeeralebdaa_logo.png"
                 alt="OneSource ERP" class="logo">
        </div>

        <div class="content">
            <p class="greeting">Dear Team,</p>

            <p class="summary">
                You have received a new action notification from <strong>OneSource ERP</strong>.
            </p>

            <p>
                Action performed: <strong>{{ $action }}</strong>
            </p>

            <p class="details-title">Action Details</p>
            <table class="details-table">
                <tr>
                    <th>Candidate Name</th>
                    <td>{{ $candidate_name }}</td>
                </tr>
                <tr>
                    <th>Passport No.</th>
                    <td>{{ $passport_no ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Reference No.</th>
                    <td>{{ $ref_no ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Foreign Partner</th>
                    <td>{{ $foreign_partner ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td>{{ $action }}</td>
                </tr>
                <tr>
                    <th>Action Date</th>
                    <td>{{ $action_date ?: '-' }}</td>
                </tr>
            </table>

            @if(!empty($other))
                <div class="note-block">
                    <strong>Notes / Reason:</strong><br>
                    {!! nl2br(e($other)) !!}
                </div>
            @endif

            <p style="margin-top:20px;">
                Please review the details and proceed as required.
            </p>

            <p>Thank you,<br>OneSource ERP</p>
        </div>

        <div class="footer">
            <p>This is an automated message from the OneSource ERP system. Please do not reply to this email.</p>
        </div>
    </div>
</div>
</body>
</html>
