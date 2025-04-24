@include('layout.header')

<div class="content-wrapper p-4">
    <h1 class="mb-4">Edit Customer</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Customer</label>
            <input type="text" name="name" value="{{ $customer->name }}" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">No HP</label>
            <input type="text" name="phone_number" value="{{ $customer->phone_number }}" class="form-control" id="phone_number" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@include('layout.footer')
