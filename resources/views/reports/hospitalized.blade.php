@extends('reports.layout')
@section('title', 'Rel. Internações')
@section('content')
<div class="pt-5">
    <h2 class="text-center">Pacientes Internados</h2>
    <div class="pt-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Data de Nascimento</th>
                    <th>Data da Hospitalização</th>
                    <th>Plano de Saúde</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                <tr>
                    <td>{{$patient->person->name}}</td>
                    <td>{{$patient->birthdate->format("d/m/Y")}} ({{$patient->birthdate->diffInYears()}} Anos)</td>
                    <td>{{$patient->hospitalizations->last()->created_at->format("d/m/Y")}}</td>
                    <td>{{$patient->hospitalizations->last()->healthPlan ? $patient->hospitalizations->last()->healthPlan->label : ""}}
                    </td>
                </tr>
                @endforeach
            </tbody>
            @if($patients->count())
            <tfoot>
                <tr>
                    <th>Paciente</th>
                    <th>Data de Nascimento</th>
                    <th>Data da Hospitalização</th>
                    <th>Plano de Saúde</th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
