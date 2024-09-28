"use strict";
var KTModalCustomersAdd = (function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            $(".tgl").flatpickr({ altInput: !0, altFormat: "d F, Y", dateFormat: "Y-m-d" });
            (i = new bootstrap.Modal(document.querySelector("#kt_modal_add_customer"))),
                (r = document.querySelector("#kt_modal_add_customer_form")),
                (t = r.querySelector("#kt_modal_add_customer_submit")),
                (e = r.querySelector("#kt_modal_add_customer_cancel")),
                (o = r.querySelector("#kt_modal_add_customer_close")),
                (n = FormValidation.formValidation(r, {
                    fields: {
                        jenis_pendapatan: { validators: { notEmpty: { message: "Pilih anggota" } } },
                        uraian: { validators: { notEmpty: { message: "Uraian" } } },
                        jumlah: { validators: { notEmpty: { message: "Jumlah harus diisi" } } },
                        tgl: { validators: { notEmpty: { message: "Tanggal harus diisi" } } },
                    },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),
                t.addEventListener("click", function (e) {
                    e.preventDefault(),
                        n &&
                            n.validate().then(function (e) {
                                
                                var jenis_pendapatan = $('#jenis_pendapatan').val();
                                var uraian = $('#uraian').val();
                                var tgl = $('#tgl').val();
                                var jumlah = $('#jumlah').val();
                                //var status = $('#status').val();
                                //var id=$('#id_data').val();
                                //alert(jangka_waktu);
                                console.log("validated!"),
                                    "Valid" == e
                                        ? (t.setAttribute("data-kt-indicator", "on"),
                                          (t.disabled = !0),
                                          setTimeout(function () {
                                            $.ajax({
                                                url:'savependapatan',
                                                type:'post',
                                                data:{jenis_pendapatan:jenis_pendapatan,uraian:uraian,tgl:tgl,jumlah:jumlah},
                                                success:function(response){
                                                    var data = JSON.parse(response);
                                                    if(data.error==1){
                                                        Swal.fire({
                                                            text:data.message,
                                                            icon:"error",
                                                            customClass: { confirmButton: "btn btn-primary" }
                                                        });
                                                    }else{
                                                        Swal.fire({
                                                            text:data.message,
                                                            icon:"success",
                                                            customClass: { confirmButton: "btn btn-primary" }
                                                        });
                                                        location.href='/pendapatan';
                                                    }
                                                    
                                                }
                                            });
                                          }, 2e3))
                                        : Swal.fire({
                                              text: "Sorry, looks like there are some errors detected, please try again.",
                                              icon: "error",
                                              buttonsStyling: !1,
                                              confirmButtonText: "Ok, got it!",
                                              customClass: { confirmButton: "btn btn-primary" },
                                          });
                            });
                }),
                e.addEventListener("click", function (t) {
                    t.preventDefault(),
                        Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" },
                        }).then(function (t) {
                            t.value
                                ? (r.reset(), i.hide())
                                : "cancel" === t.dismiss && Swal.fire({ text: "Your form has not been cancelled!.", icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } });
                        });
                }),
                o.addEventListener("click", function (t) {
                    t.preventDefault(),
                        Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light" },
                        }).then(function (t) {
                            t.value
                                ? (r.reset(), i.hide())
                                : "cancel" === t.dismiss && Swal.fire({ text: "Your form has not been cancelled!.", icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } });
                        });
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTModalCustomersAdd.init();
});


function hapus_pendapatan(id_transaksi){
    Swal.fire({
        text: "Are you sure you want to delete " + id_transaksi + "?",
        icon: "warning",
        showCancelButton: !0,
        buttonsStyling: !1,
        confirmButtonText: "Yes, delete!",
        cancelButtonText: "No, cancel",
        customClass: { confirmButton: "btn fw-bold btn-danger", cancelButton: "btn fw-bold btn-active-light-primary" },
    }).then(function (e) {
        if(e.value){
            $.ajax({
                url:'deletependapatan',
                type:'post',
                data:{id_transaksi:id_transaksi},
                success:function(response){
                    var data = JSON.parse(response);
                    if(data.error==1){
                        Swal.fire({
                            text:data.message,
                            icon:"error",
                            customClass: { confirmButton: "btn btn-primary" }
                        });
                    }else{
                        location.href='/pendapatan';
                    }
                    
                }
            });
        }
    })
}
