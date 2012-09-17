<xsl:stylesheet version = '1.0' 
     xmlns:xsl='http://www.w3.org/1999/XSL/Transform'>
<xsl:output method="html" indent="yes"/>

<xsl:template match="/root">
  <html>
    <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    </head>
    <body>
	<table border="1">
	<tr><td align="center">Название раздела</td>
	<td>&#xA0; Количество посетителей &#xA0;</td></tr>
	<tr><td>
	  <p></p>
	  <ul>
	    <xsl:for-each select="/root/list">
		  <li><xsl:value-of select="@name"/></li>
		  <xsl:apply-templates select="list"/>
	    </xsl:for-each>
	  </ul>
	</td>
	<td align="left">
	    <p></p>
	    <ul>
	    <xsl:for-each select="/root/list">
		  <li><xsl:value-of select="@value"/></li>
		  <xsl:apply-templates select="list" mode="value"/>
	    </xsl:for-each>
	  </ul>
	</td></tr>
	</table>
    </body>
  </html>
</xsl:template>

<xsl:template match="list">
  <ul>
    <li><xsl:value-of select="@name"/></li>
    <xsl:apply-templates select="list"/>
  </ul>
</xsl:template>

<xsl:template match="list" mode="value">
  <ul>
    <li><xsl:value-of select="@value"/></li>
    <xsl:apply-templates select="list" mode="value"/>
  </ul>
</xsl:template>

</xsl:stylesheet>