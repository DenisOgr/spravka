<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

    <xsl:template name="gallery">
      <xsl:param name="gallery_section"/>
      <xsl:param name="scroller" select="''"/>
     <xsl:variable name="section">?section=<xsl:value-of select="section"/></xsl:variable>
    <xsl:variable name="width"><xsl:value-of select="width"/></xsl:variable>
    <xsl:variable name="height"><xsl:value-of select="height"/></xsl:variable>
    <xsl:variable name="path"><xsl:value-of select="short_path"/></xsl:variable>
    <xsl:variable name="page"><xsl:value-of select="page"/></xsl:variable>
      <table>
        <tr>
          <td>
            <xsl:for-each select="//content/gallery/picture[id_section=$gallery_section]">
            <xsl:if test="$scroller='' or ($scroller!='' and scroller=$scroller)">
              <xsl:variable name="id"><xsl:value-of select="id"/></xsl:variable>
              <xsl:variable name="text"><xsl:value-of select="text"/></xsl:variable>
              <xsl:variable name="filename"><xsl:value-of select="../long_path"/>fg<xsl:value-of select="id_section"/>_<xsl:value-of select="id"/><xsl:value-of select="extension"/></xsl:variable>
              <xsl:variable name="picture"><xsl:value-of select="../short_path"/>fg<xsl:value-of select="id_section"/>_<xsl:value-of select="id"/><xsl:value-of select="extension"/></xsl:variable>
              <div style="margin:5px; float: left; width: {$width}px; text-align: center;">
                <a>
                  <xsl:if test="text!=''">
                    <xsl:attribute name="href"><xsl:value-of select="text"/></xsl:attribute>
                  </xsl:if>
                    <img title="" src="{$filename}" border="0"/>
                </a>
                </div>
              </xsl:if>
            </xsl:for-each>
          </td>
        </tr>
      </table>
      <center>
        <xsl:value-of select="links" disable-output-escaping="yes"/>
      </center>
  </xsl:template>
</xsl:stylesheet>
