define(['js/tool'],function(R){
	/**
	 * Created by Administrator on 2015/5/15.
	 */

	/**
	 * 选择交通工具
	 * **/
	R.vehicle = (function($){
	    var _mask,showVehicle,closeBtn,sureBtn,vehicleList,vehval,vehtext;
	    var _init = function(){
	        $('body').append('<div class="toast-mask"></div>');
	        _mask = $('div.toast-mask');
	        showVehicle = document.getElementById("showVehicle");  // 外层盒子
	        closeBtn = document.getElementById("veh-close");  //取消按钮
	        sureBtn = document.getElementById("veh-sure");   // 确定按钮
	        vehicleList = document.getElementById("vehicle-list");  // 交通工具选择列表
	    };
	    var _show = function(){
	        //_cancelCall = cancelCall;
	        _init();
	        _mask.show();
	        $(showVehicle).show().animate('fadeInUp',300,'ease',function(){$(this).css({opacity:1})});
	        //选择交通工具
	        $(vehicleList).find('li').on('touchend',function(e){
	            vehval = $(this).data('vehval');
	            vehtext = $(this).data('text');
	            $(this).addClass('hover').siblings('li').removeClass('hover');
	            e.preventDefault();
	        });
	        //取消
	        closeBtn.addEventListener('touchend',function(){
	            _hide();
	        },false);
	        //确定
	        sureBtn.addEventListener('touchend',function(){
	            if($(vehicleList).find('li').length <= 0){
	                R.alert('提示信息','请等待交通工具加载...');
	                return;
	            }
	            vehtext = vehtext || $(vehicleList).find('.hover').data('text');
	            vehval = vehval || $(vehicleList).find('.hover').data('vehval');
	            var isfloat = $(vehicleList).find('.hover').data('isfloat');
	            if(isfloat == 'true'){
	                R.confirm('提示信息','选择'+vehtext+'需要加价',function(){ //确定
	                    document.getElementById("chooseVehicle").value = vehtext;
	                    document.getElementById("getVehicleValue").value = vehval;
	                    _hide();
	                },function(){ //取消

	                });
	            }else{
	                document.getElementById("chooseVehicle").value = vehtext;
	                document.getElementById("getVehicleValue").value = vehval;
	                _hide();
	            }
	            //typeof _cancelCall === 'function' ? _cancelCall.call(this) : '';
	        },false);
	    };
	    var _hide = function(){
	        if(_mask.length > 0){
	            $(showVehicle).animate('fadeInDown',300,'ease',function(){
	                $(this).css({opacity:0,display:'none'});
	            });
	            _mask.remove();
	        }
	    };
	    return {
	        show : _show,
	        hide : _hide
	    };
	})(R.$);
});

