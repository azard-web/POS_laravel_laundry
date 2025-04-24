@include('layout.header')

<div class="content-wrapper p-4">
    <h1 class="mb-4">Tambah Customer</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Customer</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">No HP</label>
            <input type="text" name="phone_number" class="form-control" id="phone_number" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@include('layout.footer')
