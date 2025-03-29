<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jsPDF and jsPDF-AutoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <style>
        .student-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">{{ $schoolName ?? 'DPSG' }}</h2>
        <h3 class="mb-4">Student Records</h3>

        <div class="mb-3">
            <button class="btn btn-primary me-2" onclick="exportCSV()">Export to CSV</button>

        </div>

        <table id="studentTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>S/N</th>
                    <th>Matric No</th>
                    <th>StudentID</th>
                    <th>Surname</th>
                    <th>Firstname</th>
                    <th>Othername</th>
                    <th>Gender</th>
                    <th>Programme Type</th>
                    <th>Level</th>
                    <th>Course of Study</th>
                    <th>Passport Name</th>
                    <th>Passport</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($std_lists as $std_list)
                <tr>
                    <td> {{$loop->iteration}} </td>
                    <td>{{ $std_list->matric_no }}</td>
                    <td>{{ $std_list->cs_status == 0 ? 'assigned' : $std_list->cs_status  }}</td>
                    <td>{{ $std_list->surname }} </td>
                    <td> {{ $std_list->firstname }} </td>
                    <td> {{ $std_list->othernames }}</td>
                    <td> {{ $std_list->gender }}</td>
                    <td> {{ $std_list->programmeType->programmet_aname }}</td>
                    <td> {{ $std_list->level->level_name }}</td>
                    <td> {{ $std_list->stdcourseOption->programme_option }}</td>
                    <td>{{ $std_list->std_photo }}</td>
                    <td>
                        @php
                        $filePath = '/home/prtald/public_html/eportal/storage/app/public/passport/' . $std_list->std_photo;
                        $fileExists = file_exists($filePath);
                        @endphp

                        @if ($fileExists)
                        <img src="{{ 'https://portal.mydspg.edu.ng/eportal/storage/app/public/passport/' . $std_list->std_photo }}" width="100" height="80">
                        @else
                        <img src="{{ 'https://portal.mydspg.edu.ng/eportal/public/avatar.jpg' }}" width="100" height="80">
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script>
        function exportCSV() {
            const table = document.getElementById('studentTable');
            const rows = Array.from(table.querySelectorAll('tr'));
            const csv = rows.map(row => {
                const cells = Array.from(row.querySelectorAll('th, td'));
                return cells.map(cell => {
                    if (cell.querySelector('img')) {
                        return `"${cell.querySelector('img').src}"`;
                    }
                    return `"${cell.textContent.trim()}"`;
                }).join(',');
            }).join('\n');

            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'students.csv';
            a.click();
            window.URL.revokeObjectURL(url);
        }
    </script>
</body>

</html>