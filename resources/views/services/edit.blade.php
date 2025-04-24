@include('layout.header')

<div class="content-wrapper p-4">
    <h1 class="mb-4">Edit Layanan</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('services.update', $service->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Layanan</label>
            <input type="text" name="name" value="{{ $service->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="price_per_kg" class="form-label">Harga</label>
            <input type="number" name="price_per_kg" value="{{ $service->price_per_kg }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('services.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@include('layout.footer')
