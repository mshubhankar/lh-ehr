<?php
include_once("../globals.php");
include_once("$srcdir/md5.js");
include_once("$srcdir/sql.inc");
require_once("$srcdir/classes/POSRef.class.php");

if (isset($_GET["fid"])) {
	$my_fid = $_GET["fid"];
}

if (isset($_POST["fid"])) {
	$my_fid = $_POST["fid"];
}
if ($_POST["mode"] == "facility")
{

	echo '
<script type="text/javascript">
<!--
parent.$.fn.fancybox.close();
//-->
</script>

	';
}
?>
<html>
<head>

<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../library/js/fancybox/jquery.fancybox-1.2.6.css" media="screen" />
<script type="text/javascript" src="../../../library/dialog.js"></script>
<script type="text/javascript" src="../../../library/js/jquery.1.3.2.js"></script>
<script type="text/javascript" src="../../../library/js/common.js"></script>
<script type="text/javascript" src="../../../library/js/fancybox/jquery.fancybox-1.2.6.js"></script>
<script type="text/javascript">
function submitform() {
if (document.forms[0].facility.value.length>0)
document.forms[0].submit();
else
{
document.forms[0].facility.style.backgroundColor="red";
document.forms[0].facility.focus();
}
}
</script>
</head>
<body class="body_top" style="width:600px;height:330px !important;">

<table>
    <tr>
        <td>
        <span class="title"><?php xl('Edit Facility','e'); ?></span>&nbsp;&nbsp;&nbsp;</td><td>
        <a class="css_button large_button" name='form_save' id='form_save' onclick='submitform()' href='#' >
            <span class='css_button_span large_button_span'><?php xl('Save','e');?></span>
        </a>
        <a class="css_button large_button" id='cancel' href='#'>
            <span class='css_button_span large_button_span'><?php xl('Cancel','e');?></span>
        </a>
     </td>
  </tr>
</table>

<form name='facility' method='post' action="facilities.php"  target="_parent">
    <input type=hidden name=mode value="facility">
    <input type=hidden name=newmode value="admin_facility">	<!--	Diffrentiate Admin and add post backs -->
    <input type=hidden name=fid value="<?php echo $my_fid;?>">
    <?php $facility = sqlQuery("select * from facility where id='$my_fid'"); ?>

    <table border=0 cellpadding=0 cellspacing=1 style="width:630px;">
         <tr>
          <td width='150px'><span class='text'><?php xl('Name','e'); ?>: </span></td>
          <td width='220px'><input type='entry' name='facility' size='20' value='<?php echo $facility['name'] ?>'><font class="mandatory">&nbsp;*</font></td>
          <td width='200px'><span class='text'><?php xl('Phone','e'); ?> <?php xl('as','e'); ?> (000) 000-0000:</span></td>
          <td width='220px'><input type='entry' name='phone' size='20' value='<?php echo $facility['phone'] ?>'></td>
         </tr>
         <tr>
          <td><span class=text><?php xl('Address','e'); ?>: </span></td><td><input type=entry size=20 name=street value="<?php echo $facility["street"] ?>"></td>
          <td><span class='text'><?php xl('Fax','e'); ?> <?php xl('as','e'); ?> (000) 000-0000:</span></td>
          <td><input type='entry' name='fax' size='20' value='<?php echo $facility['fax'] ?>'></td>
         </tr>
        <tr>

            <td><span class=text><?php xl('City','e'); ?>: </span></td>
            <td><input type=entry size=20 name=city value="<?php echo $facility{"city"} ?>"></td>
            <td><span class=text><?php xl('Zip Code','e'); ?>: </span></td><td><input type=entry size=20 name=postal_code value="<?php echo $facility{"postal_code"} ?>"></td>
        </tr>
        <tr>
            <td><span class=text><?php xl('State','e'); ?>: </span></td><td><input type=entry size=20 name=state value="<?php echo $facility{"state"} ?>"></td>
            <td><span class=text><?php xl('Federal EIN','e'); ?>: </span></td><td><input type=entry size=20 name=federal_ein value="<?php echo $facility{"federal_ein"} ?>"></td>
        </tr>
        <tr>
            <td><span class=text><?php xl('Country','e'); ?>: </span></td><td><input type=entry size=20 name=country_code value="<?php echo $facility{"country_code"} ?>"></td>
            <td width="21"><span class=text><?php ($GLOBALS['simplified_demographics'] ? xl('Facility Code','e') : xl('Facility NPI','e')); ?>:
          </span></td><td><input type=entry size=20 name=facility_npi value="<?php echo $facility{"facility_npi"} ?>"></td>
        </tr>
         <tr>
          <td><span class='text'><?php xl('Billing Location','e'); ?>: </span></td>
          <td><input type='checkbox' name='billing_location' value='1' <?php if ($facility['billing_location'] == 1) echo 'checked'; ?>></td>
          <td rowspan='2'><span class='text'><?php xl('Accepts Assignment','e'); ?><br>(<?php xl('only if billing location','e'); ?>): </span></td>
          <td><input type='checkbox' name='accepts_assignment' value='1' <?php if ($facility['accepts_assignment'] == 1) echo 'checked'; ?>></td>
         </tr>
         <tr>
          <td><span class='text'><?php xl('Service Location','e'); ?>: </span></td>
          <td><input type='checkbox' name='service_location' value='1' <?php if ($facility['service_location'] == 1) echo 'checked'; ?>></td>
          <td>&nbsp;</td>
         </tr>

        <tr>
            <td><span class=text><?php xl('POS Code','e'); ?>: </span></td>
            <td colspan="6">
                <select name="pos_code">
                <?php
                $pc = new POSRef();

                foreach ($pc->get_pos_ref() as $pos) {
                    echo "<option value=\"" . $pos["code"] . "\" ";
                    if ($facility['pos_code'] == $pos['code']) {
                        echo "selected";
                    }
                    echo ">" . $pos['code']  . ": ". $pos['title'];
                    echo "</option>\n";
                }

                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><span class="text"><?php xl('Billing Attn','e'); ?>:</span></td>
            <td colspan="4"><input type="text" name="attn" size="45" value="<?php echo $facility['attn'] ?>"></td>
        </tr>
        <tr>
            <td><span class="text"><?php xl('CLIA Number','e'); ?>:</span></td>
            <td colspan="4"><input type="text" name="domain_identifier" size="45" value="<?php echo $facility['domain_identifier'] ?>"></td>
        </tr>
        <tr height="20" valign="bottom">
            <td colspan=2><span class="text"><font class="mandatory">*</font> <?php echo xl('Required','e');?></span></td>
        </tr>

    </table>
</form>

<script language="JavaScript">
$(document).ready(function(){
    $("#cancel").click(function() {
		  parent.$.fn.fancybox.close();
	 });
});
</script>

</body>
</html>
