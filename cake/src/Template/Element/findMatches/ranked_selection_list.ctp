<ul class="list-unstyled">

    <!-- 5-Star Rating Output-->
    <?php foreach ($rankedSelection->rating5->binaryComponents as $rankedBinary): ?>
        <li class="binaryComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">5</span></span>
            <span class="binaryComponentInfo">
                <span>
                    <?= $rankedBinary->display_name != '' ? $rankedBinary->display_name : $rankedBinary->name ?>
                </span>
                <span class="pull-right"><span class="glyphicon <?= $rankedBinary->binaryComponentState ? 'glyphicon-ok' : 'glyphicon-remove' ?> <?= $rankedBinary->binaryComponentState ? 'text-success' : 'text-danger' ?>" aria-hidden="true"></span></span>
            </span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating5->nominalAttributes as $rankedNominal): ?>
        <li class="nominalComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">5</span></span>
            <div class="nominalAttribute pull-right"><figure class="attrIcons <?= $rankedNominal->icon_path != '' ? $rankedNominal->icon_path : 'iconPlaceholder' ?>"></figure></div>
            <span class="componentNameNominalComponent<?= $rankedNominal->nominal_component->display_name != '' ? '' : ' text-muted' ?>"><?= $rankedNominal->nominal_component->display_name != '' ? ($rankedNominal->nominal_component->display_name) : $rankedNominal->nominal_component->name ?></span> <br><span class="attributeNameNominalAttribute <?= $rankedNominal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedNominal->display_name != '' ? $rankedNominal->display_name : $rankedNominal->name ?></span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating5->ordinalAttributes as $rankedOrdinal): ?>
        <li class="ordianalComponentContainer">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">5</span></span>
            <span class="componentNameOrdinalComponent<?= $rankedOrdinal->ordinal_component->display_name != '' ? '' : ' text-muted' ?>"><?=  $rankedOrdinal->ordinal_component->display_name != '' ? ( $rankedOrdinal->ordinal_component->display_name) :  $rankedOrdinal->ordinal_component->name ?></span> <span class="attributeNameOrdinalAttribute <?= $rankedOrdinal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedOrdinal->display_name != '' ? $rankedOrdinal->display_name : $rankedOrdinal->name ?></span> <br>
            <?php
            $minRange = reset($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            $maxRange = end($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            ?>
            <input type="range" min="<?= $minRange ?>" max="<?= $maxRange ?>" step="1" value="<?= $rankedOrdinal->meter ?>" disabled>
        </li>
    <?php endforeach; ?>

    <!-- 4-Star Rating Output-->
    <?php foreach ($rankedSelection->rating4->binaryComponents as $rankedBinary): ?>
        <li class="binaryComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">4</span></span>
            <span class="binaryComponentInfo">
                <span>
                    <?= $rankedBinary->display_name != '' ? $rankedBinary->display_name : $rankedBinary->name ?>
                </span>
                <span class="pull-right"><span class="glyphicon <?= $rankedBinary->binaryComponentState ? 'glyphicon-ok' : 'glyphicon-remove' ?> <?= $rankedBinary->binaryComponentState ? 'text-success' : 'text-danger' ?>" aria-hidden="true"></span></span>
            </span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating4->nominalAttributes as $rankedNominal): ?>
        <li class="nominalComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">4</span></span>
            <div class="nominalAttribute pull-right"><figure class="attrIcons <?= $rankedNominal->icon_path != '' ? $rankedNominal->icon_path : 'iconPlaceholder' ?>"></figure></div>
            <span class="componentNameNominalComponent<?= $rankedNominal->nominal_component->display_name != '' ? '' : ' text-muted' ?>"><?= $rankedNominal->nominal_component->display_name != '' ? ($rankedNominal->nominal_component->display_name) : $rankedNominal->nominal_component->name ?></span> <br><span class="attributeNameNominalAttribute <?= $rankedNominal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedNominal->display_name != '' ? $rankedNominal->display_name : $rankedNominal->name ?></span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating4->ordinalAttributes as $rankedOrdinal): ?>
        <li class="ordianalComponentContainer">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">4</span></span>
            <span class="componentNameOrdinalComponent<?= $rankedOrdinal->ordinal_component->display_name != '' ? '' : ' text-muted' ?>"><?=  $rankedOrdinal->ordinal_component->display_name != '' ? ( $rankedOrdinal->ordinal_component->display_name) :  $rankedOrdinal->ordinal_component->name ?></span> <span class="attributeNameOrdinalAttribute <?= $rankedOrdinal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedOrdinal->display_name != '' ? $rankedOrdinal->display_name : $rankedOrdinal->name ?></span> <br>
            <?php
            $minRange = reset($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            $maxRange = end($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            ?>
            <input type="range" min="<?= $minRange ?>" max="<?= $maxRange ?>" step="1" value="<?= $rankedOrdinal->meter ?>" disabled>
        </li>
    <?php endforeach; ?>

    <!-- 3-Star Rating Output-->
    <?php foreach ($rankedSelection->rating3->binaryComponents as $rankedBinary): ?>
        <li class="binaryComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">3</span></span>
            <span class="binaryComponentInfo">
                <span>
                    <?= $rankedBinary->display_name != '' ? $rankedBinary->display_name : $rankedBinary->name ?>
                </span>
                <span class="pull-right"><span class="glyphicon <?= $rankedBinary->binaryComponentState ? 'glyphicon-ok' : 'glyphicon-remove' ?> <?= $rankedBinary->binaryComponentState ? 'text-success' : 'text-danger' ?>" aria-hidden="true"></span></span>
            </span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating3->nominalAttributes as $rankedNominal): ?>
        <li class="nominalComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">3</span></span>
            <div class="nominalAttribute pull-right"><figure class="attrIcons <?= $rankedNominal->icon_path != '' ? $rankedNominal->icon_path : 'iconPlaceholder' ?>"></figure></div>
            <span class="componentNameNominalComponent<?= $rankedNominal->nominal_component->display_name != '' ? '' : ' text-muted' ?>"><?= $rankedNominal->nominal_component->display_name != '' ? ($rankedNominal->nominal_component->display_name) : $rankedNominal->nominal_component->name ?></span> <br><span class="attributeNameNominalAttribute <?= $rankedNominal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedNominal->display_name != '' ? $rankedNominal->display_name : $rankedNominal->name ?></span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating3->ordinalAttributes as $rankedOrdinal): ?>
        <li class="ordianalComponentContainer">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">3</span></span>
            <span class="componentNameOrdinalComponent<?= $rankedOrdinal->ordinal_component->display_name != '' ? '' : ' text-muted' ?>"><?=  $rankedOrdinal->ordinal_component->display_name != '' ? ( $rankedOrdinal->ordinal_component->display_name) :  $rankedOrdinal->ordinal_component->name ?></span> <span class="attributeNameOrdinalAttribute <?= $rankedOrdinal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedOrdinal->display_name != '' ? $rankedOrdinal->display_name : $rankedOrdinal->name ?></span> <br>
            <?php
            $minRange = reset($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            $maxRange = end($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            ?>
            <input type="range" min="<?= $minRange ?>" max="<?= $maxRange ?>" step="1" value="<?= $rankedOrdinal->meter ?>" disabled>
        </li>
    <?php endforeach; ?>

    <!-- 2-Star Rating Output-->
    <?php foreach ($rankedSelection->rating2->binaryComponents as $rankedBinary): ?>
        <li class="binaryComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">2</span></span>
            <span class="binaryComponentInfo">
                <span>
                    <?= $rankedBinary->display_name != '' ? $rankedBinary->display_name : $rankedBinary->name ?>
                </span>
                <span class="pull-right"><span class="glyphicon <?= $rankedBinary->binaryComponentState ? 'glyphicon-ok' : 'glyphicon-remove' ?> <?= $rankedBinary->binaryComponentState ? 'text-success' : 'text-danger' ?>" aria-hidden="true"></span></span>
            </span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating2->nominalAttributes as $rankedNominal): ?>
        <li class="nominalComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">2</span></span>
            <div class="nominalAttribute pull-right"><figure class="attrIcons <?= $rankedNominal->icon_path != '' ? $rankedNominal->icon_path : 'iconPlaceholder' ?>"></figure></div>
            <span class="componentNameNominalComponent<?= $rankedNominal->nominal_component->display_name != '' ? '' : ' text-muted' ?>"><?= $rankedNominal->nominal_component->display_name != '' ? ($rankedNominal->nominal_component->display_name) : $rankedNominal->nominal_component->name ?></span> <br><span class="attributeNameNominalAttribute <?= $rankedNominal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedNominal->display_name != '' ? $rankedNominal->display_name : $rankedNominal->name ?></span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating2->ordinalAttributes as $rankedOrdinal): ?>
        <li class="ordianalComponentContainer">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">2</span></span>
            <span class="componentNameOrdinalComponent<?= $rankedOrdinal->ordinal_component->display_name != '' ? '' : ' text-muted' ?>"><?=  $rankedOrdinal->ordinal_component->display_name != '' ? ( $rankedOrdinal->ordinal_component->display_name) :  $rankedOrdinal->ordinal_component->name ?></span> <span class="attributeNameOrdinalAttribute <?= $rankedOrdinal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedOrdinal->display_name != '' ? $rankedOrdinal->display_name : $rankedOrdinal->name ?></span> <br>
            <?php
            $minRange = reset($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            $maxRange = end($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            ?>
            <input type="range" min="<?= $minRange ?>" max="<?= $maxRange ?>" step="1" value="<?= $rankedOrdinal->meter ?>" disabled>
        </li>
    <?php endforeach; ?>

    <!-- 1-Star Rating Output-->
    <?php foreach ($rankedSelection->rating1->binaryComponents as $rankedBinary): ?>
        <li class="binaryComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">1</span></span>
            <span class="binaryComponentInfo">
                <span>
                    <?= $rankedBinary->display_name != '' ? $rankedBinary->display_name : $rankedBinary->name ?>
                </span>
                <span class="pull-right"><span class="glyphicon <?= $rankedBinary->binaryComponentState ? 'glyphicon-ok' : 'glyphicon-remove' ?> <?= $rankedBinary->binaryComponentState ? 'text-success' : 'text-danger' ?>" aria-hidden="true"></span></span>
            </span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating1->nominalAttributes as $rankedNominal): ?>
        <li class="nominalComponentContainer clearfix">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">1</span></span>
            <div class="nominalAttribute pull-right"><figure class="attrIcons <?= $rankedNominal->icon_path != '' ? $rankedNominal->icon_path : 'iconPlaceholder' ?>"></figure></div>
            <span class="componentNameNominalComponent<?= $rankedNominal->nominal_component->display_name != '' ? '' : ' text-muted' ?>"><?= $rankedNominal->nominal_component->display_name != '' ? ($rankedNominal->nominal_component->display_name) : $rankedNominal->nominal_component->name ?></span> <br><span class="attributeNameNominalAttribute <?= $rankedNominal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedNominal->display_name != '' ? $rankedNominal->display_name : $rankedNominal->name ?></span>
        </li>
    <?php endforeach; ?>
    <?php foreach ($rankedSelection->rating1->ordinalAttributes as $rankedOrdinal): ?>
        <li class="ordianalComponentContainer">
            <span class="glyphicon glyphicon-star choosenStarAgregation pull-left" aria-hidden="true"><span class="choosenStarAgregationNumber">1</span></span>
            <span class="componentNameOrdinalComponent<?= $rankedOrdinal->ordinal_component->display_name != '' ? '' : ' text-muted' ?>"><?=  $rankedOrdinal->ordinal_component->display_name != '' ? ( $rankedOrdinal->ordinal_component->display_name) :  $rankedOrdinal->ordinal_component->name ?></span> <span class="attributeNameOrdinalAttribute <?= $rankedOrdinal->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $rankedOrdinal->display_name != '' ? $rankedOrdinal->display_name : $rankedOrdinal->name ?></span> <br>
            <?php
            $minRange = reset($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            $maxRange = end($rankedOrdinal->ordinal_component->ordinal_attributes)->meter;
            ?>
            <input type="range" min="<?= $minRange ?>" max="<?= $maxRange ?>" step="1" value="<?= $rankedOrdinal->meter ?>" disabled>
        </li>
    <?php endforeach; ?>
    
</ul>