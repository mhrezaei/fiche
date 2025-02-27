!function (i) {
    function t(i) {
        this.init(i)
    }

    t.prototype = {
        value: 0,
        size: 100,
        startAngle: -Math.PI,
        thickness: "auto",
        fill: {
            gradient: ["#3aeabb", "#fdd250"]
        },
        emptyFill: "rgba(0, 0, 0, .1)",
        animation: {
            duration: 1200,
            easing: "circleProgressEasing"
        },
        animationStartValue: 0,
        reverse: !1,
        lineCap: "butt",
        constructor: t,
        el: null,
        canvas: null,
        ctx: null,
        radius: 0,
        arcFill: null,
        lastFrameValue: 0,
        init: function (t) {
            i.extend(this, t), this.radius = this.size / 2, this.initWidget(), this.initFill(), this.draw()
        },
        initWidget: function () {
            var t = this.canvas = this.canvas || i("<canvas>").prependTo(this.el)[0];
            t.width = this.size, t.height = this.size, this.ctx = t.getContext("2d")
        },
        initFill: function () {
            function t() {
                var t = i("<canvas>")[0];
                t.width = e.size, t.height = e.size, t.getContext("2d").drawImage(g, 0, 0, r, r), e.arcFill = e.ctx.createPattern(t, "no-repeat"), e.drawFrame(e.lastFrameValue)
            }

            var e = this,
                a = this.fill,
                n = this.ctx,
                r = this.size;
            if (!a) throw Error("The fill is not specified!");
            if (a.color && (this.arcFill = a.color), a.gradient) {
                var s = a.gradient;
                if (1 == s.length) this.arcFill = s[0];
                else if (s.length > 1) {
                    for (var l = a.gradientAngle || 0, h = a.gradientDirection || [r / 2 * (1 - Math.cos(l)), r / 2 * (1 + Math.sin(l)), r / 2 * (1 + Math.cos(l)), r / 2 * (1 - Math.sin(l))], o = n.createLinearGradient.apply(n, h), c = 0; c < s.length; c++) {
                        var d = s[c],
                            u = c / (s.length - 1);
                        i.isArray(d) && (u = d[1], d = d[0]), o.addColorStop(u, d)
                    }
                    this.arcFill = o
                }
            }
            if (a.image) {
                var g;
                a.image instanceof Image ? g = a.image : (g = new Image, g.src = a.image), g.complete ? t() : g.onload = t
            }
        },
        draw: function () {
            this.animation ? this.drawAnimated(this.value) : this.drawFrame(this.value)
        },
        drawFrame: function (i) {
            this.lastFrameValue = i, this.ctx.clearRect(0, 0, this.size, this.size), this.drawEmptyArc(i), this.drawArc(i)
        },
        drawArc: function (i) {
            var t = this.ctx,
                e = this.radius,
                a = this.getThickness(),
                n = this.startAngle;
            t.save(), t.beginPath(), this.reverse ? t.arc(e, e, e - a / 2, n - 2 * Math.PI * i, n) : t.arc(e, e, e - a / 2, n, n + 2 * Math.PI * i), t.lineWidth = a, t.lineCap = this.lineCap, t.strokeStyle = this.arcFill, t.stroke(), t.restore()
        },
        drawEmptyArc: function (i) {
            var t = this.ctx,
                e = this.radius,
                a = this.getThickness(),
                n = this.startAngle;
            i < 1 && (t.save(), t.beginPath(), i <= 0 ? t.arc(e, e, e - a / 2, 0, 2 * Math.PI) : this.reverse ? t.arc(e, e, e - a / 2, n, n - 2 * Math.PI * i) : t.arc(e, e, e - a / 2, n + 2 * Math.PI * i, n), t.lineWidth = a, t.strokeStyle = this.emptyFill, t.stroke(), t.restore())
        },
        drawAnimated: function (t) {
            var e = this,
                a = this.el,
                n = i(this.canvas);
            n.stop(!0, !1), a.trigger("circle-animation-start"), n.css({
                animationProgress: 0
            }).animate({
                animationProgress: 1
            }, i.extend({}, this.animation, {
                step: function (i) {
                    var n = e.animationStartValue * (1 - i) + t * i;
                    e.drawFrame(n), a.trigger("circle-animation-progress", [i, n])
                }
            })).promise().always(function () {
                a.trigger("circle-animation-end")
            })
        },
        getThickness: function () {
            return i.isNumeric(this.thickness) ? this.thickness : this.size / 14
        },
        getValue: function () {
            return this.value
        },
        setValue: function (i) {
            this.animation && (this.animationStartValue = this.lastFrameValue), this.value = i, this.draw()
        }
    }, i.circleProgress = {
        defaults: t.prototype
    }, i.easing.circleProgressEasing = function (i, t, e, a, n) {
        return (t /= n / 2) < 1 ? a / 2 * t * t * t + e : a / 2 * ((t -= 2) * t * t + 2) + e
    }, i.fn.circleProgress = function (e, a) {
        var n = "circle-progress",
            r = this.data(n);
        if ("widget" == e) {
            if (!r) throw Error('Calling "widget" method on not initialized instance is forbidden');
            return r.canvas
        }
        if ("value" == e) {
            if (!r) throw Error('Calling "value" method on not initialized instance is forbidden');
            if ("undefined" == typeof a) return r.getValue();
            var s = arguments[1];
            return this.each(function () {
                i(this).data(n).setValue(s)
            })
        }
        return this.each(function () {
            var a = i(this),
                r = a.data(n),
                s = i.isPlainObject(e) ? e : {};
            if (r) r.init(s);
            else {
                var l = i.extend({}, a.data());
                "string" == typeof l.fill && (l.fill = JSON.parse(l.fill)), "string" == typeof l.animation && (l.animation = JSON.parse(l.animation)), s = i.extend(l, s), s.el = a, r = new t(s), a.data(n, r)
            }
        })
    }
}(jQuery);

//timer
function count(elm, mins, down) {
    var baseTime = Date.parse(new Date("1/1/2016"));
    var currentTime = Date.parse(new Date());
    var delta = ((currentTime - baseTime) / 1000) % (mins * 60);

    if(isDefined(down) && down) {
        delta = (mins * 60) - delta;
    }

    var secconds = Math.floor((delta) % 60);
    var minutes = Math.floor((delta / 60) % 60);
    var hours = Math.floor((delta / (60 * 60)) % 24);
    var circleProgress = elm.next().find('.circle-progress');
    var dashArray = parseInt(circleProgress.css('stroke-dasharray'));
    if (hours) {
        elm.find('.hours').html(farsiDigits(twoDigits(hours)) + ':');
    } else {
        elm.find('.hours').empty();
    }
    elm.find('.minutes').html(farsiDigits(twoDigits(minutes)) + ':');
    elm.find('.secconds').html(farsiDigits(twoDigits(secconds)));
    //circleProgress.css('stroke-dashoffset', Math.floor((delta*dashArray)/(mins*60)));
    elm.parent().find('.circle').circleProgress({
        value: Math.floor((delta * 100) / (mins * 60)) / 100,
        animation: false,
        thickness: 13,
        startAngle: 4.7
        // reverse: true
    });
    $(window).trigger('resize');
}

$(document).ready(function () {

    var timers = new Object;
    if ($('.timer').length) {
        $('.timer').each(function (index) {
            eval("timer" + index + " = " + setInterval(function () {
                var elem = $($('.timer')[index]);
                    count(elem, parseInt($($('.timer')[index]).attr('data-minutes')), elem.hasClass('count-down'))
                }, 1000));
        });
    }
});