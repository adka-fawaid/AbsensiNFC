<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sistem Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .login-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .login-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>
<body>
    <div class="login-container d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="login-card">
                        <!-- Header -->
                        <div class="login-header p-4 text-center">
                            <img src="{{ asset('images/logo-bem.png') }}" alt="Logo BEM" style="width: 100px; height: 110px;">
                            <h3 class="mt-1 mb-0">BEM Admin</h3>
                            <p class="mb-0 opacity-75">Sistem Absensi NFC</p>
                        </div>

                        <div class="p-4">
                            <!-- Alert Messages -->
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li><i class="bi bi-x-circle me-1"></i>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Login Form -->
                            <form action="{{ route('admin.login') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="bi bi-envelope me-1"></i>Email
                                    </label>
                                    <input type="email" class="form-control form-control-lg" 
                                           id="email" name="email" value="{{ old('email') }}" 
                                            required autofocus>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-lock me-1"></i>Password
                                    </label>
                                    <input type="password" class="form-control form-control-lg" 
                                           id="password" name="password" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        Login
                                    </button>
                                </div>
                            </form>

                            <!-- Info Default Login -->
                            <div class="mt-4 p-3 bg-light rounded">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    <strong>Default Login:</strong><br>
                                    Email: admin@admin.com<br>
                                    Password: password
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-3">
                        <small class="text-white opacity-75">
                            © {{ date('Y') }} Sistem Absensi. All rights reserved.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>