"use strict";
var KTSigninGeneral = (function () {
    var e, t, i;
    return {
        init: function () {
            
            (e = document.querySelector("#kt_sign_in_form")),
                (t = document.querySelector("#kt_sign_in_submit")),
                (i = FormValidation.formValidation(e, {
                    fields: {
                        username: { validators:  { notEmpty: { message: "Username is required" } }},
                        email: { validators:  { notEmpty: { message: "Email is required" } }},
                        password: { validators: { notEmpty: { message: "The password is required" } } },
                    },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),
                t.addEventListener("click", function (n) {
                    n.preventDefault(),
                        i.validate().then(function (i) {
                            var email = $('#email').val();
                            var password = $('#password').val();
                            var username = $('#username').val();
                            "Valid" == i
                                ? (t.setAttribute("data-kt-indicator", "on"),
                                  (t.disabled = !0),
                                  setTimeout(function () {
                                      t.removeAttribute("data-kt-indicator"),
                                          (t.disabled = !1),
                                          $.ajax({
                                            url:'signupsave',
                                            type:'post',
                                            data:{username:username,password:password,email:email},
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
                                                    location.href='/';
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
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
