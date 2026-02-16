<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body{font-family:DejaVu Sans, Arial, sans-serif;font-size:10px}
    h3{margin:0 0 10px 0;font-size:14px}
    table{width:100%;border-collapse:collapse}
    th,td{border:1px solid #444;padding:6px;vertical-align:top}
    th{background:#eee}
  </style>
</head>
<body>
  <h3>{{ $title }}</h3>
  <table>
    <thead>
      <tr>
        @foreach($headings as $h)
          <th>{{ $h }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach($rows as $r)
        <tr>
          @foreach($r as $c)
            <td>{{ $c }}</td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
