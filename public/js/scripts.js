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

    //Add offer multiselect dropdown
    $("#offer_productnows").multiselect({
        disableIfEmpty: true,
        disabledText: "No Products Selected...",
        buttonWidth: "100%",
        enableFiltering: true,
        includeSelectAllOption: true,
        maxHeight: 200,
        inheritClass: true,
        numberDisplayed: 1,
        enableCaseInsensitiveFiltering: true,
        onChange: function () {
            calculateOfferTotal();
        },
        onSelectAll: function () {
            calculateOfferTotal();
        },
        onDeselectAll: function () {
            calculateOfferTotal();
        },
    });

    function calculateOfferTotal() {
        const productCount = $("#offer_productnows option:selected").length;
        const offerCost = $("#offer_cost").val();

        const startDate = $("#valid_from").val();
        const endDate = $("#valid_until").val();

        const periodDays = countDays(startDate, endDate);

        const offerTotal = periodDays * productCount * offerCost;

        $("#total_offer_cost_display").text(offerTotal.toLocaleString());
        $("#total_offer_cost").val(offerTotal);

        return offerTotal;
    }

    function countDays(startDate, endDate) {
        let days = 0;
        if (startDate != "" || endDate != "") {
            days = Math.round(
                moment
                    .duration(moment(endDate).diff(moment(startDate)))
                    .asDays()
            );
        }
        return days;
    }

    //Add valid period daterangepicker
    $(".valid_period").daterangepicker({
        timePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        timePickerSeconds: true,
        minDate: moment().startOf("day"),
        locale: {
            cancelLabel: "Clear",
        },
    });

    //Datepicker apply event
    $(".valid_period").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(
            picker.startDate.format("MM/DD/YYYY hh:mm A") +
                " - " +
                picker.endDate.format("MM/DD/YYYY hh:mm A")
        );

        $("#valid_from").val(picker.startDate.format("YYYY-MM-DD HH:mm:ss"));
        $("#valid_until").val(picker.endDate.format("YYYY-MM-DD HH:mm:ss"));

        calculateOfferTotal();
    });

    //Add Promotion Carousel
    $(".carousel").carousel();

    //Add RFQ multiselect dropdown
    $("#rfq_organizations").multiselect({
        disableIfEmpty: true,
        disabledText: "No Sellers Selected...",
        buttonWidth: "100%",
        enableFiltering: true,
        includeSelectAllOption: true,
        maxHeight: 200,
        inheritClass: true,
        numberDisplayed: 1,
        enableCaseInsensitiveFiltering: true,
        onChange: function () {
            calculateRFQTotal();
        },
        onSelectAll: function () {
            calculateRFQTotal();
        },
        onDeselectAll: function () {
            calculateRFQTotal();
        },
    });

    function calculateRFQTotal() {
        const sellerSelected = $("#rfq_organizations option:selected").length;
        const rfqCost = $("#rfq_cost").val();
        const rfqDiscount = $("#rfq_discount").val();

        const sellerCount =
            sellerSelected - rfqDiscount >= 0
                ? sellerSelected - rfqDiscount
                : 0;

        const totalRfqCost = sellerCount * rfqCost;

        $("#total_rfq_cost_display").text(totalRfqCost.toLocaleString());
        $("#total_rfq_cost").val(totalRfqCost);

        return totalRfqCost;
    }

    /*Auto-hide reject reason dropdown*/
    $(".reject_reason_container").hide();
    $("#reject_reason").prop("required", false);
    $(".rfq_status").on("change", function () {
        var selectedText = $(":selected", this).text().toLowerCase().trim();
        if (selectedText === "reject") {
            $(".reject_reason_container").show();
            $("#reject_reason").prop("required", true);
        } else {
            $(".reject_reason_container").hide();
            $("#reject_reason").prop("required", false);
        }
    });

    /*Add search to rfq product select*/
    $(".rfq_product").select2();

    /*Add new rfq product row*/
    $(document).on("click", ".add_rfq_product", function () {
        var $tr = $(this).closest(".tr_clone");
        //Current row values
        var product = $tr.find(".product").val();
        var quantity = $tr.find(".quantity").val();
        if (product !== "" && quantity !== "") {
            $("#contents").find(".rfq_product").select2("destroy");
            var $clone = $tr.clone();
            $clone.find(":text").val("");
            $tr.after($clone);
            $("#contents").find(".rfq_product").select2();
            //Scoll to contents
            $("body,html").animate(
                {
                    scrollTop: $("#contents").offset().top,
                },
                800 //speed
            );
        } else {
            alert("Please ensure all inputs are filled!");
        }
    });

    /*Rfq product selecting (unselect) event*/
    $(document).on("select2:selecting", ".rfq_product", function (e) {
        var rfqProducts = $("#rfq_product_list").data("products");
        var index = rfqProducts.indexOf($(this).val());
        if (index > -1) {
            rfqProducts.splice(index, 1);
            $("#rfq_product_list").data("products", rfqProducts);
        }
    });

    /*Rfq product select event*/
    $(document).on("select2:select", ".rfq_product", function (e) {
        var rfqProducts = $("#rfq_product_list").data("products");
        var data = e.params.data;
        if (!rfqProducts.includes(data.id)) {
            if (data.id != "") {
                rfqProducts.push(data.id);
                $("#rfq_product_list").data("products", rfqProducts);
            }
        } else {
            $(this).closest(".rfq_product").val(null).trigger("change");
            alert("You have already selected this product!");
        }
    });

    //Adding dynamic charts
    var charts = [
        { id: "buyerChart", type: "line" },
        { id: "sellerChart", type: "line" },
        { id: "productChart", type: "bar" },
        { id: "rfqChart", type: "line" },
        { id: "orderChart", type: "line" },
        { id: "revenueChart", type: "bar" },
    ];
    charts.map((chart) => {
        createChart(chart.id, chart.type);
    });

    // Set new default font family and font color to mimic Bootstrap's default styling
    (Chart.defaults.global.defaultFontFamily = "Nunito Sans"),
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = "#858796";

    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + "").replace(",", "").replace(" ", "");
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
            dec = typeof dec_point === "undefined" ? "." : dec_point,
            s = "",
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return "" + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || "").length < prec) {
            s[1] = s[1] || "";
            s[1] += new Array(prec - s[1].length + 1).join("0");
        }
        return s.join(dec);
    }

    function createChart(chartId, chartType) {
        var ctx = document.getElementById(chartId);
        var chartLabels = $("#" + chartId).data("labels");
        var chartData = $("#" + chartId).data("datasets");
        var myChart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: "Revenue",
                        backgroundColor: "rgba(0, 97, 242, 1)",
                        hoverBackgroundColor: "rgba(0, 97, 242, 0.9)",
                        borderColor: "#4e73df",
                        data: chartData,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0,
                    },
                },
                scales: {
                    xAxes: [
                        {
                            time: {
                                unit: "month",
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                //maxTicksLimit: 6,
                            },
                            maxBarThickness: 25,
                        },
                    ],
                    yAxes: [
                        {
                            ticks: {
                                min: 0,
                                //max: 15000,
                                maxTicksLimit: 5,
                                padding: 10,
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return "$" + number_format(value);
                                },
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2],
                            },
                        },
                    ],
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel =
                                chart.datasets[tooltipItem.datasetIndex]
                                    .label || "";
                            return (
                                datasetLabel +
                                ": $" +
                                number_format(tooltipItem.yLabel)
                            );
                        },
                    },
                },
            },
        });
    }
})(jQuery);
