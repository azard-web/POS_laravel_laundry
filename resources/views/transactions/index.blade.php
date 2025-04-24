@include('layout.header')

<div class="content-wrapper p-4">
  <h1 class="mb-4">Daftar Transaksi</h1>

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">+ Tambah Transaksi</a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Customer</th>
        <th>Tanggal Masuk</th>
        <th>Status</th>
        <th>Total Harga</th>
        <th>Bayar</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($transactions as $trx)
        <tr>
          <td>{{ $trx->customer->name }}</td>
          <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</td>
          <td>{{ ucfirst($trx->status) }}</td>
          <td>Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
          <td>{{ ucfirst($trx->payment_status) }}</td>
          <td>
            <a href="{{ route('transactions.show', $trx->id) }}" class="btn btn-info btn-sm">Detail</a>
            <a href="{{ route('transactions.edit', $trx->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center">Belum ada transaksi.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

@include('layout.footer')
