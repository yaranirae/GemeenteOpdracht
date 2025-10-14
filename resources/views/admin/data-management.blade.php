<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة البيانات - Gemeente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }

        .border-left-warning {
            border-left: 4px solid #f6c23e !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">إدارة البيانات والخصوصية</h6>
                    </div>
                    <div class="card-body">

                        <!-- إحصائيات البيانات -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card border-left-primary">
                                    <div class="card-body">
                                        <h6>إجمالي المشتكين</h6>
                                        <h3>{{ $dataStats['totalMelders'] }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-left-warning">
                                    <div class="card-body">
                                        <h6>مشتكين قدامى</h6>
                                        <h3>{{ $dataStats['oldMelders'] }}</h3>
                                        <small>أكثر من 3 دقائق</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- سياسات الاحتفاظ -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>سياسات الاحتفاظ بالبيانات</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>نوع البيانات</th>
                                                <th>فترة الاحتفاظ</th>
                                                <th>السبب</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataStats['retentionPeriods'] as $type => $policy)
                                                <tr>
                                                    <td>{{ $type === 'complaints' ? 'الشكاوى' : 'بيانات المشتكين' }}</td>
                                                    <td>{{ $policy['period'] }} دقائق</td>
                                                    <td>{{ $policy['description'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- إجراءات الخصوصية -->
                        <div class="row">
                            <div class="col-12">
                                <h5>إجراءات الخصوصية</h5>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    نلتزم بحماية بياناتكم الشخصية وعدم تخزين ما هو غير ضروري لخدمتكم.
                                </div>

                                <form action="{{ route('admin.execute-data-cleanup') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning"
                                        onclick="return confirm('هل أنت متأكد من تجهيل البيانات القديمة؟')">
                                        <i class="fas fa-user-shield"></i>
                                        تجهيل البيانات القديمة تلقائياً
                                    </button>
                                </form>

                                <a href="/admin/dashboard" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> العودة للوحة التحكم
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>