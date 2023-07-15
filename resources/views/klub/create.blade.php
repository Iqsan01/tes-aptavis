<!-- resources/views/klub/create.blade.php -->

@extends('layouts.main')

@section('container')
    <h1>Input Data Klub</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('klub.store') }}">
        @csrf

        <div class="form-group">
            <label for="nama">Nama Klub:</label>
            <input type="text" id="nama" name="nama" class="form-control" required>
            @error('nama')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="kota">Kota Klub:</label>
            <input type="text" id="kota" name="kota" class="form-control" required>
            @error('kota')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
