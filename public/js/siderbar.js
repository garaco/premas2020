
$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
    $('.user').toggleClass("user-show");

});

$(function () {
    var Accordion = function (el, multiple) {
        this.el = el || {};
        this.multiple || false;
        var link = this.el.find('.link');
        link.on('click', { el: this.el, multiple: this.multiple }, this.dropdown);

    }
    Accordion.prototype.dropdown = function (e) {
        var $el = e.data.el,
            $this = $(this),
            $next = $this.next();
        $next.slideToggle();
        $this.parent().toggleClass('open');
        if (!this.multiple) {
            $el.find('.sidebar-submenu').not($next).slideUp().parent().removeClass('open');
        };
    }
    var accordion = new Accordion($('.sidebar-nav'));
});
