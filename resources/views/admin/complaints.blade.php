@extends('layouts.app')

@section('content')
    <style>
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto 20px auto;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        thead {
            background: #f4f4f4;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }

        a {
            color: #3490dc;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            display: inline;
        }

        button {
            background: #e3342f;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #cc1f1a;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>

    <h1> Lijst met klachten </h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Melder</th>
                <th>Status</th>
                <th>Procedures</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($complaints as $complaint)
            
                <tr>
                    <td>{{ $complaint->id }}</td>
                    <td>{{ $complaint->melder->naam ?? 'غير معروف' }}</td>
                    <td>{{ $complaint->status }}</td>
                    <td>
                        <a href="{{ route('admin.complaints.show', $complaint->id) }}">view</a>
                        <form action="{{ route('admin.complaints.delete', $complaint->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $complaints->links() }}
    </div>
@endsection
