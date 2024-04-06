$(function () {
    function initNewsTicker(id, options) {
        var $scroller = $(id);
        $scroller.vTicker("init", options);

        $("#news_fire .next").click(function (event) {
            event.preventDefault();
            var checked = true;
            $("#news_fire").vTicker("next", { animate: checked });
        });
        $("#news_fire .prev,#news_fire .next").hover(
            function () {
                $("#news_fire").vTicker("next", { animate: checked });
                $scroller.vTicker("pause", true);
            },
            function () {
                $("#news_fire").vTicker("next", { animate: checked });
                $scroller.vTicker("pause", false);
            }
        );
        $("#news_fire .prev").click(function (event) {
            event.preventDefault();
            var checked = true;
            $("#news_fire").vTicker("prev", { animate: checked });
        });
    }

    function initNoticeBoardTicker(id, options) {
        var $scroller = $(id);
        $scroller.vTicker("init", options);

        $("#notice-board-ticker .next").click(function (event) {
            event.preventDefault();
            var checked = true;
            $("#notice-board-ticker").vTicker("next", {
                animate: false,
            });
        });
        $("#notice-board-ticker .prev,#notice-board-ticker .next").hover(
            function () {
                $scroller.vTicker("pause", true);
            },
            function () {
                $scroller.vTicker("pause", false);
            }
        );
        $("#notice-board-ticker .prev").click(function (event) {
            event.preventDefault();
            var checked = true;
            $("#notice-board-ticker").vTicker("prev", {
                animate: checked,
            });
        });
    }

    initNewsTicker("#news_fire", {});
    //initNoticeBoardTicker('#notice-board-ticker', {showItems:10, margin: 0, padding: 0,animate:false});
});