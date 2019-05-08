<?php
//edited from EA Reset Password email
$firstPart = '<html xmlns="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head></head>

<body style="margin: 0px; -webkit-text-size-adjust:none; background-color: #dddddd;" yahoo="fix">
    <div data-marker="wrapper" style="" class="stylingblock-content-wrapper"></div>
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta name="referrer" content="no-referrer">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic" rel="stylesheet" type="text/css">
    <style type="text/css">
        /** RESET STYLES **/
        p {
            margin: 1em 0;
        }

        /*Yahoo paragraph fix*/
        table td {
            border-collapse: collapse;
        }

        /*This resolves the Outlook 07, 10, and Gmail td padding issue fix*/
        img,
        a img {
            border: 0;
            height: auto;
            outline: none;
            text-decoration: none;
        }

        /* Remove the borders that appear when linking images with "border:none" and "outline:none" */
        @-ms-viewport {
            width: device-width;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            display: block !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        body,
            {
            height: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }

        /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
        linkfix a {
            color: #bababa !important;
            text-decoration: none;
        }

        /** CLIENT-SPECIFIC STYLE **/
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* Force IE to smoothly render resized images. */
        table {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        /* Remove spacing between tables in Outlook 2007 and up. */
        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        /* Force Outlook.com to display emails at full width. */
        p,
        a,
        li,
        td,
        blockquote {
            mso-line-height-rule: exactly;
        }

        /* Force Outlook to render line heights as they\'re originally set. */
        a[href^="tel"],
        a[href^="sms"] {
            color: inherit;
            cursor: default;
            text-decoration: none;
        }

        /* Force mobile devices to inherit declared link styles. */
        p,
        a,
        li,
        td,
        body,
        table,
        blockquote {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* Prevent Windows- and Webkit-based mobile platforms from changing declared text sizes. */
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass td,
        .ExternalClass div,
        .ExternalClass span,
        .ExternalClass font {
            line-height: 100%;
        }

        /* Force Outlook.com to display line heights normally. */

        /** STRUCTURAL STYLES **/

        /** CONTENT STYLES **/
        body {
            width: 100%;
            background-color: #e8e8e8;
            margin: 0 auto;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            font-family: "Arial", sans-serif !important;
        }

        /** MOBILE STYLES **/
        @media only screen and (max-device-width: 480px),
        screen and (max-width: 480px) {

            /* CLIENT-SPECIFIC STYLES */
            /* Template Shell */
            body[yahoo] {
                width: 100% !important;
                min-width: 100% !important;
                margin: 0 auto !important;
            }

            /* Force iOS Mail to render the email at full width & removes margins. */


            /*** STRUCTURAL ***/

            body[yahoo] .container {
                width: 100% !important;
                max-width: 480px !important;
            }

            body[yahoo] .mobileShow {
                display: block !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
                width: auto !important;
                max-height: inherit !important;
            }

            body[yahoo] .mobileHide {
                display: none !important;
            }

            body[yahoo] .photo img {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }

            body[yahoo] .columnStack {
                width: 100% !important;
                display: block !important;
            }

            body[yahoo] .contentCenter,
            body[yahoo] .contentCenter img,
            body[yahoo] .contentCenter table {
                margin: 0 auto !important;
            }

            body[yahoo] .textCenter {
                text-align: center !important;
            }

            body[yahoo] .textLeft {
                text-align: left !important;
            }

            body[yahoo] .nullBorder {
                border: none !important;
            }

            body[yahoo] .alignTop {
                vertical-align: top !important;
            }

            body[yahoo] .autoHeight {
                height: auto !important;
            }

            /*** PADDING ***/

            body[yahoo] .nullPad {
                padding: 0px !important;
            }

            body[yahoo] .mobilePad {
                padding-right: 30px !important;
                padding-left: 30px !important;
            }

            body[yahoo] .bottomPad5 {
                padding-bottom: 5px !important;
            }

            body[yahoo] .topPad5 {
                padding-bottom: 5px !important;
            }

            body[yahoo] .topPad10 {
                padding-top: 10px !important;
            }

            body[yahoo] .bottomPad10 {
                padding-bottom: 10px !important;
            }

            body[yahoo] .topPad15 {
                padding-top: 15px !important;
            }

            body[yahoo] .bottomPad15 {
                padding-bottom: 15px !important;
            }

            body[yahoo] .topPad20 {
                padding-top: 20px !important;
            }

            body[yahoo] .bottomPad20 {
                padding-bottom: 20px !important;
            }

            body[yahoo] .topPad25 {
                padding-top: 25px !important;
            }

            body[yahoo] .bottomPad25 {
                padding-bottom: 25px !important;
            }

            body[yahoo] .bottomPad30 {
                padding-bottom: 30px !important;
            }

            body[yahoo] .rightPad30 {
                padding-right: 30px !important;
            }

            /*** FONT RESIZING ***/

            body[yahoo] .fontResize17 {
                font-size: 17px !important;
            }

        }
    </style>

    <!--[if gte mso 9]> <style>     /* Target Outlook 2007 and 2010 */    html, body { font-family: Arial, sans-serif !important; }      table { font-family: Arial, sans-serif !important; }      td { font-family: Arial, sans-serif !important; } </style> <![endif]-->




    <!-- Start of: Header-->
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tbody>
            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 0px 20px;" class="nullPad">
                    <table border="0" cellspacing="0" cellpadding="0" width="600" class="container">
                        <tbody>
                            <tr>
                                <td align="center" bgcolor="#ffffff">

                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="middle" style="padding: 13px 40px;" class="mobilePad">
                                                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td align="left" valign="middle">
                                                                    <a href="#" target="_blank">
                                                                        <h1 style="
    text-decoration: none;
">
                                                                            Social Synergy
                                                                        </h1>
                                                                    </a>
                                                                </td>


                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- End of: Header -->
    <!-- Start of: Content -->
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tbody>
            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 0px 20px;" class="nullPad">
                    <table border="0" bgcolor="#ffffff" cellspacing="0" cellpadding="0" width="600" class="container">
                        <tbody>
                            <tr>
                                <td align="left" valign="top" width="100%" style="font-family: \'Arial\', sans-serif; font-size: 14px; mso-line-height-rule: exactly; line-height: 22px; color: #939598; padding: 30px 30px 30px;"
                                    class="mobilePad">
                                    <span style="color: #000000;"><b>Hi,</b></span><br><br>
                                    You\'re receiving this email because you requested a password reset for your Social
                                    Synergy Account. If
                                    you did not request this change, you can safely ignore this email.<br><br>
                                    To choose a new password and complete your request, please follow the link below:<br><br>
                                    <div style="word-break: break-all;">
                                        <a href="';







//SECOND PART
$secondPart = '" style="color: #4dafd4; font-family:arial; font-family:sans-serif; font-size: 16px; font-weight: bold; line-height: 150%; text-align: center; text-decoration: none;"><b>';









//THIRD PART
$thirdPart = '</b></a></div>
                                    <br>
                                    If it is not clickable, please copy and paste the URL into your browser\'s address
                                    bar.<br>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>



    <!-- End of: Footer -->
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tbody>
            <tr>
                <td align="center" bgcolor="#dddddd" height="50" style="font-size: 0px; mso-line-height-rule: exactly; line-height: 50px; height: 50px;">&nbsp;

                </td>
            </tr>
        </tbody>
    </table>
    <!-- Start of : keep gmail android from collapsing table -->
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="620" class="mobileHide">
        <tbody>
            <tr>
                <td height="1" style="font-size: 1px; line-height: 1px; min-width: 620px;">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <!-- End of : keep gmail android from collapsing table -->
    <img src="https://click.e.ea.com/open.aspx?ffcb10-feca17767160067f-fe2913757167027f771677-fe961372776d007c75-ff981675-fe29127473640679731d71-fec31772716c017b&amp;d=70068"
        width="1" height="1">





</body>

</html>';