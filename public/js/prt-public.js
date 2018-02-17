var requestData = {
	//empty
};

Number.prototype.formatMoney = function(c, d, t){
	var n = this, 
		c = isNaN(c = Math.abs(c)) ? 2 : c, 
		d = d == undefined ? "." : d, 
		t = t == undefined ? "," : t, 
		s = n < 0 ? "-" : "", 
		i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
		j = (j = i.length) > 3 ? j % 3 : 0;
	   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

(function ($) {
	'use strict';

	var loadedSteps,
		stepsCount;

	var steps = $('.steps');
	steps.slick({
		arrows: false,
		dots: false,
		draggable: false,
		infinite: false,
		swipe: false,
		touchMove: false,
		accessibility: false
	});

	var dialogOpen = false;
	var loaderOpen = false;

	function openDialog(title, content, emoji) {
		//bug fix: close on prt click
		setTimeout(function() {
			var oldEmoji = emoji;
			emoji = emoji || '😐';
			var $dialog = $('.dialog');
			var $overlay = $('.overlay');

			$('.dialog-header', $dialog).text(title);
			$('.dialog-body > .text', $dialog).html(content);
			if(oldEmoji != false) $('.dialog-body > .dialog-emoji', $dialog).text(emoji);

			$dialog.addClass('active');
			$overlay.addClass('active');
			$('.dialog-emoji').addClass('active');

			dialogOpen = true;
		}, 50);
	}

	function closeDialog() {
		if(dialogOpen) {
			$('.dialog').removeClass('active');
			$('.dialog').removeClass('privacy-active');
			$('.overlay').removeClass('active');
			$('.dialog-emoji').removeClass('active');
			dialogOpen = false;
		}
	}

	function openLoader() {
		setTimeout(function() {
			$('.loader').addClass('active');
			$('.overlay').addClass('active');
			loaderOpen = true;
		}, 50);
	}

	function closeLoader() {
		if(loaderOpen) {
			$('.loader').removeClass('active');
			$('.overlay').removeClass('active');
			loaderOpen = false;
		}
	}

	function checkForData(e) {
		var $step = $(e).closest('.step');
		if ($step == undefined) return false;
		var $dataEle = $step.find('.data[data-key]');
		if ($dataEle == undefined) return false;

		if ($dataEle[0] && $dataEle[0].hasAttribute('data-has-input')) {
			if ($dataEle.attr('data-has-input') == 'false') {
				var dv = $dataEle.find('.selected[data-value]');
				if (dv.length) {
					var key = $dataEle.attr('data-key').trim();
					requestData[key] = dv.attr('data-value');
					return true;
				}
				return false;
			}
		}

		var inputs = $step.find('input, select');
		var success = true;
		inputs.each(function () {
			var $in = $(this);
			if ($in[0].hasAttribute('required') && $in.val().trim() == "") {
				success = false;
				return false;
			}
			if($in[0].classList.contains('privacy-read')) {
				success = $($in[0]).is(':checked');
				console.log(success);
				return success;
			}
			var key = $in.attr('name').trim();
			requestData[key] = $in.val();
		});
		return success;
	}

	function emptyDone() {
		return { done: function (cb) { cb(); } }
	}

	function getTotalSlides() {
		return steps.slick('getSlick').slideCount;
	}

	function slickNext() {
		steps.slick('slickNext');
	}

	function slickGoTo(index) {
		steps.slick('slickGoTo', index);
	}

	function fillResults(results) {
		$('#prt-root .result').css('display', 'block');
		$('#prt-root .prt-resultAbsolute').text(parseFloat(results.resultAbsolute).formatMoney(2, ',', '.') +' €');
		$('#prt-root .prt-resultPerSqm').text(parseFloat(results.resultPerSqm).formatMoney(2, ',', '.')+' €');
		$('#prt-root .prt-lowAbsolute').text(parseFloat(results.lowAbsolute).formatMoney(2, ',', '.')+' €');
		$('#prt-root .prt-highAbsolute').text(parseFloat(results.highAbsolute).formatMoney(2, ',', '.')+' €');
		$('#prt-root .prt-lowPerSqm').text(parseFloat(results.lowPerSqm).formatMoney(2, ',', '.')+' €');
		$('#prt-root .prt-highPerSqm').text(parseFloat(results.highPerSqm).formatMoney(2, ',', '.')+' €');
	}

	function no_rate_display() {
		$('#prt-root .no_rate').css('display', 'block');
	}

	function getAllOtherStepsByType(type, atIndex) {
		if (loadedSteps === type) return emptyDone();
		loadedSteps = type;
		return $.post(prt_ajax_object.ajax_url, { action: 'prt_getsteps', type: type }, function (data) {

			var totalSteps = getTotalSlides();
			if(totalSteps !== 4) {
				for(var i=1;i < (totalSteps - 3); i++) {
					steps.slick('slickRemove', 1);
				}
			}

			stepsCount = data.length + 2; //+1 'cause forms + fail OR succes step
			
			for (var i = 0; i < data.length; i++) {
				steps.slick('slickAdd', data[i], (i+1), true);
			}
		}, 'json');
	}

	function validateAddress(e) {
		var $step = $(e).closest('.step');
		var $addressInput = $('.adress-input', $step);
		var successful = false;
		if ($addressInput.length) {

			openLoader();

			var jqxhr = $.ajax({
				type: "POST",
				url: prt_ajax_object.ajax_url,
				async: true,
				data: {action: 'prt_geo',address: $addressInput.val()},
				dataType: 'json'
			  });

			jqxhr.done(function(data) {
				if(data != null) {
					if(data.status == "success") {
						successful = true;
						closeLoader();
						if (checkForData(e)) slickNext();
						else openDialog('Fehler', 'Bitte füllen Sie alle erforderlichen Felder aus.');
						
					} else {
						closeLoader();
						openDialog("Adresse falsch!", data.error != null ? data.error : "Bitte geben Sie eine richtige Adresse ein!");
					}
				}
			});

			jqxhr.fail(function() {
				closeLoader();
				openDialog("Adresse falsch!", "Bitte geben Sie eine richtige Adresse ein!");
			});
		}
		return successful;
	}

	function calcProgress() {
		if (stepsCount) {
			var percent = (steps.slick('slickCurrentSlide') / stepsCount) * 100;
			if(percent >= 100) percent = 100;
			var percentShow = Math.round(percent);
			var progress = $('.progress-bar > .progress');
			progress.css('width', percent + '%');
			progress.text(percentShow + '%');
		}
	}

	function showErrorOnLastStep(errorMsg) {
		openDialog("Fehler", errorMsg);
	}

	$('#prt-root').on('input change', 'input[type="range"]', function (e) {
		var $this = $(this);
		var $step = $this.closest('.step');
		if (!$step.length) return true;
		var $display = $('.range-show-value', $step);
		if ($this[0].hasAttribute('data-values')) {
			var vals = $this.attr('data-values');
			vals = JSON.parse(vals);
			$display.val(vals[e.target.value]);
		}
		else $display.val(e.target.value);
	});

	//Privacy
	$('#prt-root .openPrivacy').on('click', function (e) {
		e.preventDefault();
		$('.dialog').addClass('privacy-active');
		openDialog('Datenschutz', $('.privacy .text').html(), false);
	});

	// Options Box
	$('#prt-root').on('click', '.option-box', function () {
		var $this = $(this);
		$this.parent().children().each(function (e) {
			$(this).removeClass('selected');
		});
		$this.addClass('selected');
	});

	//Selectable Buttons
	$('#prt-root').on('click', '.selectable-button li', function () {
		var $this = $(this);
		$this.parent().children().each(function (e) {
			$(this).removeClass('selected');
		});
		$this.addClass('selected');
	});

	$('#prt-root').click(function () {
		closeDialog();
	});

	// Buttons
	$('#prt-root').on('click', '.button', function () {
		var $this = $(this);

		if ($this.hasClass('load')) {
			if (checkForData(this)) {
				if (!requestData.type.length) return false;
				var xhr = getAllOtherStepsByType(requestData.type, 1);
				xhr.done(function () {
					slickNext();
					calcProgress();
				});
			} else {
				openDialog('Fehler', 'Bitte wählen Sie eine Immobilie aus!');
			}
			return true;
		}

		if ($this.hasClass('validateAddress')) {
			validateAddress(this);
			calcProgress();
			return true;
		}

		if ($this.hasClass('finish')) {
			//get last data
			if (!checkForData(this)) {
				openDialog('Fehler', 'Bitte füllen Sie alle erforderlichen Felder aus.');
				return false;
			}

			openLoader();

			$.post(prt_ajax_object.ajax_url,
				Object.assign({action: 'prt_submit'}, requestData),
			function(data) {
				if(data.status == "success") {
					fillResults(data);
					closeLoader();
					slickNext();
					calcProgress();
					return true;
				} else if (data.status == "no_rate") {
					no_rate_display();
					closeLoader();
					slickNext();
					calcProgress();
				} else {
					showErrorOnLastStep(data.msg);
				}
			}, 'json');
		}

		if ($this.hasClass('next')) {
			if (checkForData(this)) slickNext();
			else openDialog('Fehler', 'Bitte füllen Sie alle erforderlichen Felder aus.');
		}
		else if ($this.hasClass('prev')) {
			steps.slick('slickPrev');
		}

		calcProgress();
	});
})(jQuery);
