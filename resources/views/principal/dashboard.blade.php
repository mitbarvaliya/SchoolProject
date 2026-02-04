<!DOCTYPE html>
<html>
<head>
    <title>Principal Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container-fluid mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Welcome, {{ session('principal_name') }}</h3>

        <form action="{{ route('principal.logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>

    <!-- FLASH MESSAGE -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- ================= STUDENTS ================= -->
    <div class="card mb-5 shadow">
        <div class="card-header fw-bold bg-primary text-white">
            All Students
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <form method="POST" action="/principal/student/update/{{ $student->id }}">
                            @csrf
                            <td>
                                <input type="text" name="name" value="{{ $student->name }}" class="form-control">
                            </td>
                            <td>
                                <input type="email" name="email" value="{{ $student->email }}" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="phone" value="{{ $student->phone }}" class="form-control">
                            </td>
                            <td class="d-flex gap-2">
                                <button class="btn btn-success btn-sm">Update</button>
                                <a href="/principal/student/delete/{{ $student->id }}"
                                   onclick="return confirm('Delete this student?')"
                                   class="btn btn-danger btn-sm">
                                   Delete
                                </a>
                            </td>
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= TEACHERS ================= -->
    <div class="card shadow">
        <div class="card-header fw-bold bg-dark text-white">
            All Teachers
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($teachers as $teacher)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <form method="POST" action="/principal/teacher/update/{{ $teacher->id }}">
                            @csrf
                            <td>
                                <input type="text" name="name" value="{{ $teacher->name }}" class="form-control">
                            </td>
                            <td>
                                <input type="email" name="email" value="{{ $teacher->email }}" class="form-control">
                            </td>
                            <td class="d-flex gap-2">
                                <button class="btn btn-success btn-sm">Update</button>
                                <a href="/principal/teacher/delete/{{ $teacher->id }}"
                                   onclick="return confirm('Delete this teacher?')"
                                   class="btn btn-danger btn-sm">
                                   Delete
                                </a>
                            </td>
                        </form>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
