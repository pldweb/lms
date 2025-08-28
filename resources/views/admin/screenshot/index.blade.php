@extends('layouts.admin')
@section('title', 'Manajemen Social Media')
@section('content')
<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title w-content">Kelola Social Media</h3>
                    <div class="d-flex justify-center align-items-center" style="gap: 5px;">
                        <a href="{{ url('/admin/social-media/create') }}" class="btn btn-primary btn-sm btn-add" style="white-space: nowrap">
                            <i class="ph ph-plus"></i> Mulai Screenshot
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(id) {
        confirmModal('Apakah Anda yakin ingin menghapus social media ini?', function() {
            ajxProcess('/admin/social-media/delete-action/' + id, '', '#message-modal');
        });
    }

    $(document).ready(function () {
        $('#table-social-media').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [0, 7] } 
            ]
        });
    });
</script>
@endsection