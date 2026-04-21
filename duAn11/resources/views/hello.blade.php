<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World - The Notorious</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <h1 class="display-1 text-primary mb-4">👋</h1>
                        <h1 class="display-4 fw-bold text-dark mb-3">Hello World!</h1>
                        <p class="lead text-muted mb-4">Chào mừng đến với The Notorious - Thương hiệu thời trang thể thao</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('client.products.index') }}" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-shopping-bag me-2"></i>Xem sản phẩm
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                                    <i class="fas fa-cog me-2"></i>Quản trị
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
