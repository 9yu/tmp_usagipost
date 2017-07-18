// 内嵌外部代码
$(document).ready(function(){
	var aj = 0;
	if (document.getElementsByClassName("h-hiki")) {
		var hiki = document.getElementsByClassName("h-hiki");
		for (var i = 0; i < hiki.length; i++) {
			var hiki_obj = hiki[i];
			var hiki_url = hiki_obj.innerHTML;
			var temp = '.h-hiki:eq(' + i + ')';
			$(temp).load(hiki_url,function(){
				aj++;
				if (aj == hiki.length){
					hljs.initHighlightingOnLoad();
				};
			});
		};
	} else {
		hljs.initHighlightingOnLoad();
	};
});