@extends('reports.layout')
@section('title', 'Relatório Atendimentos')
@section('content')
<div class="pt-5">
    <h2 class="text-center">Relatório de Atendimentos</h2>
    <h4 class="text-center">Paciente: {{$patient->person->name}}</h4>
    <div class="pt-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Médico</th>
                    <th>Descrição</th>
                    @if($objectives)
                    <th>Estrategias Aplicadas</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{$appointment->created_at->format("d/m/Y H:i:00")}}</td>
                    <td>{{$appointment->doctor->person->name}}</td>
                    <td>{{$appointment->overview}}</td>
                    @if($objectives)
                    <td>
                        <ul>
                            @foreach($appointment->objectives as $objective)
                            <li>
                                {{$objective->strategy->label}} ({{$objective->minutes}} minutos).
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
            @if($appointments->count())
            <tfoot>
                <tr>
                    <th>Data</th>
                    <th>Médico</th>
                    <th>Descrição</th>
                    @if($objectives)
                    <th>Estrategias Aplicadas</th>
                    @endif
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection