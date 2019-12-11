@extends('reports.layout')
@section('title', 'Rel. de Agendamentos')
@section('content')
<div class="pt-5">
    <h2 class="text-center">Relatório de Agendamentos</h2>
    <h4 class="text-center">Dr(a). {{$doctor->person->name}}</h4>
    <div class="pt-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Data de Nascimento</th>
                    <th>Dia</th>
                    <th>Horário</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                <tr>
                    <td>{{$schedule->patient->person->name}}</td>
                    <td>
                        {{$schedule->patient->birthdate->format("d/m/Y")}}
                        ({{$schedule->patient->birthdate->diffInYears()}} Anos)
                    </td>
                    <td>{{$schedule->start_at->format("d/m/Y")}}</td>
                    <td>{{$schedule->start_at->format("H:i")}} - {{$schedule->end_at->format("H:i")}}</td>
                </tr>
                @endforeach
            </tbody>
            @if($schedules->count())
            <tfoot>
                <tr>
                    <th>Paciente</th>
                    <th>Dia</th>
                    <th>Horário</th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
