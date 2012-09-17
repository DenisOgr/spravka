<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output indent="yes"/>
    
    <xsl:template match="links_exchange">
      <xsl:variable name="section">
       <xsl:value-of select="section"/>
      </xsl:variable>
      <xsl:for-each select="list"><br/><a href="?section=20&amp;all={id}"><xsl:value-of select="name"/></a>[<xsl:value-of select="kol"/>]
      </xsl:for-each>
      
      <xsl:for-each select="all">
        <br/>
        <xsl:variable name="url">
          <xsl:value-of select="url"/>
        </xsl:variable>
        <a href="{$url}" target="blank">
          <xsl:value-of select="title"/>
        </a>
        <xsl:if test="description/text()!=''">
          <div style="padding-left: 20px;">
            <xsl:value-of select="description"/>
          </div></xsl:if>
      </xsl:for-each>
      
      
      </xsl:template>
</xsl:stylesheet>
