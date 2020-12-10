jQuery(function($){
	$('#dk_main .column:first').show();
	typewriter($('#dk_main .column:first').children('.message').children());

	$('#dk_main .column .next').click(function() {
		if($(this).parent().next().length){
			$(this).parent().hide();
			$(this).parent().next().show();
			if ($(this).parent().next().children('.message').children().is('p') ) {
				typewriter($(this).parent().next().children('.message').children());
			}
		}
	});

	function typewriter(classis) {
		console.log(classis);
		var setElm = classis,
		delaySpeed = 250,
		fadeSpeed = 0;

		setText = setElm.html();

		setElm.css({visibility:'visible'}).children().addBack().contents().each(function(){
			var elmThis = $(this);
			if (this.nodeType == 3) {
				var $this = $(this);
				$this.replaceWith($this.text().replace(/(\S)/g, '<span class="textSplitLoad">$&</span>'));
			}
		});
		$(function(){
			splitLength = $('.textSplitLoad').length;
			setElm.find('.textSplitLoad').each(function(i){
				splitThis = $(this);
				splitTxt = splitThis.text();
				splitThis.delay(i*(delaySpeed)).css({display:'inline-block',opacity:'0'}).animate({opacity:'1'},fadeSpeed);
			});
			setTimeout(function(){
				setElm.html(setText);
				setElm.parent().next().css('display', 'inline-block');
			},splitLength*delaySpeed+fadeSpeed);
		});
	}
});
