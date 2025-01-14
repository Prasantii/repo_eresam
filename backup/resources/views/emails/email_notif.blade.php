
<html lang="en-US">
<head>
    <meta name="viewport" content="width=device-width">
    <title>SIMAUN - Sistem Manajemen ASN Untuk Negeri | Administrator</title>            
    
	
	<style type="text/css"> /* -------------------------------------
    GLOBAL
    A very basic CSS reset
------------------------------------- */
* {
  margin: 0;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  box-sizing: border-box;
  font-size: 14px;
}

img {
  max-width: 100%;
}

body {
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: none;
  width: 100% !important;
  height: 100%;
  line-height: 1.6em;

  /* 1.6em * 14px = 22.4px, use px to get airier line-height also in Thunderbird, and Yahoo!, Outlook.com, AOL webmail clients */
  /*line-height: 22px;*/
}

/* Let's make sure all tables have defaults */
table td {
  vertical-align: top;
}

/* -------------------------------------
    BODY & CONTAINER
------------------------------------- */
body {
  background-color: #f6f6f6;
}

.body-wrap {
  background-color: #f6f6f6;
  width: 100%;

}

.container {
  display: block !important;
  max-width: 600px !important;
  margin: 0 auto !important;
  /* makes it centered */
  clear: both !important;
}

.content {
  max-width: 600px;
  margin: 0 auto;
  display: block;
  padding: 20px;
  border-radius: 3px 3px 3px 3px;
}

/* -------------------------------------
    HEADER, FOOTER, MAIN
------------------------------------- */
.main {
  background-color: #fff;
  border: 1px solid #DBE0E4;
  border-radius: 3px;
  border-radius: 3px 3px 3px 3px;
}

.content-wrap {
  padding: 20px;
}

.content-block {
  padding: 0 0 20px;
}

.header {
  width: 100%;
  margin-bottom: 20px;
}

.footer {
  width: 100%;
  clear: both;
  color: #7F8FA4;
  padding: 20px;
}
.footer p, .footer a, .footer td {
  color: #999;
  font-size: 12px;
}

/* -------------------------------------
    TYPOGRAPHY
------------------------------------- */
h1, h2, h3 {
  font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  color: #1B2431;
  margin: 40px 0 0;
  line-height: 1.2em;
  font-weight: 400;
}

h1 {
  font-size: 32px;
  font-weight: 500;
  /* 1.2em * 32px = 38.4px, use px to get airier line-height also in Thunderbird, and Yahoo!, Outlook.com, AOL webmail clients */
  /*line-height: 38px;*/
}

h2 {
  font-size: 24px;
  /* 1.2em * 24px = 28.8px, use px to get airier line-height also in Thunderbird, and Yahoo!, Outlook.com, AOL webmail clients */
  /*line-height: 29px;*/
}

h3 {
  font-size: 18px;
  /* 1.2em * 18px = 21.6px, use px to get airier line-height also in Thunderbird, and Yahoo!, Outlook.com, AOL webmail clients */
  /*line-height: 22px;*/
}

h4 {
  font-size: 14px;
  font-weight: 600;
}

p, ul, ol {
  margin-bottom: 10px;
  font-weight: normal;
}
p li, ul li, ol li {
  margin-left: 5px;
  list-style-position: inside;
}

/* -------------------------------------
    LINKS & BUTTONS
------------------------------------- */
a {
  color: #0F9DEA;
  text-decoration: underline;
}

.btn-primary {
  text-decoration: none;
  color: #FFF;
  background-color: #2D3349;
  border: solid #2D3349;
  border-width: 10px 20px;
  line-height: 2em;
  /* 2em * 14px = 28px, use px to get airier line-height also in Thunderbird, and Yahoo!, Outlook.com, AOL webmail clients */
  /*line-height: 28px;*/
  font-weight: bold;
  text-align: center;
  cursor: pointer;
  display: inline-block;
  border-radius: 5px;
  text-transform: capitalize;
}

/* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
------------------------------------- */
.last {
  margin-bottom: 0;
}

.first {
  margin-top: 0;
}

.aligncenter {
  text-align: center;
}

.alignright {
  text-align: right;
}

.alignleft {
  text-align: left;
}

.clear {
  clear: both;
}

.logo{
    background: #2D3349;
    text-align: center;
    border-radius: 3px 3px 0 0;
    padding: 40px 0px;
}

/* -------------------------------------
    ALERTS
    Change the class depending on warning email, good email or bad email
------------------------------------- */
.alert {
  font-size: 14px;  
  color: #fff;
  font-weight: 500;  
  padding: 20px;
  text-align: center;  
}
.alert a {
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  font-size: 16px;
}
.alert.alert-warning {
  background-color: #e55701;
}
.alert.alert-bad {
  background-color: #D0021B;
}
.alert.alert-good {
  background-color: #68B90F;
}

/* -------------------------------------
    INVOICE
    Styles for the billing table
------------------------------------- */
.invoice {
  margin: 40px auto;
  text-align: left;
  width: 80%;
}
.invoice td {
  padding: 5px 0;
}
.invoice .invoice-items {
  width: 100%;
}
.invoice .invoice-items td {
  border-top: #eee 1px solid;
}
.invoice .invoice-items .total td {
  border-top: 2px solid #333;
  border-bottom: 2px solid #333;
  font-weight: 700;
}

/* -------------------------------------
    RESPONSIVE AND MOBILE FRIENDLY STYLES
------------------------------------- */
@media only screen and (max-width: 640px) {
  body {
    padding: 0 !important;
  }

  h1, h2, h3, h4 {
    font-weight: 800 !important;
    margin: 20px 0 5px !important;
  }

  h1 {
    font-size: 22px !important;
  }

  h2 {
    font-size: 18px !important;
  }

  h3 {
    font-size: 16px !important;
  }

  .container {
    padding: 0 !important;
    width: 100% !important;
  }

  .content {
    padding: 0 !important;
  }

  .content-wrap {
    padding: 10px !important;
  }

  .invoice {
    width: 100% !important;
  }
}

/*# sourceMappingURL=styles.css.map */

  </style>
</head>

    <body itemscope itemtype="http://schema.org/EmailMessage" >

        <table class="body-wrap" >
            <tr>
                <td></td>
                <td class="container" width="600">
                    <div class="content">
                        <table class="main" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="logo" style="text-align: right;border-radius: 0px 0px 0 0;background: #334868;">
                                <a href="https://simaunbpnaceh.com/" style="outline:none; text-decoration:none;" target="_blank">
                                <span style="color:yellow;text-align: center;font-size: 20px;">SIMAUN - Sistem Manajemen ASN Untuk Negeri</a>
                                </td>
                                <td style="background: #334868;padding: 9px 0px;"></span><a href="https://simaunbpnaceh.com/" style="outline:none; text-decoration:none;" target="_blank"><img src="https://simaunbpnaceh.com/halamanuser/logomaun.png" width="100px" height="100px"></a></td>
                            </tr>
                            <tr>
                                <td class="content-wrap aligncenter" colspan="2" style="background: #efefef">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <br>
                                          <div style="padding: 10px;font-size:15px; font-family:'Helvetica Neue', helvetica, arial, sans-serif; font-weight:100; color:#545454;text-align:left;">Hi, <strong style="font-size:15px;">{{ $mail_body['nama'] }}</strong>
                                          </div>

                                          <div style="padding: 10px;font-size:15px; font-family:'Helvetica Neue', helvetica, arial, sans-serif; font-weight:100; color:#545454;text-align:left;">SELAMAT DATA ANDA BERHASIL DI VERIFIKASI
                                          </div>
      									
                                          <br>
                        									
                        									
                        									<br><br>
                        									
                                    </div>
                                        </tr>
                                        <tr>
                                            <td class="content-block aligncenter">
                                                <!-- <a href="http://www.mailgun.com">View in browser</a> -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="content-block aligncenter">
                                               
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                        </table>
                        <div class="footer">
                            <table width="100%">
                                <tr>
                                    <td class="content-block aligncenter">
                                                © 2020, <strong><span style="color: #f68e1e;">Kementerian ATR/BPN Aceh </span></strong> . supported by <strong><span style="color: #f68e1e;">RIMSCORP.</span></strong> All Rights Reserved. <br class="aligncenter content-block"> Questions? Email <a href="mailto:admin@simaunbpnaceh.com">admin@simaunbpnaceh.com</a>
                                    </td>
                                    <td class="aligncenter content-block"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>

    </body>
</html>
