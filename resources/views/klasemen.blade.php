<!-- resources/views/klasemen.blade.php -->

@extends('layouts.main')

@section('container')
    <h1>Klasemen</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Klub</th>
                <th>Ma</th>
                <th>Me</th>
                <th>S</th>
                <th>K</th>
                <th>GM</th>
                <th>GK</th>
                <th>Point</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($klasemen as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data['klub']->nama }}</td>
                    <td>{{ $data['main'] }}</td>
                    <td>{{ $data['menang'] }}</td>
                    <td>{{ $data['seri'] }}</td>
                    <td>{{ $data['kalah'] }}</td>
                    <td>{{ $data['gol_menang'] }}</td>
                    <td>{{ $data['gol_kalah'] }}</td>
                    <td>{{ $data['point'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
