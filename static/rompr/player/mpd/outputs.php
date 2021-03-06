<?php

@open_mpd_connection();
if ($is_connected) {
    $outputdata = array();
    $outputs = do_mpd_command($connection, "outputs", null, true);
    close_mpd($connection);
    foreach ($outputs as $i => $n) {
        if (is_array($n)) {
            foreach ($n as $a => $b) {
                debug_print($i." - ".$b.":".$a,"AUDIO OUTPUT");
                $outputdata[$a][$i] = $b;
            }
        } else {
            debug_print($i." - ".$n,"AUDIO OUTPUT");
            $outputdata[0][$i] = $n;
        }
    }

    print '<table>';
    for ($i = 0; $i < count($outputdata); $i++) {
        print '<tr><td>'.$outputdata[$i]['outputname'].'</td>';
        print '<td><div id="outputbutton'.$i.'" style="margin-left:12px" onclick="outputswitch('.$i.')" class="togglebutton clickicon togglebutton-'.$outputdata[$i]['outputenabled'].'"></div></td></tr>';
    }
    print '</table>';
}
close_mpd($connection);
?>