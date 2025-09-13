<style>
    .disabled {
        pointer-events: none;
        opacity: 0.5;
        background-color: #f5f5f5 !important;
        color: #888;
    }
</style>

<form id="kontakForm" enctype="multipart/form-data" method="POST" onsubmit="return false;">
                    @csrf
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="nama">Nama <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama ?? '' }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-10 row">
                        <label class="form-label" for="jabatan">Jabatan <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $data->jabatan ?? '' }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <input type="email" class="form-control" id="email" name="email" value="{{ $data->email ?? '' }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="telepon">Telepon <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $data->telepon ?? '' }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="alamat">Alamat</label>
                        <div class="col-12">
                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $data->alamat ?? '' }}</textarea>
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label" for="urutan">Urutan <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <input type="number" class="form-control" id="urutan" name="urutan" value="{{ $data->urutan ?? '' }}" min="0" required>
                        </div>
                    </div>
                    
                    <div class="form-group mb-10 row">
                        <label class="form-label d-block">Status</label>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aktif" name="aktif" value="1" {{ isset($data->aktif) && $data->aktif ? 'checked' : '' }}>
                                <label class="form-check-label" for="aktif">Aktif</label>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" class="form-control" name="id" value="{{ $data->id ?? '' }}">
                    <div class="mb-20 mt-20">
                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-add">Simpan</button>
                    </div>
                </form>

<script>
    $(document).ready(function () {
        $('#kontakForm').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/kontak/store', formData, '#message-modal')
            });
        });
    });
</script>