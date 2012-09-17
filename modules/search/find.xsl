<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output method="html" encoding="UTF-8" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" standalone="no" media-type="html" cdata-section-elements="script" indent="yes"/>
  <xsl:template match="find">
    <html>
      <head>
        <title>Результаты поиска</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF8"/>
      </head>
      <table>
        <xsl:for-each select="node">
          <tr>
            <td>
              <xsl:if test="node">
              <br/> -------------------------------------------------------------------------------------------------------------------- <br/>
              </xsl:if>
              <a target="_blank">
                <xsl:attribute name="href">
                  <xsl:value-of select="link"/>
                </xsl:attribute>
                <xsl:value-of select="title"/>
              </a>
              <br/>
              <xsl:value-of select="pagetext" disable-output-escaping="yes"/>
              <br/>
              <a target="_blank">
                <xsl:attribute name="href">
                  <xsl:value-of select="link"/>
                </xsl:attribute>
                <xsl:value-of select="link"/>
              </a>
              <br/>
            </td>
          </tr>
        </xsl:for-each>
      </table>
    </html>
  </xsl:template>

</xsl:stylesheet>
