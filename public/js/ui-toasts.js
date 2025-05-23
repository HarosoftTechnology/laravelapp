"use strict";
!function () {
    const e = document.querySelector(".toast-ex"), o = document.querySelector(".toast-placement-ex"),
        t = document.querySelector("#showToastAnimation"), s = document.querySelector("#showToastPlacement");
    let a, n, i, l, r;

    function c(t) {
        t && null !== t._element && (o && (o.classList.remove(a), DOMTokenList.prototype.remove.apply(o.classList, i)), e && e.classList.remove(a, n), t.dispose())
    }

    t && (t.onclick = function () {
        l && c(l), a = document.querySelector("#selectType").value, n = document.querySelector("#selectAnimation").value, e.classList.add(a, n), (l = new bootstrap.Toast(e)).show()
    }), s && (s.onclick = function () {
        r && c(r), a = document.querySelector("#selectTypeOpt").value, i = document.querySelector("#selectPlacement").value.split(" "), o.classList.add(a), DOMTokenList.prototype.add.apply(o.classList, i), (r = new bootstrap.Toast(o)).show()
    })
}(), $(function () {
    var k, f = -1, b = 0;
    $("#closeButton").click(function () {
        $(this).is(":checked") ? $("#addBehaviorOnToastCloseClick").prop("disabled", !1) : ($("#addBehaviorOnToastCloseClick").prop("disabled", !0), $("#addBehaviorOnToastCloseClick").prop("checked", !1))
    }), $("#showtoast").click(function () {
        var p = $("#toastTypeGroup input:radio:checked").val(), t = "rtl" === $("html").attr("dir"),
            e = $("#message").val(), u = $("#title").val() || "", o = $("#showDuration"), s = $("#hideDuration"),
            a = $("#timeOut"), n = $("#extendedTimeOut"), i = $("#showEasing"), d = $("#hideEasing"),
            h = $("#showMethod"), m = $("#hideMethod"), v = b++, l = $("#addClear").prop("checked"),
            r = void 0 === toastr.options.positionClass ? "toast-top-right" : toastr.options.positionClass,
            e = (toastr.options = {
                maxOpened: 1,
                autoDismiss: !0,
                closeButton: $("#closeButton").prop("checked"),
                debug: $("#debugInfo").prop("checked"),
                newestOnTop: $("#newestOnTop").prop("checked"),
                progressBar: $("#progressBar").prop("checked"),
                positionClass: $("#positionGroup input:radio:checked").val() || "toast-top-right",
                preventDuplicates: $("#preventDuplicates").prop("checked"),
                onclick: null,
                rtl: t
            }, r != toastr.options.positionClass && (toastr.options.hideDuration = 0, toastr.clear()), $("#addBehaviorOnToastClick").prop("checked") && (toastr.options.onclick = function () {
                alert("You can perform some custom action after a toast goes away")
            }), $("#addBehaviorOnToastCloseClick").prop("checked") && (toastr.options.onCloseClick = function () {
                alert("You can perform some custom action when the close button is clicked")
            }), o.val().length && (toastr.options.showDuration = parseInt(o.val())), s.val().length && (toastr.options.hideDuration = parseInt(s.val())), a.val().length && (toastr.options.timeOut = l ? 0 : parseInt(a.val())), n.val().length && (toastr.options.extendedTimeOut = l ? 0 : parseInt(n.val())), i.val().length && (toastr.options.showEasing = i.val()), d.val().length && (toastr.options.hideEasing = d.val()), h.val().length && (toastr.options.showMethod = h.val()), m.val().length && (toastr.options.hideMethod = m.val()), l && (t = (t = e) || "Clear itself?", e = t += '<br /><br /><button type="button" class="btn btn-secondary clear">Yes</button>', toastr.options.tapToDismiss = !1), e || (r = ["Don't be pushed around by the fears in your mind. Be led by the dreams in your heart.", '<div class="mb-3"><input class="input-small form-control" value="Textbox"/>&nbsp;<a href="http://johnpapa.net" target="_blank">This is a hyperlink</a></div><div class="d-flex"><button type="button" id="okBtn" class="btn btn-primary btn-sm me-2">Close me</button><button type="button" id="surpriseBtn" class="btn btn-sm btn-secondary">Surprise me</button></div>', "Live the Life of Your Dreams", "Believe in Your Self!", "Be mindful. Be grateful. Be positive.", "Accept yourself, love yourself!"])[f = ++f === r.length ? 0 : f]),
            c = toastr[p](e, u);
        void 0 !== (k = c) && (c.find("#okBtn").length && c.delegate("#okBtn", "click", function () {
            alert("you clicked me. i was toast #" + v + ". goodbye!"), c.remove()
        }), c.find("#surpriseBtn").length && c.delegate("#surpriseBtn", "click", function () {
            alert("Surprise! you clicked me. i was toast #" + v + ". You could perform an action here.")
        }), c.find(".clear").length && c.delegate(".clear", "click", function () {
            toastr.clear(c, {force: !0})
        }))
    }), $("#clearlasttoast").click(function () {
        toastr.clear(k)
    }), $("#cleartoasts").click(function () {
        toastr.clear()
    })
});