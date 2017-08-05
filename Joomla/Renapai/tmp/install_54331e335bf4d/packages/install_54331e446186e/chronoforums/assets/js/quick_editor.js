jQuery.fn.extend({
	insertAtCaret: function(startValue, endValue){
		return this.each(function(i){
			if(document.selection){
				//For browsers like Internet Explorer
				this.focus();
				var sel = document.selection.createRange();
				sel.text = startValue+sel.text+endValue;
				this.focus();
			}else if(this.selectionStart || this.selectionStart == '0'){
				//For browsers like Firefox and Webkit based
				var startPos = this.selectionStart;
				var endPos = this.selectionEnd;
				var scrollTop = this.scrollTop;
				var selectedValue = this.value.substring(startPos, endPos);
				this.value = this.value.substring(0, startPos)+startValue+selectedValue+endValue+this.value.substring(endPos,this.value.length);
				this.focus();
				this.selectionStart = startPos + selectedValue.length + startValue.length + endValue.length;
				this.selectionEnd = startPos + selectedValue.length + startValue.length + endValue.length;
				this.scrollTop = scrollTop;
			}else{
				this.value += startValue+endValue;
				this.focus();
			}
		});
	}
});