"use strict";
var KTCustomersList = (function () {
    var t,
        e,
        o = () => {
            e.querySelectorAll('[data-kt-customer-table-filter="delete_row"]').forEach((e) => {
                e.addEventListener("click", function (e) {
                    e.preventDefault();
                    const o = e.target.closest("tr"),
                        n = o.querySelectorAll("td")[1].innerText;
                        Swal.fire({
                            text: "Are you sure you want to delete " + n + "?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: { confirmButton: "btn fw-bold btn-danger", cancelButton: "btn fw-bold btn-active-light-primary" },
                        }).then(function (e) {
                            if(e.value){
                                $.ajax({
                                    url:'deleteanggota',
                                    type:'post',
                                    data:{no_anggota:n},
                                    success:function(response){
                                        var data = JSON.parse(response);
                                        if(data.error==1){
                                            Swal.fire({
                                                text:data.message,
                                                icon:"error",
                                                customClass: { confirmButton: "btn btn-primary" }
                                            });
                                        }else{
                                            Swal.fire({ text: "You have deleted " + n + "!.", icon: "success", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn fw-bold btn-primary" } }).then(function () {
                                                t.row($(o)).remove().draw();
                                            })
                                        }
                                        
                                    }
                                });
                            }else{
                                "cancel" === e.dismiss && Swal.fire({ text: n + " was not deleted.", icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                            }
                        });
                });
            });
        },
        n = () => {
            const o = e.querySelectorAll('[type="checkbox"]'),
                n = document.querySelector('[data-kt-customer-table-select="delete_selected"]');
            o.forEach((t) => {
                t.addEventListener("click", function () {
                    setTimeout(function () {
                        c();
                    }, 50);
                });
            }),
                n.addEventListener("click", function () {
                    Swal.fire({
                        text: "Are you sure you want to delete selected customers?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: { confirmButton: "btn fw-bold btn-danger", cancelButton: "btn fw-bold btn-active-light-primary" },
                    }).then(function (n) {
                        n.value
                            ? Swal.fire({ text: "You have deleted all selected customers!.", icon: "success", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn fw-bold btn-primary" } }).then(
                                  function () {
                                      o.forEach((e) => {
                                          e.checked &&
                                              t
                                                  .row($(e.closest("tbody tr")))
                                                  .remove()
                                                  .draw();
                                      });
                                      e.querySelectorAll('[type="checkbox"]')[0].checked = !1;
                                  }
                              )
                            : "cancel" === n.dismiss &&
                              Swal.fire({ text: "Selected customers was not deleted.", icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn fw-bold btn-primary" } });
                    });
                });
        };
    const c = () => {
        const t = document.querySelector('[data-kt-customer-table-toolbar="base"]'),
            o = document.querySelector('[data-kt-customer-table-toolbar="selected"]'),
            n = document.querySelector('[data-kt-customer-table-select="selected_count"]'),
            c = e.querySelectorAll('tbody [type="checkbox"]');
        let r = !1,
            l = 0;
        c.forEach((t) => {
            t.checked && ((r = !0), l++);
        }),
            r ? ((n.innerHTML = l), t.classList.add("d-none"), o.classList.remove("d-none")) : (t.classList.remove("d-none"), o.classList.add("d-none"));
    };
    return {
        init: function () {
            (e = document.querySelector("#kt_customers_table")) &&
                (e.querySelectorAll("tbody tr").forEach((t) => {
                    const e = t.querySelectorAll("td"),
                        o = moment(e[5].innerHTML, "DD MMM YYYY, LT").format();
                    e[5].setAttribute("data-order", o);
                }),
                (t = $(e).DataTable({
                    info: !1,
                    order: [],
                    columnDefs: [
                        { orderable: !1, targets: 0 },
                        { orderable: !1, targets: 6 },
                    ],
                })).on("draw", function () {
                    n(), o(), c();
                }),
                n(),
                document.querySelector('[data-kt-customer-table-filter="search"]').addEventListener("keyup", function (e) {
                    t.search(e.target.value).draw();
                }),
                o(),
                (() => {
                    const e = document.querySelector('[data-kt-ecommerce-order-filter="status"]');
                    $(e).on("change", (e) => {
                        let o = e.target.value;
                        "all" === o && (o = ""), t.column(3).search(o).draw();
                    });
                })());
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTCustomersList.init();
});

function editsetupsimpanan(id){
    $('#kt_modal_add_customer').modal('show');
    $.ajax({
        url:'getsetupsimpanan',
        type:'get',
        data:{id:id},
        success:function(response){
            var data = JSON.parse(response);
            $('#nama_simpanan').val(data.message.nama_simpanan);
            $('#jangka_waktu').val(data.message.jangka);
            $('#bunga_pinjaman').val(data.message.bunga);
            $('#status').val(data.message.status);
            $('#id_data').val(id);
        }
    });
}

function deletesetupsimpanan(id){
    Swal.fire({
        text: "Are you sure you want to delete ?",
        icon: "warning",
        showCancelButton: !0,
        buttonsStyling: !1,
        confirmButtonText: "Yes, delete!",
        cancelButtonText: "No, cancel",
        customClass: { confirmButton: "btn fw-bold btn-danger", cancelButton: "btn fw-bold btn-active-light-primary" },
    }).then(function (e) {
        if(e.value){
            $.ajax({
                url:'deletesetupsimpanan',
                type:'post',
                data:{id:id},
                success:function(response){
                    location.href='/setupsimpanan';
                }
            });
        }
    });
}
