<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Welcome Message</title>
    </head>
    <body>
        <center>
            <table width="600" background="#FFFFFF" style="text-align:left;" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="18" width="31" style="border-bottom:1px solid #e4e4e4;">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                    <td height="18" width="131">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                    <td height="18" width="466" style="border-bottom:1px solid #e4e4e4;">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td height="2" width="31" style="border-bottom:1px solid #e4e4e4;">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                    <td height="2" width="131">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                    <td height="2" width="466" style="border-bottom:1px solid #e4e4e4;">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                </tr>
                <!--GREEN STRIPE-->
                <tr>
                    <td background="<?php echo base_url(); ?>images/greenback.gif" width="31" bgcolor="#45a853" style="border-top:1px solid #FFF; border-bottom:1px solid #FFF;" height="113">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>

                    <!--WHITE TEXT AREA-->
                    <td width="131" bgcolor="#FFFFFF" style="border-top:1px solid #FFF; text-align:center;" height="113" valign="middle">
                        <span style="font-size:25px; font-family:Trebuchet MS, Verdana, Arial; color:#2e8a3b;">Success!</span>
                    </td>

                    <!--GREEN TEXT AREA-->
                    <td background="<?php echo base_url(); ?>images/greenback.gif" bgcolor="#45a853" style="border-top:1px solid #FFF; border-bottom:1px solid #FFF; padding-left:15px;" height="113">
                        <span style="color:#FFFFFF; font-size:18px; font-family:Trebuchet MS, Verdana, Arial;">User Enquiry.</span>
                    </td>
                </tr>

                <!--DOUBLE BORDERS BOTTOM-->
                <tr>
                    <td height="3" width="31" style="border-top:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4;">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                    <td height="3" width="131">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                    <td height="3" style="border-top:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4;">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <!--CONTENT STARTS HERE-->
                        <br />
                        <br />
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="15"><div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                                </td>
                                <td width="325" style="padding-right:10px; font-family:Trebuchet MS, Verdana, Arial; font-size:12px;" valign="top">
                                    <span style="font-family:Trebuchet MS, Verdana, Arial; font-size:17px; font-weight:bold;">Dear,</span>
                                    <br />
                                    <p>  <?php echo $firstname; ?></p>
                                    <p> <?php echo $mail; ?></p>
                                    <br />
                                    <div ><?php echo $body; ?></div>

       <!--<div style="padding-left:20px; padding-bottom:10px;"><img src="images/spade.gif" alt=""/>&nbsp;&nbsp;&nbsp;Benefit of receiving email (#2)</div>
       <div style="padding-left:20px; padding-bottom:10px;"><img src="images/spade.gif" alt=""/>&nbsp;&nbsp;&nbsp;Benefit of receiving email (#3)</div>-->

                                    <p>In the meantime, you can <a href="<?php echo base_url() ?>">return to my website</a> to continue browsing.</p>

                                    Best Regards,<br/>
                                    <?php echo $firstname; ?>.<br/>

                                    eknowledgetree.com .<br/>
                                    <br/>

                                    This welcome email was sent to you because you recently signed up for <a href="<?php echo base_url() ?>">Triwin</a>.

                                </td>
                                <td style="border-left:1px solid #e4e4e4; padding-left:15px;" valign="top">
                                    <!--RIGHT COLUMN SECOND BOX-->
                                    <br />
                                    <table width="100%" cellpadding="0" cellspacing="0" style="border-bottom:1px solid #e4e4e4; font-family:Trebuchet MS, Verdana, Arial; font-size:12px;">
                                        <tr>
                                            <td>
                                                <div style="font-family:Trebuchet MS, Verdana, Arial; font-size:17px; font-weight:bold; padding-bottom:10px;">Have Any Questions?</div>
                                                <img src="<?php echo base_url(); ?>images/penpaper.gif" align="right" style="padding-left:10px; padding-top:10px; padding-bottom:10px;" alt=""/>
                                                <p>Don't hesitate to hit the reply button to any of the messages you receive.</p>
                                                <br />
                                            </td>
                                        </tr>
                                    </table>

                                    <!--RIGHT COLUMN THIRD BOX-->
                                    <br />
                                    <table cellpadding="0" width="100%" cellspacing="0" style="font-family:Trebuchet MS, Verdana, Arial; font-size:12px;">
                                        <tr>
                                            <td>
                                                <div style="font-family:Trebuchet MS, Verdana, Arial; font-size:17px; font-weight:bold; padding-bottom:10px;">Have A Topic Idea?</div>
                                                <img src="<?php echo base_url(); ?>images/lightbulb.gif" align="right" style="padding-left:10px; padding-top:10px; padding-bottom:10px;" alt=""/>
                                                <p>I'd love to hear it! Just reply any time and let me know what topics you'd like to know more about.</p>

                                                <br />
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br />
            <table cellpadding="0" style="border-top:1px solid #e4e4e4; text-align:center; font-family:Trebuchet MS, Verdana, Arial; font-size:12px;" cellspacing="0" width="600">
                <tr>
                    <td height="2" style="border-bottom:1px solid #e4e4e4;">
                        <div style="line-height: 0px; font-size: 1px; position: absolute;">&nbsp;</div>
                    </td>
                </tr>
                <td style="font-family:Trebuchet MS, Verdana, Arial; font-size:12px;">
                    <br />
                    <strong><a href="mailto:support@eknowledgetree.com">support@triwin.com</a></strong><br />

                </td>
                </tr>
            </table>
        </center>
    </body>
</html>