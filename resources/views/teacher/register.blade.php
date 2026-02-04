<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">Teacher Registration</h4>

                    <form method="POST" action="{{ route('teacher.register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" class="form-control" placeholder="Enter your name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" placeholder="Enter password">
                        </div>

                        <button class="btn btn-primary w-100">Register</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
