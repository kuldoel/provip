/*! jQuery Mobile v1.3.0 | Copyright 2010, 2013 jQuery Foundation, Inc. | jquery.org/license */
(function(a,b,c){typeof define=="function"&&define.amd?define(["jquery"],function(d){return c(d,a,b),d.mobile}):c(a.jQuery,a,b)})(this,document,function(a,b,c,d){(function(a){a.mobile={}})(a),function(a,b){var d={touch:"ontouchend"in c};a.mobile.support=a.mobile.support||{},a.extend(a.support,d),a.extend(a.mobile.support,d)}(a),function(a,b,c,d){function x(a){while(a&&typeof a.originalEvent!="undefined")a=a.originalEvent;return a}function y(b,c){var e=b.type,f,g,i,k,l,m,n,o,p;b=a.Event(b),b.type=c,f=b.originalEvent,g=a.event.props,e.search(/^(mouse|click)/)>-1&&(g=j);if(f)for(n=g.length,k;n;)k=g[--n],b[k]=f[k];e.search(/mouse(down|up)|click/)>-1&&!b.which&&(b.which=1);if(e.search(/^touch/)!==-1){i=x(f),e=i.touches,l=i.changedTouches,m=e&&e.length?e[0]:l&&l.length?l[0]:d;if(m)for(o=0,p=h.length;o<p;o++)k=h[o],b[k]=m[k]}return b}function z(b){var c={},d,f;while(b){d=a.data(b,e);for(f in d)d[f]&&(c[f]=c.hasVirtualBinding=!0);b=b.parentNode}return c}function A(b,c){var d;while(b){d=a.data(b,e);if(d&&(!c||d[c]))return b;b=b.parentNode}return null}function B(){r=!1}function C(){r=!0}function D(){v=0,p.length=0,q=!1,C()}function E(){B()}function F(){G(),l=setTimeout(function(){l=0,D()},a.vmouse.resetTimerDuration)}function G(){l&&(clearTimeout(l),l=0)}function H(b,c,d){var e;if(d&&d[b]||!d&&A(c.target,b))e=y(c,b),a(c.target).trigger(e);return e}function I(b){var c=a.data(b.target,f);if(!q&&(!v||v!==c)){var d=H("v"+b.type,b);d&&(d.isDefaultPrevented()&&b.preventDefault(),d.isPropagationStopped()&&b.stopPropagation(),d.isImmediatePropagationStopped()&&b.stopImmediatePropagation())}}function J(b){var c=x(b).touches,d,e;if(c&&c.length===1){d=b.target,e=z(d);if(e.hasVirtualBinding){v=u++,a.data(d,f,v),G(),E(),o=!1;var g=x(b).touches[0];m=g.pageX,n=g.pageY,H("vmouseover",b,e),H("vmousedown",b,e)}}}function K(a){if(r)return;o||H("vmousecancel",a,z(a.target)),o=!0,F()}function L(b){if(r)return;var c=x(b).touches[0],d=o,e=a.vmouse.moveDistanceThreshold,f=z(b.target);o=o||Math.abs(c.pageX-m)>e||Math.abs(c.pageY-n)>e,o&&!d&&H("vmousecancel",b,f),H("vmousemove",b,f),F()}function M(a){if(r)return;C();var b=z(a.target),c;H("vmouseup",a,b);if(!o){var d=H("vclick",a,b);d&&d.isDefaultPrevented()&&(c=x(a).changedTouches[0],p.push({touchID:v,x:c.clientX,y:c.clientY}),q=!0)}H("vmouseout",a,b),o=!1,F()}function N(b){var c=a.data(b,e),d;if(c)for(d in c)if(c[d])return!0;return!1}function O(){}function P(b){var c=b.substr(1);return{setup:function(d,f){N(this)||a.data(this,e,{});var g=a.data(this,e);g[b]=!0,k[b]=(k[b]||0)+1,k[b]===1&&t.bind(c,I),a(this).bind(c,O),s&&(k.touchstart=(k.touchstart||0)+1,k.touchstart===1&&t.bind("touchstart",J).bind("touchend",M).bind("touchmove",L).bind("scroll",K))},teardown:function(d,f){--k[b],k[b]||t.unbind(c,I),s&&(--k.touchstart,k.touchstart||t.unbind("touchstart",J).unbind("touchmove",L).unbind("touchend",M).unbind("scroll",K));var g=a(this),h=a.data(this,e);h&&(h[b]=!1),g.unbind(c,O),N(this)||g.removeData(e)}}}var e="virtualMouseBindings",f="virtualTouchID",g="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),h="clientX clientY pageX pageY screenX screenY".split(" "),i=a.event.mouseHooks?a.event.mouseHooks.props:[],j=a.event.props.concat(i),k={},l=0,m=0,n=0,o=!1,p=[],q=!1,r=!1,s="addEventListener"in c,t=a(c),u=1,v=0,w;a.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500};for(var Q=0;Q<g.length;Q++)a.event.special[g[Q]]=P(g[Q]);s&&c.addEventListener("click",function(b){var c=p.length,d=b.target,e,g,h,i,j,k;if(c){e=b.clientX,g=b.clientY,w=a.vmouse.clickDistanceThreshold,h=d;while(h){for(i=0;i<c;i++){j=p[i],k=0;if(h===d&&Math.abs(j.x-e)<w&&Math.abs(j.y-g)<w||a.data(h,f)===j.touchID){b.preventDefault(),b.stopPropagation();return}}h=h.parentNode}}},!0)}(a,b,c),function(a,b,d){function k(b,c,d){var e=d.type;d.type=c,a.event.dispatch.call(b,d),d.type=e}var e=a(c);a.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight scrollstart scrollstop".split(" "),function(b,c){a.fn[c]=function(a){return a?this.bind(c,a):this.trigger(c)},a.attrFn&&(a.attrFn[c]=!0)});var f=a.mobile.support.touch,g="touchmove scroll",h=f?"touchstart":"mousedown",i=f?"touchend":"mouseup",j=f?"touchmove":"mousemove";a.event.special.scrollstart={enabled:!0,setup:function(){function f(a,c){d=c,k(b,d?"scrollstart":"scrollstop",a)}var b=this,c=a(b),d,e;c.bind(g,function(b){if(!a.event.special.scrollstart.enabled)return;d||f(b,!0),clearTimeout(e),e=setTimeout(function(){f(b,!1)},50)})}},a.event.special.tap={tapholdThreshold:750,setup:function(){var b=this,c=a(b);c.bind("vmousedown",function(d){function i(){clearTimeout(h)}function j(){i(),c.unbind("vclick",l).unbind("vmouseup",i),e.unbind("vmousecancel",j)}function l(a){j(),f===a.target&&k(b,"tap",a)}if(d.which&&d.which!==1)return!1;var f=d.target,g=d.originalEvent,h;c.bind("vmouseup",i).bind("vclick",l),e.bind("vmousecancel",j),h=setTimeout(function(){k(b,"taphold",a.Event("taphold",{target:f}))},a.event.special.tap.tapholdThreshold)})}},a.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:30,verticalDistanceThreshold:75,start:function(b){var c=b.originalEvent.touches?b.originalEvent.touches[0]:b;return{time:(new Date).getTime(),coords:[c.pageX,c.pageY],origin:a(b.target)}},stop:function(a){var b=a.originalEvent.touches?a.originalEvent.touches[0]:a;return{time:(new Date).getTime(),coords:[b.pageX,b.pageY]}},handleSwipe:function(b,c){c.time-b.time<a.event.special.swipe.durationThreshold&&Math.abs(b.coords[0]-c.coords[0])>a.event.special.swipe.horizontalDistanceThreshold&&Math.abs(b.coords[1]-c.coords[1])<a.event.special.swipe.verticalDistanceThreshold&&b.origin.trigger("swipe").trigger(b.coords[0]>c.coords[0]?"swipeleft":"swiperight")},setup:function(){var b=this,c=a(b);c.bind(h,function(b){function g(b){if(!e)return;f=a.event.special.swipe.stop(b),Math.abs(e.coords[0]-f.coords[0])>a.event.special.swipe.scrollSupressionThreshold&&b.preventDefault()}var e=a.event.special.swipe.start(b),f;c.bind(j,g).one(i,function(){c.unbind(j,g),e&&f&&a.event.special.swipe.handleSwipe(e,f),e=f=d})})}},a.each({scrollstop:"scrollstart",taphold:"tap",swipeleft:"swipe",swiperight:"swipe"},function(b,c){a.event.special[b]={setup:function(){a(this).bind(c,a.noop)}}})}(a,this)})
// Placeholder plugin for jQuery
!function(b){function d(a){this.input=a;a.attr("type")=="password"&&this.handlePassword();b(a[0].form).submit(function(){if(a.hasClass("placeholder")&&a[0].value==a.attr("placeholder"))a[0].value=""})}d.prototype={show:function(a){if(this.input[0].value===""||a&&this.valueIsPlaceholder()){if(this.isPassword)try{this.input[0].setAttribute("type","text")}catch(b){this.input.before(this.fakePassword.show()).hide()}this.input.addClass("placeholder");this.input[0].value=this.input.attr("placeholder")}},hide:function(){if(this.valueIsPlaceholder()&&this.input.hasClass("placeholder")&&(this.input.removeClass("placeholder"),this.input[0].value="",this.isPassword)){try{this.input[0].setAttribute("type","password")}catch(a){}this.input.show();this.input[0].focus()}},valueIsPlaceholder:function(){return this.input[0].value==this.input.attr("placeholder")},handlePassword:function(){var a=this.input;a.attr("realType","password");this.isPassword=!0;if(b.browser.msie&&a[0].outerHTML){var c=b(a[0].outerHTML.replace(/type=(['"])?password\1/gi,"type=$1text$1"));this.fakePassword=c.val(a.attr("placeholder")).addClass("placeholder").focus(function(){a.trigger("focus");b(this).hide()});b(a[0].form).submit(function(){c.remove();a.show()})}}};var e=!!("placeholder"in document.createElement("input"));b.fn.placeholder=function(){return e?this:this.each(function(){var a=b(this),c=new d(a);c.show(!0);a.focus(function(){c.hide()});a.blur(function(){c.show(!1)});b.browser.msie&&(b(window).load(function(){a.val()&&a.removeClass("placeholder");c.show(!0)}),a.focus(function(){if(this.value==""){var a=this.createTextRange();a.collapse(!0);a.moveStart("character",0);a.select()}}))})}}(window.jQuery)

// data-shift api 
!function ($) {

  "use strict"; // jshint ;_;

 /* SHIFT CLASS DEFINITION
  * ====================== */

  var Shift = function (element) {
    this.$element = $(element)
    this.$prev = this.$element.prev()
    !this.$prev.length && (this.$parent = this.$element.parent())
  }

  Shift.prototype = {
  	constructor: Shift

    , init:function(){
    	var $el = this.$element
    	, method = $el.data()['toggle'].split(':')[1]    	
    	, $target = $el.data('target')
    	$el.hasClass('in') || $el[method]($target).addClass('in')
    }
    , reset :function(){
    	this.$parent && this.$parent['prepend'](this.$element)
    	!this.$parent && this.$element['insertAfter'](this.$prev)
    	this.$element.removeClass('in')
    }
  }

 /* SHIFT PLUGIN DEFINITION
  * ======================= */

  $.fn.shift = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('shift')
      if (!data) $this.data('shift', (data = new Shift(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.shift.Constructor = Shift
}(window.jQuery);

Date.now = Date.now || function() { return +new Date; };

!function ($) {

  $(function(){


     $(document).on('click', '.student-details', function() {

         $btn  = $(this);
         $slug = $(this).attr('data-student');

         var jqxhr = $.get(Routing.generate('provip_application_marketplace_detailuser',{ slug: $slug }), function() {
         })
         .done(function(data) {
                 $btn.popover({
                     'content': data
                 });
         })
         .always(function() {

         });

     })

     $(document).on('click', '.remove-task-pre-submit', function(e) {
         $btn = $(e.target);
         console.log($btn.closest('.row').remove());
     });

      $('.date').datepicker().on('changeDate', function(ev){
          $('.datepicker').hide();
      });


      $('a.new-skill').click(function(e){

          $('.loader').show();

          $.post(Routing.generate('provip_application_hei_info'),$('form.new-skill').serialize())
              .fail(function(xhr, status, error){
                  $('.errors').show();
                  $('.errors').html(xhr.responseText);
              })
              .done(function(data){
                  $('div.skills').append(data);
                  setTimeout(function() {$('div.skills .new').removeClass('new')}, 0);
                  $('form.new-skill').trigger("reset");
                  $('.errors').hide();
              })
              .always(function(){
                  $('.loader').hide();
              })

      });

      $('button.new-staff').click(function(e){

          e.preventDefault();

          $('.loader').show();

          $.post(Routing.generate('provip_application_company_staff'),$('form.new-staff').serialize())
              .fail(function(xhr, status, error){
                $('.errors').show();
                $('.errors').html(xhr.responseText);
              })
              .done(function(data){
                $('#new-staff-member').modal('hide');
                $('#staff-list').prepend(data);
                setTimeout(function() {$('#staff-list .new').removeClass('new')}, 0);
                $('form.new-staff').trigger("reset");
                $('.errors').hide();
              })
              .always(function(){
                  $('.loader').hide();
              })

      });

      $('button.new-hei-staff').click(function(e){

          e.preventDefault();

          $('.loader').show();

          $.post(Routing.generate('provip_application_hei_staff'),$('form.new-staff').serialize())
              .fail(function(xhr, status, error){
                  $('.errors').show();
                  $('.errors').html(xhr.responseText);
              })
              .done(function(data){
                  $('#new-staff-member').modal('hide');
                  $('#staff-list').prepend(data);
                  setTimeout(function() {$('#staff-list .new').removeClass('new')}, 0);
                  $('form.new-staff').trigger("reset");
                  $('.errors').hide();
              })
              .always(function(){
                  $('.loader').hide();
              })

      });


      $('button.new-goal').click(function(e){

          e.preventDefault();

          $('.loader').show();

          $.post(Routing.generate('provip_application_opportunity_detail',{ slug: $('button.complete-opportunity').attr('data-slug') }),$('form.new-goal').serialize())
              .fail(function(xhr, status, error){
                  $('.errors').show();
                  $('.errors').html(xhr.responseText);
              })
              .done(function(data){

                  $('#new-goal').modal('hide');
                  $('.panel-content.goals').prepend(data);
                  setTimeout(function() {$('.panel-content .new').removeClass('new')}, 0);
                  $('form.new-goal').trigger("reset");
                  $('.errors').hide();
              })
              .always(function(){
                  $('.loader').hide();
              })

      });

      $('button.new-learning-goal').click(function(e){

          e.preventDefault();

          $('.loader').show();

          $.post(Routing.generate('provip_application_hei_info'),$('form.new-goal').serialize())
              .fail(function(xhr, status, error){
                  $('.errors').show();
                  $('.errors').html(xhr.responseText);
              })
              .done(function(data){

                  $('#new-goal').modal('hide');
                  $('ul.goals').prepend(data);
                  setTimeout(function() {$('ul.goals .new').removeClass('new')}, 0);
                  $('form.new-goal').trigger("reset");
                  $('.errors').hide();
              })
              .always(function(){
                  $('.loader').hide();
              })

      });

      $('button.complete-opportunity').click(function(e){

          e.preventDefault();

          $('.loader').show();

          $.post(Routing.generate('provip_application_opportunity_detail',{ slug: $(this).attr('data-slug') }),$('form.complete-opportunity').serialize())
              .fail(function(xhr, status, error){
                  $('.errors').show();
                  $('.errors').html(xhr.responseText);
                  $("#errors").modal('show');
              })
              .done(function(xhr, status){
                  console.log(xhr);
                  $('.errors').hide();
                  $('button.complete-opportunity').removeClass('btn-success')
                      .addClass('disabled')
                      .text('Saved!');
                  $('button.complete-opportunity').attr('data-slug', xhr);
              })
              .always(function(){
                  $('.loader').hide();
              })

      });

      $('body').on('click', '.show-goal', function(e){

          $('.loader').show();

          var goalId = $(this).attr('data-goal');
          var opportunitySlug = $(this).attr('data-opportunity');

          var jqxhr = $.get(Routing.generate('provip_application_opportunity_editgoal',{ slug: opportunitySlug, deliverable_id: goalId  }), function() {
             console.log("loading goal")
          })
              .done(function(data) {
                  $('.goal-form').html(data);
                  $('#edit-goal').modal('show');
              })
              .always(function() { $('.loader').hide(); });

      });

      $('body').on('click', '.delete-goal', function(e){

          $('.loader').show();

          var goalId = $(this).attr('data-goal');
          var opportunitySlug = $(this).attr('data-opportunity');

          $(this).parent().parent().parent().hide();

          var jqxhr = $.get(Routing.generate('provip_application_opportunity_deletegoal',{ slug: opportunitySlug, deliverable_id: goalId  }), function() {
              console.log("deleting goal")
          })
              .done(function(data) {
                  console.log($(this).parent().parent().parent().remove());
              })
              .always(function() { $('.loader').hide(); });

      });

      $('.toggle-opportunity').click(function(){


          var btn = $(this);

          $('.loader').show();

          var opportunitySlug = $(this).attr('data-opportunity');

          var jqxhr = $.get(Routing.generate('provip_application_opportunity_toggle',{ slug: opportunitySlug }), function() {
              console.log("toggling...")
          })
          .done(function(data) {
                console.log(data);
                  if(data == "complete")
                  {
                      btn
                          .removeClass('btn-success')
                          .removeClass('active')
                          .addClass('btn-info')
                          .text('Publish')
                  }
                  if(data == "published")
                  {
                      btn
                          .removeClass('btn-info')
                          .addClass('active')
                          .addClass('btn-success')
                          .text('Published')
                  }
          })
          .always(function() { $('.loader').hide(); });


      });

      $('.approve').click(function(){

          var btn = $(this);

          $('.loader').show();

          var enrollment = $(this).attr('data-enrollment');

          var jqxhr = $.get(Routing.generate('provip_application_hei_approve',{ id: enrollment }), function() {
              console.log("approving...")
          })
              .done(function(data) {
                  console.log(data);
                  if(data == "complete")
                  {
                      btn
                          .removeClass('btn-success')
                          .addClass('btn-disabled')
                          .text('Approved')
                  }
              })
              .always(function() { $('.loader').hide(); });


      });



      $("form.complete-opportunity :input").focus(function() {
          if($('button.complete-opportunity').hasClass('disabled'))
          {
              $('button.complete-opportunity')
                  .removeClass('disabled')
                  .addClass('btn-success')
                  .text('Save changes')
          }
      });

      $('button.new-opportunity').click(function(e){

          e.preventDefault();

          $('.loader').show();

          $.post(Routing.generate('provip_application_opportunity_index'),$('form.new-opportunity').serialize())
              .fail(function(xhr, status, error){
                  $('.errors').show();
                  $('.errors').html(xhr.responseText);
              })
              .done(function(data){
                  $('#new-opportunity').modal('hide');
                  $('#opportunity-list').prepend(data);
                  setTimeout(function() {$('#opportunity-list .new').removeClass('new')}, 0);
                  $('form.new-opportunity').trigger("reset");
                  $('.errors').hide();
              })
              .always(function(){
                  $('.loader').hide();
              })

      });

      $('.staff-search').keyup(function() {

          $('.loader').show();

          $.get(Routing.generate('provip_application_company_search',{ q: $(this).val() }))
              .fail(function(xhr, status, error){
                  alert(xhr.responseText);
              })
              .done(function(data){
                  $('#staff-list').html(data);
                  $('.loader').hide();
              })
      });


      $('.hei-staff-search').keyup(function() {

          $('.loader').show();

          $.get(Routing.generate('provip_application_hei_search',{ q: $(this).val() }))
              .fail(function(xhr, status, error){
                  alert(xhr.responseText);
              })
              .done(function(data){
                  $('#staff-list').html(data);
                  $('.loader').hide();
              })
      });



    // select boxes bootstrap-select.min.js
    $('.selectpicker').selectpicker();


  	// placeholder
  	$('input[placeholder], textarea[placeholder]').placeholder();

    // popover
    $("[data-toggle=popover]").popover();
    $(document).on('click', '.popover-title .close', function(e){
    	var $target = $(e.target), $popover = $target.closest('.popover').prev();
    	$popover && $popover.popover('hide');
    });

	// tooltip
    $("[data-toggle=tooltip]").tooltip();

  	// class
	$(document).on('click', '[data-toggle^="class"]', function(e){
		e && e.preventDefault();
		var $this = $(e.target), $class , $target;
		!$this.data('toggle') && ($this = $this.closest('[data-toggle^="class"]'));
    	$class = $this.data()['toggle'].split(':')[1];
    	$target = $( $this.data('target') || $this.attr('href') );
    	$target.toggleClass($class);
    	$this.toggleClass('active');
	});

	// panel toggle
	$(document).on('click', '.panel-toggle', function(e){
		e && e.preventDefault();
		var $this = $(e.target), $class = 'panel-collapse' , $target;
		if (!$this.is('a')) $this = $this.closest('a');
		$target = $this.closest('.panel');
    	$target.toggleClass($class);
    	$this.toggleClass('active');
	});
	
	// carousel
	$('.carousel.auto').carousel();
	
	// button loading
	$(document).on('click.button.data-api', '[data-loading-text]', function (e) {
	    var $this = $(e.target);
	    $this.is('i') && ($this = $this.parent());
	    $this.button('loading');
	});

	// carousel swipe
	$(".carousel").swiperight(function() {
		$(this).find('.left').trigger('click');
    });

    $(".carousel").swipeleft(function() {
        $(this).find('.right').trigger('click');
    });

    var scrollToTop = function(){
		!location.hash && setTimeout(function () {
		    if (!pageYOffset) window.scrollTo(0, 0);
		}, 1000);
	};
	
    var $window = $(window);
    // mobile
	var mobile = function(option){
		if(option == 'reset'){
			$('[data-toggle^="shift"]').shift('reset');
			return;
		}
		scrollToTop();
		$('[data-toggle^="shift"]').shift('init');
	};
	// unmobile
	$window.width() < 768 && mobile();
  	$window.resize(function() {
	  	$window.width() < 767 && mobile();
	   	$window.width() >= 768 && mobile('reset');
	});


  	var isRgbaSupport = function(){
		var value = 'rgba(1,1,1,0.5)',
		el = document.createElement('p'),
		result = false;
		try {
			el.style.color = value;
			result = /^rgba/.test(el.style.color);
		} catch(e) {}
		el = null;
		return result;
	};

	var toRgba = function(str, alpha){
		var patt = /^#([\da-fA-F]{2})([\da-fA-F]{2})([\da-fA-F]{2})$/;
		var matches = patt.exec(str);
		return "rgba("+parseInt(matches[1], 16)+","+parseInt(matches[2], 16)+","+parseInt(matches[3], 16)+","+alpha+")";
	};

	// chart js
	var generateSparkline = function($re){
		$(".sparkline").each(function(){
			var $data = $(this).data();
			if($re && !$data.resize) return;
			if($data.type == 'bar'){
				!$data.barColor && ($data.barColor = "#3fcf7f");
				!$data.barSpacing && ($data.barSpacing = 2);
				$(this).next('.axis').find('li').css('width',$data.barWidth+'px').css('margin-right',$data.barSpacing+'px');
			};
			
			($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
			
			// $data.fillColor && ($data.fillColor.indexOf("#") !== -1) && isRgbaSupport() && ($data.fillColor = toRgba($data.fillColor, 0.5));
			$data.spotColor = $data.minSpotColor = $data.maxSpotColor = $data.highlightSpotColor = $data.lineColor;
			$(this).sparkline( $data.data || "html", $data);

			if($(this).data("compositeData")){
				var $cdata = {};
				$cdata.composite = true;
				$cdata.spotRadius = $data.spotRadius;
				$cdata.lineColor = $data.compositeLineColor || '#a3e2fe';
				$cdata.fillColor = $data.compositeFillColor || '#e3f6ff';
				$cdata.highlightLineColor =  $data.highlightLineColor;
				$cdata.spotColor = $cdata.minSpotColor = $cdata.maxSpotColor = $cdata.highlightSpotColor = $cdata.lineColor;
				isRgbaSupport() && ($cdata.fillColor = toRgba($cdata.fillColor, 0.5));
				$(this).sparkline($(this).data("compositeData"),$cdata);
			};
			if($data.type == 'line'){
				$(this).next('.axis').addClass('axis-full');
			};
		});
	};

	var sparkResize;
	$(window).resize(function(e) {
		clearTimeout(sparkResize);
		sparkResize = setTimeout(function(){generateSparkline(true)}, 500);
	});
	generateSparkline(false);

	// easypie
	var updatePie = function($that) {
		var $this = $that, 
		$text = $('span', $this), 
		$oldValue = $text.html(), 
		$newValue = Math.round(100*Math.random());
	    
	    $this.data('easyPieChart').update($newValue);

	    $({v: $oldValue}).animate({v: $newValue}, {
			duration: 1000,
			easing:'swing',
			step: function() {
				$text.text(Math.ceil(this.v));
			}
		});
	};

    $('.easypiechart').each(function(){
    	var $barColor = $(this).data("barColor") || function($percent) {
            $percent /= 100;
            return "rgb(" + Math.round(255 * (1-$percent)) + ", " + Math.round(255 * $percent) + ", 125)";
        },
		$trackColor = $(this).data("trackColor") || "#c8d2db",
		$scaleColor = $(this).data("scaleColor"),
		$lineWidth = $(this).data("lineWidth") || 12,
		$size = $(this).data("size") || 130,
		$animate = $(this).data("animate") || 1000;

		$(this).easyPieChart({
	        barColor: $barColor,
	        trackColor: $trackColor,
	        scaleColor: $scaleColor,
	        lineCap: 'butt',
	        lineWidth: $lineWidth,
	        size: $size,
	        animate: $animate,
	        onStop: function(){
	        	var $this = this.$el;
	        	$this.data("loop") && setTimeout(function(){ $this.data("loop") && updatePie($this) }, 2000);        	
	        }
	    });
	});

    $(document).on('click', '[data-toggle^="class:pie"]', function (e) {
    	e && e.preventDefault();
	    var $btn = $(e.target), $loop = $('[data-loop]').data('loop'), $target;
	    !$btn.data('toggle') && ($btn = $btn.closest('[data-toggle^="class"]'));
	    $target = $btn.data('target');
	    !$target && ($target = $btn.closest('[data-loop]'));
		$target.data('loop', !$loop);
		!$loop && updatePie($('[data-loop]'));
	});
    
	$(".combodate").each(function(){ $(this).combodate();});

	$('.dropfile').each(function(){
		var $dropbox = $(this);
		if (typeof window.FileReader === 'undefined') {
		  $('small',this).html('File API & FileReader API not supported').addClass('text-danger');
		  return;
		}

		this.ondragover = function () {$dropbox.addClass('hover'); return false; };
		this.ondragend = function () {$dropbox.removeClass('hover'); return false; };
		this.ondrop = function (e) {
		  e.preventDefault();
		  $dropbox.removeClass('hover').html('');
		  var file = e.dataTransfer.files[0],
		      reader = new FileReader();
		  reader.onload = function (event) {
		  	$dropbox.append($('<img>').attr('src', event.target.result));
		  };
		  reader.readAsDataURL(file);
		  return false;
		};
	});





  });
}(window.jQuery);



function setupTaskForm() {

// Get the ul that holds the collection of tags
    var collectionHolder = $('article.tasks');

// setup an "add a tag" link
    var $addTagLink = $('<div class="row"><div class="col col-lg-12"><a href="#" class="btn btn-info btn-small"><i class="icon-plus"></i>Add a task</a></div></div>');
    var $newLinkLi = $('<div></div>').append($addTagLink);

    // add the "add a tag" anchor and li to the tags ul
    collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolder.data('index', collectionHolder.find(':input').length);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm(collectionHolder, $newLinkLi);
    });
};

function addTagForm(collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');

    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div></div>').append(newForm);
    $newLinkLi.before($newFormLi);
    $('.date').datepicker().on('changeDate', function(ev){
        $('.datepicker').hide();
    });
}

function setupBoxes() {
    boxes = $('.fixed-height');
    maxHeight = Math.max.apply(
        Math, boxes.map(function() {
            return $(this).height();
        }).get());
    boxes.height(maxHeight);
}

$(document).ready(function(){
   $('a[rel="popover"]').popover();
   setupTaskForm();
   setupBoxes();

});