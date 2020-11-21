@extends('master.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <a href="{{ route('akun.create') }}" class="btn btn-md btn-success mb-3">TAMBAH AKUN</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">USERNAME</th>
                                <th scope="col">PASSWORD</th>
                                <th scope="col">IMAGE</th>
                                <th scope="col">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($akuns as $akun)
                            <tr>
                                <td>{{ $akun->username }}</td>
                                <td>{{ $akun->password }}</td>

                                <td class="text-center">
                                    <img src="{{ Storage::url('public/images/').$akun->image }}" class="rounded"
                                        style="width: 150px">
                                </td>

                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                        action="{{ route('akun.destroy', $akun->id) }}" method="POST">
                                        <a href="{{ route('akun.edit', $akun->id) }}"
                                            class="btn btn-sm btn-primary">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <div class="alert alert-danger">
                                Data Blog belum Tersedia.
                            </div>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $akuns->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    @if(session()-> has('success'))
        
        toastr.success('{{ session('success') }}', 'BERHASIL!'); 

    @elseif(session()-> has('error'))

        toastr.error('{{ session('error') }}', 'GAGAL!'); 
        
    @endif
</script>
@endpush