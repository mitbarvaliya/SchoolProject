

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <h2>Welcome, {{ session('teacher_name') }}</h2>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Add Student Button --}}
    <button class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>

    {{-- Add Student Modal --}}
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="{{ route('teacher.student.store') }}" method="POST">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone">
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Add Student</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <h3 class="mt-4">All Students</h3>

    @if($students->count() > 0)
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Teacher ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone ?? '-' }}</td>
                    <td>{{ $student->teacher_id ?? 'N/A' }}</td>
                    <td>
                        {{-- Update Button triggers modal --}}
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal{{ $student->id }}">Update</button>

                        {{-- Delete Form --}}
                        <form action="{{ route('teacher.student.delete', $student->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                        </form>
                    </td>
                </tr>

                {{-- Update Modal --}}
                <div class="modal fade" id="updateModal{{ $student->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $student->id }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="{{ route('teacher.student.update', $student->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                          <h5 class="modal-title" id="updateModalLabel{{ $student->id }}">Update Student</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="name{{ $student->id }}" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name{{ $student->id }}" name="name" value="{{ old('name', $student->name) }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="email{{ $student->id }}" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email{{ $student->id }}" name="email" value="{{ old('email', $student->email) }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="phone{{ $student->id }}" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone{{ $student->id }}" name="phone" value="{{ old('phone', $student->phone) }}">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                @endforeach
            </tbody>
        </table>
    @else
        <p>No students found.</p>
    @endif
</div>

