<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:output encoding="utf-8" method="html" indent="yes" media-type="text/xhtml"
        cdata-section-elements="script"/>

    
    
<xsl:include href="content.xsl"/>
    <xsl:template match="root">
        <html>
            <head>
                <title>ооо "МЕГАСТАЛЬ"</title>
                <link rel="StyleSheet" href="style.css" type="text/css"/>
            </head>
            <body>

                <table class="maxarea" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td id="logopart">

                            <table class="maxarea" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td rowspan="2" class="companyname">
                                        <img width="451" height="142" src="images/companyname.jpg"/>
                                    </td>
                                    <td width="100%" class="links">
                                        <nobr>
                                            <a href="">поиск</a>
                                            <span>|</span>
                                            <a href="">добавить в избранное</a>
                                            <span>|</span>
                                            <a href="">карта сайта</a>
                                            <span>|</span>
                                            <a href="">info@rusteplo.com</a>
                                            <span>|</span>
                                            <a href="javascript:print();">печать</a>
                                        </nobr>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="100%" class="main_menu">
                                        <xsl:call-template name="main_menu"/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td id="panelpart">
                            <table class="maxarea" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <a href="?section=6" title="Изготовление">
                                            <img src="images/mmenu01.jpg"/>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="?section=7" title="Проектирование">
                                            <img src="images/mmenu02.jpg"/>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="?section=8" title="Сертификация">
                                            <img src="images/mmenu03.jpg"/>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="?section=9" title="Экспертиза">
                                            <img src="images/mmenu04.jpg"/>
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <xsl:apply-templates select="content"/>
                        </td>
                    </tr>

                    <tr>
                        <td id="footer">
                            <table class="maxarea" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td id="bottommenu"><xsl:value-of select="content/main/copyright"/></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
