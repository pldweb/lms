function confirmModal(message, confirmCallback) {
    $('#modalTitle').text('Konfirmasi');
    $('#modalBody').html(`
        <div class="text-center p-3">
            <h5>${message}</h5>
            <div class="mt-4">
                <button id="confirmYes" class="btn btn-success text-white">Ya, Lanjutkan</button>
                <button class="btn btn-secondary text-white" onclick="hideModal()">Batal</button>
            </div>
        </div>
    `);

    $('#universalModal').modal('show');
    $('#modalBody').off('click', '#confirmYes');
    $('#modalBody').on('click', '#confirmYes', function () {
        confirmCallback();
        setTimeout(function (){
            hideModal();
        }, 2000)
    });
}

function ajxProcess(url = null, dataInput = null, message = null, func = null) {
    $.ajax({
        url: url,
        type: 'POST',
        data: dataInput,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        processData: false,
        success: function(response) {
            $(message).html(response);
        },
        error: function(xhr) {
            $(message).html('Gagal: ' + xhr);
        }
    });
}

function ajxFile(url = null, dataInput = null, message = null) {
    $.ajax({
        url: url,
        type: 'POST',
        data: dataInput,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        contentType: false,
        processData: false,
        success: function(response) {
            $(message).html(response);
        },
        error: function(xhr) {
            $(message).html('Gagal: ' + xhr);
        }
    });
}

function deleteData(id, url, selector) {
    const html = `
        <div class="text-center p-3">
            <h5>Apakah Anda yakin ingin menghapus data ini?</h5>
            <div class="mt-4">
                <button class="btn btn-danger text-white" onclick="confirmDelete(${id}, '${url}', '${selector}')">Ya, Hapus</button>
                <button class="btn btn-secondary text-white" onclick="hideModal()">Batal</button>
            </div>
        </div>
    `;
    $('#modalTitle').text('Konfirmasi Hapus');
    $('#modalBody').html(html);
    $('#universalModal').modal('show');
}

function confirmDelete(id, url, elem = null) {
    $.ajax({
        url: url,
        type: 'POST',
        data: {id: id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            $(elem).html(res);
        },
        error: function () {
            alert('Gagal menghapus data.');
        }
    });
}

function loadData(url, elem = null) {
    $.ajax({
        url: url ,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $(elem).html(data);
        },
        error: function(data) {
            $(elem).html('<div class="alert alert-danger">Gagal memuat data.</div>');
        }
    });
}

function editData(id, url, text = 'Edit Data', elem = '#modalBody') {
    $.ajax({
        url: url,
        type: 'POST',
        data: { id: id },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            $(elem).html(res)
        },
        error: function () {
            alert('Gagal simpan data.');
        }
    });
    $('#modalTitle').text(text);
    $('#universalModal').modal('show');

}

function showModal(url, title = 'Form', method = 'GET') {
    $('#modalTitle').text(title);
    $('#modalBody').html('<div class="text-center p-4"><div class="spinner-border text-primary" role="status"></div></div>');
    $('#universalModal').modal('show');

    $.ajax({
        url: url,
        method: method,
        success: function (response) {
            $('#modalBody').html(response);
        },
        error: function (xhr) {
            $('#modalBody').html('<div class="alert alert-danger">Gagal memuat data.</div>');
        }
    });
}

function hideModal() {
    $('#universalModal').modal('hide');
    $('#modalTitle').text('');
    $('#modalBody').html('');
    $('#message-modal').html('');
    $('#universalModal').find('form').trigger('reset');
}



/**
 * Fungsi ringkas untuk mengambil data lokasi (JSON) dan mengisi dropdown.
 */

