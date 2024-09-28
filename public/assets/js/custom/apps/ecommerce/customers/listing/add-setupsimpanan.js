"use strict";
var KTModalCustomersAdd = (function () {
    var t, e, o, n, r, i;
    return {
        init: function () {
            (i = new bootstrap.Modal(document.querySelector("#kt_modal_add_customer"))),
                (r = document.querySelector("#kt_modal_add_customer_form")),
                (t = r.querySelector("#kt_modal_add_customer_submit")),
                (e = r.querySelector("#kt_modal_add_customer_cancel")),
                (o = r.querySelector("#kt_modal_add_customer_close")),
                (n = FormValidation.formValidation(r, {
                    fields: {
                        anggota: { validators: { notEmpty: { message: "Pilih anggota" } } },
                        tgl_transaksi: { validators: { notEmpty: { message: "Tgl Transaksi harus diisi" } } },
                        jumlah: { validators: { notEmpty: { message: "Jumlah harus diisi" } } },
                        
                    },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),
                t.addEventListener("click", function (e) {
                    e.preventDefault(),
                        n &&
                            n.validate().then(function (e) {
                                
                                var nama_simpanan = $('#nama_simpanan').val();
                                var jangka_waktu = $('#jangka_waktu').val();
                                var bunga_pinjaman = $('#bunga_pinjaman').val();
                                var status = $('#status').val();
                                var id=$('#id_data').val();
                                //alert(jangka_waktu);
                                console.log("validated!"),
                                    "Valid" == e
                                        ? (t.setAttribute("data-kt-indicator", "on"),
                                          (t.disabled = !0),
                                          setTimeout(function () {
                                            $.ajax({
                                                url:'savesetupsimpanan',
                                                type:'post',
                                                data:{nama_simpanan:nama_simpanan,jangka_waktu:jangka_waktu,bunga_pinjaman:bunga_pinjaman,status:status,id:id},
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
                                                        location.href='/setupsimpanan';
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


function deletesimpananpokok(id_transaksi){
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
                url:'deletesimpananpokok',
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
                        location.href='/simpananpokok';
                    }
                    
                }
            });
        }
    })
}
