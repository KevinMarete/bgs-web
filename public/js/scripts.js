/*!
 * Start Bootstrap - SB Admin Pro v1.0.0 (https://shop.startbootstrap.com/product/sb-admin-pro)
 * Copyright 2013-2020 Start Bootstrap
 * Licensed under SEE_LICENSE (https://github.com/BlackrockDigital/sb-admin-pro/blob/master/LICENSE)
 */
(function ($) {
    "use strict";

    // Enable Bootstrap tooltips via data-attributes globally
    $('[data-toggle="tooltip"]').tooltip();

    // Enable Bootstrap popovers via data-attributes globally
    $('[data-toggle="popover"]').popover();

    $(".popover-dismiss").popover({
        trigger: "focus",
    });

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

    // Activate Feather icons
    feather.replace();

    // Activate Bootstrap scrollspy for the sticky nav component
    $("body").scrollspy({
        target: "#stickyNav",
        offset: 82,
    });

    // Scrolls to an offset anchor when a sticky nav link is clicked
    $('.sb-nav-sticky a.nav-link[href*="#"]:not([href="#"])').click(
        function () {
            if (
                location.pathname.replace(/^\//, "") ==
                    this.pathname.replace(/^\//, "") &&
                location.hostname == this.hostname
            ) {
                var target = $(this.hash);
                target = target.length
                    ? target
                    : $("[name=" + this.hash.slice(1) + "]");
                if (target.length) {
                    $("html, body").animate(
                        {
                            scrollTop: target.offset().top - 81,
                        },
                        200
                    );
                    return false;
                }
            }
        }
    );

    // Click to collapse responsive sidebar
    $("#layoutSidenav_content").click(function () {
        const BOOTSTRAP_LG_WIDTH = 992;
        if (window.innerWidth >= 992) {
            return;
        }
        if ($("body").hasClass("sb-sidenav-toggled")) {
            $("body").toggleClass("sb-sidenav-toggled");
        }
    });

    //Click subscription option
    $(document).on("click", ".subscription-btn", function () {
        //Add price, package to hidden field(s) in form
        $(".subscription-price").val($(this).data("price"));
        $(".subscription-package").val($(this).data("package"));
    });

    //Fade-out alert boxes in 5secs
    setTimeout(function () {
        $(".alert").hide();
    }, 10000);

    //Show confirm on .delete
    $(".delete").click(function () {
        var r = confirm("Are you sure?");
        if (r == true) {
            $(this).attr("disabled", "disabled");
        } else {
            return false;
        }
    });

    //Active sidebar link
    $(".menu .nav-link").removeClass("active");
    $("." + $(".page-name").val()).addClass("active");

    //Add new table row
    $(document).on("click", ".add", function () {
        var $tr = $(this).closest(".tr_clone");
        //Current row values
        var product = $tr.find(".product").val();
        var batch_number = $tr.find(".batch_number").val();
        var expiry_date = $tr.find(".expiry_date").val();
        var quantity = $tr.find(".quantity").val();
        if (
            product !== "" &&
            batch_number !== "" &&
            expiry_date !== "" &&
            quantity !== ""
        ) {
            var $clone = $tr.clone();
            $clone.find(":text").val("");
            $clone.find(".expiry_date").val("");
            $tr.after($clone);
        } else {
            alert("Please ensure all inputs are filled!");
        }
    });

    //Remove new table row
    $(document).on("click", ".remove", function () {
        var rowCount = $(".transactions-tbl>tbody tr").length;
        if (rowCount > 1) {
            var r = confirm("Are you sure, you want to remove this row?");
            if (r == true) {
                $(this).parent().parent().remove();
            } else {
                return false;
            }
        } else {
            alert("You cannot remove the last row!");
        }
    });

    //Prevent duplicate form submissions
    $("form").submit(function () {
        $(this).find(":submit").attr("disabled", "disabled");
    });

    //Payment-types change eventHandler
    $(document).on("change", ".payment_types", function () {
        let selected_id = $(this).find(":selected").val();
        let selected_details = $(this).find(":selected").attr("data-details");
        let default_id = $("#default_payment_type_id").val();
        let default_details = $("#default_payment_type_details").val();
        let pretty_details = "";

        if (selected_id === default_id) {
            pretty_details = JSON.stringify(
                JSON.parse(default_details),
                undefined,
                4
            );
        } else {
            pretty_details = JSON.stringify(
                JSON.parse(selected_details),
                undefined,
                4
            );
        }
        $("#payment_details").val(pretty_details);
    });

    //Add pagination and search to product listing pages
    jplist.init();

    //Add multipledatespicker
    $(".display_date").multiDatesPicker({
        dateFormat: "yy-mm-dd",
        minDate: 0, // today
        onSelect: function (display_date) {
            if (!checkAvailability(display_date)) {
                $(".display_date").multiDatesPicker(
                    "removeDates",
                    display_date
                );
            }
            //Add dates to hidden submission field
            let dates = $(".display_date").multiDatesPicker("value");
            $("input:hidden[name=display_date]").val(dates);
            //Display total promotion cost
            let dates_arr = dates.split(",");
            let num_of_dates = dates != "" ? dates_arr.length : 0;
            let promotion_cost = $("#promotion_cost").val();
            $("#total_promotion_cost").text(
                (promotion_cost * num_of_dates).toLocaleString()
            );
        },
    });

    //Check availability for promotion booking
    function checkAvailability(display_date) {
        const limit = $("#booking_Limit").val();
        const bookings = JSON.parse($("#bookings").val());
        if (display_date in bookings) {
            if (bookings[display_date] + 1 > limit) {
                alert("Error! You cannot book on this date, already full.");
                return false;
            }
        }
        return true;
    }
})(jQuery);
