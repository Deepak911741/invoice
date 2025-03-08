<script>
//common js
var pagination_view_html = 'ajax-view';
//custom plugins
(function($) {
	$.extend({
		ovrly: function(wrapper) {
			var container = wrapper ? wrapper : "body";
			var methods = {
				init: function() {
					$(container)
						.addClass('rel-pos')
						.children(".overlay-block")
						.remove();

					var style = '';
					if (wrapper == '' || wrapper == 'body' || wrapper === undefined) {
						style = 'style="position:fixed; height: 100vh; width: 100vw;z-index: 1099;"';
					}

					$(`<div class="overlay-block" ${ style }>
						<div>
							<div class="spinner-border text-light" role="status">
								<span class="sr-only">Loading...</span>
							</div>
						</div>
					</div>`).appendTo(container);

					if ($('#overlayBlockStyle').length < 1) {
						$(`<style id="overlayBlockStyle">
								.rel-pos { position:relative !important; overflow-y: hidden; }
								.overlay-block { position: absolute; height: 100%; width: 100%; top: 0; left: 0; background-color: rgba(30, 30, 30, 0.75); z-index: 1010; color: #fff; display: flex; align-items: center; justify-content: center; }
							</style>`
						).appendTo("body");
					}
				},
				kill: function() {
					$(container).find(".overlay-block").fadeOut(150, function() {
						$(this).remove();
						setTimeout(() => {
							$(container).removeClass('rel-pos');
						}, 150);
					});
				}
			};

			return methods;
		}
	});

	$.fn.elasticMenu = function() {
		if ($(window).innerWidth() < 992) {
			return;
		} else {
			var $elm = $(this);
			$elm.each(function() {
				var $nav = $(this);
				var activeItem = $($nav).find(".active");
				var navItems = $($nav).attr("data-bs-targets");
				var shadow = $("<div>", { class: "nav-shadow" }).css({
					width: 0,
					transform: "translate3d(-50%,-100%, 0)",
					opacity: 0
				});

				// activeItem.addClass("is-active");
				shadow.insertAfter($nav);

				// here i_* = initial;
				var i_top = 0;
				var i_left = 0;
				var i_height = 0;
				var i_width = 0;
				var i_opacity = 0;

				function UpdateActiveCoords() {
					if (activeItem.length == 1) {
						i_top = activeItem.offset().top;
						i_left = activeItem.offset().left;
						i_height = activeItem.outerHeight();
						i_width = activeItem.outerWidth();
						i_opacity = 1;
					} else {
						i_top = $nav.offset().top;
						i_left = $nav.offset().left;
						i_height = $nav.outerHeight();
						i_width = 0; //$nav.outerWidth();
						i_opacity = 0;
					}
				}

				function moveShadow(t, l, h, w, o) {
					shadow.css({
						"background-color": "#f90",
						"transition": "0.35s all",
						"opacity": o,
						"position": "fixed",
						"z-index": -1,
						"height": h,
						"width": w,
						"left": l + w / 2
					});
				}

				UpdateActiveCoords();
				moveShadow(i_top, i_left, i_height, i_width, i_opacity);

				// here c_* = current
				var c_height;
				var c_width;
				var c_top;
				var c_left;
				var c_opacity;

				$(navItems).each(function() {
					$(this).hover(
						function() {
							c_height = $(this).outerHeight();
							c_width = $(this).outerWidth();
							c_top = $(this).offset().top;
							c_left = $(this).offset().left;
							c_opacity = 1;
							// console.log(top, left, height, width);
							moveShadow( c_top , c_left , c_height , c_width , c_opacity );
						},
						function() {
							moveShadow( i_top , i_left , i_height , i_width , i_opacity );
						}
					);
					$(window).on("resize scroll", function() {
						setTimeout(function() {
							if (activeItem.length == 1) {
								UpdateActiveCoords();
								moveShadow( i_top , i_left , i_height , i_width , i_opacity );
							}
						}, 300);
						// console.log(left, top, height, width);
					});
				});
			});
		}
	};
})(jQuery);

function showLoader() {
	$.ovrly().init();
}

function hideLoader() {
	$.ovrly().kill();
}

$(document).on("click", ".reset-wild-tigers", function() {
	showLoader();
	window.location.reload();
});


//override defaults
if (typeof alertify !== "undefined") {
	function alertifyMessage(type, message) {
		switch (type) {
			case "error":
				alertify.notify(message, "error", 5);
				break;
			case "success":
				alertify.notify(message, "success", 5);
				break;
			case "warning":
				alertify.notify(message, "warning", 5);
				break;
			case "info":
				alertify.notify(message);
				break;
			default:
				alertify.notify(message);
		}
	}
	
	alertify.defaults.transition = "slide";
	alertify.defaults.theme.ok = "btn btn-primary";
	alertify.defaults.theme.cancel = "btn btn-danger";
	alertify.defaults.theme.input = "form-control";
}

function ucword( message ){
	var str = '';
	str = message.toLowerCase().replace(/\b[a-z]/g, function(letter) {
	    return letter.toUpperCase();
	});
	return str;
}

if (typeof jQuery.validator !== "undefined") {
	jQuery.validator.setDefaults({
		errorPlacement: function(error, element) {
			if (
				element.hasClass("select2") &&
				element.next(".select2-container").length
			) {
				error.insertAfter(element.next(".select2-container"));
			} else if (element.parent(".input-group").length) {
				error.insertAfter(element.parent());
			} else if (
				element.prop("type") === "radio" &&
				element.parent(".radio-inline").length
			) {
				error.insertAfter(element.parent().parent());
			} else if (
				element.prop("type") === "checkbox" ||
				element.prop("type") === "radio"
			) {
				error.appendTo(element.parent().parent());
			} else if (element.prop("type") === "file") {
				error.appendTo(
					element
						.parent()
						.parent()
						.parent()
				);
			} else {
				error.insertAfter(element);
			}
		}
	});

	$.validator.messages.minlength = function (param, inputField) {
	    return 'Please Enter At Least ' + param + ' Characters';
	}

	$.validator.addMethod("email_regex",function(value, element, regexp) {
		var re = new RegExp(/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,6}\b$/i);
		return this.optional(element) || re.test($.trim(value));
	},function(params, element) {
		var getMessage = ( ( $(element).attr("placeholder") != "" && $(element).attr("placeholder") != null ) ? $(element).attr("placeholder").replace("*", "") : ( ( $(element).attr("field-name") != "" && $(element).attr("field-name") != null ) ? $(element).attr("field-name").replace("*", "") : "{{ trans('messages.email') }}" ) )
		var message = getMessage.replace('enter', '').replace('your', '').replace('Enter', '').replace('Your', '') ;
		return "Please Enter Valid " + ( message );
	});

	$.validator.addMethod("website_regex",function(value, element, regexp) {
		var re = new RegExp(/^(https?|ftp|torrent|image|irc):\/\/(-\.)?([^\s\/?\.#-]+\.?)+(\/[^\s]*)?$/i);
		return this.optional(element) || re.test($.trim(value));
	},
		"Please Enter Valid Website Url."
	);
	
	$.validator.addMethod( "noSpace", function(value, element) {
		return this.optional(element) || $.trim(value) != "";
	},function(params, element) {
		var getMessage = ( ( $(element).attr("placeholder") != "" && $(element).attr("placeholder") != null ) ? $(element).attr("placeholder").replace("*", "") : ( ( $(element).attr("field-name") != "" && $(element).attr("field-name") != null ) ? $(element).attr("field-name").replace("*", "") : "{{ trans('messages.email') }}" ) );
		var message = getMessage.replace('enter', '').replace('your', '');
		return "Please Enter " + message;
	});

	$.validator.addMethod("mobile_regex",function(value, element, regexp) {
		var re = new RegExp(/^[6789]\d{9}$/);
		return this.optional(element) || re.test(value);
	},function(params, element) {
		var getMessage = ( ( $(element).attr("placeholder") != "" && $(element).attr("placeholder") != null ) ? $(element).attr("placeholder").replace("*", "") : ( ( $(element).attr("field-name") != "" && $(element).attr("field-name") != null ) ? $(element).attr("field-name").replace("*", "") : "{{ trans('messages.mobile-no') }}" ) );
		var message = getMessage.toLowerCase().replace('enter', '').replace('your', '');
		return "Please Enter Valid " + ucword( message );
	});
}

function onlyDecimal(thisitem) {
	var val = $(thisitem).val().trim();

	if (parseInt(val) == 0) {
		var newValue = val.replace(/^0+/, "");
		return $(thisitem).val(newValue);
	}

	if (isNaN(val)) {
		val = val.replace(/[^0-9\.]/g, "");
		//if (val.split(".").length > 2) val = val.replace(/\.+$/, "");
	}
	return $(thisitem).val(val);
}

function onlyNumber(thisitem) {
	var $val = $(thisitem).val().trim().replace(/[^\d]/g, "");
	$(thisitem).val($val);
}

function onlyNumberWithSpaceAndPlusSign(thisitem) {
	var $val = $(thisitem).val().replace(/[^ +\d]/g, "");
	$(thisitem).val($val);
}

function naturalNumber(thisitem) {
	var $val = $(thisitem).val().trim().replace(/[^\d]/g, "").replace(/^0+/g, "");
	$(thisitem).val($val);
}

var check_ajax_false  = false;
function searchAjax(ajaxUrl, ajaxData, pagination = false) {
	
	var result;
	if( check_ajax_false != true ){
	
		$.ajax({
			type: "POST",
			url: ajaxUrl,
			data: ajaxData,
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			beforeSend: function() {
			//block ui
			showLoader();
			check_ajax_false = true;
		},
		success: function(response) {
			hideLoader();
			
			if( ajaxData.button_name != "" && ajaxData.button_name != null && ajaxData.button_name == '{{ config("constants.EXCEL_EXPORT_BUTTON_TYPE") }}' ){
				
				response = $.trim(response);

                if( response != "" && response  != null ){
                	var response = jQuery.parseJSON(response);
	    			
                	if( response.status_code == "{{ config('constants.SUCCESS_AJAX_CALL') }}" ){	
						var opResult = response;
			            var $a = $("<a>");
			            $a.attr("href", opResult.data);
			            $("body").append($a);
			            $a.attr("download", response.file_name);
			            $a[0].click();
			            $a.remove();
					} else if( response.status_code == "{{ config('constants.ERROR_AJAX_CALL') }}" ){
						alertifyMessage('error' , response.data);
					}
                }
				
			
			} else {
				if (pagination != false) {
					$(".ajax-view").append(response);
				} else {
					$(".ajax-view").html("");
					$(".ajax-view").html(response);
				}
				result = response;
				
			}
			result = response;
			check_ajax_false = false;
			return true;
		},
		error: function() {
			hideLoader();
			check_ajax_false = false;
			}
		});
		return true;
	} else {
		return false;
	}
}



function multipleFilePreview(thisitem , default_field_name = 'final_selected_image') {
	var invalidImage = false;
	var field_id = $(thisitem).attr("id");
	var field_name = $(thisitem).attr("data-field-name");
	if( field_name == "" || field_name == null ){
		field_name = default_field_name;
	}
	var only_image_preview = ( ( $.trim($(thisitem).attr('data-only-image')) != "" && $.trim($(thisitem).attr('data-only-image')) != null && $.trim($(thisitem).attr('data-only-image')) == "{{ config('constants.SELECTION_YES') }}" ) ? true : false )
	var multipleImageName = [];
	$("." + field_id + "-preview-div").html("");
	var parent_form_id = $.trim($(thisitem).parents('form').attr('id'));

	if (thisitem.files) {
		var filesAmount = thisitem.files.length;

		if( $("#"+ parent_form_id ).find("[name='"+field_name+"']").length == 0 ){
			var $a = $("<input type='hidden'>");
	        $a.attr("name", field_name);
	        $("#"+ parent_form_id ).append($a);
	    } 

		for (i = 0; i < filesAmount; i++) {
			var f = thisitem.files[i];
			var reader = new FileReader();
			var file_type = thisitem.files[i].type;
			file_type = ( ( file_type != "" && file_type != null ) ? file_type.toLowerCase() : '' );
			var type_of_file = '';
			if (  ( file_type == "image/jpg" ) || ( file_type == "image/png" ) || ( file_type == "image/jpeg" ) ) {
				type_of_file = 'image';
			} 
			reader.onload = (function(theFile) {
				return function(e) {
					var imageName = "";
					var imageName = theFile.name;
					var imageHtml = "";
					if (imageName != "") {
						multipleImageName.push(imageName);
						$("#"+ parent_form_id ).find("[name='"+field_name+"']").val(multipleImageName.toString());
					}
					imageHtml = multipleFilePreviewHtml(  event , field_name ,  imageName , only_image_preview  );
					$("." + field_id + "-preview-div").append( $.parseHTML(imageHtml) );
				};
			})(f);

			reader.readAsDataURL(thisitem.files[i]);
		}

		$("#"+ parent_form_id ).find("[name='"+field_name+"']").val(multipleImageName.toString());

		if (invalidImage != false) {
			$("#" + field_id).val("");
			$("." + field_id + "-preview-div").hide();
			$("." + field_id + "-preview-div").html("");
			alertifyMessage("error", '{{ trans("messages.invalid-file-selection") }}');
			$(thisitem).siblings(".custom-file-label").html("{{ trans('messages.choose-file') }}");
		} else {
			$("." + field_id + "-preview-div").show();
			$(thisitem).siblings(".custom-file-label").html("{{ trans('messages.multiple-file-selected') }}");
		}
	}
}

function multipleFilePreviewHtml(  event , field_name ,  imageName , only_image_preview = false ){
	var html = '';

	
	html += '<div class="mb-3 gallery-image-div  file-preview-mdiv">';
	html += '<div class="upload-main-image">';
	if( only_image_preview == true ){
		html += '<img src="' +event.target.result +'" alt="" srcset="" class="img-fluid">';
	} else {
		html += '<label class="pe-2 file-name-preview-label">'+imageName+'</label>';
	}
	html += '<div class="close-buttons">';
	html += '<button type="button" class="button-gallery btn btn-danger button-round" title="{{ trans("messages.delete-file") }}" onclick="removeImage(this)"  data-preview-name="' +imageName +'">';
	html += '<i class="fas fa-times cancel-icon"></i>';
	html += '</button>';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	return html;
}
var single_image_field_name = [];
function removeImage(thisitem , default_remove_field_name = 'remove_image') {
	var remove_field_name = $(thisitem).attr("data-remove-field-name");
	if( remove_field_name == "" || remove_field_name == null ){
		remove_field_name = default_remove_field_name;
	}

	var confirm_box = '{{ trans("messages.delete-file") }}';
	var confirm_box_msg = '{{ trans("messages.common-delete-file-msg") }}';
		
	alertify.confirm( confirm_box , confirm_box_msg,function() {

		var image_name = $(thisitem).attr("data-image-name");
		var module_name = $(thisitem).attr("data-module-name");
		var record_id = $(thisitem).attr("data-record-id");
		var field_name = $(thisitem).attr("data-field-name");
		var single_image_field = $(thisitem).attr("data-single-field");
		var parent_form_id = $.trim($(thisitem).parents('form').attr('id'));

		if ( single_image_field != "" && single_image_field != null && single_image_field == "{{ config('constants.SELECTION_YES') }}") {
			var filedId = $("[name='"+field_name+"']").attr("id");
			$("[name='"+field_name+"']").val("");
			$("[name='"+field_name+"']").siblings(".custom-file-label").html("{{ trans('messages.choose-file') }}");

			$("." + filedId + "-preview-div").hide();
			$("." + filedId + "-preview").attr("src", "{{ config('constants.STATIC_IMAGE_PATH') }}");

			if( $("#"+ parent_form_id ).find("[name='remove_image_" + field_name + "']").length > 0 ){
				$("#"+ parent_form_id ).find("[name='remove_image_" + field_name + "']").val("{{ config('constants.SELECTION_YES') }}");
			} else {
				var $a = $("<input type='hidden'>");
		        $a.attr("name", 'remove_image_' + field_name );
		        $("#"+ parent_form_id ).append($a);
		        $("#"+ parent_form_id ).find("[name='remove_image_" + field_name + "']").val("{{ config('constants.SELECTION_YES') }}");
			}

			
			
		} else {

			$(thisitem).parents(".gallery-image-div").remove();
			var remove_field_value = $("[name='"+remove_field_name+"']").val();
			var updated_remove_field_value = [];

			if( remove_field_value != "" && remove_field_value != null ){
				var updated_remove_field_value = remove_field_value.split(",");
				updated_remove_field_value.push( $(thisitem).attr('data-preview-name') );
			} else {
				updated_remove_field_value.push( $(thisitem).attr('data-preview-name') );
			}
			if( $("#"+ parent_form_id ).find("[name='"+remove_field_name+"']").length > 0 ){
				$("#"+ parent_form_id ).find("[name='"+remove_field_name+"']").val(updated_remove_field_value);
			} else {
				var $a = $("<input type='hidden'>");
		        $a.attr("name", remove_field_name);
		        $("#"+ parent_form_id ).append($a);
		        $("#"+ parent_form_id ).find("[name='"+remove_field_name+"']").val(updated_remove_field_value.toString());
			}
		}
	},function() {});
}

//boundry -------------------------------------------------------------------------------------------------------

//designers
function menuDrop() {
	if ($(window).innerWidth() > 991) {
		$(
			".twt-navbar .nav-item.dropdown, .twt-navbar .dropdown-submenu"
		).hover(
			function() {
				$(this)
					.find(".dropdown-menu")
					.first()
					.stop(true, true)
					.delay(250)
					.slideDown(150);
			},
			function() {
				$(this)
					.find(".dropdown-menu")
					.first()
					.stop(true, true)
					.delay(100)
					.slideUp(100);
			}
		);
		$(".twt-navbar .dropdown > a").click(function() {
			location.href = this.href;
		});
	}
}

$(document).ready(function() {
	menuDrop();
	$("#slide-toggle").on("click", function() {
		$("body").toggleClass("nav-slide-open");
	});
	$("button.navbar-toggler").click(function(){
		setTimeout(function() {
				if ($('.table').hasClass("dataTable")) {
					$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
				}
			}, 300 );
		
	})

	
$(function() {
		// var current = window.location.href.substring(window.location.href.lastIndexOf("/") + 1);
		var current = window.location.href;

		if (current != "") {
			$(".nav-link").each(function() {
				var href = $(this).attr("href");
				if (href == current) {
					var check_header_class = $(this).parents('body').hasClass('vertical-header');
					if( check_header_class != false ){
						$(this).parent().addClass("active");
						$(this).parents('.sub-dropdown-collapse').addClass('show');
						$(this).parents('.items-drodown-menu').addClass('show');
						$(this).parents('.dropdown-sub-megamenu').addClass('active');
						

						$(this).parents('.nav-items-class').addClass('active');	
					}
				}
			});
			$(".nav-link").each(function() {
				var href = $(this).attr("href");
				if (href == current) {
					$(this)
						.parent()
						.addClass("active");
				}
			});
		}
	});

	$(document).on("click", function(e) {
		// console.log(!$(e.target).is('#slide-toggle, #slide-toggle .fas'), $(window).innerWidth() < 992);
		if (
			$(window).innerWidth() < 992 &&
			!$(e.target).is("#slide-toggle, #slide-toggle .fas")
		) {
			$("body").removeClass("nav-slide-open");
		}
	});

	// sidebar - admin side
	$(document).on("click", ".navbar-toggler", function() {
		$("#wrapper").toggleClass("toggled");
	});
	// sidebar sub menu
	$('.sidebar [data-bs-toggle="collapse"]').on("click", function() {
		var current = $(this);
		current
			.parent()
			.siblings()
			.find(".collapse.show")
			.collapse("hide");
	});

	// sidebar close on outside click
	$(document).on("click", function(e) {
		if (
			$(window).innerWidth() < 1200 &&
			!$(e.target).closest("#sidebar").length > 0 &&
			!$(e.target).is(".navbar-toggler")
		) {
			$("#wrapper").removeClass("toggled");
		}
	});

	if (window.location.hash) {

		setTimeout(function() {
			window.scrollTo(0, 0);
		}, 1);
		setTimeout(function() {
			$("html, body").animate(
				{
					scrollTop: $(window.location.hash).offset().top - 96
				},
				1000
			);
		}, 300);
	}

	$(document).on('click' , 'a[href*="#"]' , function(){
		var hash = this.hash;
		if (hash !== "" && $(hash).length) {
			event.preventDefault();

			if (!$(this).attr("data-bs-toggle")) {
				$("html, body").animate(
					{
						scrollTop:
							$(hash).offset().top -
							$(".navbar").outerHeight() -
							70
					},
					800
				);
			}
		}
	});
	
	var topOffset = $("#navMain").attr("data-offset")
		? parseInt($("#navMain").attr("data-offset"))
		: 0;
	if ($(".main-navbar-wrapper").hasClass("fallen-nav")) {
		$(".main-navbar-wrapper").css(
			"min-height",
			$("#navMain").outerHeight() + topOffset
		);
	} else if ($(".main-navbar-wrapper").hasClass("notch-nav")) {
		$(".main-navbar-wrapper").css(
			"min-height",
			$("#navMain").outerHeight() + topOffset
		);
	} else {
		$(".main-navbar-wrapper").css(
			"min-height",
			$("#navMain").outerHeight()
		);
	}

	setTimeout(function()  {
		$("#elastic_parent").elasticMenu();
	}, 300);

	if ($(document).find(".select2").length > 0) {
		$(".select2").select2();
	}

	// slick slider
	$("#header-slider").on("init", function(e, slick) {
		var $firstAnimatingElements = $("div.header-slide:first-child").find(
			"[data-animation]"
		);
		doAnimations($firstAnimatingElements);
	});
	$("#header-slider").on("beforeChange", function(
		e,
		slick,
		currentSlide,
		nextSlide
	) {
		var $animatingElements = $(
			'div.header-slide[data-slick-index="' + nextSlide + '"]'
		).find("[data-animation]");
		doAnimations($animatingElements);
	});
	if ($("#header-slider").length > 0) {
		$("#header-slider").slick({
			autoplay: true,
			autoplaySpeed: 4000,
			dots: false,
			arrows: true,
			// fade: true,
			pauseOnHover: false
		});
	}

	function doAnimations(elm) {
		var animationEndEvents =
			"webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
		elm.each(function() {
			var $this = $(this);
			var $animationDelay = $this.data("delay");
			var $animationType = "animated " + $this.data("animation");
			$this.css({
				"animation-delay": $animationDelay,
				"-webkit-animation-delay": $animationDelay
			});
			$this.addClass($animationType).one(animationEndEvents, function() {
				$this.removeClass($animationType);
			});
		});
	}
	// slick slider end

	/* $(document).on('change' , 'input[type="file"]' , function(e){
		let filenames = [];

		let files = e.target.files;

		if (files.length > 1) {
			// filenames.push(files.length + " images added");
			filenames.push("{{ trans('messages.multiple-file-added') }}");
		} else {
			for (let i in files) {
				if (files.hasOwnProperty(i)) {
					filenames.push(files[i].name);
				}
			}
		}
		$(this).siblings(".custom-file-label").html(filenames.join(","));
	}) */

	$(".dropdown > a, .dropdown-submenu > a").on("click", function(e) {

		if ($(window).innerWidth() < 992) {
			e.preventDefault();
		}

		var submenu = $(this);
		$(this)
			.parent()
			.siblings()
			.find(".dropdown-menu")
			.removeClass("show");
		// submenu.next(".dropdown-menu").toggleClass("show");
		e.stopPropagation();
	});

	// hide any open menus when parent closes
	$(".dropdown").on("hidden.bs.dropdown", function() {
		$(".dropdown-menu.show").parent().removeClass("show");
	});
});
$(window).resize(function() {
	setTimeout(function() {
		menuDrop();
	}, 500);
});

$(window).scroll(function() {
	if ($(this).scrollTop() > 72) {
		$(".twt-navbar").addClass("fixed");
	} else {
		$(".twt-navbar").removeClass("fixed");
	}
});



var valid_form_flag = false;
var twt_submit_event = false;
var form_id = '';
$(document).on("keypress", function(e) {
	
    if (typeof $("input:focus").val() != 'undefined' && e.keyCode == 13) {
        $("input:focus").parents("#filter").find('.twt-search-btn').click();

        if ($('body').hasClass('modal-open')) {
            $('.modal').on('hidden.bs.modal', function() {
                $('.modal-backdrop').remove();
            });

            form_id = $('.modal.show').find('form').attr('id');
            
            if (form_id != "" && form_id != null) {
                if ($("#" + form_id).find(".twt-submit-btn").prop('disabled') != true) {
                    if ($("#" + form_id).valid() != false) {
                        valid_form_flag = true;
                        $("#" + form_id).find(".twt-submit-btn").prop('disabled', true);
                        if (twt_submit_event != true) {
                            twt_submit_event = true;
                            $("#" + form_id).find(".twt-submit-btn").click();
                        }
                    }
                    if($("#" + form_id).find(':input').filter('.invalid-input').length > 0){
    					$("#" + form_id).find(':input').filter('.invalid-input:first').focus();
    				}
                }
            }
        }
    }
});

$(function(){
	$('.twt-submit-btn').on('click', function(){
		if($('body').hasClass('modal-open')){
			var current_modal_form_id = $.trim($(this).closest('form').attr('id'));
			if( current_modal_form_id != "" && current_modal_form_id != null ){
				if($("#" + current_modal_form_id).find(':input').filter('.invalid-input').length > 0){
					$("#" + current_modal_form_id).find(':input').filter('.invalid-input:first').focus();
				}
			}
		}
	});
})

/*
$(document).keypress(function(event){
	
	var element_class_list = ( ( $(event.target).attr('class') != "" && $(event.target).attr('class') != null )  ? $(event.target).attr('class') : "" )

	var elementClassArray = element_class_list.length > 0 ? element_class_list.split(' ') : [];
	
	if(jQuery.inArray("twt-enter-search", elementClassArray) !== -1){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			$("input:focus").parents("#searchFilter").find('.search-button').click();
		}
	}
});
*/


function imagePreview( thisitem, allowed_file_type = 'image' ) {
	var filedId = $(thisitem).attr("id");
	var validImageTypes = [];
	var validExtensions = [];
	var message = '';
	
	switch(allowed_file_type){
		case 'image':
			validImageTypes = [ 'image/jpg', 'image/jpeg', 'image/png' ];
			validExtensions = [ 'jpg', 'jpeg', 'png', 'svg' ];
			message = '{{ trans("messages.error-only-specific-are-allowed" , [ "fileType" => "JPG, JPEG And PNG"  ]  ) }}';
			break;
		case 'image_pdf':
			validImageTypes = [ 'image/jpg', 'image/jpeg', 'image/png', 'application/pdf' ] ;
			validExtensions = [ 'jpg', 'jpeg', 'png', 'pdf' ];
			message = '{{ trans("messages.error-only-specific-are-allowed" , [ "fileType" => "JPG, JPEG, PNG And PDF"  ]  ) }}';
			break;
		case 'image_pdf_doc':
			validImageTypes = [ 'image/jpg', 'image/jpeg', 'image/png', 'application/pdf' , 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ] ;
			validExtensions = [ 'jpg', 'jpeg', 'png', 'pdf', 'doc' , 'docx' ];
			message = '{{ trans("messages.error-only-specific-are-allowed" , [ "fileType" => "JPG, JPEG, PNG, DOC, DOCX And PDF"  ]  ) }}';
			break;
		case 'pdf_doc':
			validImageTypes = [ 'application/pdf' , 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ] ;
			validExtensions = [ 'pdf', 'doc' , 'docx' ];
			message = '{{ trans("messages.error-only-specific-are-allowed" , [ "fileType" => "DOC, DOCX And PDF"  ]  ) }}';
			break;
		case 'image_pdf_doc_excel':
			validImageTypes = [ 'image/jpg', 'image/jpeg', 'image/png', 'application/pdf' , 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ] ;
			validExtensions = [ 'pdf', 'doc', 'docx' , 'png' , 'jpg' , 'jpeg' , 'xls' , 'xlsx' ];
			message = '{{ trans("messages.error-only-specific-are-allowed" , [ "fileType" => "JPG, JPEG, PNG, DOC, DOCX, EXCEl And PDF"  ]  ) }}';
			break;
	}
	
	if (thisitem.files && thisitem.files[0]) {

		var fileName = $.trim(thisitem.files[0].name);

		var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
		fileNameExt = ( ( fileNameExt != "" && fileNameExt != null ) ?  fileNameExt.toLowerCase() : '' );	
		
	   var fileType = thisitem.files[0]["type"];

	   if ( $.inArray(fileNameExt, validExtensions) == -1 ) {
	   		alertifyMessage("error", message );
	   		$("." + filedId + "-preview-div").hide();
	   		$(thisitem).attr('data-has-image' , '{{ config("constants.SELECTION_NO") }}');
	   		$(thisitem).attr('data-valid-image' , '{{ config("constants.SELECTION_NO") }}');
	   		$(thisitem).siblings(".custom-file-label").html("{{ trans('messages.choose-file') }}");
	   		$(thisitem).blur();
	   		$(thisitem).val("");
	   		return false;
	   	}
	   	
	   
	       
	   	if ( $.inArray(fileNameExt, validExtensions) != -1 ) {
	   		
	   		$("." + filedId + "-preview-div").parent('div').show();
	   		$("." + filedId + "-preview-div").show();
	   		$("." + filedId + "-preview").show();
	   		$("." + filedId + "-preview").attr("src", "");
	   		
	   		if( allowed_file_type ==  'image' ){
	   			var reader = new FileReader();
	   			reader.onload = function (e) {
					$("." + filedId + "-preview").attr("src", e.target.result);
				}
				reader.readAsDataURL(thisitem.files[0]);
			} else {
				$("." + filedId + "-preview").html( thisitem.files[0]["name"] );
			}
	   		
	   		$(thisitem).attr('data-has-image' , '{{ config("constants.SELECTION_YES") }}');
	   		$(thisitem).attr('data-valid-image' , '{{ config("constants.SELECTION_YES") }}');
	   		$(thisitem).siblings(".custom-file-label").html(thisitem.files[0]["name"]);
	   	}
	} else {
		$("." + filedId + "-preview-div").hide();
   		$(thisitem).attr('data-has-image' , '{{ config("constants.SELECTION_NO") }}');
   		$(thisitem).attr('data-valid-image' , '{{ config("constants.SELECTION_NO") }}');
   		$(thisitem).siblings(".custom-file-label").html("{{ trans('messages.choose-file') }}");
   		$(thisitem).blur();
   		$(thisitem).val("");
   		return false;
	}

}

$(function(){
    $('input[type="text"], input[type="file"] , textarea, select ').attr('autocomplete', 'off');
    $('input[type="password"]').attr('autocomplete', 'new-password');
});
$(document).ajaxSuccess(function(){
	$('input[type="text"], input[type="file"] , textarea, select ').attr('autocomplete', 'off');
	$('input[type="password"]').attr('autocomplete', 'new-password');
});
var check_old_password = '{{ config("constants.CHECK_OLD_PASSWORD") }}';
var check_password_regex = '{{ config("constants.CHECK_PASSWORD_REGEX") }}';
var check_strong_password = '';
$.validator.addMethod("checkStrongPassword", function(value, element) {
    var result = true;
    var err_message = ''; 
    var new_password = $.trim($("[name='new_password']").val());

    if( new_password != "" && new_password != null ){
    	ajaxResponse = $.ajax({
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: backend_site_url + 'check-strong-password',
            dataType: "json",
            data: {
                'new_password': $.trim($("[name='new_password']").val()),
                'user_id': ($.trim($("[name='user_id']").val()) != '' ? $.trim($("[name='user_id']").val()) : null),
                'record_id': ($.trim($("[name='record_id']").val()) != '' ? $.trim($("[name='record_id']").val()) : null)
            },
            beforeSend: function() {
                //block ui
                //showLoader();
            },
            success: function(response) {
            	check_strong_password = response.message
                if (response.status_code == "{{ config('constants.SUCCESS_AJAX_CALL') }}") {
                    return false;
                } else {
                    result = false;
                    return true;
                }
            }
        });
    }
    return result;
}, function (params, element) {
	return check_strong_password;
});

//( '{{ config("constants.CHECK_OLD_PASSWORD") }}' == 1 ? '{{ trans("messages.error-last-password-same") }}' : '{{ trans("messages.error-strong-password") }}'  )

function openBootstrapModal(modal_id){

	var bootstap_modal_options = {};
	bootstap_modal_options = {  
		backdrop: 'static',
		keyboard: false 
	};
	
	var myModal = new bootstrap.Modal(document.getElementById(modal_id), bootstap_modal_options)
	myModal.show();
}

function getFileBaseName(str)
{
	var base = '';
	if( str != "" && str != null ){
	  var base = new String(str).substring(str.lastIndexOf('/') + 1); 
	    if(base.lastIndexOf(".") != -1)       
	        base = base.substring(0, base.lastIndexOf("."));
		
	}
 
   return base;
}

function checkAll(thisitem){
	$(thisitem).closest('table').find('.all-checkbox').prop('checked' , $(thisitem).prop('checked'));
}

function dataExportIntoExcel(export_info){
	
	if( export_info != "" && export_info != null ){
		var pagination_url = export_info.url;
		var search_data = export_info.search_data;
		search_data.custom_export_action = 'export';
		
		$.ajax({
	        url: pagination_url,
	        type: 'post',
	        dataType : 'json',
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	        data: search_data,
	        beforeSend: function() {
	            //block ui
	            showLoader();
	        },
	        success: function (response) {
	            hideLoader();
	            if( response.status_code == "{{ config('constants.SUCCESS_AJAX_CALL') }}" ){	
					var opResult = response;
		            var $a = $("<a>");
		            $a.attr("href", opResult.data);
		            $("body").append($a);
		            $a.attr("download", response.file_name);
		            $a[0].click();
		            $a.remove();
				} else if( response.status_code == "{{ config('constants.ERROR_AJAX_CALL') }}" ){
					alertifyMessage('error' , '{{ trans("messages.no-record-found") }}');
				}
	        }
	    });
	} else {
		alertifyMessage('error' , '{{ trans("messages.no-record-found") }}');
	}
}

function thousands_separators(num)
{
  var num_parts = num.toString().split(".");
  
  num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  if(num_parts[1] != "" && num_parts[1] != null ){
	  num_parts[1] = parseInt(num_parts[1]);
	  num_parts[1] = num_parts[1].toFixed(2);
  }
  return num_parts.join(".");
}

function formatMoney(amount, decimalCount = 0, decimal = ".", thousands = ",") {
  try {
    decimalCount = Math.abs(decimalCount);
    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

    const negativeSign = amount < 0 ? "-" : "";

    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
    let j = (i.length > 3) ? i.length % 3 : 0;

    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
  } catch (e) {
    
  }
};

function enumText(str){
	var str = str.replace(/_/g, ' ');
	str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
	    return letter.toUpperCase();
	});
	return str;
}

function onlyNumberWithSpace(thisitem) {
	var $val = $(thisitem)
		.val()
		.replace(/[^ \d]/g, "");
	$(thisitem).val($val);
}

$(function(){
	$('.modal').on('hidden.bs.modal' , function(){
		if( $(this).find('form').length > 0 ) { 
			$(this).find('form').validate().resetForm();
			$(this).find('form').trigger("reset");
			$(this).find('form .custom-file-label').html("{{ trans('messages.choose-file') }}"); 
		}
	});
});

$($(".modal").find("form")).on("submit",function(e){
	e.preventDefault();
    e.stopPropagation();
    //$(".lookup-modal-action-button").click();
});

$(document).ready(function () {  
var bootstrapModalCounter = 0;
	$('.modal').on("hidden.bs.modal", function (e) {
	--bootstrapModalCounter;
	
	if (bootstrapModalCounter > 0) {
			$('body').addClass('modal-open');
	}
	}).on("show.bs.modal", function (e) {
		$(this).find(".twt-submit-btn").prop('disabled' , false);
		++bootstrapModalCounter;
		twt_submit_event = false;
		$(document).off('focusin.modal');
		const zIndex = 1050 + 10 * $('.modal:visible').length; 
		$(this).css('z-index', zIndex);
		document.activeElement.blur(); 
		setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack')); 
	});
	
	alertify.confirm().set({onfocus:function(){ $('.btn-close').blur();}});

	$('.select2').each(function () {
      $(this).select2({
          theme: 'bootstrap-5',
          dropdownParent: $(this).parent(),
      });
  });
	$('.select2-outwrapper').each(function () {
      $(this).select2({
          theme: 'bootstrap-5',
          dropdownParent: $('.wrapper').parent(),
      });
  });
	$(".onclick-change-name").click(function(){			
			if ($(this).prop("checked")){
				$(this).siblings().html('Enable')
			}
			else{
				$(this).siblings().html('Disable')
			}
	});
	
		if (typeof $.fn.dataTable !== "undefined") {
			setTimeout(function() {
					$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
			}, 900 );

			$("button.navbar-toggler, .twt-filter-btn,.modal .btn-close,.alert .btn-close").click(function(){
					setTimeout(function() {
							$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
					}, 300 );
			})
		}
});

$(document).on('select2:close' , '.select2' , function(e){
	var field_name = $(this).attr('name');
	if( field_name != "" && field_name != null ){
		//$("[name='"+field_name+"']").valid();
	}
});

var ckEditorCongfig = [
	{ name: 'document', items: [ 'Source',] },
		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'Undo', 'Redo' ] },
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule',] },
		'/',
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
];

$(function() {
    if (typeof alertify !== "undefined") {
        alertify.confirm().set({
            onshow: null,
            onclose: function() {
                $('.btn-close').blur();
                if ($.trim(form_id) != '' && $.trim(form_id) != null) {
                    $("#" + form_id).find('.twt-submit-btn').prop('disabled', false);
                    $("#" + form_id).removeAttr('inert');
                    valid_form_flag = false;
                }
            }
        });

        alertify.confirm().set({
            onshow: function() {
                if (form_id == '' || form_id == null) {
                    form_id = $('.modal.show').find('form').attr('id');
                }

                if (form_id != "" && form_id != null) {
                    if ($("#" + form_id).find(".twt-submit-btn").prop('disabled') != true) {
                        $("#" + form_id).find(".twt-submit-btn").prop('disabled', true);
                    }
                    $("#" + form_id).attr('inert', true);
                }

                this.set('oncancel', function(closeEvent) {
                    twt_submit_event = false;
                });
            }
        });
    }
});

function showPassword(thisitem) {
	var status = $(thisitem).parents(".pass-section").find(".pass-input");
	if (status.attr('type') === 'password') {
		status.attr('type', 'text');
		$(thisitem).parents('.pass-section').find(".eye-slash-icon").removeClass("fa-eye");
		$(thisitem).parents('.pass-section').find(".eye-slash-icon").addClass("fa-eye-slash");
	} else {
		status.attr('type', 'password');
		$(thisitem).parents('.pass-section').find(".eye-slash-icon").addClass("fa-eye");
		$(thisitem).parents('.pass-section').find(".eye-slash-icon").removeClass("fa-eye-slash");
	}
}

$(document).ready(function() {
	$(".modal").on('shown.bs.modal', function() {
    	$(this).find('form :input:not(:disabled):not([readonly]):not(button):visible:first').focus();
    });
    
	$('form :input:not(:disabled):not([readonly]):not(button):visible:first').focus();
	let current_form_first_field_value = $('form :input:not(:disabled):not([readonly]):not(button):visible:first').val();
	$('form :input:not(:disabled):not([readonly]):not(button):visible:first').val('');
	$('form :input:not(:disabled):not([readonly]):not(button):visible:first').val(current_form_first_field_value);
});

$(document).on('mouseover','input[type="file"]' , function(){
	$(this).attr('title' , $(this).siblings('.custom-file-label').html() );
});

$(document).on('mouseout','input[type="file"]' , function(){
	$(this).attr('title' , "" );
});

$(document).on('click','input[type="file"]' , function(){
	$(this).attr('title' , "" );
});
</script>