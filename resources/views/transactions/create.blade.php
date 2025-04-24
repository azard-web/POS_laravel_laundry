@include('layout.header')

<div class="content-wrapper p-4">
  <h1 class="mb-4">Tambah Transaksi</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('transactions.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="customer_id" class="form-label">Customer</label>
      <select name="customer_id" id="customer_id" class="form-control" required>
        <option value="">-- Pilih Customer --</option>
        @foreach ($customers as $customer)
          <option value="{{ $customer->id }}">{{ $customer->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="transaction_date" class="form-label">Tanggal Transaksi</label>
      <input type="date" name="transaction_date" id="transaction_date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="pickup_date" class="form-label">Tanggal Ambil (Opsional)</label>
      <input type="date" name="pickup_date" id="pickup_date" class="form-control">
    </div>

    <hr>
    <h5>Layanan Laundry</h5>
    <div id="service-list">
      <div class="row mb-3 service-item">
        <div class="col-md-6">
          <label class="form-label">Jenis Layanan</label>
          <select name="services[]" class="form-control" required>
            <option value="">-- Pilih Layanan --</option>
            @foreach ($services as $service)
              <option value="{{ $service->id }}">{{ $service->service_name }} - Rp {{ number_format($service->price_per_kg, 0, ',', '.') }}/kg</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Berat (kg)</label>
          <input type="number" name="quantities[]" class="form-control" step="0.1" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="button" class="btn btn-danger btn-sm remove-service">Hapus</button>
        </div>
      </div>
    </div>

    <button type="button" id="add-service" class="btn btn-secondary btn-sm mb-4">+ Tambah Layanan</button>

    <div>
      <button type="submit" class="btn btn-success">Simpan Transaksi</button>
      <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>

@include('layout.footer')

<script>
  document.getElementById('add-service').addEventListener('click', function () {
    const serviceList = document.getElementById('service-list');
    const newItem = serviceList.querySelector('.service-item').cloneNode(true);
    newItem.querySelectorAll('input').forEach(input => input.value = '');
    newItem.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
    serviceList.appendChild(newItem);
  });

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-service')) {
      const items = document.querySelectorAll('.service-item');
      if (items.length > 1) {
        e.target.closest('.service-item').remove();
      }
    }
  });
</script>
