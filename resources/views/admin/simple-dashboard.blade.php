<!DOCTYPE html>
<html>
<head>
    <title>Test Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: red; } /* لون خلفية واضح للاختبار */
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-primary">Test Dashboard</h1>
        <p>If you see this with styles, then the issue is in your main dashboard file.</p>
        <p>Total Complaints: {{ $totalComplaints }}</p>
    </div>
</body>
</html>