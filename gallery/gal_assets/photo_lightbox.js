// phptos.php에서 사진 클릭 시 브라우저 화면 전체에 꽉 차게 사진 나오는 기능
$(window).on('load', function() {    
    
    $(document).on("click","#pt_section div img", function(){      
      $(".lightbox").fadeIn(300);
      $(".lightbox").append("<img src='" + $(this).attr("src") + "' alt='" + $(this).attr("alt") + "' />");
      $(".filter").css("background-image", "url(" + $(this).attr("src") + ")");
      $(".title").append("<h1 id='photo_title'>" + $(this).attr("alt") + "</h1>");
      $("html").css("overflow", "hidden"); // 사진 확대 시 우측 스크롤 숨김
      if ($(this).parent().is(":last-child")) {
        $(".arrowr").css("display", "none");
        $(".arrowl").css("display", "block");
      } else if ($(this).parent().is(":first-child")) {
        $(".arrowr").css("display", "block");
        $(".arrowl").css("display", "none");
      } else {
        $(".arrowr").css("display", "block");
        $(".arrowl").css("display", "block");
      }
    });

    
    $(document).on("click",".close", function(){
      $(".lightbox").fadeOut(300);
      $("#photo_title").remove();
      $(".lightbox img").remove();
      $("html").css("overflow", "auto");
    });

    $(document).on('keyup', function(e) {
      if (e.keyCode == 27) { // esc 누르면 사진 크게 보는 창 닫힘
        $(".lightbox").fadeOut(300);
        $("#photo_title").remove();
        $(".lightbox img").remove();
        $("html").css("overflow", "auto");
      }
    });

    
    $(document).on("click",".arrowr", function(){
      var imgSrc = $(".lightbox img").attr("src");
      var search = $("#pt_section div").find("img[src$='" + imgSrc + "']").parent();
      var newImage = search.next().children('img').attr("src");
      var newAlt = search.next().children('img').attr("alt");
      /*$(".lightbox img").attr("src", search.next());*/
      $(".lightbox img").attr("src", newImage);
      $(".lightbox img").attr("alt", newAlt);
      $(".filter").css("background-image", "url(" + newImage + ")");
      // $(".title").html("<h1>" + newAlt + "</h1>");
      $("#photo_title").text(newAlt);

      // if (!search.next().is(":last-child")) {
      //   $(".arrowl").css("display", "block");
      // } else {
      //   $(".arrowr").css("display", "none");
      // }

      if (search.next().is(":last-child")) {
        $(".arrowr").css("display", "none");
        $(".arrowl").css("display", "block");
      } else if (search.next().is(":first-child")) {
        $(".arrowr").css("display", "block");
        $(".arrowl").css("display", "none");
      } else {
        $(".arrowr").css("display", "block");
        $(".arrowl").css("display", "block");
      }
    });

    
    $(document).on("click",".arrowl", function(){
      var imgSrc = $(".lightbox img").attr("src");
      var search = $("#pt_section div").find("img[src$='" + imgSrc + "']").parent();
      var newImage = search.prev().children('img').attr("src");
      var newAlt = search.prev().children('img').attr("alt");
      /*$(".lightbox img").attr("src", search.next());*/
      $(".lightbox img").attr("src", newImage);
      $(".lightbox img").attr("alt", newAlt);
      $(".filter").css("background-image", "url(" + newImage + ")");
      // $(".title").html("<h1>" + newAlt + "</h1>");
      $("#photo_title").text(newAlt);

      // if (!search.prev().is(":first-child")) {
      //   $(".arrowr").css("display", "block");
      // } else {
      //   $(".arrowl").css("display", "none");
      // }

      if (search.prev().is(":last-child")) {
        $(".arrowr").css("display", "none");
        $(".arrowl").css("display", "block");
      } else if (search.prev().is(":first-child")) {
        $(".arrowr").css("display", "block");
        $(".arrowl").css("display", "none");
      } else {
        $(".arrowr").css("display", "block");
        $(".arrowl").css("display", "block");
      }
    });

  });