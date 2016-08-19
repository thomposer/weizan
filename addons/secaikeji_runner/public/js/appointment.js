define(['js/zepto.min','js/tool','js/mobiscroll.min'],function($,R){
	/**
	 * @fileoverview 帮我送-预约取功能弹层
	 * @author mingrui| mingrui@rrkd.cn
	 * @version 1.0 | 2015-06-15
	 * @example
	 * 	var obj = R.appointment.bind($('#expectedtime')); 选择列表中的项后会覆盖节点的value或innerHTML
	 *  obj.show(); //触发给$('#expectedtime')绑定的事件显示弹层
	 *  obj.gettime(); //返回2015-06-16 18:30:00
	 *  obj.selectcal.add(function(obj){}); $.Callbacks()类型 弹层选择后的回调，传入的参数obj为{value:'2015-06-16 18:30:00',text:'今天18:30:00'}
	 */
	R.appointment = (function($){
		var endhour = 23, endminute = 45, difminute = 15;
		var format = window.$.mobiscroll.datetime.formatDate;
		/**
		 * 如果数字长度只有一位则添加一个0 
		 */
		function addzero(num){
			return num.toString().length > 1? num: '0'+num;
		}
		var wheelobj = { //滚轮数据
	    	todayhour: null, //今天的小时
	    	todayminute: null, //今天的分钟
	    	allhour: { //全天小时
	    		keys: ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
	    		values: ['0时','1时','2时','3时','4时','5时','6时','7时','8时','9时','10时','11时','12时','13时','14时','15时','16时','17时','18时','19时','20时','21时','22时','23时']
	    	},
	    	allminute: { //全天分钟
	    		keys: ['00','15','30','45'],
	    		values: ['0分','15分','30分','45分']
	    	},
	    	daylist: null//天列表
	    };
	    var cur = { //记录当前数据，控制滚轮数据切换
	        todfirhour: null, //今天的第一个小时
	        todday: null, //今天的键值
	    	day: null, //当前滚动定位天
	    	hour: null //当前滚动定位小时
	    };
	    var wheeldata = null; //给scroller用的滚轮数据
	    
	    var layer = $('<input style="position: absolute;left: -99999px;"/>').appendTo('body');
		var callback = { //记录当前调用show方法传入的一些回调
			close: function(){} //弹层close后的回调函数
		};
	    /**
	     * 数据重置 
	     */
	    function resetData(){
	    	wheelobj.todayhour = null;
	    	wheelobj.todayminute = null;
	    	wheelobj.daylist = null;
	    	cur.todfirhour = null;
	    	cur.todday = null;
	    	cur.day = null;
	    	cur.hour = null;
	    }
	    /**
	     * 获取格式化后的时间串  
	     */
	    function getTimeText(time){
	    	var arr = time.split(' ');
	    	var year = arr[0];
	    	if(wheelobj.daylist){
	    		var i = $.inArray(year,wheelobj.daylist.keys);
	    		if(i == -1){
	    			return '';
	    		}
	    		return wheelobj.daylist.values[i]+arr[1];
	    	}
	    	return '';
	    }
	    /**
	     * 往后加几天并返回格式化后的日期 
	     */
	    function addday(nowdate,num){
	    	var result = [];
	    	while(num > 0){
	    		nowdate.setDate(nowdate.getDate()+1);
	    		result.push(format('yy-mm-dd',nowdate));
	    		num--;
	    	}
	    	return result;
	    }
		/**
		 * 构建滚轮数据
		 */
		function buildWheel(){
			resetData();
			var hour = 0, minute = 0, nowdate = new Date(), notoday = false;
			//检测今天
			nowdate.setHours(nowdate.getHours()+1);
			minute = Math.ceil(nowdate.getMinutes()/difminute)*difminute; //今天开始的分钟数
			var date = nowdate.getDate(); //当前几号
			hour = nowdate.getHours(); //当前几点
			if(minute > endminute){ //换下一个小时
				nowdate.setHours(hour+1);
				if(nowdate.getDate() != date){ //说明今天已无可预约的时间
					notoday = true;
					//初始化滚轮数据
					wheelobj.daylist = { //天列表
					    keys: [format('yy-mm-dd',nowdate)],
					    values: ['明天','后天']
					};
					wheelobj.daylist.keys = wheelobj.daylist.keys.concat(addday(nowdate,1));
					wheeldata = [[wheelobj.daylist,wheelobj.allhour,wheelobj.allminute]];
					cur.day = wheelobj.daylist.keys[0];
					cur.hour = wheelobj.allhour.keys[0];
					return;
				}
				hour = nowdate.getHours();
				minute = 0;
			}
			if(!notoday){
				window.nowdate = nowdate;
				//初始化滚轮数据
				wheelobj.daylist = { //天列表
				    keys: [format('yy-mm-dd',nowdate)],
				    values: ['今天','明天','后天']
				};
				wheelobj.daylist.keys = wheelobj.daylist.keys.concat(addday(nowdate,2));
				cur.todday = wheelobj.daylist.keys[0];
				cur.day = cur.todday;
				wheelobj.todayhour = {keys:[],values:[]};
				for(hour; hour <= endhour; hour++){
					wheelobj.todayhour.keys.push(addzero(hour));
					wheelobj.todayhour.values.push(hour+'时');
				}
				cur.todfirhour = wheelobj.todayhour.keys[0];
				cur.hour = cur.todfirhour;
				wheelobj.todayminute = {keys:[],values:[]};
				for(minute; minute <= endminute; minute+=difminute){
					wheelobj.todayminute.keys.push(addzero(minute));
					wheelobj.todayminute.values.push(minute+'分');
				}
				wheeldata = [[wheelobj.daylist,wheelobj.todayhour,wheelobj.todayminute]];
			}
		}
		$.fn.mobiscroll = window.$.fn.mobiscroll;
		//给指定input绑定初始化scroller组件
		function init(){
			buildWheel();
			layer.mobiscroll().scroller({
		        theme: 'mobiscroll',
		        lang: 'zh',
		        display: 'bottom',
		        showInput: false,
		        //closeOnOverlay: false,
		        wheels: wheeldata,
				validate: function (html, index, time, dir, inst) { //滚动后验证，然后替换滚轮列表数据
					var wheelarr = inst._tempWheelArray;
					var newwheel = null;
					var changewheel = null;
					if(index == 0){ //说明滚动日期列
						if(wheelarr[index] != cur.day){ //判断日期是否有变
							if(wheelarr[index] == cur.todday){ //说明是今天
								if(parseInt(wheelarr[1]) <= parseInt(cur.todfirhour)){ //说明将切换至今天第一个小时
									newwheel = [[wheelobj.daylist,wheelobj.todayhour,wheelobj.todayminute]];
									changewheel = [1,2];
								}
								else{ //说明不是今天的第一个小时
									newwheel = [[wheelobj.daylist,wheelobj.todayhour,wheelobj.allminute]];
									changewheel = [1];
								}
							}
							else if(cur.day == cur.todday){ //说明不是今天且上一次的定位日期是今天
								newwheel = [[wheelobj.daylist,wheelobj.allhour,wheelobj.allminute]];
								changewheel = [1,2];
							}
					    }
					}
					else if(index == 1){ //说明当前滚动小时列
						if(wheelarr[index] != cur.hour){
							if(wheelarr[0] == cur.todday){ //如果是今天
								if(wheelarr[index] == cur.todfirhour){ //如果是滚动到第一个小时
									newwheel = [[wheelobj.daylist,wheelobj.todayhour,wheelobj.todayminute]];
									changewheel = [2];
								}
								else if(cur.hour == cur.todfirhour){ //如果不是滚动到第一个小时且上一个小时是第一个小时
									newwheel = [[wheelobj.daylist,wheelobj.todayhour,wheelobj.allminute]];
									changewheel = [2];
								}
							}
						}
					}
					cur.day = wheelarr[0];
					cur.hour = wheelarr[1];
					if(newwheel != null){
						inst.settings.wheels = newwheel;
		                inst.changeWheel(changewheel);
					}
				},
				formatValue: function(data){
					return data[0]+' '+data[1]+':'+data[2]+':00';
				},
				onClose: function(val,btn){
					callback.close({
							value: val,
							text: getTimeText(val),
							btn: btn
					});
				}
		    });
		    init = function(){
		    	buildWheel();
		    	layer.mobiscroll('init',{wheels: wheeldata});
		    };
		}
		/**
		 * 弹层显示
		 * @param {Function} closefun 弹层关闭的回调函数 
		 */
		function show(closefun){
			callback.close = closefun;
			init();
			layer.mobiscroll('show');
		}
		/**
		 * 给指定input绑定预约取类 
		 */
		function calappoint(elem){
			if(elem && elem.size() > 0){
				var that = this;
				this.elem = elem;
				this.evtname = 'touchend';
				var nodetype = this.elem.prop('type');
				nodetype == 'checkbox'? this.evtname = 'change': '';
				this.nodetype = nodetype;
				this.selectcal = $.Callbacks(); //弹层列表项选择后的回调
				this.closecal = $.Callbacks(); //弹层列表关闭后的回调
				this.focuscal = $.Callbacks(); //elem节点focus后回调，如果是radio和checked，则checked后才会触发
				this.elem.on(this.evtname,function(e){
					e.stopPropagation();
					if((that.nodetype == 'checkbox' && $(this).prop('checked')) || (that.nodetype != 'checkbox')){
						if(that.nodetype = 'radio'){that.elem.prop('checked',true);}
						that.elem.find('[type="radio"]').prop('checked',true);
						show(function(obj){
							if(obj.btn == 'set'){
								that.elem.data('time',obj.value);
							}
							that.closecal.fire(obj);
						});
						that.focuscal.fire();
					}
					return false;
				});
			}
			else{
				throw new Error('calappoint传入的节点不存在');
			}
		}
		/**
		 * 显示弹层
		 */
		calappoint.prototype.show = function(){
			this.elem.trigger(this.evtname);
		};
		/**
		 * 获取当前选中的时间数据 ,没有则为''
		 */
		calappoint.prototype.gettime = function(){
			return this.elem.data('time') || '';
		};
	    /**
	     * 设置当前选中的时间数据
	     * @param val
	     */
	    calappoint.prototype.settime = function(val){
	        this.elem.data('time',val || '');
	    };
		return {
			/**
			 * 给指定input类型的节点绑定期望送达时间选择功能
	         * @param elem 绑定弹层的节点对象
	         * @return {calappoint类实例对象}
			 */
			bind: function(elem){
				return new calappoint(elem);
			}
		};
	})(R.$);
});

