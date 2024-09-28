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
                        debet: { validators: { notEmpty: { message: "Aset harus dipilih" } } },
                        jumlah_debet: { validators: { notEmpty: { message: "Jumlah Aset harus diisi" } } },
                        kredit: { validators: { notEmpty: { message: "Kewajiban harus dipilih" } } },
                        jumlah_kredit: { validators: { notEmpty: { message: "Jumlah Kewajiban harus diisi" } } }
                    },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),
                t.addEventListener("click", function (e) {
                    e.preventDefault(),
                        n &&
                            n.validate().then(function (e) {
                                
                                var debet = $('#debet').val();
                                var jumlah_debet = $('#jumlah_debet').val();
                                var kredit = $('#kredit').val();
                                var jumlah_kredit = $('#jumlah_kredit').val();
                                var tahun = $('#tahun').val();
                                var id=$('#id_data').val();
                                
                                console.log("validated!"),
                                    "Valid" == e
                                        ? (t.setAttribute("data-kt-indicator", "on"),
                                          (t.disabled = !0),
                                          setTimeout(function () {
                                            $.ajax({
                                                url:'simpanneracaawal',
                                                type:'post',
                                                data:{debet:debet,jumlah_debet:jumlah_debet,kredit:kredit,jumlah_kredit:jumlah_kredit,tahun:tahun,id_data:id},
                                                success:function(response){
                                                    var data = JSON.parse(response);
                                                    if(data.error==1){
                                                        Swal.fire({
                                                            text:data.message,
                                                            icon:"error",
                                                            customClass: { confirmButton: "btn btn-primary" }
                                                        });
                                                        $('#kt_modal_add_customer_submit').prop('disabled', false);
                                                        $('.indicator-progress').hide();
                                                        $('.indicator-label').show();
                                                    }else{
                                                        Swal.fire({
                                                            text:data.message,
                                                            icon:"success",
                                                            customClass: { confirmButton: "btn btn-primary" }
                                                        });
                                                        location.href='/neracaawal';
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
