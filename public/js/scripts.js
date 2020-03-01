/*!
    * Start Bootstrap - SB Admin Pro v1.0.0 (https://shop.startbootstrap.com/product/sb-admin-pro)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under SEE_LICENSE (https://github.com/BlackrockDigital/sb-admin-pro/blob/master/LICENSE)
    */
    (function($) {
  "use strict";

  // Enable Bootstrap tooltips via data-attributes globally
  $('[data-toggle="tooltip"]').tooltip();

  // Enable Bootstrap popovers via data-attributes globally
  $('[data-toggle="popover"]').popover();

  $(".popover-dismiss").popover({
    trigger: "focus"
  });

  // Add active state to sidbar nav links
  var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
  $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
    if (this.href === path) {
      $(this).addClass("active");
    }
  });

  // Toggle the side navigation
  $("#sidebarToggle").on("click", function(e) {
    e.preventDefault();
    $("body").toggleClass("sb-sidenav-toggled");
  });

  // Activate Feather icons
  feather.replace();

  // Activate Bootstrap scrollspy for the sticky nav component
  $("body").scrollspy({
    target: "#stickyNav",
    offset: 82
  });

  // Scrolls to an offset anchor when a sticky nav link is clicked
  $('.sb-nav-sticky a.nav-link[href*="#"]:not([href="#"])').click(function() {
    if (
      location.pathname.replace(/^\//, "") ==
        this.pathname.replace(/^\//, "") &&
      location.hostname == this.hostname
    ) {
      var target = $(this.hash);
      target = target.length ? target : $("[name=" + this.hash.slice(1) + "]");
      if (target.length) {
        $("html, body").animate(
          {
            scrollTop: target.offset().top - 81
          },
          200
        );
        return false;
      }
    }
  });

  // Click to collapse responsive sidebar
  $("#layoutSidenav_content").click(function() {
    const BOOTSTRAP_LG_WIDTH = 992;
    if (window.innerWidth >= 992) {
      return;
    }
    if ($("body").hasClass("sb-sidenav-toggled")) {
        $("body").toggleClass("sb-sidenav-toggled");
    }
  });

  //Click subscription option
  $(document).on( "click", ".subscription-btn", function() {
    //Add price, package to hidden field(s) in form
    $(".subscription-price").val($(this).data('price'))
    $(".subscription-package").val($(this).data('package'))
  });

  //Fade-out alert boxes in 5secs
  setTimeout(function() {
    $(".alert").hide()
  }, 10000);

  //Show confirm on .delete
  $('.delete').click(function() {
    var r = confirm("Are you sure?");
    if (r == true){
      $(this).attr('disabled', 'disabled');
    }else{
      return false;
    }
  });

  //Active sidebar link
  $('.menu .nav-link').removeClass('active');
  $('.'+$('.page-name').val()).addClass('active');

  //Add new table row
  $(document).on('click', '.add', function () {
    var $tr    = $(this).closest('.tr_clone');
    //Current row values
    var product =$tr.find('.product').val();
    var batch_number =$tr.find('.batch_number').val();
    var expiry_date =$tr.find('.expiry_date').val();
    var quantity =$tr.find('.quantity').val();
    if(product !== '' && batch_number !== '' && expiry_date !== '' && quantity !== ''){
      var $clone = $tr.clone();
      $clone.find(':text').val('');
      $clone.find('.expiry_date').val('');
      $tr.after($clone);
    }else{
      alert('Please ensure all inputs are filled!')
    }
  });

  //Remove new table row
  $(document).on('click', '.remove', function () {
    var rowCount = $('.transactions-tbl>tbody tr').length;
    if(rowCount>1){
      var r = confirm("Are you sure, you want to remove this row?");
      if (r == true){
        $(this).parent().parent().remove();
      }else{
        return false;
      }
    }else{
      alert('You cannot remove the last row!')
    }
  });

})(jQuery);
