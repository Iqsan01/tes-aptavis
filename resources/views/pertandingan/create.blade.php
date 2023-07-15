@extends('layouts.main')

@section('container')
    <h1>Input Skor Pertandingan</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2>A. Satu per satu</h2>
    <form method="POST" action="{{ route('pertandingan.store') }}">
        @csrf

        <div class="form-group">
            <label for="klub_id_1">Klub 1:</label>
            <select id="klub_id_1" name="klub_id_1" class="form-control" required>
                @foreach ($klubs as $klub)
                    <option value="{{ $klub->id }}">{{ $klub->nama }}</option>
                @endforeach
            </select>
            @error('klub_id_1')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="klub_id_2">Klub 2:</label>
            <select id="klub_id_2" name="klub_id_2" class="form-control" required>
                @foreach ($klubs as $klub)
                    <option value="{{ $klub->id }}">{{ $klub->nama }}</option>
                @endforeach
            </select>
            @error('klub_id_2')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="skor_1">Skor Klub 1:</label>
            <input type="number" id="skor_1" name="skor_1" class="form-control" required>
            @error('skor_1')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="skor_2">Skor Klub 2:</label>
            <input type="number" id="skor_2" name="skor_2" class="form-control" required>
            @error('skor_2')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary my-4">Save</button>
    </form>

    <h2>B. Multiple</h2>
    <form method="POST" action="{{ route('pertandingan.storeMultiple') }}">
        @csrf

        <div id="multiple-pertandingan">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="klub_id[]">Klub:</label>
                        <select id="klub_id[]" name="klub_id[]" class="form-control" required>
                            @foreach ($klubs as $klub)
                                <option value="{{ $klub->id }}">{{ $klub->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="skor_1[]">Skor:</label>
                        <input type="number" id="skor_1[]" name="skor_1[]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="klub_id[]">Klub:</label>
                        <select id="klub_id[]" name="klub_id[]" class="form-control" required>
                            @foreach ($klubs as $klub)
                                <option value="{{ $klub->id }}">{{ $klub->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="skor_2[]">Skor:</label>
                        <input type="number" id="skor_2[]" name="skor_2[]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-1" style="display: none;">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger" onclick="removePertandingan(this)">Remove</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group my-2">
            <button type="button" class="btn btn-primary" onclick="addPertandingan()">Add</button>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <script>
        function addPertandingan() {
            var pertandinganDiv = document.createElement('div');
            pertandinganDiv.classList.add('row', 'pertandingan-row');

            var klubDiv = document.createElement('div');
            klubDiv.classList.add('col-md-5');
            var klubFormGroup = document.createElement('div');
            klubFormGroup.classList.add('form-group');
            var klubLabel = document.createElement('label');
            klubLabel.setAttribute('for', 'klub_id[]');
            klubLabel.innerText = 'Klub:';
            var klubSelect = document.createElement('select');
            klubSelect.classList.add('form-control');
            klubSelect.setAttribute('name', 'klub_id[]');
            var klubOptions = document.getElementById('klub_id[]').innerHTML;
            klubSelect.innerHTML = klubOptions;
            klubFormGroup.appendChild(klubLabel);
            klubFormGroup.appendChild(klubSelect);
            klubDiv.appendChild(klubFormGroup);

            var skor2Div = document.createElement('div');
            skor2Div.classList.add('col-md-5');
            var skor2FormGroup = document.createElement('div');
            skor2FormGroup.classList.add('form-group');
            var skor2Label = document.createElement('label');
            skor2Label.setAttribute('for', 'skor_2[]');
            skor2Label.innerText = 'Skor:';
            var skor2Input = document.createElement('input');
            skor2Input.classList.add('form-control');
            skor2Input.setAttribute('type', 'number');
            skor2Input.setAttribute('name', 'skor_2[]');
            skor2FormGroup.appendChild(skor2Label);
            skor2FormGroup.appendChild(skor2Input);
            skor2Div.appendChild(skor2FormGroup);

            var removeDiv = document.createElement('div');
            removeDiv.classList.add('col-md-1');
            var removeFormGroup = document.createElement('div');
            removeFormGroup.classList.add('form-group');
            var removeButton = document.createElement('button');
            removeButton.setAttribute('type', 'button');
            removeButton.classList.add('btn', 'btn-danger');
            removeButton.innerText = 'Remove';
            removeButton.onclick = function() {
                removePertandingan(this);
            };
            removeFormGroup.appendChild(removeButton);
            removeDiv.appendChild(removeFormGroup);

            pertandinganDiv.appendChild(klubDiv);
            pertandinganDiv.appendChild(skor2Div);
            pertandinganDiv.appendChild(removeDiv);

            document.getElementById('multiple-pertandingan').appendChild(pertandinganDiv);
        }

        function removePertandingan(button) {
            button.closest('.pertandingan-row').remove();
        }
    </script>
@endsection
