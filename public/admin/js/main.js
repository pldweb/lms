(function ($) {
  "use strict";
  
  // ==========================================
  //      Start Document Ready function
  // ==========================================
  $(document).ready(function () {
    
    
  // =========================== Dropdown menu Js Start =======================
    $('.dropdown-menu').on('click', function (event) {
      event.stopPropagation(); 
    }); 

    // Remove Dropdown Menu
    $('.close-dropdown').on('click', function () {
      $('.dropdown-menu').removeClass('show'); 
      $('.dropdown-btn').removeClass('show'); 
      $('.dropdown-btn').setAttribute('aria-expanded', 'false')
    }); 
  // =========================== Dropdown menu Js End =======================


  // =========================== Submenu Open & Close Js Start =======================
  $('.has-dropdown').on('click', function () {
    $('.has-dropdown').removeClass('activePage'); 
    $('.has-dropdown').not($(this)).find('.sidebar-submenu').slideUp(400); 
    
    $(this).find('.sidebar-submenu').slideToggle(400); 
    $(this).toggleClass('activePage'); 
  }); 

  // $('.sidebar-menu__item.activePage').find('.sidebar-submenu').slideDown(400);
  // =========================== Submenu Open & Close Js End =======================
    
  
  // ========================== add active class to ul>li top Active current page Js Start =====================
  function dynamicActiveMenuClass(selector) {
    let FileName = window.location.pathname.split("/").reverse()[0];

    selector.find("li").each(function () {
      let anchor = $(this).find("a");
      if ($(anchor).attr("href") == FileName) {
        $(this).addClass("activePage");
      }
    });
    // if any li has activePage element add class
    selector.children("li").each(function () {
      if ($(this).find(".activePage").length) {
        $(this).addClass("activePage");
      }
    });
    // if no file name return
    if ("" == FileName) {
      selector.find("li").eq(0).addClass("activePage");
    }
  }
  if ($('ul').length) {
    dynamicActiveMenuClass($('ul'));
  }
  // ========================== add active class to ul>li top Active current page Js End =====================
  

  //  =========================== Submenu Open & Active Dropdown menu while page active ========================
    if ($('.sidebar-menu__item').hasClass('activePage')) {
      $('.sidebar-menu__item.activePage').find('.sidebar-submenu').slideDown(400); 
    }
  //  =========================== Submenu Open & Active Dropdown menu while page active End ========================


  //  =========================== Sidebar Open & Close Start ===============================
  $('.toggle-btn').on('click', function () {
    $('.sidebar').addClass('active')
    $('.side-overlay').addClass('show')
  }); 

  $('.side-overlay, .sidebar-close-btn').on('click', function () {
    $('.side-overlay').removeClass('show')
    $('.sidebar').removeClass('active')
  }); 
  //  =========================== Sidebar Open & Close End ===============================

  
  // =========================== Tooltip Js Start ===============================
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
  // =========================== Tooltip Js End ===============================

  // ============================= Image Upload Js Start ==============================
  $(function(){ 
    $("#fileUpload").fileUpload();
  });
  // ============================= Image Upload Js End ==============================

  
  // ============================= Image Upload Js Start ==============================
  $('.text-counter').on('input', function () {
    const characterCount = $(this).val().length; 
    console.log(characterCount);
    $('#current').text(characterCount); 
  }); 
  // ============================= Image Upload Js End ==============================

  
  // ============================= Course Details Accordion Js Start ==============================
  $('.course-item__button').on('click', function () {
    
    $('.course-item__button').not($(this)).removeClass('active'); 
    $('.course-item__button').not($(this)).closest('.course-item').find('.course-item-dropdown').slideUp(); 

    $(this).toggleClass('active'); 
    $(this).closest('.course-item').find('.course-item-dropdown').slideToggle(); 
  }); 

  $('.course-list__item.active .circle i').removeClass('ph ph-circle'); 
  $('.course-list__item.active .circle i').addClass('ph-fill ph-check-circle text-main-600'); 

  // ============================= Course Details Accordion Js End ==============================


  // ================== Password Show Hide Js Start ==========
  $(".toggle-password").on('click', function() {
    $(this).toggleClass("active");
    var input = $($(this).attr("id"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  // ========================= Password Show Hide Js End ===========================

  // ========================= Billing Radio Checked Js Start ===========================
  $('.form-check-input.payment-method-one').on('change', function () {
    $('.payment-method.payment-method-one').removeClass('active'); 
    $(this).closest('.payment-method.payment-method-one').addClass('active'); 
  }); 

  $('.form-check-input.payment-method-two').on('change', function () {
    $('.payment-method.payment-method-two').removeClass('active'); 
    $(this).closest('.payment-method.payment-method-two').addClass('active'); 
  }); 
  // ========================= Billing Radio Checked Js End ===========================

  
  // ========================= List Grid View Js Start ===========================
  $('.list-grid-view li.activePage').each(function() {
    var icon = $(this).find('a i');
    if (icon.hasClass('ph-rows')) {
        icon.removeClass('ph-rows').addClass('ph-fill ph-rows');
    } else if (icon.hasClass('ph-squares-four')) {
        icon.removeClass('ph-squares-four').addClass('ph-fill ph-squares-four');
    }
  });

  $('.list-view-btn').on('click', function () {
    $(this).addClass('active');
    $('.grid-view-btn').removeClass('active'); 
    $('.list-view').removeClass('d-none'); 
    $('.grid-view').addClass('d-none'); 
  }); 

  $('.grid-view-btn').on('click', function () {
    $(this).addClass('active');
    $('.list-view-btn').removeClass('active'); 
    $('.grid-view').removeClass('d-none'); 
    $('.list-view').addClass('d-none'); 
  }); 
  // ========================= List Grid View Js End ===========================

  
  // ========================= Toggle Search Box Js Start ===========================
  $('.toggle-search-btn').on('click', function () {
    $(this).toggleClass('bg-main-600 border-main-600 text-white'); 
    $('.toggle-search-box').slideToggle(); 
  }); 
  // ========================= Toggle Search Box Js End ===========================

  });
  // ==========================================
  //      End Document Ready function
  // ==========================================

  // ========================= Preloader Js Start =====================
    $(window).on("load", function(){
      $('.preloader').fadeOut(); 
    })
    // ========================= Preloader Js End=====================

    // ========================= Header Sticky Js Start ==============
    $(window).on('scroll', function() {
      if ($(window).scrollTop() >= 260) {
        $('.header').addClass('fixed-header');
      }
      else {
          $('.header').removeClass('fixed-header');
      }
    }); 
    // ========================= Header Sticky Js End===================

})(jQuery);


$(document).ready(function() {
  $('#provinsi, #kota, #kecamatan, #desa').select2({
      theme: 'bootstrap-5'
  });
});

    function ajxDropdown(url, targetSelector, placeholder, callback = null) {
    const target = $(targetSelector);
    target.html('<option value="">Memuat...</option>').prop('disabled', true);
    $.ajax({
        url: url, type: 'GET', dataType: 'json',
        success: function(response) {
            target.html(`<option value="">${placeholder}</option>`).prop('disabled', false);
            $.each(response, function(key, value) {
                target.append(`<option value="${value.kode}">${value.nama}</option>`);
            });
            target.select2({ theme: 'bootstrap-5' });
            if (typeof callback === "function") callback(); // 🔁 jalankan callback kalau ada
        },
        error: function() { 
            target.html(`<option value="">Gagal memuat</option>`).prop('disabled', true);
            target.select2({ theme: 'bootstrap-5' });
        }
    });
}

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