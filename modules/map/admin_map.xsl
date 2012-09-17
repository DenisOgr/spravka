<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output indent="yes"/>

    <xsl:template match="map">
      <map>
        <xsl:variable name="start">?section=<xsl:value-of select="section"/>&amp;</xsl:variable>        
      <p>Этот раздел не администрируется.</p>
        </map>
    </xsl:template>
</xsl:stylesheet>
