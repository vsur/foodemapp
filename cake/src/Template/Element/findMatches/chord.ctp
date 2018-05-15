<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1>Mockup-Darstellung</h1>
        <h2>Chord-Diagramm für Desktop</h2>
        <p>1. Quadrant: Alle sonstigen nicht gewählten Kriterien</p>
        <p>2 + 3. Quadrant: Alle zurückgelieferten Ergebnisse/Orte</p>
        <p>4. Quadrant: Alle gewählten Kriterien</p>
        <p>Die Verbindungslinien stellen die Zuordnung von Orteh und Eigenschaften dar./p>
        <?= $this->Html->image('list-mockup.png', ['alt' => 'Mock-up für die Listendarstellung der App', 'style' => 'width: 100%']); ?>
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