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
                        nama: { validators: { notEmpty: { message: "Nama Anggota harus diisi" } } },
                        email: { validators: { notEmpty: { message: "Email Harus di isi" } } },
                        nik: { validators: { notEmpty: { message: "NIK Harus diisi" } } },
                        alamat: { validators: { notEmpty: { message: "Alamat harus diisi" } } },
                        no_telp: { validators: { notEmpty: { message: "No Telp Harus diisi" } } },
                    },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),
                t.addEventListener("click", function (e) {
                    e.preventDefault(),
                        n &&
                            n.validate().then(function (e) {
                                
                                var no_anggota = $('#no_anggota').val();
                                var nik = $('#nik').val();
                                var nama = $('#nama').val();
                                var email = $('#email').val();
                                var no_telp = $('#no_telp').val();
                                var alamat = $('#alamat').val();
                                var alamat = $('#alamat').val();
                                var jenis_kelamin=$('#jenis_kelamin').val();
                                var jenis_anggota='aktif';
                                var photo=$('#photo').val();
                                var koordinat=$('#koordinat').val();
                                var id=$('#id_data').val();
                                console.log("validated!"),
                                    "Valid" == e
                                        ? (t.setAttribute("data-kt-indicator", "on"),
                                          (t.disabled = !0),
                                          setTimeout(function () {
                                            $.ajax({
                                                url:'saveanggota',
                                                type:'post',
                                                data:{no_anggota:no_anggota,nik:nik,email:email,no_telp:no_telp,alamat:alamat,nama:nama,jenis_kelamin:jenis_kelamin,jenis_anggota:jenis_anggota,photo:photo,koordinat:koordinat,id:id},
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
                                                        location.href='/anggota';
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
