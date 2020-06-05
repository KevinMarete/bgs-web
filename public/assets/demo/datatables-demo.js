// Call the dataTables jQuery plugin
$(document).ready(function () {
    var oTable = $("#dataTable, .dataTable").DataTable({
        order: [[1, "asc"]],
    });

    $(".bulk_all_unpublish[type=checkbox]").on("change", function (e) {
        oTable
            .$(".bulk_item_unpublish[type='checkbox']")
            .not(this)
            .prop("checked", this.checked);

        values = getSelectedTableValues(oTable);
        saveSelectedValues(".pricelist_ids", JSON.stringify(values));
    });

    $(".bulk_all_publish[type=checkbox]").on("change", function (e) {
        oTable
            .$(".bulk_item_publish[type='checkbox']")
            .not(this)
            .prop("checked", this.checked);

        values = getSelectedTableValues(oTable);
        saveSelectedValues(".pricelist_ids", JSON.stringify(values));
    });

    $(document).on(
        "change",
        ".bulk_item_unpublish[type=checkbox]",
        function () {
            values = getSelectedTableValues(oTable);
            saveSelectedValues(".pricelist_ids", JSON.stringify(values));
        }
    );

    $(document).on("change", ".bulk_item_publish[type=checkbox]", function () {
        values = getSelectedTableValues(oTable);
        saveSelectedValues(".pricelist_ids", JSON.stringify(values));
    });

    function getSelectedTableValues(Table) {
        return Table.$("input:checkbox:checked")
            .map(function () {
                return $(this).val();
            })
            .get();
    }

    function saveSelectedValues(element, values) {
        $(element).val(values);
    }
});

$(document).ready(function () {
    $("#dataTableActivity").DataTable({
        order: [[0, "desc"]],
    });
});
