@extends('layouts.app')

@section('content')
    <h1>قائمة الشكاوى</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->id }}</td>
                    <td>{{ $complaint->status }}</td>
                    <td>
                        <a href="{{ route('admin.complaints.show', $complaint->id) }}">عرض</a>
                        <form action="{{ route('admin.complaints.delete', $complaint->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $complaints->links() }}
@endsection
