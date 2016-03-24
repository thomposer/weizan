/*下拉展开*/
function showDetail(id,obj) {
	var _self = $(obj);
	var layer = $("#detail_layer");
	var next_layer = _self.next("#detail_layer");
	// 是否已开启
	if(next_layer.size()) {
		next_layer.slideUp('fast',function() {
			this.remove();
		});
		return;
	}else if(layer.size()) {
		layer.slideUp('fast');
		layer.remove();
	}
	var html = '';
	html += "<div class='list-group-item' style='background-color:rgb(220,220,220);display:none;' id='detail_layer'><div class='row'><div class='col-sm-offset-8 col-sm-4'>";
	html += "<button class='btn btn-success btn-sm' title='坐标查看'>";
	html += "<span class='glyphicon glyphicon-flag'></span>";
	html += "</button>&nbsp;";
		
	html += "<button class='btn btn-warning btn-sm' title='编辑'>";
	html += "<span class='glyphicon glyphicon-th-list'></span>";
	html += "</button>";

	html += "</div></div></div>";
	_self.after(html);
	$("#detail_layer").slideDown('fast');
	
}