<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .welcome-box {
            background: #0d6efd;
            color: white;
            padding: 20px;
            border-radius: 8px;
        }

        .carousel img {
            height: 400px;
            object-fit: cover;
        }

        footer {
            background: #212529;
            color: #fff;
            padding: 20px 0;
            margin-top: 50px;
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">MySchoolProject</a>

        <div class="ms-auto">
            <a href="/students/logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<!-- WELCOME -->
<div class="container mt-4">
    <div class="welcome-box text-center shadow">
        <h2>Welcome, {{ session('student_name') }}</h2>
        <p class="mb-0">We are happy to have you at MySchoolProject 🎓</p>
    </div>
</div>

<!-- SLIDER -->
<div class="container mt-4">
    <div id="schoolSlider" class="carousel slide shadow" data-bs-ride="carousel">

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#schoolSlider" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#schoolSlider" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#schoolSlider" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1588072432836-e10032774350" class="d-block w-100" alt="School Image">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to Our School</h5>
                    <p>Learning today, leading tomorrow</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9" class="d-block w-100" alt="Classroom">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Modern Classrooms</h5>
                    <p>Smart education for smart students</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7" class="d-block w-100" alt="Library">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Best Learning Environment</h5>
                    <p>Knowledge is power</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#schoolSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#schoolSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<!-- STUDENT INFO -->
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header fw-bold bg-primary text-white">
            My Profile
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Phone:</strong> {{ $student->phone }}</p>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="text-center">
    <div class="container">
        <p class="fw-bold">MySchoolProject</p>
        <p>Kothariya Chokdi, Rajkot - 360022</p>
        <p>© {{ date('Y') }} MySchoolProject. All Rights Reserved.</p>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
