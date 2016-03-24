/**
 * Created by luwei on 2016/2/4.
 */

(function () {
    var width = $(".gglpanel").width();
    var height = $(".gglpanel").height();
    var ggl_canvas = document.getElementById("ggl_canvas");
    var ggl_ctx = ggl_canvas.getContext("2d");
    ggl_canvas.width = width;
    ggl_canvas.height = height;
    var img = document.getElementById("ggl_huise");
    img.onload = function () {
        ggl_ctx.drawImage(img, 0, 0, width, height);
        canvas_wipe(ggl_canvas, 50, function () {

        });
    };
})();

/**
 * 通过修改globalCompositeOperation来达到擦除的效果
 * @param {element} canvas canvasElement
 * @param {int} path 超过百分之多少时使用回调
 * @param {function} callback 回调函数
 * */
function canvas_wipe(canvas, path, callback) {
    console.log(canvas);
    var ctx = canvas.getContext("2d");
    var x1, y1, a = 30, timeout, totimes = 100, jiange = 30;
    var hastouch = "ontouchstart" in window ? true : false,
        tapstart = hastouch ? "touchstart" : "mousedown",
        tapmove = hastouch ? "touchmove" : "mousemove",
        tapend = hastouch ? "touchend" : "mouseup";
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
    ctx.lineWidth = a * 2;
    ctx.globalCompositeOperation = "destination-out";
    canvas.addEventListener(tapstart, function (e) {
        clearTimeout(timeout);
        e.preventDefault();

        x1 = hastouch ? e.targetTouches[0].pageX : e.clientX - canvas.offsetLeft;
        y1 = hastouch ? e.targetTouches[0].pageY : e.clientY - canvas.offsetTop;

        ctx.save();
        ctx.beginPath();
        ctx.arc(x1, y1, 1, 0, 2 * Math.PI);
        ctx.fill();
        ctx.restore();

        canvas.addEventListener(tapmove, tapmoveHandler);
        canvas.addEventListener(tapend, function () {
            canvas.removeEventListener(tapmove, tapmoveHandler);

            timeout = setTimeout(function () {
                var imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                var dd = 0;
                for (var x = 0; x < imgData.width; x += jiange) {
                    for (var y = 0; y < imgData.height; y += jiange) {
                        var i = (y * imgData.width + x) * 4;
                        if (imgData.data[i + 3] > 0) {
                            dd++
                        }
                    }
                }
                if (dd / (imgData.width * imgData.height / (jiange * jiange)) < (1 - ( path / 100))) {
                    if (callback)
                        callback();
                }
            }, totimes)
        });
        var iii = 0;

        function tapmoveHandler(e) {
            iii++;
            //console.log(iii);
            clearTimeout(timeout);
            e.preventDefault();
            x2 = hastouch ? e.targetTouches[0].pageX : e.clientX - canvas.offsetLeft;
            y2 = hastouch ? e.targetTouches[0].pageY : e.clientY - canvas.offsetTop;

            ctx.save();
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.stroke();
            ctx.restore();

            x1 = x2;
            y1 = y2;
        }
    });
}