<aside id="heatmapBar">
    <nav>
        <ul>
            <li id="heatmapShow-mMove">
                <span class="glyphicon glyphicon-move" aria-hidden="true"></span> All
            </li>
            <li id="heatmapShow-mClick">
                <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> All
            </li>
            <?php if ($displayVariant == "list") : ?>
                <li id="dataShow-aoiList">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> AOI
                </li>
            <?php endif; ?>
            <?php if ($displayVariant == "chord") : ?>
                <li id="dataShow-aoiChord">
                    <span class="glyphicon glyphicon-link" aria-hidden="true"></span> AOI
                </li>
            <?php endif; ?>
            <?php if ($displayVariant == "map") : ?>
                <li id="dataShow-aoiMap">
                    <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> AOI
                </li>
            <?php endif; ?>
        </ul>

    </nav>
</aside>
<script>
    $(document).ready(function() {
        $("#heatmapBar").hover(function(mouseEvent) {
            $(this).toggleClass("showHeatmapBar");
        });
    });
</script>