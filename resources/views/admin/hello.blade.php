<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Hello - The Notorious</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-secondary text-white shadow">
                    <div class="card-body text-center py-5">
                        <h1 class="display-1 mb-4">⚙️</h1>
                        <h1 class="display-4 fw-bold mb-3">Admin Hello!</h1>
                        <p class="lead mb-4">Chào mừng đến trang quản trị The Notorious</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-warning btn-lg w-100">
                                    <i class="fas fa-boxes me-2"></i>Quản lý sản phẩm
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('client.products.index') }}" class="btn btn-outline-light btn-lg w-100">
                                    <i class="fas fa-home me-2"></i>Về trang chủ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
