<?

$base_URL=$_SERVER['HTTP_HOST'];

echo "
<head>
<title>Gabia Hiworks Salt Monitoring</title>
<link rel='stylesheet' href='http://$base_URL/ci/application/views/css/integrated.css' type='text/css'>
</head>

<table class='Menu' width='100%' cellpadding='0' cellspacing='0' border='0'>
        <tr>
                <td>
                        <table  class='Menu' cellpadding='0' cellspacing='0' border='0'>
                                <tr>
                                        <td class='Link' height='24' align='left'> <b>HIWORKS</b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/' target='content1'>&nbsp;&nbsp;Total</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/critical' target='content1'>&nbsp;&nbsp;Critical</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/splist' target='content1'>&nbsp;&nbsp;Service&Process</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/disk' target='content1'>&nbsp;&nbsp;Disk</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/traffic' target='content1'>&nbsp;&nbsp;Traffic</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/nores' target='content1'>&nbsp;&nbsp;No Response</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/mlog' target='content1'>&nbsp;&nbsp;MessageLog</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/rlog' target='content1'>&nbsp;&nbsp;RebootLog</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/events' target='content1'>&nbsp;&nbsp;Events</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/uptime' target='content1'>&nbsp;&nbsp;Uptime</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/grains' target='content1'>&nbsp;&nbsp;Grains</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/degree' target='content1'>&nbsp;&nbsp;Degree</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/hardware' target='content1'>&nbsp;&nbsp;HWinfo</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/cmevents' target='content1'>&nbsp;&nbsp;CM_events</a></b></td>
                                        <td class='Link' height='24' align='left'> <b><a href='http://$base_URL/ci/index.php/saltstack/ipmievents' target='content1'>&nbsp;&nbsp;IPMI_events</a></b></td>
                                </tr>
                        </table>
                </td>
        </tr>
</table>
<br>";
?>
