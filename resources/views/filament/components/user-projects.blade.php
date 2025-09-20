<style>
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .custom-table th {
        background: #f9fafb;
        text-transform: uppercase;
        font-size: 12px;
        color: #6b7280;
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #e5e7eb;
    }

    .custom-table td {
        padding: 8px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    .badge {
        display: inline-block;
        padding: 3px 10px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 9999px;
        color: #fff;
    }

    .badge-orange {
        background-color: #f97316;
        /* orange */
    }

    .badge-green {
        background-color: #16a34a;
        /* green */
    }

    .badge-gray {
        background-color: #6b7280;
        /* fallback */
    }
</style>

<div style="overflow-x: auto;">
    <table class="custom-table">
        <thead>
            <tr>
                <th>Nama Project</th>
                <th>Deskripsi</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description ?: '-' }}</td>
                    <td>
                        {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        @if ($project->status === 'in process')
                            <span class="badge badge-orange">In Process</span>
                        @elseif ($project->status === 'done')
                            <span class="badge badge-green">Done</span>
                        @else
                            <span class="badge badge-gray">{{ ucfirst($project->status) }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
