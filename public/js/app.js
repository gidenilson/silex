app = function ($) {
    var btnCriar = $('#btnCriar'),
        form = $('#form-edit-entity'),
        btnSalvar = $('#btnSalvar'),
        trs = $("tr[data-id]"),
        btnCancelar = $('#btnCancelar'),
        inputMethod = $("input[name='_method']"),
        inputId = $("input[name='id']"),
        formAction = form.prop('action');





    btnCriar.on('click', function () {

        form.slideDown(300);
        btnSalvar.prop("disabled", false);
        trs.removeClass("editing");
        formReset();
        inputMethod.val('post');
        inputId.val('');
        form.prop('action', formAction);
    });

    btnCancelar.on('click', function () {
        form.slideUp(300);
        btnSalvar.prop("disabled", true);
        trs.removeClass("editing");
        formReset();

    });

    function edit(id) {
        var els, el, f, v, i;
        els = $("tr[data-id=" + id + "]  span[data-field]");
        for (i = 0; i < els.length; i += 1) {
            el = $(els[i]);
            f = el.data('field');
            v = el[0].innerText;
            $("#form-" + f).val(v);
        }
        trs.removeClass("editing");
        $("tr[data-id=" + id + "]").addClass("editing");
        form.slideDown(300);
        btnSalvar.prop("disabled", false);
        inputMethod.val('put');
        inputId.val(id);
        form.prop('action', formAction + "/" + id);

    }
    function del (id){
        form.prop('action', formAction + "/" + id);
        inputMethod.val('delete');
        inputId.val('');
        form.prop('method', 'post');
        form.submit();
    };

    function formReset() {
        form.each(function () {
            this.reset();
        });
    };
    return {edit : edit, delete : del};
}(jQuery);
