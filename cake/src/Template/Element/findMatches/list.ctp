<div class="row" id="listView">
    <div class="col-md-12">
    <?php foreach ($ypois as $nr => $ypoi): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title clearfix"><strong><?= $this->Number->format($nr + 1) . '.' ?> <?= h($ypoi->name) ?></strong> <div class="listMoreInfo pull-right">Mehr Infos anzeigen <span class="caret"></span></div></h3>
            </div>
            <div class="panel-body">
                <div class="row chosenAgregation">
                    <div class="col-md-12">
                        <?= $this->Selection->createAggregatedSelectionRow($rankedSelection) ?>
                    </div>
                </div>
                <div class="row componentOverview">
                    <div class="col-sm-6 choosenSelection">
                        <h4><span class="label label-primary">Gewählte</span></h4>
                        <?= $this->Selection->createRankedSelectionList($rankedSelection) ?>
                    </div>
                    <div class="col-sm-6">
                        <h4><span class="label label-default">Übrige</span></h4>
                        <ul class="list-unstyled">
                            <?php foreach ($ypoi->binary_components as $binaryComponent): ?>
                                <?php if (!in_array($binaryComponent->id, $rankedSelection->binaryComponentIDs)): ?>
                                    <li class="binaryComponentContainer clearfix">
                                        <span class="componentNameBinarySlider<?= $binaryComponent->display_name != '' ? '' : ' text-muted' ?>"><?= $binaryComponent->display_name != '' ? $binaryComponent->display_name : $binaryComponent->name ?></span><label class="switch pull-right"><input type="checkbox" checked disabled><span class="slider round"></span></label>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php foreach ($ypoi->nominal_attributes as $nomnialAttribute): ?>
                                <?php if (!in_array($nomnialAttribute->id, $rankedSelection->nominalAttributeIDs)): ?>
                                    <li class="nominalComponentContainer clearfix">
                                        <div class="nominalAttribute pull-right"><figure class="attrIcons <?= $nomnialAttribute->icon_path != '' ? $nomnialAttribute->icon_path : 'iconPlaceholder' ?>"></figure></div>
                                        <span class="componentNameNominalComponent<?= $nomnialAttribute->nominal_component->display_name != '' ? '' : ' text-muted' ?>"><?= $nomnialAttribute->nominal_component->display_name != '' ? ($nomnialAttribute->nominal_component->display_name) : $nomnialAttribute->nominal_component->name ?></span> <br><span class="attributeNameNominalAttribute <?= $nomnialAttribute->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $nomnialAttribute->display_name != '' ? $nomnialAttribute->display_name : $nomnialAttribute->name ?></span>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php foreach ($ypoi->ordinal_attributes as $ordinalAttribute): ?>
                                <?php if (!in_array($ordinalAttribute->id, $rankedSelection->ordinalAttributeIDs)): ?>
                                    <li class="ordianalComponentContainer">
                                        <span class="componentNameOrdinalComponent<?= $ordinalAttribute->ordinal_component->display_name != '' ? '' : ' text-muted' ?>"><?=  $ordinalAttribute->ordinal_component->display_name != '' ? ( $ordinalAttribute->ordinal_component->display_name) :  $ordinalAttribute->ordinal_component->name ?></span> <span class="attributeNameOrdinalAttribute <?= $ordinalAttribute->display_name != '' ? 'textURcolor' : 'text-muted' ?>"><?= $ordinalAttribute->display_name != '' ? $ordinalAttribute->display_name : $ordinalAttribute->name ?></span> <br>
                                        <?php
                                            $minRange = reset($ordinalAttribute->ordinal_component->ordinal_attributes)->meter;
                                            $maxRange = end($ordinalAttribute->ordinal_component->ordinal_attributes)->meter;
                                        ?>
                                        <input type="range" min="<?= $minRange ?>" max="<?= $maxRange ?>" step="1" value="<?= $ordinalAttribute->meter ?>" disabled>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Binary</th>
                <th>Nominal</th>
                <th>Ordinal</th>
                <th>Stars</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ypois as $nr => $ypoi): ?>
                <tr>
                    <td><?= $this->Number->format($nr + 1) ?></td>
                    <td><?= h($ypoi->name) ?></td>
                    <td>
                        <ol style="margin-bottom: 0">
                            <?php foreach ($ypoi->binary_components as $binaryComponent): ?>
                                <li><?= $binaryComponent->display_name != '' ? $binaryComponent->display_name : ('<span class="text-muted">' . $binaryComponent->name . '</span>')  ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td>
                        <ol style="margin-bottom: 0">
                            <?php foreach ($ypoi->nominal_attributes as $nomnialAttribute): ?>
                                <li><?= $nomnialAttribute->nominal_component->display_name != '' ? ($nomnialAttribute->nominal_component->display_name . '.') : ('<span class="text-muted">' . $nomnialAttribute->nominal_component->name . ':</span>') ?> <?= $nomnialAttribute->display_name != '' ? $nomnialAttribute->display_name : ('<span class="text-muted">' . $nomnialAttribute->name . '</span>') ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td>
                        <ol style="margin-bottom: 0">
                            <?php foreach ($ypoi->ordinal_attributes as $ordinalAttribute): ?>
                                <li><?= $ordinalAttribute->ordinal_component->display_name != '' ? ($ordinalAttribute->ordinal_component->display_name . ':') : ('<span class="text-muted">' . $ordinalAttribute->ordinal_component->meter . ':</span>') ?> <?= $ordinalAttribute->display_name != '' ? $ordinalAttribute->display_name : ('<span class="text-muted">' . $ordinalAttribute->name . '</span>') ?></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td><?= $this->Number->format($ypoi->stars) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div> <!-- /.col-md-12 -->
</div>