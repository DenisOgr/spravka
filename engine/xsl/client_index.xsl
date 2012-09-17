<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:php="http://php.net/xsl">
  <xsl:output method="html" encoding="UTF-8" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" standalone="no" media-type="html" cdata-section-elements="script" indent="yes"/>
  <xsl:include href="client_section.xsl"/>
  <xsl:include href="../../modules/delivery/client_delivery.xsl"/>
  <xsl:include href="client_content.xsl"/>
  <xsl:template match="root">
    <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <base href="{domain}"></base>

        <script language="javascript">
          document.ondragstart = test;
          //запрет на перетаскивание
          document.onselectstart = test;
          //запрет на выделение элементов страницы
          document.oncontextmenu = test;
          //запрет на выведение контекстного меню
          function test() {
          return false
          }
        </script>
        <script language="javascript">
          function rf() { return false; }
          document.oncontextmenu=rf;
          isNN=0; isOp=0; isIE=0;
          if(navigator.appName.indexOf("Explorer")!=-1) { isIE=1; document.onselectstart=rf; }
          else if(document.layers||(window.captureEvents)) { isNN=1; document.captureEvents(Event.MOUSEDOWN);self.blur(); }
          //else if(window.captureEvents) { isOp=1; document.write("<input type="Text" style="visibility:hidden;position:absolute" id="ht" onblur="this.focus()"/>"); ht.focus(); }
        </script>
        <META HTTP-EQUIV="Cache-Control" content="no-cache"/>

        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
        <xsl:if test="not(content/meta_tags/node/title='')">
          <title>
            <xsl:value-of select="content/meta_tags/node/title"/>
          </title>
        </xsl:if>
        <meta name="description" content="{content/meta_tags/node/description}"/>
        <meta name="keywords" content="{content/meta_tags/node/keywords}"/>

        <script type="text/javascript" src="/engine/js/menu.js"></script>
        <script src="/engine/js/jquery.tools.min.js"></script>
        <script type="text/javascript" src="/engine/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="/sm2/soundmanager2.js"></script>
        <script type="text/javascript" src="/sm2/mp3-player-button.js"></script>
        <link rel="stylesheet" type="text/css" href="/sm2/flashblock.css"></link>
        <link rel="stylesheet" type="text/css" href="/sm2/mp3-player-button.css"></link>
        <link rel="stylesheet" type="text/css" href="/scroller/imageScroller.css"/>
        <script type="text/javascript" src="/scroller/imageScroller.js"/>
        <link href="style.css" rel="stylesheet" type="text/css"></link>
        <script language="javascript">
        $(document).ready(function() {
          $(".sm2_button").click(function() {
          $.cookie("sm2_state",$(this).attr('class'));
          });
        });
        </script>
      </head>

      <body marginheight="0" marginwidth="0"><xsl:text> </xsl:text><xsl:comment>START</xsl:comment><xsl:text> </xsl:text><center>
          <div style="position:relative; width:1000px" id="div_main">
            <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="mtableborder">
              <tr>
                <td>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="344" height="176" class="music">
                      <xsl:if test="php:function('file_exists', concat(//server_root,'/uploads/music.mp3'))">
                        <a class="sm2_button" href="/uploads/music.mp3"/>
                      </xsl:if>
                        <a href="{//content/main/link1}">
                          <xsl:variable name="attribute">border="0"</xsl:variable>
                          <xsl:copy-of select="php:function('Files::show_image','photo1','',string(//content/main/photo1), string($attribute))"/>
                        </a>
                      </td>
                      <td valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td background="images/lbg.jpg" valign="top" align="left">
                                    <div class="icona">
                                      <a href="?section=8">
                                        <img src="images/icon_map.gif" width="13" height="13" vspace="10" border="0"/>
                                      </a>
                                      <br/>
                                      <a href="/">
                                        <img src="images/icon_home.gif" width="13" height="13" vspace="10" border="0"/>
                                      </a>
                                      <br/>
                                      <a href="mailto:{//content/main/email}">
                                        <img src="images/icon_mail.gif" width="13" height="13" vspace="10" border="0"/>
                                      </a>
                                    </div>
                                    <div class="text4" style="width:175px; height:60px;">
                                      <xsl:value-of select="//content/list_articles/articles_anons/list/anons[../id_section=7]" disable-output-escaping="yes"/>
                                    </div>
                                  </td>
                                  <td style="background-image: url(images/som.gif);">
                                   <div class="topright">
                                    <xsl:value-of select="//content/main/text" disable-output-escaping="yes"/>
                                   </div>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <xsl:call-template name="main_menu"/>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td background="images/2st.gif" width="1" height="8">
                  <img src="images/2st.gif" width="1" height="10"/>
                </td>
              </tr>
              <tr>
                <td height="20" style="background:#565146; padding:0px 15px; color:#fff">
                  <marquee scrollamount="1" scrolldelay="20" align="middle" direction="left">
                    <xsl:for-each select="//content/baners/item[id_section=467]">
                      <xsl:value-of select="url" disable-output-escaping="yes"/>
                    </xsl:for-each>
                  </marquee>
                </td>
              </tr>
              <tr>
                <td valign="top" style="padding:0px; padding-left:8px">

                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>

                      <td width="718" valign="top">
                        <table width="718" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>&#160; <xsl:comment>END</xsl:comment> &#160;<xsl:apply-templates select="content"/>&#160; <xsl:comment>START</xsl:comment> &#160;</td>
                          </tr>
                          <tr>
                            <td>
                              <div id="search">
                                <table width="312" border="0" cellspacing="0" cellpadding="0">
                                  <form id="form1" name="form1" method="post" action="?section=9">
                                    <tr>

                                      <td background="images/searchbg.gif" valign="top" style="padding-top:4px; padding-left:20px">
                                        <input type="text" name="find_text" id="textfield" class="input"/>
                                      </td>
                                      <input type="hidden" name="search" value="Искать"/>
                                      <td width="78" valign="top">
                                        <img src="images/searchbutton.gif" onclick="javascript:form1.submit();"/>
                                      </td>

                                    </tr>
                                  </form>

                                </table>
                                <!-- /SEARCH -->
                              </div>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td background="images/nblock.gif" width="714" height="159" align="left" valign="top">
                                    <div style="padding: 9px 1px 5px 1px;">
                                      <xsl:call-template name="gallery">
                                        <xsl:with-param name="gallery_section">21</xsl:with-param>
                                      </xsl:call-template>
                                    </div>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td valign="top" align="right">
                        <div align="left" class="plus1">
                          <div style="margin-top:50px;" class="text13" align="center">
                            <xsl:call-template name="gallery">
                              <xsl:with-param name="gallery_section">23</xsl:with-param>
                              <xsl:with-param name="scroller">0</xsl:with-param>
                            </xsl:call-template> &#160; </div>
                          <div>
                            <xsl:for-each select="//content/baners/item[id_section=22]">
                              <xsl:value-of select="url" disable-output-escaping="yes"/>
                              <br/>
                            </xsl:for-each>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>

                </td>
              </tr>
              <tr>
                <td>

	<link href="/css/colorbox/example2/colorbox.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/engine/js/jquery.colorbox.js" />
	<div style="margin:5px; background-color:#f1ead8; padding:10px">
		<div id="outerContainer">
			<div id="imageScroller">
				<div id="viewer" class="js-disabled">
					<xsl:for-each select="//content/gallery/picture[id_section=23]">
						<xsl:if test="scroller=1">
							<xsl:variable name="id">
								<xsl:value-of select="id" />
							</xsl:variable>
							<xsl:variable name="text">
								<xsl:value-of select="text" />
							</xsl:variable>
							<xsl:variable name="filename">
								<xsl:value-of select="concat(../long_path,'fg',id_section,'_',id,extension)" />
							</xsl:variable>
							<xsl:variable name="picture">
								<xsl:value-of select="concat(../short_path,'fg',id_section,'_',id,extension)" />
							</xsl:variable>
							<a class="wrapper" rel="{$picture}">
								<xsl:if test="text!=''">
									<xsl:attribute name="href"><xsl:value-of select="text" /></xsl:attribute>
								</xsl:if>
								<img class="img_scroll" src="{$filename}" height="170" />
							</a>
							<img src="{$picture}" style="display:none;" />
						</xsl:if>
					</xsl:for-each>
				</div>
			</div>
		</div>
	</div>
                   <!--  <marquee scrollamount="1" scrolldelay="20" align="middle" direction="left" height="130">
                      <xsl:for-each select="//content/baners/item[id_section=468]">
                        <xsl:value-of select="url" disable-output-escaping="yes"/>
                      </xsl:for-each>
                    </marquee> -->

                </td>
              </tr>
              <tr>
                <td height="108" valign="top" background="images/linebot.gif" align="left">
                  <table width="100%">
                    <tr>
                      <td>
                        <div style="padding:10px">
                          <div class="text2">Организационные вопросы:</div>
                          <div class="text3">
                            <xsl:value-of select="//content/list_articles/articles_anons/list/anons[../id_section=20]" disable-output-escaping="yes"/>
                          </div>
                          <div class="text3">
                            <xsl:value-of select="//content/main/copyright" disable-output-escaping="yes"/>
<br/><a href="http://oksamitnyj.pp.ua" style="color:#FFF;decoration:underline;">Создание сайта - WebKontora</a>
                          </div>
                        </div>
                      </td>
                      <td height="108" valign="centr" align="right">
                        <xsl:for-each select="//content/baners/item[id_section=25]">
                          <xsl:value-of select="url" disable-output-escaping="yes"/>
                        </xsl:for-each>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </div>
        </center>&#160; <xsl:comment>END</xsl:comment> &#160;</body>
    </html>
  </xsl:template>
</xsl:stylesheet>
