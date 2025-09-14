@extends('layouts.admin')
@section('title', isset($user) ? 'Edit User' : 'Tambah User')
@section('content')

<div class="row mt-20">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header b-title">
                <h3 class="card-title">{{ isset($user) ? "Edit User $jenis" : "Tambah User $jenis Baru" }}</h3>
            </div>
            <div class="card-body" style="padding-top: 20px;">
                <div class="tab-content" id="userTypeTabContent">
                    <form id="createSiswaForm" class="user-form" enctype="multipart/form-data" method="POST" onsubmit="return false;">
                            @csrf
                            <input type="hidden" id="inputJenis" name="jenis" value="{{ isset($user) && $user->roles->first() ? $user->roles->first()->name : (isset($jenis) ? $jenis : 'siswa') }}">
                            <div class="row">
                                <div class="col-12">
                                    @include('admin.user.form')
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        initSelect2(".select2");

        // Preview foto saat file dipilih untuk siswa
        $('#inputFoto').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewFoto').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Submit form siswa
        $('#createSiswaForm').submit(function(e) {
            e.preventDefault();
            let dataInput = new FormData(this);
            let url = '{{ isset($user) ? "/admin/user/create-user-action" : "/admin/user/create-user-action" }}';
            
            // Jika mode edit, tambahkan ID user
            @if(isset($user))
            dataInput.append('id', '{{ $user->id }}');
            @endif
            
            confirmModal('Apakah data siswa yang kamu masukkan sudah benar?', function (){
                ajxProcess(url, dataInput, '#message-modal')
            });
        });
    });
</script>

@endsection