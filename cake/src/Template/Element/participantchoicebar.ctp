<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand hidden-xs hidden-sm" href="#"><?= $step; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form method="post" class="navbar-form navbar-right">
                <div class="form-group">
                    <select name="participants" class="nav-select" id="participantChoice" required="required">
                        <option value="">(Bitte auswählen)</option>
                        <?php
                          foreach ($allParticipants as $key => $participant) {
                            $start = $this->Time->format($participant->startdate);
                            $duration = $participant->submitdate->diff($participant->startdate)->format('%H:%i:%s h');
                            $optionLabel = "ID: " .  $participant->id . " Am: " . $start . " Dauer: " . $duration;
                            $preselect = false;
                            if( $participantData->id == $participant->id) {
                              $preselect = true;
                            }
                            echo '<option value="' . $participant->id . '"' . ($preselect ? ' selected="selected"' : '') .'>' . $optionLabel  . '</option>';
                          }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-default">Anzeigen</button>
            </form>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>