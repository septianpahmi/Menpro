@php
    use Carbon\Carbon;
    use Carbon\CarbonPeriod;

    $task = $getRecord();
    $project = $task->project;

    $start = Carbon::parse($project->start_date);
    $end = Carbon::parse($project->end_date);

    // generate hari kerja saja
    $dates = collect(CarbonPeriod::create($start, $end))->filter(
        fn($d) => !in_array($d->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]),
    );

    // group per minggu
    $weeks = $dates->groupBy(fn($date) => $date->format('Y-m-W'));
@endphp

<style>
    table.timeline {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }

    table.timeline th,
    table.timeline td {
        border: 1px solid #444;
        padding: 4px 6px;
        text-align: center;
        height: 25px;
        min-width: 25px;
    }

    table.timeline th {
        background: #f3f3f3;
        font-weight: bold;
    }

    table.timeline .month-header {
        background: #e2e8f0;
        /* abu2 */
        font-size: 13px;
    }

    table.timeline .week-header {
        background: #faf089;
        /* kuning */
    }

    table.timeline .active {
        background: #ef4444;
        /* merah tailwind */
        color: #fff;
        font-weight: bold;
    }
</style>
<h2 style="text-align: center; font-size: 18px; font-weight: bold;">
    Schedule Pekerjaan Interior
</h2>
<div style="text-align: center; margin-top: 5px; font-size: 14px;">
    <strong>CV. APRILIA PROJECT</strong>
</div>
<div style="display: flex; justify-content: space-between; margin-top: 15px; margin-bottom: 10px; font-size: 14px;">
    <strong>Project : {{ $project->name }}</strong>
</div>
<table class="timeline">
    <thead>
        {{-- Baris Bulan --}}
        <tr>
            <th rowspan="3">No</th>
            <th rowspan="3">Item Pekerjaan</th>
            <th rowspan="3">Durasi</th>
            <th rowspan="3">Start</th>
            <th rowspan="3">Finish</th>

            @foreach ($weeks->groupBy(fn($w) => $w->first()->format('F Y')) as $month => $monthWeeks)
                <th colspan="{{ $monthWeeks->count() }}" class="month-header">
                    {{ $month }}
                </th>
            @endforeach
        </tr>

        {{-- Baris Minggu --}}
        <tr>
            {{-- @foreach ($weeks as $key => $days)
                @php $weekOfMonth = ceil($days->first()->day / 7); @endphp
                <th class="week-header">Minggu ke-{{ $weekOfMonth }}</th>
            @endforeach --}}
        </tr>

        {{-- Baris Range Tanggal --}}
        <tr>
            @foreach ($weeks as $days)
                <th>{{ $days->first()->format('d') }}–{{ $days->last()->format('d') }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($project->tasks as $i => $task)
            {{-- Header Task (A, B, C, ...) --}}
            <tr style="background: #fde68a; font-weight: bold;">
                <td>{{ chr(65 + $i) }}</td> {{-- A, B, C, D --}}
                <td colspan="{{ 4 + $weeks->count() }}" style="text-align: left;">
                    {{ $task->name }}
                </td>
            </tr>
            @foreach ($task->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="text-align: left;">{{ $item->name }}</td>
                    <td>{{ $item->task->duration ? $item->task->duration . ' hari' : '-' }}</td>
                    <td>{{ $item->task->start_date ? \Carbon\Carbon::parse($item->task->start_date)->format('d M Y') : '-' }}
                    </td>
                    <td>{{ $item->task->end_date ? \Carbon\Carbon::parse($item->task->end_date)->format('d M Y') : '-' }}
                    </td>

                    @foreach ($weeks as $days)
                        @php
                            $inRange = false;

                            if ($item->task->start_date && $item->task->end_date) {
                                foreach ($days as $day) {
                                    if ($day->between($item->task->start_date, $item->task->end_date)) {
                                        $inRange = true;
                                        break;
                                    }
                                }
                            }
                            $hasResult = $item->results
                                ->filter(
                                    fn($r) => $days->contains(
                                        fn($d) => $d->isSameDay(\Carbon\Carbon::parse($r->created_at)),
                                    ),
                                )
                                ->isNotEmpty();
                            $statusClass = '';
                            $symbol = '';

                            if ($inRange) {
                                if ($item->status === 'done') {
                                    $statusClass = 'text-gray-800 font-bold';
                                    $symbol = '✔'; // hijau selesai
                                } elseif ($item->status === 'in_progress') {
                                    $statusClass = 'text-red-600 font-bold';
                                    $symbol = '✔'; // merah masih berjalan
                                } else {
                                    $statusClass = 'text-yellow-600 font-bold';
                                    $symbol = '✔'; // kuning planned
                                }
                            }

                            if ($hasResult) {
                                $statusClass = 'text-gray-800 font-bold';
                                $symbol = '✔'; // biru ada upload
                            }
                        @endphp

                        <td class="{{ $statusClass }}">
                            {{ $symbol }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
